<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(Request $request): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|array
    {
        try {
            $admin = checkAdmin($request->user()->id);

            return $admin ?
                Companies::query()
                    ->select('id', 'name', 'slug')
                    ->get() :
                Companies::query()
                    ->select('id', 'name', 'slug')
                    ->join('role_user', 'companies.id', '=', 'role_user.compId')
                    ->where('role_user.user_id', $request->user()->id)
                    ->get();

        } catch (\Exception $th) {
            return response()->json(['error' => 'Erro ao buscar empresas'], 500);
        }
    }
}
