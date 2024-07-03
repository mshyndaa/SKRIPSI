<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAkses extends Authenticatable
{
    use HasFactory, Notifiable;
protected $connection = 'mysql1';
    protected $table = 'user_akses';
    

    protected $fillable = ['user_id','company_id'];
}