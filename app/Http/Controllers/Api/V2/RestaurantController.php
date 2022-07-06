<?php
namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\RestaurantResource;
use App\Models\Order;
use App\Models\Restaurant;
use Auth;
use Request;

class RestaurantController extends Controller {

    public function store(RestaurantRequest $request) {
        $restaurant = Restaurant::where('cr_no', $request->cr_no)
                ->orWhere('vat_no', $request->vat_no)
                ->orWhereHas('admin', function ($q) {
                    $q->where('id', Auth::id());
                })->orWhereHas('restaurantBranches', function ($q) {
                    $q->whereHas('BranchUsers', function ($q2) {
                        $q2->where('id', Auth::id());
                    });
                })->first();

        if ($restaurant) {
            return response()->json([
                'status' => false,
                'message' => translate('Restaurant is already exist in the system.')
            ], 406);
        }

        $restaurant = Restaurant::create([
            'name'          => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'cr_no'          => $request->cr_no,
            'vat_no'          => $request->vat_no,
            'contact_user'          => $request->email,
            'description'          => $request->description ?? '',
            'content'          => $request->content ?? '',
            'logo'                  => $request->logo,
            'cr_file'          => $request->cr_file,
            'vat_file'          => $request->vat_file,
            'admin_id'             => Auth::id(),
        ]);
        $user = Auth::user();
        $user->restaurant_id = $restaurant->id;
        $user->save();

        return (new RestaurantResource($restaurant));
        // return $this->successResponse($restaurantResource);
    }

    public function show() {
        $restaurant = Restaurant::whereHas('admin', function($q) {
            $q->where('id', Auth::id());
        })->orWhereHas('restaurantBranches', function($q) {
            $q->whereHas('BranchUsers', function($q2) {
                $q2->where('id', Auth::id());
            });
        })->first();

        if ($restaurant) {
            $restaurantResource = new RestaurantResource($restaurant);
            return $this->successResponse($restaurantResource);
        } else {
            $msg = translate("You Don't have a resturant register");
            return $this->errorResponse($msg);
        }
    }

    function getOrderList(Request $request)
        {
            $order_query = Order::query();
            if ($request->payment_status != "" || $request->payment_status != null) {
                $order_query->where('payment_status', $request->payment_status);
            }
            if ($request->delivery_status != "" || $request->delivery_status != null) {
                $delivery_status = $request->delivery_status;
                $order_query->whereIn("id", function ($query) use ($delivery_status) {
                    $query->select('order_id')
                        ->from('order_details')
                        ->where('delivery_status', $delivery_status);
                });
            }

            return new PurchaseHistoryMiniCollection($order_query->where('seller_id', auth()->user()->id)->latest()->paginate(5));
        }

}
