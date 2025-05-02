<?php

/**
 *Created by Pavel
 *Created at 17-12-22
 */

namespace App\Entities\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebSettings extends Model
{
    use SoftDeletes;

    protected $table = 'web_settings';
    protected $primaryKey = 'id';

}