<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function pageNotAllowed($message,$requested_url=null)
    {
        $message = Crypt::decryptString($message);
        $requested_url = isset($requested_url)? Crypt::decryptString($requested_url) : null;
        return view('page_not_allowed',compact('message','requested_url'));
    }

    public function parkForAMoment($message,$departure,$requested_url)
    {
        $message = Crypt::decryptString($message);
        $requested_url = Crypt::decryptString($requested_url);
        $departureTime= Carbon::parse($departure)->timestamp;
        $currentTime = Carbon::now()->timestamp;
        return view('redirect_with_timer',compact('message','departureTime','currentTime','requested_url'));
    }
}
