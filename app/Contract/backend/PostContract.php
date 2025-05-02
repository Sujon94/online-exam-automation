<?php
/**
 *Created by PhpStorm
 *Created at ৫/১/২২ ৫:১২ PM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

Interface PostContract
{
    public function store(Request $request);

    public function getAllPost();
    
    public function getAllServices();

    public function getAPostInfo(int $id);

    public function update(Request $request, $id);

    public function delete(int $id);

    public function delete_file(int $fileId);

    public function download(int $fileId);
}