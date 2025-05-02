<?php
/**
 *Created by PhpStorm
 *Created at ২৭/৯/২১ ১২:০৮ PM
 */

namespace App\Entities\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    protected $table = 'contact_info';
    protected $primaryKey = 'contact_id';


}