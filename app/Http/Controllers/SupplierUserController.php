<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierUserRequest;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Debugbar;
use Hash;
use Illuminate\Http\Request;

class SupplierUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $sort_supplier = null;

        $usersSupplier = User::query()
            ->whereIn('user_type', ['supplier_admin', 'supplier_warehouse_admin']);

        $usersSupplier = User::whereHas('roles', function($q){
            $q->whereIn('name', ['supplier_admin']);
        })
        ->whereHas('supplier', function($q) {
            $q->whereNotIn('name', adminRolesList());
        });

        if (!empty($request->input('search'))) {
            $sort_search = $request->search;
            $user_ids = $usersSupplier->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
        }

        if(!empty($request->input('sort_supplier'))) {
            $sort_supplier = $request->input('sort_supplier');
            $usersSupplier = $usersSupplier->where('provider_id', $sort_supplier);
        }


        $usersSupplier = $usersSupplier->paginate(15);
        return view('backend.suppliers.users.index', compact('usersSupplier', 'sort_search', 'sort_supplier'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplierRolesList= Role::whereIn("name", supplierRolesList())->get();
        $suppliers = Supplier::get();
        return view('backend.suppliers.users.create', compact('suppliers','supplierRolesList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierUserRequest $request)
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
            $user->roles()->sync($request->user_type);

            flash(translate('User has been created successfully'))->success();
            return redirect()->route('admin.suppliers.users.index');
        } catch (\Exception $e) {
            Debugbar::error($e);
            flash(translate('Failed Created User'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = User::findOrFail($id);
        $supplierUserRolesId = $supplier->roles->pluck("id");
        $suppliers = Supplier::get();
        $supplierRolesList= Role::whereIn("name", supplierRolesList())->get();

        return view('backend.suppliers.users.edit', compact('supplier', 'suppliers','supplierRolesList','supplierUserRolesId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->provider_id = $request->supplier_id;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            $user->roles()->sync($request->roleIds);
            flash(translate('User has been updated successfully'))->success();
            return redirect()->route('admin.suppliers.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (User::destroy($id)) {
            flash(translate('User has been deleted successfully'))->success();
            return redirect()->route('admin.suppliers.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}
