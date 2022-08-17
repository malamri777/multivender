@extends('frontend.layouts.app')

@if (isset($category_id))
@php
$meta_title = \App\Models\Category::find($category_id)->meta_title;
$meta_description = \App\Models\Category::find($category_id)->meta_description;
@endphp
@elseif (isset($brand_id))
@php
$meta_title = \App\Models\Brand::find($brand_id)->meta_title;
$meta_description = \App\Models\Brand::find($brand_id)->meta_description;
@endphp
@else
@php
$meta_title = get_setting('meta_title');
$meta_description = get_setting('meta_description');
@endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $meta_title }}">
<meta itemprop="description" content="{{ $meta_description }}">

<!-- Twitter Card data -->
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $meta_title }}" />
<meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')
<div class="page-header mt-30 mb-50">
    <div class="container">
        <div class="archive-header">
            <div class="row align-items-center">
                <div class="col-xl-3">
                    @if(array_key_exists('isCategory', $pageType))
                    <h1 class="mb-15">{{ $pageType['category']->getTranslation('name') }}</h1>
                    <div class="breadcrumb">
                        <a href="index.html" rel="nofollow">
                            <i class="fi-rs-home mr-5"></i>
                            {{ translate('Home') }}
                        </a>
                        <span></span>
                        {{ translate('Category') }}
                        <span></span>
                        {{ $pageType['category']->getTranslation('name') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-30">
    <div class="row">
        <div class="col-lg-4-5">
            <div class="shop-product-fillter">
                <div class="totall-product">
                    <p>{{ translate('We found') }}<strong class="text-brand">{{ ' ' . $products->count() ?? 0
                            }}</strong> {{ translate('items') }}!</p>
                </div>
                <div class="sort-by-product-area">
                    <div class="sort-by-cover mr-10">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps"></i>{{ translate('Show') }}:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span> {{ $paginateNumber }} <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        @if($products->count() > 10)
                        <div class="sort-by-dropdown">
                            <ul>
                                <li>
                                    <a class="{{ $paginateNumber == 10 ? 'active' : '' }}"
                                        href="{{ Request::url() . '?paginateNumber=10'}}">10</a>
                                </li>
                                <li>
                                    <a class="{{ $paginateNumber == 20 ? 'active' : '' }}"
                                        href="{{ Request::url() . '?paginateNumber=20'}}">20</a>
                                </li>
                                <li>
                                    <a class="{{ $paginateNumber == 40 ? 'active' : '' }}"
                                        href="{{ Request::url() . '?paginateNumber=40'}}">40</a>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="sort-by-cover">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps-sort"></i>{{ translate('Sort by') }}:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span>
                                    @if($sort_by == 'newest')
                                    {{ translate('Newest') }}
                                    @elseif($sort_by == 'oldest')
                                    {{ translate('Oldest') }}
                                    @elseif($sort_by == 'price-asc')
                                    {{ translate('Price: Low to High') }}
                                    @elseif($sort_by == 'price-desc')
                                    {{ translate('Price: High to Low') }}
                                    @else
                                    {{ translate('None') }}
                                    @endif
                                    <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">
                            <ul>
                                <li><a class="{{ $sort_by == 'newest' ? 'active' : ''}}"
                                        href="{{ Request::url() . '?sort_by=newest'}}">{{ translate('Newest') }}</a>
                                </li>
                                <li><a class="{{ $sort_by == 'oldest' ? 'active' : ''}}"
                                        href="{{ Request::url() . '?sort_by=oldest'}}">{{ translate('Oldest') }}</a>
                                </li>
                                <li><a class="{{ $sort_by == 'price-asc' ? 'active' : ''}}"
                                        href="{{ Request::url() . '?sort_by=price-asc'}}">{{ translate('Price: Low to
                                        High') }}</a></li>
                                <li><a class="{{ $sort_by == 'price-desc' ? 'active' : ''}}"
                                        href="{{ Request::url() . '?sort_by=price-desc'}}">{{ translate('Price: High to
                                        Low') }}</a></li>
                                <li><a class="{{ $sort_by == '' or isset($sort_by) ? 'active' : ''}}"
                                        href="{{ Request::url() }}">{{ translate('None') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if($products and $products->count() > 0)
                <div class="row product-grid">
                    @foreach($products as $product)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30">
                            @include('frontend.partials.product_card', $product)
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--product grid-->
                <div class="pagination-area mt-20 mb-20">
                    {{ $products->appends(request()->input())->links() }}
                </div>

            @else
            <div class="text-center mt-100">
                <h1>{{ translate('No Prodeuct') }}</h1>
            </div>
            @endif

            <!--End Deals-->
        </div>
        <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
            <div class="sidebar-widget widget-category-2 mb-30">
                <h5 class="section-title style-1 mb-30">Category</h5>
                <ul>
                    @php
                    $categories = \App\Models\Category::withCount('products')->where('level', 0)->get();
                    @endphp
                    @foreach($categories as $category)
                    <li>
                    <a href="{{ route('products.category', $category->slug)  }}">
                            <img src="{{ $category->icon }}" alt="" />
                            {{$category->getTranslation('name')}}
                        </a>
                        <span class="count">{{ $category->products_count }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- Fillter By Price -->
            {{-- <div class="sidebar-widget price_range range mb-30">
                <h5 class="section-title style-1 mb-30">Fill by price</h5>
                <div class="price-filter">
                    <div class="price-filter-inner">
                        <div id="slider-range" class="mb-20"></div>
                        <div class="d-flex justify-content-between">
                            <div class="caption">From: <strong id="slider-range-value1" class="text-brand"></strong>
                            </div>
                            <div class="caption">To: <strong id="slider-range-value2" class="text-brand"></strong></div>
                        </div>
                    </div>
                </div>
                <div class="list-group">
                    <div class="list-group-item mb-10 mt-10">
                        <label class="fw-900">Color</label>
                        <div class="custome-checkbox">
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox1"><span>Red (56)</span></label>
                            <br />
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox2"><span>Green (78)</span></label>
                            <br />
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox3"><span>Blue (54)</span></label>
                        </div>
                        <label class="fw-900 mt-15">Item Condition</label>
                        <div class="custome-checkbox">
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox11"><span>New (1506)</span></label>
                            <br />
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox21"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox21"><span>Refurbished
                                    (27)</span></label>
                            <br />
                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox31"
                                value="" />
                            <label class="form-check-label" for="exampleCheckbox31"><span>Used (45)</span></label>
                        </div>
                    </div>
                </div>
                <a href="shop-grid-right.html" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i>
                    Fillter</a>
            </div> --}}
            <!-- Product sidebar Widget -->
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
</script>
@endsection
