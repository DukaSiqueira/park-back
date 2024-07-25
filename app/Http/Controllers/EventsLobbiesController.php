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
                    $query->withCount(['records' => function ($subQuery) {
                        $subQuery->where('status', 1);
                    }]);
                }])
                ->get();


            foreach ($lobbies as $lobby) {
                $lobby->validated_record = 0;
                $lobby->pending_record = 0;
                if ($lobby->event->records_count > 0) $lobby->total_records = $lobby->event->records_count;
            }

            return $lobbies;
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao buscar lobbies'], 500);
        }
    }
}
