<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Warehouse\Transformers\Api\Tax\TaxmainResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);

        $nameTransdesc = $this->translations['description'];
        $keydesc = fetchLangFromInputFields($nameTransdesc);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $request->header('index') == true ? $nameTrans[$key] ?? [] : $nameTrans,
            'is_active' => $this->is_active ?? '',
            'details_obj' => [
                'model' => $this->model ?? '',
                'cost_price' => $this->cost_price ?? '',
                'sales_price' => $this->sales_price ?? '',
                'max_stock' => $this->max_stock ?? '',
                'min_stock' => $this->min_stock ?? '',
                'min_sales_price' => $this->min_sales_pricen ?? '',
                'unit_id' => $this->unit_id,
                'product_kind' => $this->product_kind ?? '',
                'weight' => $this->weight ?? '',
                'Producer' => $this->Producer ?? '',
                'transportation_fees' => $this->transportation_fees ?? '',
                'default_qty' => $this->default_qty ?? '',
                'cost_way' => $this->cost_way ?? '',
                'initial_cost_price' => $this->initial_cost_price ?? '',
                'order_limit' => $this->order_limit ?? '',
                'cash_commission' => $this->cash_commission ?? '',
                'later_commission' => $this->later_commission ?? '',
                'commission_type' => $this->commission_type ?? '',
                'taxes'=>TaxmainResource::collection($this->taxes) ?? '',
                'purchase_disc_type' => $this->purchase_disc_type ?? '',
                'purchase_disc_amount_type' => $this->purchase_disc_amount_type  ?? '',
                'purchase_disc_amount' => $this->purchase_disc_amount ?? '',
                'buy_free_percent' => $this->buy_free_percent ?? '',
                'cost_price_effect' => $this->cost_price_effect ?? '',
                'sale_disc_type' => $this->sale_disc_type ?? '',
                'sale_disc_amount_type' => $this->sale_disc_amount_type ?? '',
                'sale_disc_amount' => $this->sale_disc_amount ?? '',
                'sale_free_percent' => $this->sale_free_percent ?? '',
            ],
            'fixed_assets_obj'  => [
                'asset_value' => $this->asset_value,
                "purchase_date" => $this->purchase_date ?? '',
                'product_account_id' => $this->product_account_id,
                "apply_deprecation" => $this->apply_deprecation ?? '',
                'deprecation_percent' => $this->deprecation_percent,
                'purchase_value' => $this->purchase_value,
                'deprecation_amount' => $this->deprecation_amount,
                'deprecation_account_id' => $this->deprecation_account_id,
                'total_deprecation_account_id' => $this->total_deprecation_account_id,
                "deprecation_start_date" => $this->deprecation_start_date ?? '',
                'scrap_amount' => $this->scrap_amount,
                'asset_status_id'   => $this->asset_status_id,
                'car_id'   => $this->car_id,
                'cost_center_id' => $this->cost_center_id,
                'trailer_id'   => $this->trailer_id,
            ],
            'accounts_obj'  => [
                'sales_account_id' => $this->sales_account_id,
                'resales_account_id' => $this->resales_account_id,
                'purchase_account_id' => $this->purchase_account_id,
                'repurchase_account_id' => $this->repurchase_account_id,
                'cost_account_id' => $this->cost_account_id,
                'stock_account_id' => $this->stock_account_id,
            ],
            'compounds_obj'  => [
                'compounds'   => $this->compounds->map->pivot ?? '',
            ],


            'product_type' => $this->product_type ?? '',
            'barcode' => $this->barcode ?? '',
            'images' => $this->images ?? '',
            'color' => $this->color ?? '',
            'description' => $request->header('index') == true ? $nameTransdesc[$keydesc] ?? [] : (object)$nameTransdesc,
            'max_purchase_disc_amount' => $this->max_purchase_disc_amount  ?? '',
            'max_sales_disc_amount' => $this->max_sales_disc_amount ?? '',
            'life_time' => $this->life_time ?? '',
            'life_time_type' => $this->life_time_type  ?? '',
            'is_diff_weight_mat' => $this->is_diff_weight_mat ?? '',
            'has_nofraction' => $this->has_nofraction ?? '',
            'guarantee_days' => $this->guarantee_days ?? '',
            'lengh_factor' => $this->lengh_factor ?? '',
            'width_factor' => $this->width_factor ?? '',
            'height_factor' => $this->height_factor ?? '',
            'scales_material' => $this->scales_material ?? '',
            'scales_part1' => $this->scales_part1 ?? '',
            'scales_part2' => $this->scales_part2 ?? '',
            'scales_part3' => $this->scales_part3 ?? '',
            'category_id' => $this->category_id,
            'category' => $this->category->name ?? '',
            'unit' => $this->productUnit->name ?? '',
            'branch_id' => $this->branch_id,
            'guarantee_id' => $this->guarantee_id,
            'suppliers'   => $this->suppliers->map->pivot ?? '',
            'determinants'   =>  $this->determinants->map->pivot ?? '',
            'warehouses'   => $this->warehouses->map->pivot ?? '',
            'alternatives'   => $this->alternatives->map->pivot ?? '',
            'units'   =>  $this->units->map->pivot ?? '',
            'tags'   => $this->tags->map->pivot ?? '',
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
