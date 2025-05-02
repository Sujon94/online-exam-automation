<?php

namespace App;

use App\Entities\backend\lookup\LReligion;
use App\Entities\backend\Students;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_role','parent_table_id', 'mobile','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function student_details()
    {
        return $this->belongsTo(Students::class,'parent_table_id','student_id');
    }

    /*public function religion_info()
    {
        return $this->belongsTo(LReligion::class,'religion_id','religion_id');
    }*/

}
