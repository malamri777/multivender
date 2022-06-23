<?php

namespace App\Observers;

use App\Models\Warehouse;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class WarehouseActionObserver
{
    public function created(Warehouse $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Warehouse'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Warehouse $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Warehouse'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
