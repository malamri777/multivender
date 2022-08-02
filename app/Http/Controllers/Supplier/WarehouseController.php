<?php

namespace App\Http\Controllers\Supplier;

use Auth;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\Product;
use App\Models\District;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\WarehouseRequest;
use App\Http\Requests\ModelStatusRequest;
use App\Http\Requests\WarehouseUserRequest;

class WarehouseController extends Controller
{
    //


    public function warehouseIndex(Request $request)
    {
        $search_supplier = $request->search_supplier;
        $sort_supplier = $request->sort_supplier;
        $sort_state = $request->sort_state;
        $sort_city = $request->sort_city;


        $query = Warehouse::query()->with('admin');

        if ($request->sort_state) {
            $query = $query->where('state_id', $sort_state);
        }
        if ($request->sort_city) {
            $query = $query->where('city_id', $sort_city);
        }

        $warehouses = $query->where('supplier_id', Auth::user()->provider_id)
            ->paginate(10);

        return view('supplier.warehouses.index', compact('warehouses', 'search_supplier', 'sort_state', 'sort_city'));

    }

    public function warehouseEdit(Request $request)
    {

        $warehouse = Warehouse::findOrFail(decrypt($request->input('id')));

        $suppliers = Supplier::get();
        $states = State::where('country_id', 1)->get();
        $cities = City::where('state_id', $warehouse->state_id)->get();
        $districts = District::where('city_id', $warehouse->city_id)->get();
        return view('supplier.warehouses.edit', compact('warehouse', 'suppliers', 'states', 'cities', 'districts'));


    }

    public function warehouseUpdate(WarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->name = $request->name;
        $warehouse->supplier_id = $request->supplier_id;
        $warehouse->state_id = $request->state_id;
        $warehouse->city_id = $request->city_id;
        $warehouse->district_id = $request->district_id;
        if ($warehouse->save()) {
            flash(translate('Warehouse has been updated successfully'))->success();
            return redirect()->route('supplier.warehouse.index');
        }

        flash(translate('Error updated Warehouse'))->error();
        return back();
    }

    public function warehouseCreate(Request $request){
        $suppliers = Supplier::get();
        $states = State::where('country_id', 1)->get();
        return view('supplier.warehouses.create', compact('suppliers', 'states'));
    }

    public function warehouseStore(WarehouseRequest $request)
    {
        $warehouse = new Warehouse();
        $warehouse->name = $request->name;
        $warehouse->supplier_id = $request->supplier_id;
        $warehouse->country_id = 1;
        $warehouse->state_id = $request->state_id;
        $warehouse->city_id = $request->city_id;
        $warehouse->district_id = $request->district_id;
        if ($warehouse->save()) {
            flash(translate('Warehouse has been created successfully'))->success();
            return redirect()->route('supplier.warehouse.index');
        }

        flash(translate('Error Creating Warehouse'))->error();
        return back();
    }

    public function warehouseDestroy(Request $request)
    {
        if (Warehouse::destroy($request->input('id'))) {
            flash(translate('Warehouse has been deleted successfully'))->success();
            return redirect()->route('supplier.warehouse.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function warehouseUpdateStatus(Request $request){
        $warehouse = Warehouse::findOrFail($request->id);
        $warehouse->status = $request->status;
        $warehouse->save();
        return 1;
    }


    public function warehouseUsersPage(Request $request)
    {

        $sort_search = null;
        $sort_warehouse = null;
        $usersWarehouse = [];


        $usersWarehouse = User::query()
        ->whereHas('supplier.supplierWarehouses',function($q){
            $q->where('supplier_id', Auth::user()->provider_id);
        })
        ->other();

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
        }


        $usersWarehouse = $usersWarehouse->paginate(15);

        return view('supplier.warehouses.users.index', compact('sort_search', 'sort_warehouse', 'usersWarehouse'));

    }

    public function userEdit(Request $request)
    {

        $id = $request->input('id');
        $warehouseUser = User::with(["warehouses", 'supplier', 'supplier.supplierWarehouses'])->findOrFail($id);
        $warehouseUserRolesId = $warehouseUser->roles->pluck('id');
        $warehouseIds = $warehouseUser->warehouses->pluck('id') ?? [];
        $suppliers = Supplier::get();
        $warehouse = Warehouse::get();
        $warehouseRolesList= Role::whereIn("name", warehouseRolesList())->get();
        return view('supplier.warehouses.users.edit', compact('warehouseUser', 'suppliers', 'warehouseIds','warehouseUserRolesId','warehouseRolesList','warehouse'));
    }

    public function userUpdate(WarehouseUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->provider_id = $request->supplier_id;
        $user->user_type = $request->user_type;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        // $user->warehouseUsers()->sync($request->warehouses);
        if ($user->save()) {
            flash(translate('User has been updated successfully'))->success();
            return redirect()->route('supplier.warehouse.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function userCreate(Request $request)
    {
        $warehouseRolesList= Role::whereIn("name", warehouseRolesList())->get();
        $warehouse = Warehouse::get();
        $suppliers = Supplier::get();
        return view('supplier.warehouses.users.create', compact('suppliers','warehouseRolesList','warehouse'));
    }

    public function userStore(WarehouseUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->mobile,
                'password' => bcrypt($request->password),
                'provider_id' => $request->supplier_id,
                'user_type' => $request->user_type
            ]);
            $user->warehouseUsers()->sync($request->warehouses);

            flash(translate('User has been created successfully'))->success();
            return redirect()->route('supplier.warehouse.users.index');
        } catch (\Exception $e) {
            flash(translate('Failed Created User'))->error();
            return back();
        }
    }

    public function userDestroy(Request $request)
    {
        if (User::destroy($request->input('id'))) {
            flash(translate('User has been deleted successfully'))->success();
            return redirect()->route('supplier.warehouse.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }





    public function warehouseProductsPage(Request $request)
    {

        $search = null;

        $products = Product::whereHas('warehouse',function($q){
            $q->where('supplier_id', Auth::id());
        })->orderBy('created_at', 'desc');


        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%' . $search . '%');
        }
        $products = $products->paginate(10);
        return view('supplier.warehouses.products.index', compact('products', 'search'));
    }

}
