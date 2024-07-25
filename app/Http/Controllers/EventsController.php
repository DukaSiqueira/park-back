<?php

namespace App\Http\Controllers;

use App\Models\Events;
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
}
