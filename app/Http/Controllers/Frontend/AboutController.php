<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\PageSetup;
use App\Enums\PageContent;
use App\Enums\PageName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AboutController extends Controller
{
    public function index()
    {
        $about_us = PageSetup::select('*')->where('page_id', PageName::WHO_WE_ARE)->where('content_id',PageContent::ABOUT_US)
            ->orderBy('content_serial', 'asc')->first();
        $future_of_edu = PageSetup::select('*')->where('page_id', PageName::WHO_WE_ARE)->where('content_id',PageContent::WE_ARE_FUTURE_OF_EDUCATION)
            ->orderBy('content_serial', 'asc')->first();
        $key_points = PageSetup::select('*')->where('page_id', PageName::WHO_WE_ARE)->where('content_id',PageContent::KEY_POINTS)
            ->orderBy('content_serial', 'asc')->get();
        $vision = PageSetup::select('*')->where('page_id', PageName::WHO_WE_ARE)->where('content_id',PageContent::VISION)
            ->orderBy('content_serial', 'asc')->first();
        $objectives = PageSetup::select('*')->where('page_id', PageName::WHO_WE_ARE)->where('content_id',PageContent::OBJECTIVES)
            ->orderBy('content_serial', 'asc')->first();
        return view('frontend.about.index', compact('about_us', 'future_of_edu', 'key_points','vision', 'objectives'));
    }

}