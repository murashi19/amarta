<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function change($lang)
{
    Session::put('locale', $lang);

    Log::info('Bahasa aplikasi diubah', [
        'user_id' => auth()->id(),
        'locale' => $lang,
        'from' => url()->previous(),
        'to' => url()->current(),
    ]);

    return redirect()->back();
}

}

