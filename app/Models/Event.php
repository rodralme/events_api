<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'start', 'end'];

    protected $fillable = ['title', 'description', 'start', 'end'];

    public function organizers()
    {
        return $this->belongsToMany(
            Person::class, 'events_people', 'event_id', 'person_id');
    }
}
