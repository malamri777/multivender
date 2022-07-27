<?php

namespace App\Http\Controllers\Supplier;

use Auth;

class NotificationController extends Controller
{
    public function index() {
        $notifications = auth()->user()->notifications()->paginate(15);
        auth()->user()->unreadNotifications->markAsRead();

        return view('supplier.notification.index', compact('notifications'));
    }
}
