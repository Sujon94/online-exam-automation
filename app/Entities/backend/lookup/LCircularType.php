<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LCircularType extends Model
{
    //use SoftDeletes;

    protected $table = "l_circular_types";
    protected $primaryKey = "circular_type_id";
}