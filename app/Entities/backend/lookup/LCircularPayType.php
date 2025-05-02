<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LCircularPayType extends Model
{
    //use SoftDeletes;

    protected $table = "l_circular_pay_types";
    protected $primaryKey = "circular_pay_type_id";
}