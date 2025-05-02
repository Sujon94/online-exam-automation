<?php


namespace App\Entities\backend;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentUser extends Authenticatable
{
    use Notifiable;

    protected $guarded = 'frontend';

    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime'];
}