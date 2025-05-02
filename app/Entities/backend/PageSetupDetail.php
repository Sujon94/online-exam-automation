<?php

/**
 *Created by Pavel
 *Created at 17-12-22
 */

namespace App\Entities\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSetupDetail extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'page_setup_dtl';
    protected $primaryKey = 'setup_dtl_id';

}