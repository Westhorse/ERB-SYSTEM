<?php

namespace App\Http\Controllers;


class LanguageController extends Controller
{
    public function update($lang)
    {
        app()->setlocale($lang);

        return response(['lang' => app()->getLocale(), 'status' => true], 200);
    }
}
