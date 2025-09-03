<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contactUsPage()
    {
        return view('front.contact');
    }
    public function privacyPage()
    {
        return view('front.privacy-policy');
    }
    public function termsPage()
    {
        return view('front.terms-of-service');      
    }
}
