<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantUserRequest;
use App\Models\Role;
use App\Models\Restaurant;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class RestaurantUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $sort_restaurant = null;

        $usersRestaurant = User::query()
            ->whereIn('user_type', ['restaurant_admin', 'restaurant_branch_admin']);

        if (!empty($request->input('search'))) {
            $sort_search = $request->search;
            $user_ids = $usersRestaurant->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
        }

        if(!empty($request->input('sort_restaurant'))) {
            $sort_restaurant = $request->input('sort_restaurant');
            $usersRestaurant = $usersRestaurant->where('provider_id', $sort_restaurant);
        }


        $usersRestaurant = $usersRestaurant->paginate(15);
        return view('backend.restaurants.users.index', compact('usersRestaurant', 'sort_search', 'sort_restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::get();
        return view('backend.restaurants.users.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->mobile,
                'password' => bcrypt($request->password),
                'provider_id' => $request->restaurant_id,
                'user_type' => $request->user_type
            ]);

            flash(translate('User has been created successfully'))->success();
            return redirect()->route('admin.restaurants.users.index');
        } catch (\Exception $e) {
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
        $restaurant = User::findOrFail($id);
        $restaurants = Restaurant::get();
        return view('backend.restaurants.users.edit', compact('restaurant', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->provider_id = $request->restaurant_id;
        $user->user_type = $request->user_type;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            flash(translate('User has been updated successfully'))->success();
            return redirect()->route('admin.restaurants.users.index');
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
            return redirect()->route('admin.restaurants.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}