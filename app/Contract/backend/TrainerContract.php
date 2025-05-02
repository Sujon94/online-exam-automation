<?php


namespace App\Contract\backend;

use Illuminate\Http\Request;

interface TrainerContract
{
    public function getAllTrainer();

    public function store(Request $request);

    public function update(Request $request, $id);

    public function delete($id);
}