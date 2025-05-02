<?php


namespace App\Contract\backend;

use Illuminate\Http\Request;

interface WebSettingsContract
{
    public function storeUpdate(Request $request);
}