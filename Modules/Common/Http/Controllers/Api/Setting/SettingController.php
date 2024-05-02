<?php

namespace Modules\Common\Http\Controllers\Api\Setting;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Setting\Setting;
use Modules\Common\Repositories\IRepositories\Setting\ISettingRepository;
use Modules\Common\Transformers\Api\Setting\SettingResource;

class SettingController extends Controller
{

    public function __construct(private ISettingRepository $settingRepository)
    {
    }

    public function index(Request $request)
    {
        try {
            $setting = Setting::whereIn('setting_id', $request->settings)->get();
            return JsonResponse::respondSuccess('success',  SettingResource::collection($setting));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $settings = $request['settings'];
            if (isset($request->settings["15"])) {
                $model = Setting::where('setting_id', 15)->first();
                $model->update(['setting_value' => $request->settings["15"]['image']]);
            }
            foreach ($settings as $key => $value) {
                Setting::where('setting_id', $key)->update([
                    'setting_value' => $value
                ]);
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
