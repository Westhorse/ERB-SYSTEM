<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
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

    /**
     * Display a listing of the tempEmployee.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function tempEmployees()
    {
        try {
            $tempAccounts = DB::table('temp_employees')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempAccounts);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    /**
     * Display a listing of the tempEmployee.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function tempGroups()
    {
        try {
            $tempAccounts = DB::table('temp_groups')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempAccounts);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    /**
     * Display a listing of the tempEmployee.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function tempCostCenters()
    {
        try {
            $tempAccounts = DB::table('temp_cost_centers')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempAccounts);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

        /**
     * Display a listing of the tempEmployee.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function tempProjects()
    {
        try {
            $tempAccounts = DB::table('temp_projects')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempAccounts);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function tempUsers()
    {
        try {
            $tempUsers = DB::table('temp_users')->select(
                '*'
            )->orderByDesc('created_at')->get();
            return JsonResponse::respondSuccess(JsonResponse::MSG_SUCCESS, $tempUsers);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


}
