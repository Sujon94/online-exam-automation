<?php
/**
 *Created by PhpStorm
 *Created at ৫/১/২২ ৫:১৫ PM
 */

namespace App\Entities\backend;


use App\Entities\backend\lookup\LPostCategory;
use App\Enums\TableName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use Sluggable;
    protected $table = "posts";
    protected $primaryKey = "post_id";

    public function category()
    {
        return $this->belongsTo(LPostCategory::class,'post_category_id','post_category_id');
    }

    public function post_photo(){
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','post_id')->where('parent_table','=',TableName::POSTS);
    }

    public function sluggable(): array
    {
        return [
            'slug'=>[
                'source'=>'title'
            ]
        ];
    }
}