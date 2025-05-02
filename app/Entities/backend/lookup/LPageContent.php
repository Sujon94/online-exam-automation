<?php


namespace App\Entities\backend\lookup;


use Illuminate\Database\Eloquent\Model;

class LPageContent extends Model
{
    protected $table = "l_page_content";
    protected $primaryKey = "content_id";
    public $timestamps = false;
}