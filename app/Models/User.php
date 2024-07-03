<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
protected $connection = 'mysql1';
    protected $table = 'users';
    protected $primaryKey = 'id_users';

    protected $fillable = ['username','password','role','email','verify_key','active','updated_at','updated_by'];
}