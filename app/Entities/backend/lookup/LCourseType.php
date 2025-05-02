<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LCourseType extends Model
{
    use SoftDeletes;

    protected $table = "l_course_types";
    protected $primaryKey = "id";
}