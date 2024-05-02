<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

if (!function_exists('getAutoGeneratedNextCode')) {

    function getAutoGeneratedNextCode($code)
    {
        $numbersInCode = "";
        $reversedNumberInCode = "";
        $codeLength = strlen($code);
        // For loop throughout the given code to check for the value if it is number or not
        // via ascii code for numbers (0-9) which are located in range (48-57), then
        // we will get all numbers from the right till we reach alpha character
        // the loop will be stopped!
        for ($i = $codeLength - 1; $i >= 0; $i--) {

            if (ord($code[$i]) >= 48 && ord($code[$i]) <= 57) {

                $numbersInCode .= $code[$i];
            } else {
                break;
            }
        }
        $reversedNumberInCode = strrev($numbersInCode);
        $lengthOfNumbersInCode = strlen($reversedNumberInCode);
        $reversedNumberInIntegerFormat = (int)$reversedNumberInCode;
        $autoIncrementedNumberByOne = $reversedNumberInIntegerFormat + 1;
        $autoIncrementedNumberInStringFormat = (string)$autoIncrementedNumberByOne;
        //$LengthOfTheAutoIncrementedNumber = strlen($autoIncrementedNumberInStringFormat);

        $rightPartOfTheNewCode = str_pad($autoIncrementedNumberInStringFormat, $lengthOfNumbersInCode, "0", STR_PAD_LEFT);
        $lengthOfTheRightPartOfTheCode = $codeLength - $lengthOfNumbersInCode;
        $leftPartOfTheNewCode = substr($code, 0, $lengthOfTheRightPartOfTheCode);

        $nextCode = $leftPartOfTheNewCode . $rightPartOfTheNewCode;

        return $nextCode;
    }
};

function checkColumnUsed($pschema_name, $ptable_name, $pcolumn_name, $pvalue, $extable = [])
{
    $table_list = DB::select('SELECT
        TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
      FROM
        INFORMATION_SCHEMA.KEY_COLUMN_USAGE
      WHERE
        REFERENCED_TABLE_SCHEMA = ' . "'$pschema_name'" . ' AND
        REFERENCED_TABLE_NAME = ' . "'$ptable_name'" . ' AND
        REFERENCED_COLUMN_NAME = ' . "'$pcolumn_name'" . '');

    foreach ($table_list as $table) {
        $table_name = $table->TABLE_NAME;

        if (in_array($table_name, $extable)) {

            continue;
        }
        $column_name = $table->COLUMN_NAME;
        $ROWSCOUNT = DB::select('SELECT COUNT(*) as R_count FROM ' . $table_name . ' WHERE ' . $column_name . '=' . $pvalue);

        if ($ROWSCOUNT[0]->R_count > 0) {

            return true;
            break;
        }
    }
    return false;
}




function insertExchange($from_currency, $to_currency, $exchange_date, $exchange_rate)
{
    $x = 1 / $exchange_rate;


    DB::insert('Insert into c_currencies_exchange (from_currency_id,to_currency_id,exchange_date,exchange_rate,created_at,updated_at)

    values (?, ?, ?, ?,?,?)', [$to_currency, $from_currency, $exchange_date, $x, now(), now()]);
}


function updateExchange($from_currency, $old_to_currency, $to_currency, $old_exchange_date, $exchange_date, $exchange_rate)
{

    $x = 1 / $exchange_rate;


    DB::update('update c_currencies_exchange set from_currency_id = ?,exchange_rate =?  , exchange_date = ?,updated_at=?
   Where from_currency_id = ? and to_currency_id = ? and exchange_date =? ', [$to_currency, $x, $exchange_date, now(), $old_to_currency, $from_currency, $old_exchange_date]);
}

if (!function_exists('validateOneLangAsRequired')) {
    function validateOneLangAsRequired($languages, $array, $attribute, $type = 'string')
    {
        if (!$languages)
            throw new BadRequestException(trans('msg_add_proper_header'));

        if (gettype($array) != 'array') return $rules = [$attribute => 'required|array'];
        $rules = [];
        $langLocals = explode(',', $languages);
        $arr_filter = array_filter($array);
        if (empty($arr_filter)) {
            foreach ($langLocals as $locale) {
                $rules += [$attribute . '.' . $locale => 'required|' . $type];
            }
        } else {
            foreach ($langLocals as $locale) {
                $rules += [$attribute . '.' . $locale => 'nullable|' . $type];
            }
        }
        return $rules;
    }
}


if (!function_exists('validateNullableField')) {
    function validateNullableField($languages, $attribute, $rule)
    {
        $rules = [];
        $langLocals = explode(',', $languages);
        foreach ($langLocals as $locale) {
            $rules += [$attribute . '.' . $locale => 'nullable|' . $rule];
        }
        return $rules;
    }
}


if (!function_exists('checkNumperValidation')) {
    function checkNumperValidation($request_type, $table_name, $id = null, $key = null, $value = null)
    {
        $code = [];
        if ($request_type == 'PATCH' || $request_type == 'PUT') {
            $code += [
                'alpha_dash', 'required',
                Rule::unique($table_name, 'order_number')->ignore($id)->where(function ($query) {
                    $query->where('deleted_at', null);
                })->when(isset($value), function ($query) use ($key, $value) {
                    $query->where($key, $value);
                })
            ];
            return $code;
        } else {
            $code += [
                'alpha_dash', 'required',
                Rule::unique($table_name, 'order_number')->where(function ($query) {
                    $query->where('deleted_at', null);
                })->when(isset($value), function ($query) use ($key, $value) {
                    $query->where($key, $value);
                })
            ];
            return $code;
        }
    }
}


if (!function_exists('fetchLangFromInputFields')) {
    function fetchLangFromInputFields($transLanguages)
    {
        $key = '';
        if (array_key_exists(app()->getLocale(), $transLanguages) && $transLanguages[app()->getLocale()] !== "") {
            $key = app()->getLocale();
        } else {
            $key = array_key_first(array_filter($transLanguages));
        }
        return $key;
    }
}


if (!function_exists('checkCodeValidation')) {
    function checkCodeValidation($request_type, $table_name, $id = null, $key = null, $value = null)
    {
        $code = [];
        if ($request_type == 'PATCH' || $request_type == 'PUT') {
            $code += [
                'alpha_dash', 'required',
                Rule::unique($table_name, 'code')->ignore($id)->where(function ($query) {
                    $query->where('deleted_at', null);
                })->when(isset($value), function ($query) use ($key, $value) {
                    $query->where($key, $value);
                })
            ];
            return $code;
        } else {
            $code += [
                'alpha_dash', 'required',
                Rule::unique($table_name, 'code')->where(function ($query) {
                    $query->where('deleted_at', null);
                })->when(isset($value), function ($query) use ($key, $value) {
                    $query->where($key, $value);
                })
            ];
            return $code;
        }
    }

    function customSync($data, $array_key)
    {
        $customData = [];
        foreach ($data as $value) {
            $customData[$value[$array_key]] = $value;
        }
        return $customData;
    }

    if (!function_exists('itemBalance')) {
        function itemBalance($productId, $warehouseId = null, $date = null)
        {
            if (!$date) $date = Carbon::now()->format('Y-m-d');

            $q = "SELECT t1.warehouse_id , t1.product_id, IFNULL(tOpening.opening_balance,0) AS opening_balance,IFNULL(tAdd.Add_balance,0) as Add_balance,IFNULL(tIssue.Issue_balance,0) as Issue_balance,(IFNULL(tOpening.opening_balance,0) + IFNULL(tAdd.Add_balance,0) - IFNULL(tIssue.Issue_balance,0) )as Item_balance
            FROM w_products_warehouses t1 left OUTER JOIN  
            (SELECT warehouse_id,product_id, SUM(converted_add_qty) AS opening_balance FROM c_bills_items 
            Where id in (Select id from  bill_effect_balance  Where type_Id = 5 AND bill_date <= " . $date . " )
            GROUP BY warehouse_id,product_id) tOpening on t1.warehouse_id = tOpening.warehouse_id and t1.product_id = tOpening.product_id 
            left OUTER JOIN 
            (SELECT warehouse_id,product_id, SUM(converted_add_qty) AS Add_balance FROM c_bills_items 
            Where  id in (Select id from bill_effect_balance  Where type_Id  in (2,3)  AND  bill_date <=  " . $date . ")
            GROUP BY warehouse_id,product_id) tAdd on t1.warehouse_id = tAdd.warehouse_id and t1.product_id = tAdd.product_id
            left OUTER JOIN
            (SELECT warehouse_id,product_id , SUM(converted_issue_qty) AS Issue_balance FROM c_bills_items 
            Where  id in (Select id from  bill_effect_balance  Where type_Id  in (1,4) AND  bill_date <=  " . $date . ") 
            GROUP BY warehouse_id,product_id) tIssue on t1.warehouse_id = tIssue.warehouse_id and t1.product_id = tIssue.product_id
            Where t1.product_id = $productId";

            if (!empty($warehouseId)) $q  .=  " AND t1.warehouse_id = $warehouseId";

            $q  .=  " Order by t1.warehouse_id ;";

            $data = DB::select($q);
            return $data;
        }
    }
}
