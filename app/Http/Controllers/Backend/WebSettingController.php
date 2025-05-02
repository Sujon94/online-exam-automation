<?php


namespace App\Http\Controllers\Backend;

use App\Contract\backend\WebSettingsContract;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebSettingController extends Controller
{
    private WebSettingsContract $webSettingsManager;

    public function __construct(WebSettingsContract $webSettingsManager)
    {
        $this->webSettingsManager = $webSettingsManager;
    }

    public function appearance()
    {
        return view("backend.web-setting.appearance_setup");
    }

    public function appearanceStoreUpdate(Request $request)
    {
        $response = $this->webSettingsManager->storeUpdate($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();
    }
}