<?php


namespace App\Entities\frontend;


use App\Entities\backend\Students;
use Illuminate\Database\Eloquent\Model;

class StudentUser extends Model
{
    protected $table = 'student_users';
    protected $primaryKey = 'id';

    public function student_details()
    {
        return $this->belongsTo(Students::class,'id','student_id');
    }
}