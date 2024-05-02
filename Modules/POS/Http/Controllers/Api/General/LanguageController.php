<?php

namespace Modules\POS\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function update($lang)
    {
        app()->setlocale($lang);

        return response(['lang' => app()->getLocale(), 'status' => true], 200);
    }
}
