<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:৩৫ PM
 */

namespace App\Entities\backend;


use App\Entities\backend\lookup\LCircularPayType;
use App\Entities\backend\lookup\LCircularRole;
use App\Entities\backend\lookup\LCircularType;
use App\Entities\backend\lookup\LLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    //use SoftDeletes;
    protected $table = "trainers";
    protected $primaryKey = "trainer_id";




    public function circular_role()
    {
        return $this->belongsTo(LCircularRole::class,'circular_role_id','circular_role_id');
    }

    public function circular_types()
    {
        return $this->belongsTo(LCircularType::class,'circular_type_id','circular_type_id');
    }

    public function circular_pay_types()
    {
        return $this->belongsTo(LCircularPayType::class,'circular_pay_type_id','circular_pay_type_id');
    }

    public function locations()
    {
        return $this->belongsTo(LLocation::class,'location_id','location_id');
    }



}