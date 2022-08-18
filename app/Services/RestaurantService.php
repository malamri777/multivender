<?php

namespace App\Services;

use App\Http\Resources\V2\RestaurantResource;
use App\Models\Color;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Utility\CombinationsUtility;
use App\Utility\ProductUtility;
use App\Utility\WathqUtility;
use Auth;
use Illuminate\Support\Str;
use Request;

class RestaurantService
{
    public function store($request)
    {
        $restaurant = Restaurant::where('cr_no', $request->cr_no)
            ->orWhere('vat_no', $request->vat_no)
            ->orWhereHas('admin', function ($q) {
                $q->where('id', Auth::id());
            })->orWhereHas('restaurantBranches', function ($q) {
                $q->whereHas('BranchUsers', function ($q2) {
                    $q2->where('id', Auth::id());
                });
            })
            ->first();

        if ($restaurant) {
            return response()->json([
                'status' => false,
                'message' => translate('Restaurant is already exist in the system. Please contact the administrator.'),
            ], 406);
        }

        $wathqRequestStatusDev = true;
        $wathqRequest = null;
        if (!$wathqRequestStatusDev) {
            $wathqRequest = WathqUtility::sendRequest($request->cr_no);
        } else {
            $wathqRequest = WathqUtility::testData();
        }


        if ($wathqRequest['success'] == false) {
            return response()->json([
                'status' => false,
                'message' => $wathqRequest['message']
            ], 406);
        }

        if (
            $wathqRequestStatusDev and $wathqRequest['success'] == true and isset($wathqRequest['data'])
            and (Str::lower($wathqRequest['data']['expiryDate']) != Str::lower($request->expiryDate) or Str::lower($wathqRequest['data']['crName']) != Str::lower($request->name))
        ) {
            return response()->json([
                'status' => false,
                'message' => "Incorrect data entry"
            ], 406);
        }

        $restaurant = Restaurant::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'cr_no'             => $request->cr_no,
            'vat_no'            => $request->vat_no,
            'contact_user'      => $request->email,
            'description'       => $request->description ?? '',
            'content'           => $request->content ?? '',
            'admin_id'          => Auth::id(),
            'wathqData'         => $wathqRequestStatusDev ? json_encode($wathqRequest['data']) : $wathqRequest['data'] ?? '',
        ]);

        $user = Auth::user();
        $user->restaurant_id = $restaurant->id;
        $user->save();
        $role = Role::where('name', 'restaurant_admin')->first();
        $user->roles()->sync($role);

        return $restaurant;
    }
}
