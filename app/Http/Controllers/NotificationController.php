<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function index() {
        $notifications = auth()->user()->notifications()->paginate(15);

        auth()->user()->unreadNotifications->markAsRead();

        if(Auth::check() and Auth::user()->hasRole(adminRolesList())) {
            return view('backend.notification.index', compact('notifications'));
        }

        if(Auth::check() and Auth::user()->hasRole(supplierRolesList())) {
            return view('supplier.notification.index', compact('notifications'));
        }

        if(Auth::check() and Auth::user()->hasRole(normalRolesList())) {
            return view('frontend.user.customer.notification.index', compact('notifications'));
        }

    }
}
