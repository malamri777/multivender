<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\FlashDealProduct;
use App\Models\ProductStock;
use App\Models\ProductTax;
use App\Models\Product;
use App\Models\User;
use App\Models\WholesalePrice;
use Artisan;
use Auth;
use Illuminate\Http\Request;
use Modules\Translations\Entities\ProductTranslation;

class WholesaleService
{
    public function store(Request $request)
    {
        $product = new Product;
        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));

        if(Product::where('slug', $product->slug)->count() > 0){
            flash(translate('Another product exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        $product->name = $request->name;
        $product->added_by = $request->added_by;
        if(Auth::user()->user_type == 'seller'){
            $product->user_id = Auth::user()->id;
            if(get_setting('product_approve_by_admin') == 1) {
                $product->approved = 0;
            }
        }
        else{
            $product->user_id = User::where('user_type', 'admin')->first()->id;
        }
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->barcode = $request->barcode;

        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }
        $product->photos = $request->photos;
        $product->thumbnail_img = $request->thumbnail_img;
        $product->unit = $request->unit;
        $product->min_qty = $request->min_qty;
        $product->low_stock_quantity = $request->low_stock_quantity;
        $product->stock_visibility_state = $request->stock_visibility_state;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags = implode(',', $tags);

        $product->description = $request->description;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;

        $product->shipping_type = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }
        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if($request->has('meta_img')){
            $product->meta_img = $request->meta_img;
        } else {
            $product->meta_img = $product->thumbnail_img;
        }

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $colors = array();
        $product->colors = json_encode($colors);

        $choice_options = array();
        $product->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $product->published = 1;
        if($request->button == 'unpublish' || $request->button == 'draft') {
            $product->published = 0;
        }

        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }
        if ($request->has('featured')) {
            $product->featured = 1;
        }
        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }
        $product->cash_on_delivery = 0;
        if ($request->cash_on_delivery) {
            $product->cash_on_delivery = 1;
        }

        $product->wholesale_product = 1;
        $product->save();

        $product_stock              = new ProductStock;
        $product_stock->product_id  = $product->id;
        $product_stock->variant     = '';
        $product_stock->price       = $request->unit_price;
        $product_stock->sku         = $request->sku;
        $product_stock->qty         = $request->current_stock;
        $product_stock->save();

        if($request->has('wholesale_price')){
            foreach($request->wholesale_price as $key => $price){
                $wholesale_price = new WholesalePrice;
                $wholesale_price->product_stock_id = $product_stock->id;
                $wholesale_price->min_qty = $request->wholesale_min_qty[$key];
                $wholesale_price->max_qty = $request->wholesale_max_qty[$key];
                $wholesale_price->price = $price;
                $wholesale_price->save();
            }
        }

        //VAT & Tax
        if($request->tax_id) {
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }
        //Flash Deal
        if($request->flash_deal_id) {
            $flash_deal_product = new FlashDealProduct;
            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->save();
        }

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
        $product_translation->save();

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    public function update(Request $request , $id){
        $product                    = Product::findOrFail($id);
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->barcode           = $request->barcode;
        $product->cash_on_delivery = 0;
        $product->featured = 0;
        $product->todays_deal = 0;
        $product->is_quantity_multiplied = 0;

        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }

        if($request->lang == env("DEFAULT_LANGUAGE")){
            $product->name          = $request->name;
            $product->unit          = $request->unit;
            $product->description   = $request->description;
            $product->slug          = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->slug)));
        }

        if($request->slug == null){
            $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));
        }

        if(Product::where('id', '!=', $product->id)->where('slug', $product->slug)->count() > 0){
            flash(translate('Another product exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        $product->photos                 = $request->photos;
        $product->thumbnail_img          = $request->thumbnail_img;
        $product->min_qty                = $request->min_qty;
        $product->low_stock_quantity     = $request->low_stock_quantity;
        $product->stock_visibility_state = $request->stock_visibility_state;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags           = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link     = $request->video_link;
        $product->unit_price     = $request->unit_price;
        $product->discount       = $request->discount;
        $product->discount_type     = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime( $date_var[1]);
        }

        $product->shipping_type  = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }

        if ($request->has('featured')) {
            $product->featured = 1;
        }

        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_img          = $request->meta_img;

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        $product->pdf = $request->pdf;

        $colors = array();
        $product->colors = json_encode($colors);

        $choice_options = array();
        $product->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $product_stock              = $product->stocks->first();
        $product_stock->price       = $request->unit_price;
        $product_stock->sku         = $request->sku;
        $product_stock->qty         = $request->current_stock;
        $product_stock->save();

        $product->save();

        foreach ($product->stocks->first()->wholesalePrices as $key => $wholesalePrice) {
            $wholesalePrice->delete();
        }

        if($request->has('wholesale_price')){
            foreach($request->wholesale_price as $key => $price){
                $wholesale_price = new WholesalePrice;
                $wholesale_price->product_stock_id = $product_stock->id;
                $wholesale_price->min_qty = $request->wholesale_min_qty[$key];
                $wholesale_price->max_qty = $request->wholesale_max_qty[$key];
                $wholesale_price->price = $price;
                $wholesale_price->save();
            }
        }

        //Flash Deal
        if($request->flash_deal_id) {
            if($product->flash_deal_product){
                $flash_deal_product = FlashDealProduct::findOrFail($product->flash_deal_product->id);
                if(!$flash_deal_product) {
                    $flash_deal_product = new FlashDealProduct;
                }
            } else {
                $flash_deal_product = new FlashDealProduct;
            }

            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->discount = $request->flash_discount;
            $flash_deal_product->discount_type = $request->flash_discount_type;
            $flash_deal_product->save();
        }

        //VAT & Tax
        if($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }

        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
        $product_translation->name          = $request->name;
        $product_translation->unit          = $request->unit;
        $product_translation->description   = $request->description;
        $product_translation->save();

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        if(Product::destroy($id)){
            Cart::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
    }
}
