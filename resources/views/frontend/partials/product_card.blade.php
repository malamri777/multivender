<div class="product-img-action-wrap">
    <div class="product-img product-img-zoom">
        <a href="{{ route('product', $product->slug) }}">
            <img class="default-img"
                src="{{ uploaded_asset($product->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                alt="{{ $product->getTranslation('name')  }}" />
            <img class="hover-img"
                src="{{ uploaded_asset($product->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                alt="{{ $product->getTranslation('name') }}" />
        </a>
    </div>
    <div class="product-action-1">
        {{-- <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html">
            <i class="fi-rs-heart"></i>
        </a>
        <a aria-label="Compare" class="action-btn" href="shop-compare.html">
            <i class="fi-rs-shuffle"></i>
        </a> --}}
        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal">
            <i class="fi-rs-eye"></i>
        </a>
    </div>
    {{-- <div class="product-badges product-badges-position product-badges-mrg">
        <span class="hot">Hot</span>
    </div> --}}
</div>
<div class="product-content-wrap">
    <div class="product-category">
        <a href="{{ route('products.category', $product->category->slug) }}">{{
            $product->category->getTranslation('name') }}</a>
    </div>
    <h2><a href="{{ route('product', $product->slug) }}">{{ $product->getTranslation('name') }}</a></h2>
    <div class="product-rate-cover">
        <div class="product-rate d-inline-block">
            <div class="product-rating" style="width: 90%"></div>
        </div>
        {{-- <span class="font-small ml-5 text-muted"> (4.0)</span> --}}
    </div>
    <div>
        {{-- <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span> --}}
        <span class="font-small text-muted">
            By <a href="{{ route('products.brand', $product->brand->slug) }}">{{
                $product->brand->getTranslation('name')}}</a>
        </span>
    </div>
    <div class="product-card-bottom">
        <div class="product-price">
            <span>{{ single_price($product->warehouseProductsLowestPrice->first()->price ?? 0) }}</span>
            {{-- <span class="old-price">$32.8</span> --}}
        </div>
        <div class="add-cart">
            <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
        </div>
    </div>
</div>
