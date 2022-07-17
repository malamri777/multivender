<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\WarehouseUserRequest;


class WarehouseUserController extends Controller
{

    public function index(Request $request)
    {
        $sort_search = null;
        $sort_warehouse = null;
        $usersWarehouse = [];

        $usersWarehouse = User::query()
            ->whereIn('user_type', [
                'warehouse_admin',
                'warehouse_warehouse_admin',
                'warehouse_warehouse_user',
                'warehouse_warehouse_driver',
            ]);

        if (!empty($request->input('search'))) {
            $sort_search = $request->search;
            $user_ids = $usersWarehouse->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
        }

        if(!empty($request->input('sort_warehouse'))) {
            $sort_warehouse = $request->input('sort_warehouse');
            $warehouse = Warehouse::find($sort_warehouse);
            $usersWarehouse = $usersWarehouse
                ->whereHas('warehouseUsers', function($q) use ($warehouse) {
                    $q->where('warehouses.id', $warehouse->id);
                })
                ->where('provider_id', $warehouse->supplier_id);
            // $usersWarehouse = $usersWarehouse->whereHas('warehouseUsers',function($q) use($sort_warehouse){
            //     $q->where('id',$sort_warehouse);
            // });
        }


        $usersWarehouse = $usersWarehouse->paginate(15);
        return view('backend.suppliers.warehouses.users.index', compact('sort_search', 'sort_warehouse', 'usersWarehouse'));
    }

    public function create()
    {
        $warehouses = Warehouse::get();
        return view('backend.suppliers.warehouses.users.create', compact('warehouses'));
    }


    public function store(WarehouseUserRequest $request)
    {
        // try {
            $warehouse = Warehouse::find($request->warehouse_id);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->mobile,
                'password' => bcrypt($request->password),
                'provider_id' => $warehouse->supplier_id,
                'user_type' => $request->user_type
            ]);
            $user->warehouseUsers()->attach($warehouse);

            flash(translate('User has been created successfully'))->success();
            return redirect()->route('admin.suppliers.warehouses.users.index');
        // } catch (\Exception $e) {
        //     flash(translate('Failed Created User'))->error();
        //     return back();
        // }
    }


    public function edit($id)
    {
        $warehouse = User::findOrFail($id);
        $warehouses = Warehouse::get();
        return view('backend.suppliers.warehouses.users.edit', compact('warehouse', 'warehouses'));
    }

    public function update(WarehouseUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->provider_id = $request->supplier_id;
        $user->user_type = $request->user_type;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        $user->warehouseUsers()->sync($warehouse);
        if ($user->save()) {
            flash(translate('User has been updated successfully'))->success();
            return redirect()->route('admin.suppliers.warehouses.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {

        if (User::destroy($id)) {
            flash(translate('User has been deleted successfully'))->success();
            return redirect()->route('admin.suppliers.warehouses.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}
