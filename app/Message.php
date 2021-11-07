<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_user', 'to_user', 'message', 'file', 'is_read'];

}
