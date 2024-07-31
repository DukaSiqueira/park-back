<?php

namespace App\Http\Controllers;

use App\Models\EventsLobbies;
use App\Models\EventsLobbiesRecords;
use App\Models\EventsTicketsRecords;
use Illuminate\Http\Request;

class EventsLobbiesRecordsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $ticket = EventsTicketsRecords::query()
                ->where('compId', $request->compId)
                ->where('eventId', $request->eventId)
                ->where('code', $request->code)
                ->where('status', 1)
                ->first();

            if (!$ticket) {
                return response()
                    ->json([
                        'error' => 'Ingresso não encontrado!'
                    ], 500);
            }

            $record = EventsLobbiesRecords::query()
                ->where('eventId', $request->eventId)
                ->where('ticketsEventsBuyRecId', $ticket->id)
                ->first();

            $lobby = EventsLobbies::query()
                ->where('id', $request->lobbyId)
                ->where('eventId', $request->eventId)
                ->first();

            if ($record && $lobby->type == 'shared') {
                return response()
                    ->json([
                        'error' => 'Ingresso já validado!'
                    ], 500);
            }

            EventsLobbiesRecords::query()
                ->create([
                    'compId' => $request->compId,
                    'eventId' => $request->eventId,
                    'ticketsEventsBuyRecId' => $ticket->id,
                    'userId' => auth()->user()->id,
                    'lobbyId' => $request->lobbyId,
                    'status' => 1
                ]);

            return response()->json(['success' => 'Ingresso validado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
