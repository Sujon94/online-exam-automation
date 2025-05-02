<?php


namespace App\Entities\backend\exam_system;


use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ECertificateRegister extends Model
{
    use SoftDeletes;
    use Timestamp;
    protected $table = "e_certificates_register";
    protected $primaryKey = "certificate_id";
}