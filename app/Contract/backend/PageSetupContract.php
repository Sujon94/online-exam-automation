<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১১:১৪ AM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

interface PageSetupContract
{
    public function store(Request $request);

    public function update(Request $request, int $id);

    public function delete(int $id);
}