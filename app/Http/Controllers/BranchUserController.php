<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\BranchUserRequest;
use App\Models\Restaurant;

class BranchUserController extends Controller
{


    public function index(Request $request)
    {
        $sort_search = null;
        $sort_branch = null;
        $usersBranch= [];

        $usersBranch = User::query()
            ->whereIn('user_type', [
                'branch_admin',
                'restaurant_branch_admin',
                'restaurant_branch_user',
                'restaurant_branch_driver',
            ]);

        if (!empty($request->input('search'))) {
            $sort_search = $request->search;
            $user_ids = $usersBranch->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
        }

        if(!empty($request->input('sort_branch'))) {
            $sort_branch = $request->input('sort_branch');
            $branch = Branch::find($sort_branch);
            $usersBranch = $usersBranch
                ->whereHas('branchUsers', function($q) use ($branch) {
                    $q->where('branches.id', $branch->id);
                })
                ->where('provider_id', $branch->restaurant_id);
            // $usersWarehouse = $usersWarehouse->whereHas('warehouseUsers',function($q) use($sort_warehouse){
            //     $q->where('id',$sort_warehouse);
            // });
        }


        $usersBranch = $usersBranch->paginate(15);
        return view('backend.restaurants.branches.users.index', compact('sort_search', 'sort_branch', 'usersBranch'));
    }

    public function create()
    {
        $restaurants = Restaurant::get();
        return view('backend.restaurants.branches.users.create', compact('restaurants'));
    }


    public function store(BranchUserRequest $request)
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
            $user->branchUsers()->sync($request->branches);

            flash(translate('User has been created successfully'))->success();
            return redirect()->route('admin.restaurants.branches.users.index');
        } catch (\Exception $e) {
            flash(translate('Failed Created User'))->error();
            return back();
        }
    }


    public function edit($id)
    {
        $branchUser = User::with(["branches", 'restaurant', 'restaurant.restaurantBranches'])->findOrFail($id);
        $branchIds = $branchUser->branches->pluck('id') ?? null;
        $restaurants = Restaurant::get();
        return view('backend.restaurants.branches.users.edit', compact('branchUser', 'restaurants', 'branchIds'));
    }

    public function update(BranchUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->restaurant_id = $request->restaurant_id;
        $user->user_type = $request->user_type;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        $user->branchUsers()->sync($request->branches);
        if ($user->save()) {
            flash(translate('User has been updated successfully'))->success();
            return redirect()->route('admin.restaurants.branches.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {

        if (User::destroy($id)) {
            flash(translate('User has been deleted successfully'))->success();
            return redirect()->route('admin.restaurants.branches.users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}
