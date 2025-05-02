<?php


namespace App\Entities\backend;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelfDevelopmentFile extends Model
{
    use SoftDeletes;
    protected $table = "self_development_file";
    protected $primaryKey = "self_development_file_id";
}