<?php

namespace App\Http\Controllers;

use App\Models\EventsLobbies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsLobbiesController extends Controller
{
    public function show($eventId): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|array
    {
        try {
            $lobbies = EventsLobbies::query()
                ->select('id', 'name', 'type', 'eventId')
                ->where('status', 1)
                ->where('eventId', $eventId)
                ->with(['event' => function ($query) {
                    $query->with([
                        'records' => function ($subQuery) {
                            $subQuery->where('status', 1)
                                ->with('lobbyRecord');
                        }
                    ]);
                }])
                ->get();

            foreach ($lobbies as $lobby) {
                $lobby->validated_record = 0;
                $lobby->pending_record = 0;
                $lobby->total_records = 0;

                if ($lobby->event->records->isNotEmpty()) {
                    $lobby->total_records = $lobby->event->records->count();
                    $lobby->validated_record = $lobby->event->records->filter(function ($record) {
                        return $record->lobbyRecord;
                    })->count();
                    $lobby->pending_record = $lobby->total_records - $lobby->validated_record;
                }
            }

            return $lobbies;
        } catch (\Throwable $th) {

            return response()->json(['error' => $th], 500);
        }
    }
}
