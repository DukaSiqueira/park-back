<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventsTicketsRecords;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function show($compId): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|array
    {
        try {
            return Events::query()
                ->select('id', 'name')
                ->where('status', 1)
                ->where('compId', $compId)
                ->orderBy('startTime')
                ->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao buscar eventos'], 500);
        }
    }

    public function getValidatedTickets($eventId)
    {
        try {
            return EventsTicketsRecords::query()
                ->select('tickets_records.id', 'tickets.name as ticketName', 'events_batches.name as batchName',
                    'users.name as userName', 'tickets_records.code')
                ->where('tickets_records.status', 1)
                ->where('tickets_records.eventId', $eventId)
                ->has('lobbyRecord')
                ->join('users', 'users.id', '=', 'tickets_records.userId')
                ->join('tickets', 'tickets.id', '=', 'tickets_records.ticketId')
                ->join('events_batches', 'events_batches.id', '=', 'tickets_records.batchId')
                ->get();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
