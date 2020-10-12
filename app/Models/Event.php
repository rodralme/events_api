<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'start', 'end'];

    protected $fillable = ['title', 'description', 'start', 'end'];
}
