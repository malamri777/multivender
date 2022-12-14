<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\BrandCollection;
use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\CitiesCollection;
use App\Http\Resources\V2\CountriesCollection;
use App\Http\Resources\V2\DistrictCollection;
use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductResource;
use App\Http\Resources\V2\StatesCollection;
use App\Http\Resources\V2\SupplierCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\State;
use App\Models\Supplier;
use Cache;
use Illuminate\Http\Request;

class RestaurantPublicController extends Controller
{
    public function app()
    {
        $mobile_home_slider = Cache::rememberForever('mobile_home_slider', function () {
            $mobile_slider_images = json_decode(get_setting('mobile_home_slider_images'), true);
            $mobile_slider_links = json_decode(get_setting('mobile_home_slider_links'), true);
            $sliders = [];

            foreach ($mobile_slider_images ?? [] as $key => $image) {
                $slider['image'] = uploaded_asset($image);
                $slider['link'] = $mobile_slider_links[$key];
                $sliders[] = $slider;
            }

            return $sliders;
        });

        $categories = Cache::remember('mobile_home_categories', 86400, function () {
            return new CategoryCollection(Category::orderBy('order_level', 'desc')->get());
        });

        $brands = Cache::remember('mobile_home_brands', 86400, function () {
            return new BrandCollection(Brand::orderBy('updated_at', 'desc')->get());
        });

        $suppliers = Cache::remember('mobile_home_suppliers', 86400, function () {
            return new SupplierCollection(Supplier::get());
        });

        $bestSelling = Cache::remember('mobile_home_best_selling_products', 86400, function () {
            $products = Product::orderBy('created_at', 'desc')
                ->physical();
            return new ProductMiniCollection(filter_products($products)->limit(10)->get());
        });

        $latest = Cache::remember('mobile_home_latest_products', 86400, function () {
            $products = Product::orderBy('created_at', 'desc');
            return new ProductMiniCollection(Product::latest()->paginate(10));
        });



        return response()->json([
            'result' => true,
            'slider' => $mobile_home_slider,
            'categories' => $categories,
            'brands' => $brands,
            'suppliers' => $suppliers,
            'bestSellingProduct' => $bestSelling,
            'latest' => $latest
        ]);
    }

    public function supplierList()
    {
        $suppliers = Supplier::where('supplier_waiting_for_upload_file', 1)
            ->where('supplier_waiting_for_admin_approve', 1)
            ->orderBy('order')->paginate(10);
        $supplierResource = new SupplierCollection($suppliers);
        return $supplierResource;
    }

    public function productBySupplier(Supplier $supplier)
    {
        $products = Product::whereHas('warehouse', function ($q) use ($supplier) {
            $q->where('supplier_id', $supplier->id);
        })->paginate(10);
        $productCollection = new ProductCollection($products);
        return $productCollection;
    }

    public function related($id)
    {
        return Cache::remember("app.related_products-$id", 86400, function () use ($id) {
            $product = Product::find($id);
            $products = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->physical();
            return new ProductMiniCollection(filter_products($products)->limit(10)->get());
        });
    }

    public function show($id)
    {
        return Cache::remember("app.product-show-$id", 86400, function () use ($id) {
            $product = Product::find($id);
            $productResource = new ProductResource($product);
            return $productResource;
        });
    }

    public function categoryList()
    {
        return Cache::remember("app.product-category", 86400, function () use ($id) {
            $categories = Category::get();
            return CategoryCollection::make($categories);
        });
    }

    public function getLocationList()
    {
        try {
            $countries = Cache::rememberForever('api.locations', function () {
                return Country::with(['states', 'states.cities', 'states.cities.districts'])->get();
            });

            return response()->json([
                'success' => true,
                'data' => $countries
            ], 200);
        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
            }
            return response()->json($data, 406);
        }
    }

    public function getCountriesList()
    {
        try {
            $countries = Cache::rememberForever('ap.countries', function () {
                return Country::where('status', true)->get();
            });

            return response()->json([
                'success' => true,
                'data' => CountriesCollection::make($countries)
            ], 200);
        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
            }
            return response()->json($data, 406);
        }
    }

    public function getStateList()
    {
        try {
            $states = Cache::rememberForever('ap.states', function () {
                return State::where('status', true)->get();
            });

            return response()->json([
                'success' => true,
                'data' => StatesCollection::make($states)
            ], 200);
        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
            }
            return response()->json($data, 406);
        }
    }

    public function getCityList(State $state)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => CitiesCollection::make($state->cities)
            ], 200);
        } catch (\Exception $e) {
            $data = [];
            $data['success'] = false;
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
            }
            return response()->json($data, 406);
        }
    }

    public function getDistrictList(City $city)
    {
        try {

            return response()->json([
                'success' => true,
                'data' => DistrictCollection::make($city->districts)
            ], 200);
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
