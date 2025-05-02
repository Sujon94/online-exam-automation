<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;

class LSetupPage extends Model
{
    protected $table = "l_setup_page";
    protected $primaryKey = "page_id";
    public $timestamps = false;
}