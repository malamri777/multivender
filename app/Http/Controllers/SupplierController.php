<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WarehouseUser;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::where('verification_status', 1)->paginate(10);
        return view('backend.suppliers.index', compact('suppliers'));
    }

    public function frontendIndex()
    {
        $suppliers = Supplier::where('verification_status', 1)->paginate(10);
        $supplierCount = Supplier::where('verification_status', 1)->count();
        return view('frontend.supplier.list', compact('suppliers', 'supplierCount'));
    }

    public function create()
    {
        return view('backend.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->cr_no = $request->cr_no;
        $supplier->vat_no = $request->vat_no;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->contact_user = $request->contact_user;
        $supplier->description = $request->description;
        $supplier->content = $request->content;
        $supplier->logo = $request->logo;
        if ($supplier->save()) {
            flash(translate('Supplier has been created successfully'))->success();
            return redirect()->route('admin.suppliers.index');
        }

        flash(translate('Error Creating Supplier'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
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
        $supplier = Supplier::findOrFail(decrypt($id));

        return view('backend.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SupplierRequest  $request
     * @param  Supplier  $supplier
     * @return Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->name = $request->name;
        $supplier->cr_no = $request->cr_no;
        $supplier->vat_no = $request->vat_no;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->contact_user = $request->contact_user;
        $supplier->description = $request->description;
        $supplier->content = $request->content;
        $supplier->logo = $request->logo;
        if ($supplier->save()) {
            $oldSupplierUser = $supplier->admin;
            if($oldSupplierUser->provider_id !== $request->admin_id) {
                $newSupplierUser = User::findOrFail($request->admin_id);
                $newSupplierUser->provider_id = $supplier->id;
                $newSupplierUser->save();
                $oldSupplierUser->provider_id = null;
                $oldSupplierUser->save();
                flash(translate('Admin Supplier has been updated successfully'))->success();
            }
            flash(translate('Supplier has been updated successfully'))->success();
            return redirect()->route('admin.suppliers.index');
        }


        flash(translate('Error updating Supplier'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Supplier::destroy($id)){
            flash(translate('Supplier has been deleted successfully'))->success();
            return redirect()->route('admin.suppliers.index');
        }

        flash(translate('Error deleting Supplier'))->error();
        return back();
    }

    public function updateStatus(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $supplier->verification_status = $request->verification_status;


        $supplier->save();
        return 1;
    }

    /**
     * Update the supplier status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsersBySupplierId($id = null)
    {
        if ($id) {
            $usersSupplier = User::whereIn('user_type', ['supplier_admin', 'supplier_warehouse_admin'])
                ->where('name', 'like', "")
                ->paginate(10);
        }

        $usersSupplier = User::whereIn('user_type', ['supplier_admin', 'supplier_warehouse_admin'])
            ->paginate(10);

            return view('backend.suppliers.users.index', [
                'users' => $usersSupplier
            ]);
    }

    /**
     * Update the supplier status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function queryUsersForSupplier(Request $request, Supplier $supplier)
    {
        $term = $request->get('q');
        if($request->ajax()){
            $userSupplier = User::where('provider_id', $supplier->id)
                ->whereHas('roles', function($q){
                    $q->whereIn('name', ['supplier_admin']);
                })
                ->paginate(10);

            $morePages = true;
            $pagination_obj = json_encode($userSupplier);
            if (empty($userSupplier->nextPageUrl())) {
                $morePages = false;
            }

            $results = array(
                "results" => $pagination_obj,
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return \Response::json($results);
        }
    }

    public function unverified() {
        $suppliers = Supplier::where('verification_status', 0)->paginate(10);
        return view('backend.suppliers.index', compact('suppliers'));
    }

    public function supplierRegisterForm() {
        return view('frontend.supplier.register');
    }

    public function supplierRegister(Request $request)
    {
        dd($request->all());
    }
}
