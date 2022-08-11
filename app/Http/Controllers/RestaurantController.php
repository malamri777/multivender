<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::paginate(10);
        return view('backend.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('backend.restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRestaurantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantRequest $request)
    {
        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->cr_no = $request->cr_no;
        $restaurant->vat_no = $request->vat_no;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->contact_user = $request->contact_user;
        $restaurant->description = $request->description;
        $restaurant->content = $request->content;
        $restaurant->logo = $request->logo;
        $restaurant->cr_file = $request->cr_file;
        $restaurant->vat_file = $request->vat_file;
        if ($restaurant->save()) {
            flash(translate('Restaurant has been created successfully'))->success();
            return redirect()->route('admin.restaurants.index');
        }

        flash(translate('Error Creating Restaurant'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
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
        $restaurant = Restaurant::findOrFail(decrypt($id));

        return view('backend.restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RestaurantRequest  $request
     * @param  Restaurant  $restaurant
     * @return Response
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->name = $request->name;
        $restaurant->cr_no = $request->cr_no;
        $restaurant->vat_no = $request->vat_no;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->contact_user = $request->contact_user;
        $restaurant->description = $request->description;
        $restaurant->content = $request->content;
        $restaurant->logo = $request->logo;
        if ($restaurant->save()) {
            $oldRestaurantUser = $restaurant->admin;
            if($oldRestaurantUser->provider_id !== $request->admin_id) {
                $newRestaurantUser = User::findOrFail($request->admin_id);
                $newRestaurantUser->provider_id = $restaurant->id;
                $newRestaurantUser->save();
                $oldRestaurantUser->provider_id = null;
                $oldRestaurantUser->save();
                flash(translate('Admin Restaurant has been updated successfully'))->success();
            }
            flash(translate('Restaurant has been updated successfully'))->success();
            return redirect()->route('admin.restaurants.index');
        }


        flash(translate('Error updating Restaurant'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Restaurant::destroy($id)){
            flash(translate('Restaurant has been deleted successfully'))->success();
            return redirect()->route('admin.restaurants.index');
        }

        flash(translate('Error deleting Restaurant'))->error();
        return back();
    }

    public function updateStatus(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->id);
        $restaurant->status = $request->status;


        $restaurant->save();
        return 1;
    }

    /**
     * Update the restaurant status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsersByRestaurantId($id = null)
    {
        if ($id) {
            $usersRestaurant = User::whereIn('user_type', ['restaurant_admin', 'restaurant_branch_admin'])
                ->where('name', 'like', "")
                ->paginate(10);
        }

        $usersRestaurant = User::whereIn('user_type', ['restaurant_admin', 'restaurant_branch_admin'])
            ->paginate(10);

            return view('backend.restaurants.users.index', [
                'users' => $usersRestaurant
            ]);
    }

    /**
     * Update the restaurant status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function queryUsersForRestaurant(Request $request, Restaurant $restaurant)
    {
        $term = $request->get('q');
        if($request->ajax()){
            $userRestaurant = User::where('provider_id', $restaurant->id)
                ->where('user_type', 'restaurant_admin')
                ->where('name', 'like', "%$term%")
                ->orWhere('email', 'like', "%$term%")
                ->select('id', 'name')
                ->paginate(10);

            $morePages = true;
            $pagination_obj = json_encode($userRestaurant);
            if (empty($userRestaurant->nextPageUrl())) {
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
}
