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
        $suppliers = Supplier::paginate(10);
        return view('backend.suppliers.index', compact('suppliers'));
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
        $supplier->status = $request->status;


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
            $userSupplier = User::where('user_type', 'supplier_admin')
                ->where('name', 'like', "")
            // ->where(with(['supplierWarehouses', 'supplierWarehouses.warehouseWarehouseUsers'])
            ->paginate(10);
            // return $userSupplier;

            $html = '';

            if ($userSupplier->count() > 0) {
                $html .= '<option value=""></option>';
            }

            foreach ($userSupplier as $row) {
                $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }

            echo json_encode($html);
        }
        echo json_encode('');

        // $supplierUser = WarehouseUser::with('user')->paginate(10);
        // TODO: getUsers for suppliers
        // dd($supplierUser);

        // dd($supplier);
    }

    /**
     * Update the supplier status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function queryUsersForSupplier(Request $request, Supplier $supplier)
    {
        $term = $request->get('term');
        if($request->ajax()){
            $userSupplier = User::where('provider_id', $supplier->id)
                ->where('user_type', 'supplier_admin')
                ->where('name', 'like', "%$term%")
                ->select('id', 'name')
                ->paginate(10);

            $morePages = true;
            $pagination_obj = json_encode($userSupplier);
            if (empty($userSupplier->nextPageUrl())) {
                $morePages = true;
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
}
