<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ms_item extends Model
{
    use Notifiable;
    protected $table = 'ms_item';
protected $connection = 'mysql1';
    protected $fillable = [
        '_id','x_axis','y_axis','name','type','location','link'
    ];
}
