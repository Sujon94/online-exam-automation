<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;


class PrivacyPolicyController extends Controller
{
    public function index()
    {
        return view('frontend.privacy-policy.index');
    }

}