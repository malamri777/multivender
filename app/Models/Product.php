<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\Scopes\ProductWarehouseScope;
use Modules\Translations\Entities\ProductTranslation;

class Product extends Model
{
    use Sluggable;

    protected $fillable = [
        'sku', 'name', 'added_by', 'user_id', 'category_id', 'brand_id', 'photos', 'thumbnail_img', 'video_provider', 'video_link',
        'tags', 'description', 'unit_price', 'purchase_price', 'variant_product', 'attributes', 'choice_options', 'unit', 'slug',
        'approved', 'choice_options', 'colors', 'variations', 'todays_deal', 'published', 'approved', 'stock_visibility_state',
        'cash_on_delivery', 'featured', 'seller_featured', 'current_stock', 'unit', 'min_qty', 'low_stock_quantity',
        'discount', 'discount_type', 'discount_start_date', 'discount_end_date', 'shipping_type', 'shipping_cost', 'is_quantity_multiplied',
        'est_shipping_days', 'meta_title', 'meta_description', 'meta_img', 'pdf', 'slug', 'rating', 'barcode', 'digital', 'external_link',
        'external_link_btn'
    ];

    protected $with = ['product_translations', 'taxes'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->product_translations->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ProductWarehouseScope);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 1);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function flash_deal_product()
    {
        return $this->hasOne(FlashDealProduct::class);
    }

    public function bids()
    {
        return $this->hasMany(AuctionProductBid::class);
    }

    public function warehouse()
    {
        return $this->hasManyThrough(
            warehouse::class,
            WarehouseProduct::class,
            'warehouse_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function warehouseProducts() {
        return $this->hasMany(WarehouseProduct::class)->orderBy('price');
    }

    public function warehouseProductsLowestPrice()
    {
        return $this->hasMany(WarehouseProduct::class)->orderBy('price')->limit(1);
    }

    public function scopeProductFilterLowPrice($query) {
        return $query;
    }

    public function scopePhysical($query)
    {
//        return $query->where('digital', 0);
        return $query;
    }




    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
