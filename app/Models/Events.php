<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'compId',
        'name',
        'description',
        'date',
        'startTime',
        'maxSold',
        'featured',
        'showPage',
        'status',
        'slug'
    ];

    public function records(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventsTicketsRecords::class, 'eventId', 'id');
    }
}
