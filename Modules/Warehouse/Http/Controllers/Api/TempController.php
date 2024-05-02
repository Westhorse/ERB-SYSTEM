<?php

namespace Modules\Warehouse\Http\Controllers\Api;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{DB};

class TempController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the tempAccounts.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function tempAccounts()
    {
        try {
            $tempAccounts = DB::table('temp_accounts')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempAccounts);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
