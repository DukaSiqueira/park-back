<?php

namespace App\Http\Controllers;

use App\Models\EventsLobbies;
use Illuminate\Http\Request;

class EventsLobbiesController extends Controller
{
    public function show($eventId)
    {
        try {
            return EventsLobbies::query()
                ->select('id', 'name')
                ->where('status', 1)
                ->where('eventId', $eventId)
                ->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao buscar lobbies'], 500);
        }
    }
}
