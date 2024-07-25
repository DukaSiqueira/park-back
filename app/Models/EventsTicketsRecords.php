<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventsTicketsRecords extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tickets_records';
    protected $fillable = [
        'rhash',
        'compId',
        'ticketId',
        'eventId',
        'userId',
        'typeId',
        'batchId',
        'ticketBuyId',
        'ticketRecordId',
        'promoterId',
        'eventPromoterTicketId',
        'promoterGroupId',
        'price',
        'rate',
        'cupom',
        'name',
        'phone',
        'document',
        'birthdate',
        'payGo',
        'code',
        'image',
        'status',
        'obs'
    ];
}
