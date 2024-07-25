<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsLobbiesRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'compId',
        'eventId',
        'ticketsEventsBuyRecId',
        'listEventCustomerId',
        'userId',
        'lobbyId',
        'status'
    ];
}
