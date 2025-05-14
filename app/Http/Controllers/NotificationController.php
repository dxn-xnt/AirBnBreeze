<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Current notifications (unread or recent)
        $notifications = [
            [
                'id' => 1,
                'type' => 'new_booking',
                'title' => "Limosnero's Private House",
                'sender' => 'Donesia Pacquio',
                'message' => 'New booking request',
                'time' => '9:41 AM',
                'read' => false,
                'image' => 'assets/images/MD.png',
                'is_older' => false
            ],
            [
                'id' => 2,
                'type' => 'cancellation',
                'title' => "Cancelled Booking for Limosnero's Private House",
                'sender' => 'Donesia Pacquio',
                'message' => 'Booking was cancelled',
                'time' => 'Yesterday',
                'read' => false,
                'image' => 'assets/images/MD.png',
                'is_older' => false
            ],
            [
                'id' => 3,
                'type' => 'completed',
                'title' => "Completed Booking for Limosnero's Private House",
                'sender' => 'Donesia Pacquio',
                'message' => 'Booking completed successfully',
                'time' => '2 days ago',
                'read' => true,
                'image' => 'assets/images/MD.png',
                'is_older' => false
            ],
        ];

        // Older notifications (read and older than a week)
        $olderNotifications = [
            [
                'id' => 4,
                'type' => 'payment',
                'title' => "New Review for Limosnero's Private House",
                'sender' => 'Donesia Pacquio',
                'message' => 'Payment processed successfully',
                'time' => '1 week ago',
                'read' => true,
                'image' => 'assets/images/MD.png',
                'is_older' => true
            ],
            [
                'id' => 5,
                'type' => 'review',
                'title' => "New Review for Limosnero's Private House",
                'sender' => 'Donesia Pacquio',
                'message' => 'Left a 5-star review',
                'time' => '2 weeks ago',
                'read' => true,
                'image' => 'assets/images/MD.png',
                'is_older' => true
            ],
        ];

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
        // In a real app, mark all notifications as read
        return redirect()->back();
    }

    public function delete($id)
    {
        // In a real app, delete the notification
        return redirect()->back();
    }
}
