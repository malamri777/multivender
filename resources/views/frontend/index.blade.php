@extends('frontend.layouts.app')

@section('content')
<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="row">
            @if(count($featured_categories) > 0)
            <div class="col-lg-2 d-none d-lg-flex">
                <div class="categories-dropdown-wrap style-2 font-heading mt-30">
                    <div class="d-flex categori-dropdown-inner">
                        <ul>
                            @foreach ($featured_categories as $key => $category)
                            <li>
                                <a href="{{ route('products.category', $category->slug) }}"> <img
                                        src="{{ uploaded_asset($category->icon) }}" alt="" />
                                    {{ $category->getTranslation('name') }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @php
            $mainBannerSize = 7;
            if (empty(get_setting_json('home_banner1_images')) or count($featured_categories) == 0) {
            $mainBannerSize = 12;
            } elseif (empty(get_setting_json('home_banner1_images'))) {
            $mainBannerSize = 9;
            } elseif (count($featured_categories) == 0) {
            $mainBannerSize = 7;
            }
            @endphp
            <div class="col-lg-{{ $mainBannerSize }}">
                <div class="home-slide-cover mt-30">
                    <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                        @if (get_setting('home_slider_images') != null)
                        @php
                        $slider_images = json_decode(get_setting('home_slider_images'), true);
                        $slider_links = json_decode(get_setting('home_slider_links'), true);
                        if (isLocaleAr()) {
                        $slider_body = json_decode(get_setting('home_slider_body_ar'), true);
                        } else {
                        $slider_body = json_decode(get_setting('home_slider_body_en'), true);
                        }
                        @endphp
                        @foreach ($slider_images as $key => $value)
                        <div class="single-hero-slider single-animation-wrap"
                            style="background-image: url({{ uploaded_asset($slider_images[$key]) }})">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40">
                                    {{ $slider_body[$key]}}
                                </h1>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="slider-arrow hero-slider-1-arrow"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    @if (!empty(get_setting_json('home_banner1_images')))
                    @php
                    $slider_banner_images = get_setting_json('home_banner1_images');
                    $slider_banner_links = get_setting_json('home_banner1_links');
                    if (isLocaleAr()) {
                    $slider_banner_body = get_setting_json('home_banner1_body_ar');
                    } else {
                    $slider_banner_body = get_setting_json('home_banner1_body_en');
                    }
                    @endphp
                    @foreach ($slider_banner_images as $key => $value)
                    <div class="col-md-6 col-lg-12">
                        <div class="banner-img style-4 mt-40">
                            <img src="{{ uploaded_asset($slider_banner_images[$key]) }}" alt="" />
                            <div class="banner-text">
                                <h4 class="mb-30">
                                    {{ $slider_banner_body[$key] }}
                                </h4>
                                <a href="{{ $slider_banner_links[$key] }}" class="btn btn-xs mb-50">Shop Now <i
                                        class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--End hero slider-->
<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>{{ translate('Selected Categories') }}</h3>
                <ul class="list-inline nav nav-tabs links">
                    @foreach($top10_categories as $category)
                    <li class="list-inline-item nav-item">
                        <a class="nav-link" href="{{ route('products.category', $category->slug) }}">{{
                            $category->getTranslation('name') }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow"
                id="carausel-10-columns-arrows"></div>
        </div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">
                @foreach(\App\Models\Brand::get() as $key => $value)
                <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".{{ $key }} s">
                    <figure class="img-hover-scale overflow-hidden">
                        <a href="{{ route('products.brand', ['brand_slug' => $value->slug ])}}"><img
                                src="{{ uploaded_asset($value->logo) }}" alt="" height="70px" /></a>
                    </figure>
                    <h6><a href="{{ route('products.brand', ['brand_slug' => $value->slug ])}}">{{
                            $value->getTranslation('name') }} </a></h6>
                    <span>26 items</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!--End category slider-->
{{-- <section class="banners mb-25">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <img src="assets/frontend/imgs/banner/banner-1.png" alt="" />
                    <div class="banner-text">
                        <h4>
                            Everyday Fresh & <br />Clean with Our<br />
                            Products
                        </h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <img src="assets/frontend/imgs/banner/banner-2.png" alt="" />
                    <div class="banner-text">
                        <h4>
                            Make your Breakfast<br />
                            Healthy and Easy
                        </h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-md-none d-lg-flex">
                <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                    <img src="assets/frontend/imgs/banner/banner-3.png" alt="" />
                    <div class="banner-text">
                        <h4>The best Organic <br />Products Online</h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!--End banners-->
<section class="bg-grey-1 section-padding pt-100 pb-80 mb-80">
    <div class="container">
        <h1 class="mb-80 text-center">Trending items</h1>
        <div class="row product-grid">
            @foreach ($trend_products_list as $product)
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                <div class="product-cart-wrap mb-30">
                    <div class="product-img-action-wrap">
                        <div class="product-img product-img-zoom">
                            <a href="{{ route('product', $product->slug) }}">
                                <img class="default-img" src="{{ uploaded_asset($product->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}" alt="{{ $product->getTranslation('name')  }}" />
                                <img class="hover-img" src="{{ uploaded_asset($product->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}" alt="{{ $product->getTranslation('name') }}" />
                            </a>
                        </div>
                        <div class="product-action-1">
                            {{-- <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html">
                                <i class="fi-rs-heart"></i>
                            </a>
                            <a aria-label="Compare" class="action-btn" href="shop-compare.html">
                                <i class="fi-rs-shuffle"></i>
                            </a> --}}
                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                data-bs-target="#quickViewModal">
                                <i class="fi-rs-eye"></i>
                            </a>
                        </div>
                        {{-- <div class="product-badges product-badges-position product-badges-mrg">
                            <span class="hot">Hot</span>
                        </div> --}}
                    </div>
                    <div class="product-content-wrap">
                        <div class="product-category">
                            <a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->getTranslation('name') }}</a>
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
                                By <a href="{{ route('products.brand', $product->brand->slug) }}">{{ $product->brand->getTranslation('name')}}</a>
                            </span>
                        </div>
                        <div class="product-card-bottom">
                            <div class="product-price">
                                <span>{{ $product->warehouseProductsLowestPrice->first()->price ?? 0 }}</span>
                                {{-- <span class="old-price">$32.8</span> --}}
                            </div>
                            <div class="add-cart">
                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!--row-->
    </div>
</section>
<!--End Best Sales-->

{{-- <section class="section-padding mb-30">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                data-wow-delay="0">
                <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                <div class="product-list-small animated animated">
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-1.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Nestle Original Coffee-Mate Coffee Creamer</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-2.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Nestle Original Coffee-Mate Coffee Creamer</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-3.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Nestle Original Coffee-Mate Coffee Creamer</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                data-wow-delay=".1s">
                <h4 class="section-title style-1 mb-30 animated animated">Trending Products</h4>
                <div class="product-list-small animated animated">
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-4.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Organic Cage-Free Grade A Large Brown Eggs</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-5.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Seeds of Change Organic Quinoa, Brown, & Red
                                    Rice</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-6.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Naturally Flavored Cinnamon Vanilla Light
                                    Roast Coffee</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                data-wow-delay=".2s">
                <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                <div class="product-list-small animated animated">
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-7.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Pepperidge Farm Farmhouse Hearty White
                                    Bread</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-8.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Organic Frozen Triple Berry Blend</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-9.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Oroweat Country Buttermilk Bread</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                data-wow-delay=".3s">
                <h4 class="section-title style-1 mb-30 animated animated">Top Rated</h4>
                <div class="product-list-small animated animated">
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-10.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Foster Farms Takeout Crispy Classic Buffalo
                                    Wings</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-11.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">Angie’s Boomchickapop Sweet & Salty Kettle
                                    Corn</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="shop-product-right.html"><img
                                    src="{{ asset('assets/frontend/imgs/shop/thumbnail-12.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="shop-product-right.html">All Natural Italian-Style Chicken
                                    Meatballs</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                <span>$32.85</span>
                                <span class="old-price">$33.8</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!--End 4 columns-->
@endsection

@section('script')
@endsection
