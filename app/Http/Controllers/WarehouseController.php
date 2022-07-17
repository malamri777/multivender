<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelStatusRequest;
use App\Http\Requests\WarehouseRequest;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        if ($request->get('sort_supplier')) {
            $warehouses = $query->where('supplier_id', $request->sort_supplier)
                ->paginate(10);
        } else {
            $warehouses = $query->paginate(10);
        }

        $suppliers = Supplier::get();
        return view('backend.suppliers.warehouses.index', compact('warehouses', 'suppliers', 'sort_supplier', 'search_supplier', 'sort_state', 'sort_city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::get();
        $states = State::where('country_id', 1)->get();
        return view('backend.suppliers.warehouses.create', compact('suppliers', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)
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
            return redirect()->route('admin.warehouses.index');
        }

        flash(translate('Error Creating Warehouse'))->error();
        return back();
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
        $warehouse = Warehouse::findOrFail(decrypt($id));

        $suppliers = Supplier::get();
        $states = State::where('country_id', 1)->get();
        $cities = City::where('state_id', $warehouse->state_id)->get();
        $districts = District::where('city_id', $warehouse->city_id)->get();
        return view('backend.suppliers.warehouses.edit', compact('warehouse', 'suppliers', 'states', 'cities', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        // $warehouse->country_id = 1;
        $warehouse->name = $request->name;
        $warehouse->supplier_id = $request->supplier_id;
        $warehouse->state_id = $request->state_id;
        $warehouse->city_id = $request->city_id;
        $warehouse->district_id = $request->district_id;
        if ($warehouse->save()) {
            flash(translate('Warehouse has been updated successfully'))->success();
            return redirect()->route('admin.warehouses.index');
        }

        flash(translate('Error updated Warehouse'))->error();
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
        if(Warehouse::destroy($id)) {
            flash(translate('Warehouse has been deleted successfully'))->success();
            return redirect()->route('admin.warehouses.index');
        }

        flash(translate('Error Deleting Warehouse'))->error();
        return back();
    }

    /**
     * Update the warehouse status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(ModelStatusRequest $request)
    {
        $warehouse = Warehouse::findOrFail($request->id);
        $warehouse->status = $request->status;


        $warehouse->save();
        return 1;
    }

    public function getWarehouseOptionBySupplierId(Request $request)
    {
        if ($request->supplier_id) {
            $items = Warehouse::where('supplier_id', $request->supplier_id)->get();

            $html = '';

            if ($items->count() > 0) {
                $html .= '<option value=""></option>';
            }

            foreach ($items as $row) {
                $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }

            echo json_encode($html);
        } else {
            echo json_encode('');
        }
    }
}
