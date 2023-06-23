<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
	public function swap($locale)
	{

		if (!in_array($locale, ['en', 'ar'])) {
			abort(400);
		} else {
			session()->put('locale', $locale);
		}

		App::setLocale($locale);
		return redirect()->back();
	}
}
