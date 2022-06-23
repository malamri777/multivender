<?php

namespace App\Observers;

use App\Notifications\DataChangeEmailNotification;
use Notification;

class SupplierActionObserver
{
    public function created(Supplier $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Supplier'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Supplier $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Supplier'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
