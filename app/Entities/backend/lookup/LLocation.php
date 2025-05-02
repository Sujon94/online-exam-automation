<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LLocation extends Model
{
    //use SoftDeletes;

    protected $table = "l_location";
    protected $primaryKey = "location_id";
}