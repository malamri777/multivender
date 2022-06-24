<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistrictRequest;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;
use Modules\Translations\Entities\DistrictTranslation;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_country = $request->sort_country;
        $sort_state = $request->sort_state;
        $sort_city = $request->sort_city;
        $search_district = $request->search_district;

        $district_queries = District::query();
        if ($request->search_district) {
            $district_queries->where('name', 'like', "%$search_district%");
        }
        if ($request->sort_country) {
            $district_queries = $district_queries->whereHas('city.state.country', function ($q) use ($sort_country) {
                $q->where('id', $sort_country);
            });
        }
        if ($request->sort_state) {
            $district_queries = $district_queries->whereHas('city.state', function ($q) use ($sort_state) {
                $q->where('id', $sort_state);
            });
        }
        if ($request->sort_city) {
            $district_queries = $district_queries->whereHas('city', function ($q) use ($sort_city) {
                $q->where('id', $sort_city);
            });
        }


        $districts = $district_queries
            ->with(['city', 'city.state', 'city.state.country'])
            ->orderBy('status', 'desc')->paginate(15);

        return view('backend.setup_configurations.districts.index', compact('districts', 'sort_country', 'sort_state', 'sort_city', 'search_district'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request)
    {
        $district = new District();

        $district->name = $request->name;
        $district->city_id = $request->city_id;

        $district->save();

        flash(translate('District has been inserted successfully'))->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang  = $request->lang;
        $district  = District::with(['city', 'city.state'])->findOrFail($id);
        $states = State::where('status', 1)->get();
        $cities = City::where('state_id', $district->city->state->id)->get();
        return view('backend.setup_configurations.districts.edit', compact('district', 'lang', 'states', 'cities'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, $id)
    {
        $district = District::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $district->name = $request->name;
        }

        $district->city_id = $request->city_id;

        $district->save();

        $district_translation = DistrictTranslation::firstOrNew(['lang' => $request->lang, 'district_id' => $district->id]);
        $district_translation->name = $request->name;
        $district_translation->save();

        flash(translate('District has been updated successfully'))->success();
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
        $district = District::findOrFail($id);

        foreach ((array) $district->district_translation as $key => $district_translation) {
            $district_translation->delete();
        }

        District::destroy($id);

        flash(translate('District has been deleted successfully'))->success();
        return redirect()->route('admin.districts.index');
    }

    public function updateStatus(Request $request){
        $district = District::findOrFail($request->id);
        $district->status = $request->status;
        $district->save();

        return 1;
    }

    public function getDistrictOptionByCityId(Request $request)
    {
        if ($request->city_id) {
            $districts = District::where('city_id', $request->city_id)->get();

            $html = '';

            if($districts->count() > 0) {
                $html .= '<option value=""></option>';
            }

            foreach ($districts as $row) {
                $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }

            echo json_encode($html);
        } else {
            echo json_encode('');
        }
    }
}
