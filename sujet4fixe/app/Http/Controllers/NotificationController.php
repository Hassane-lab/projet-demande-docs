<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // ✅ Lister les notifications
    
public function index(Request $request): JsonResponse
{
    $user = $request->user();

    if ($user->role === 'agent') {
        // L’agent voit toutes les notifications
        $notifications = Notification::orderByDesc('created_at')->get();
    } else {
        // L’utilisateur voit uniquement les siennes
        $notifications = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    return response()->json([
        'notifications' => $notifications
    ]);
}

    // ✅ Marquer une notification comme lue
    public function markAsRead($id): JsonResponse
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notif) {
            return response()->json(['error' => 'Notification introuvable ou non autorisée'], 404);
        }

        $notif->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marquée comme lue.']);
    }
}