<?php

/**
 *Created by Pavel
 *Created at 17-12-22
 */

namespace App\Entities\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSetupMaster extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'page_setup';
    protected $primaryKey = 'id';

}