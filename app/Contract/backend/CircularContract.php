<?php


namespace App\Contract\backend;

use Illuminate\Http\Request;

interface CircularContract
{
    public function getAllCircularTypes();

    public function getAllCircularPayTypes();

    public function getAllCircular();

    public function store(Request $request);

    public function update(Request $request, $id);

    public function delete($id);

}