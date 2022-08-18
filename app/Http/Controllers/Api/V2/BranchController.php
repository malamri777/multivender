<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\BranchRequest;
use App\Http\Resources\V2\RestaurantUserResource;
use App\Models\Branch;
use App\Models\Restaurant;
use Auth;

class BranchController extends Controller
{

    public function index($parent_id = 0)
    {
    }

    public function create(BranchRequest $request)
    {
        try {
            $restaurant = Restaurant::where('id', Auth::user()->restaurant_id)
                ->where('restaurant_waiting_for_upload_file', false)
                ->where('restaurant_waiting_for_admin_approve', false)
                ->first();

            $branch = Branch::where('name', $request->name)
                            ->where('restaurant_id', $restaurant->id)
                            ->first();
            if($branch) {
                return response()->json([
                    'success' => false,
                ], 409);
            }

            $branch = new Branch();
            $branch->name = $request->name;
            $branch->admin_id = $request->admin_id ?? Auth::id();
            $branch->restaurant_id = $restaurant->id;
            $branch->street = $request->street;
            $branch->country_id = 1;
            $branch->state_id = $request->state_id;
            $branch->city_id = $request->city_id;
            $branch->district_id = $request->district_id;
            $branch->long = $request->long;
            $branch->lat = $request->lat;
            if($branch->save()) {
                return response()->json([
                    'success' => true,
                    'data' => RestaurantUserResource::make(Auth::user())
                ], 200);
            }

            return response()->json([
                'success' => false,
            ], 406);


        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if(config('app.debug')) {
                $data['error'] = $e->getMessage();
            }

            return response()->json($data, 406);
        }
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        try {
            $restaurant = Restaurant::where('id', Auth::user()->restaurant_id)
                ->where('restaurant_waiting_for_upload_file', false)
                ->where('restaurant_waiting_for_admin_approve', false)
                ->first();

            $branch->name = $request->name;
            $branch->admin_id = $request->admin_id ?? Auth::id();
            $branch->restaurant_id = $restaurant->id;
            $branch->street = $request->street;
            $branch->country_id = 1;
            $branch->state_id = $request->state_id;
            $branch->city_id = $request->city_id;
            $branch->district_id = $request->district_id;
            $branch->long = $request->long;
            $branch->lat = $request->lat;
            if ($branch->save()) {
                return response()->json([
                    'success' => true,
                    'data' => RestaurantUserResource::make(Auth::user())
                ], 200);
            }

            return response()->json([
                'success' => false,
            ], 406);

        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
            }

            return response()->json($data, 406);
        }
    }
}
