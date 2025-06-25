<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    // ✅ Liste des demandes (agent voit tout, user ses propres demandes)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'agent') {
            return response()->json(Demande::with('documentType', 'user')->get());
        }

        return response()->json(Demande::with('documentType')
            ->where('user_id', $user->id)
            ->get());
    }

    // ✅ Créer une nouvelle demande
    public function store(Request $request)
    {
        $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
        ]);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'document_type_id' => $request->document_type_id,
            'statut' => 'en_attente',
        ]);

        return response()->json([
            'message' => 'Demande envoyée.',
            'demande' => $demande
        ], 201);
    }

    // ✅ Afficher une demande spécifique
    public function show(Demande $demande)
    {
        $user = Auth::user();

        if ($user->role !== 'agent' && $demande->user_id !== $user->id) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        return response()->json($demande->load('documentType'));
    }

    // ✅ Mise à jour d'une demande (statut + commentaire) par agent
    public function update(Request $request, Demande $demande)
    {
        $user = Auth::user();

        if ($user->role !== 'agent') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
            'commentaire' => 'nullable|string'
        ]);

        $demande->update([
            'statut' => $request->statut,
            'commentaire' => $request->commentaire,
        ]);

        Notification::create([
            'user_id' => $demande->user_id,
            'message' => "Votre demande #{$demande->id} a été mise à jour. Statut : {$request->statut}.",
        ]);

        return response()->json([
            'message' => 'Demande mise à jour.',
            'demande' => $demande
        ]);
    }

    // ✅ Supprimer une demande (agent uniquement)
    public function destroy(Demande $demande)
    {
        $user = Auth::user();

        if ($user->role !== 'agent') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $demande->delete();

        return response()->json(['message' => 'Demande supprimée avec succès.']);
    }
}