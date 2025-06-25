<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Demande;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $total = Demande::count();
        $enAttente = Demande::where('statut', 'en attente')->count();
        $acceptees = Demande::where('statut', 'acceptée')->count();
        $refusees = Demande::where('statut', 'refusée')->count();

        return response()->json([
            'total' => $total,
            'en_attente' => $enAttente,
            'acceptees' => $acceptees,
            'refusees' => $refusees,
        ]);
    }
}