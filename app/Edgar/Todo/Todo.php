<?php

namespace App\Edgar\Todo;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'completed'
    ];
}
