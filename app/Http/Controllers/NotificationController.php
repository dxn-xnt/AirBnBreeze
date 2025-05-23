<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Current notifications (unread or recent)
        $notifications = Notification::with(['sender', 'property'])
            ->where('notif_receiver_id', auth()->id())
            ->where('notif_is_read', false)
            ->get();

        // Older notifications (read and older than a week)
        $olderNotifications = Notification::with(['sender', 'property'])
            ->where('notif_receiver_id', auth()->id())
            ->where('notif_is_read', true)
            ->get();

        return view('pages.notifications', [
            'notifications' => $notifications,
            'olderNotifications' => $olderNotifications
        ]);
    }

    public function markAsRead($id)
    {
        // In a real app, mark notification as read in database
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        $userId = auth()->id();
        $updatedCount = Notification::where('notif_receiver_id', $userId)
            ->where('notif_is_read', false)
            ->update(['notif_is_read' => true]);

        return redirect()->route('notifications.index');
    }

    public function delete($id)
    {
        try {
            $notification = Notification::where('notif_receiver_id', auth()->id())
                ->findOrFail($id);

            $notification->delete();

            return redirect()->route('notifications.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 404);
        }
    }
}
