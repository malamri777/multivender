<?php
namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\RestaurantResource;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Services\RestaurantService;
use App\Utility\WathqUtility;
use Auth;
use Illuminate\Http\Request;
use Str;

class RestaurantController extends Controller {

    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function store(RestaurantRequest $request) {

        $restaurant = $this->restaurantService->store($request);

        return (new RestaurantResource($restaurant));
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

    public function uploadFiles(Request $request, Restaurant $restaurant) {
        $request->validate([
            'cr_file'    => 'required',
            'vat_file'   => 'required',
        ]);

        if(empty($restaurant)) {
            return response()->json([
                'status' => false,
                'message' => "Incorrect data entry"
            ], 406);
        }
        $restaurant->cr_file = $request->cr_file;
        $restaurant->vat_file = $request->vat_file;
        $restaurant->restaurant_waiting_for_upload_file = false;
        $restaurant->save();

        return response()->json([
            'success' => true,
            'message' => translate('Successfully updated')
        ]);
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
