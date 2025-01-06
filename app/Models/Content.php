<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    protected $fillable = [
        'text',
        'title',
        'structure',
        'user_id'
    ];
}
