<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelStatusRequest;
use App\Http\Requests\BranchRequest;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\Restaurant;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_restaurant = $request->search_restaurant;
        $sort_restaurant = $request->sort_restaurant;
        $sort_state = $request->sort_state;
        $sort_city = $request->sort_city;

        $query = Branch::query()->with('admin');

        if ($request->sort_state) {
            $query = $query->where('state_id', $sort_state);
        }
        if ($request->sort_city) {
            $query = $query->where('city_id', $sort_city);
        }

        if ($request->get('sort_restaurant')) {
            $branches = $query->where('restaurant_id', $request->sort_restaurant)
                ->paginate(10);
        } else {
            $branches = $query->paginate(10);
        }

        $restaurants = Restaurant::get();
        return view('backend.restaurants.branches.index', compact('branches', 'restaurants', 'sort_restaurant', 'search_restaurant', 'sort_state', 'sort_city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::get();
        $states = State::where('country_id', 1)->get();
        return view('backend.restaurants.branches.create', compact('restaurants', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->restaurant_id = $request->restaurant_id;
        $branch->country_id = 1;
        $branch->state_id = $request->state_id;
        $branch->city_id = $request->city_id;
        $branch->district_id = $request->district_id;
        if ($branch->save()) {
            flash(translate('Branch has been created successfully'))->success();
            return redirect()->route('admin.branches.index');
        }

        flash(translate('Error Creating Branch'))->error();
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
        $branch = Branch::findOrFail(decrypt($id));

        $restaurants = Restaurant::get();
        $states = State::where('country_id', 1)->get();
        $cities = City::where('state_id', $branch->state_id)->get();
        $districts = District::where('city_id', $branch->city_id)->get();
        return view('backend.restaurants.branches.edit', compact('branch', 'restaurants', 'states', 'cities', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        // $branch->country_id = 1;
        $branch->name = $request->name;
        $branch->restaurant_id = $request->restaurant_id;
        $branch->state_id = $request->state_id;
        $branch->city_id = $request->city_id;
        $branch->district_id = $request->district_id;
        if ($branch->save()) {
            flash(translate('Branch has been updated successfully'))->success();
            return redirect()->route('admin.branches.index');
        }

        flash(translate('Error updated Branch'))->error();
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
        if(Branch::destroy($id)) {
            flash(translate('Branch has been deleted successfully'))->success();
            return redirect()->route('admin.branches.index');
        }

        flash(translate('Error Deleting Branch'))->error();
        return back();
    }

    /**
     * Update the branch status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(ModelStatusRequest $request)
    {
        $branch = Branch::findOrFail($request->id);
        $branch->status = $request->status;


        $branch->save();
        return 1;
    }

    public function getBranchOptionByRestaurantId(Request $request)
    {
        if ($request->restaurant_id) {
            $items = Branch::where('restaurant_id', $request->restaurant_id)->get();

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

