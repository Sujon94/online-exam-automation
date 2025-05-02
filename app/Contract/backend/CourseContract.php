<?php


namespace App\Contract\backend;


use App\Entities\backend\Course;
use Illuminate\Http\Request;

interface CourseContract
{
    public function store(Request $request);

    public function getAllCourse();

    public function getAllActiveCourses();

    public function getACourseInfo($id);

    public function update(Request $request, $id);

    public function delete($id);

    public function getTypeWiseCourses($id);

    public function getTypeWiseRandomCourses($course_id=null, $id);

    public function getCourseDetails($id);

    public function updateMasterYN($course_id, $status);
}