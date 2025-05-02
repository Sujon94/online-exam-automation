<?php


namespace App\Contract\backend;

use Illuminate\Http\Request;

interface CourseTypeContract
{
    public function store(Request $request);

    public function getAllCourseTypes();

    public function getACourseTypeInfo($id);

    public function update(Request $request, $id);

    public function delete($id);
}