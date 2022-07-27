<?php

namespace App\Http\Controllers\Supplier;

use Str;
use Auth;
use Artisan;
use Combinations;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\ProductTax;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\WarehouseProduct;
use App\Services\ProductService;

use App\Services\ProductTaxService;
use App\Services\ProductTranslation;
use App\Http\Requests\ProductRequest;
use App\Services\ProductStockService;
use App\Services\ProductFlashDealService;
use App\Http\Requests\WarehouseProductReqeust;



class ProductController extends Controller
{
    protected $productService;
    protected $productTaxService;
    protected $productFlashDealService;
    protected $productStockService;
    protected $ProductSupplierService;

    public function __construct(
        ProductService $productService,
        ProductTaxService $productTaxService,
        ProductFlashDealService $productFlashDealService,
        ProductStockService $productStockService,
    ) {
        $this->productService = $productService;
        $this->productTaxService = $productTaxService;
        $this->productFlashDealService = $productFlashDealService;
        $this->productStockService = $productStockService;
    }

    public function index(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%' . $search . '%');
        }
        $products = $products->paginate(10);
        return view('supplier.product.products.index', compact('products', 'search'));
    }

    public function create(Request $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (seller_package_validity_check()) {
                $categories = Category::where('parent_id', 0)
                    ->where('digital', 0)
                    ->with('childrenCategories')
                    ->get();
                return view('supplier.product.products.create', compact('categories'));
            } else {
                flash(translate('Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('supplier.product.products.create', compact('categories'));
    }

    public function exist()
    {
        return view('supplier.product.products.exist');
    }

    public function find_sku(Request $request)
    {
        if($request->input('sku') && !$request->input('warehouse')){

            $product = Product::where('sku',$request->input('sku'))->first();
            if($product){
                $warehouses = Warehouse::where('supplier_id', Auth::user()->provider_id)->get();
                $html = '';
                $html .= '<option selected label="Please Select">Please Select</option>';
                foreach ($warehouses as $row) {
                    $html .= '<option value="'.$row->id .'">'.$row->name.'</option>';
                }
                return response()->json(['product' => $product, 'warehouses' => $warehouses,'html' => $html]);
            }else{
                return response()->json(['product' => null, 'message' => 'not_found']);
            }

        }elseif($request->input('sku') && $request->input('warehouse')){

            $warehouses = Warehouse::where('supplier_id', Auth::user()->provider_id)->get();
            $html = '';
            foreach ($warehouses as $row) {
                if($row->id == $request->input('warehouse')){
                    $html .= '<option selected value="'.$row->id .'">'.$row->name.'</option>';
                }else{
                    $html .= '<option value="'.$row->id .'">'.$row->name.'</option>';
                }
            }

            $product = Product::where('sku',$request->input('sku'))->first();
            if($product){
                $warehouse_product = WarehouseProduct::where('product_id',$product->id)->where('warehouse_id',$request->input('warehouse'))->first();
                if($warehouse_product){
                    return response()->json(['product' => $product, 'warehouse_product' => $warehouse_product, 'html' => $html]);
                }else{
                    return response()->json(['product' => $product, 'warehouse_product' => false, 'html' => $html]);
                }
            }else{
                return response()->json(['product' => false, 'message' => 'not_found']);
            }
        }else{
            // no sku enterd
            return response()->json(['product' => null, 'message' => 'no_sku']);
        }
    }

    public function store_exist(WarehouseProductReqeust $request)
    {


        info($request->all());
        info(explode(' to ',$request->date_range)[0]);
        info(explode(' to ',$request->date_range)[1]);

        if($request->warehouse_product_id){

            $warehouseProduct = WarehouseProduct::where('id', $request->warehouse_product_id)->where('warehouse_id', $request->warehouse_id);
            if($warehouseProduct){
                $warehouseProduct = WarehouseProduct::where('id', $request->warehouse_product_id)
                ->update([
                    'price' => $request->price ,
                    'sale_price' => $request->sale_price ,
                    'quantity' => $request->quantity,
                    "sale_price_type" => $request->sale_price_type,
                    "sale_price_start_date" => explode(' to ',$request->date_range)[0],
                    "sale_price_end_date" => explode(' to ',$request->date_range)[1],
                    "low_stock_quantity" => $request->low_stock_quantity
                ]);



                if($warehouseProduct){
                    flash(translate('Warehouse Product Updated Successfully'))->success();
                }else{
                    flash(translate('Something Went Wrong'))->success();
                }
            }else{
                flash(translate('Something Went Wrong'))->success();
            }
        }else{
            $warehouseProduct = WarehouseProduct::create([
                "warehouse_id" => $request->warehouse_id,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "quantity" => $request->quantity,
                "sale_price_type" => $request->sale_price_type,
                "sale_price_start_date" => explode(' to ',$request->date_range)[0],
                "sale_price_end_date" => explode(' to ',$request->date_range)[1],
                "low_stock_quantity" => $request->low_stock_quantity,
                "product_id" => $request->product_id,
                'updated_by_id' =>  Auth::user()->id,
                'created_by_id' =>  Auth::user()->id
            ]);


            if($warehouseProduct){
                flash(translate('Warehouse Product Created Successfully'))->success();
            }else{
                flash(translate('Something Went Wrong'))->success();
            }
        }

        return redirect()->route('supplier.products.exist');
    }


    public function store(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return redirect()->route('supplier.products');
            }
        }

        $product = $this->productService->store($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));
        $request->merge(['product_id' => $product->id]);

        //VAT & Tax
        if($request->tax_id) {
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        //Product Stock
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        // Product Translations
        $request->merge(['lang' => config('myenv.DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('supplier.products');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (Auth::user()->id != $product->user_id) {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('supplier.product.products.edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        //Product
        $product = $this->productService->update($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]), $product);

        //Product Stock
        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }
        $request->merge(['product_id' => $product->id]);
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        //VAT & Tax
        if ($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            $request->merge(['product_id' => $product->id]);
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        ProductTranslation::where('lang', $request->lang)
            ->where('product_id', $request->product_id)
            ->update($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

    public function add_more_choice_option(Request $request)
    {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if (addon_is_activated('seller_subscription') && $request->status == 1) {
            $shop = $product->user->shop;
            if (
                $shop->package_invalid_at == null
                || Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) < 0
                || $shop->product_upload_limit <= $shop->user->products()->where('published', 1)->count()
            ) {
                return 2;
            }
        }
        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if ($product->save()) {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function duplicate($id)
    {
        $product = Product::find($id);
        if (Auth::user()->id != $product->user_id) {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return back();
            }
        }

        if (Auth::user()->id == $product->user_id) {
            $product_new = $product->replicate();
            $product_new->slug = $product_new->slug . '-' . Str::random(5);
            $product_new->save();

            //Product Stock
            $this->productStockService->product_duplicate_store($product->stocks, $product_new);

            //VAT & Tax
            $this->productTaxService->product_duplicate_store($product->taxes, $product_new);

            flash(translate('Product has been duplicated successfully'))->success();
            return redirect()->route('supplier.products');
        } else {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (Auth::user()->id != $product->user_id) {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }

        $product->product_translations()->delete();
        $product->stocks()->delete();
        $product->taxes()->delete();


        if (Product::destroy($id)) {
            Cart::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}
