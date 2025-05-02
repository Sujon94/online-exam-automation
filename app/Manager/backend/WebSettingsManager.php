<?php


namespace App\Manager\backend;

use App\Contract\backend\WebSettingsContract;
use App\Entities\backend\WebSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebSettingsManager implements WebSettingsContract
{
    protected WebSettings $webSettings;

    public function __construct()
    {
        $this->webSettings = new WebSettings();
    }

    public function storeUpdate(Request $request)
    {
        $postData = $request->except('_token');

        try {
            DB::beginTransaction();

            foreach ( $postData as $key => $value ){

                $webSettings = $this->webSettings->where('type', $key)->first();

                if($webSettings != null){

                    //$webSettings->type = $key;
                    $webSettings->value = $value;

                    $webSettings->save();
                }
                else{
                    $webSettings = new WebSettings();

                    $webSettings->type = $key;
                    $webSettings->value = $value;

                    $webSettings->save();
                }
            }

            DB::commit();
            return ["code"=>'1',"status" => 'success', "message" => 'Data Saved Successfully'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code"=>'99',"status" => 'error', "message" => 'Exception Occurred'.$e->getMessage()];
        }

    }

}