<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
protected $connection = 'mysql1';
    protected $table = 'admin';
     protected $primaryKey = 'id_users';
protected $casts = [
    'created_at' => 'date:m/d/Y',
    'updated_at' => 'date:m/d/Y',
];
    protected $fillable = ['id_users','username','password','role','email','verify_key','active','updated_at','updated_by'];
}