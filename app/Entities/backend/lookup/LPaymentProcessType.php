<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;

class LPaymentProcessType extends Model
{
    protected $table = "l_payment_process_types";
    protected $primaryKey = "payment_type_id";
}