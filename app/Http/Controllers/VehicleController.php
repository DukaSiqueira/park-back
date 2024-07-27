<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function showVehicleByTicketCode($ticket_code)
    {
        $vehicle = Vehicle::query()->where('ticket_code', $ticket_code)->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Alterar o campo 'type' antes de retornar
        $vehicle->type = $vehicle->type === 'car' ? 'carro' : 'moto';

        return response()->json(['vehicle' => $vehicle], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_code' => 'required|exists:tickets_records,code',
            'type' => 'required|in:car,motorcycle',
            'plate' => 'required|string|max:20|unique:vehicles,plate'
        ]);

        if (Vehicle::where('ticket_code', $validatedData['ticket_code'])->exists()) {
            return response()->json(['error' => 'A vehicle is already registered for this ticket'], 400);
        }

        $vehicle = Vehicle::create($validatedData);

        $vehicle->type = $vehicle->type === 'car' ? 'carro' : 'moto';

        return response()->json(['vehicle' => $vehicle], 201);
    }

    public function destroy($ticket_code)
    {
        $vehicle = Vehicle::query()->where('ticket_code', $ticket_code)->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully'], 200);
    }

}
