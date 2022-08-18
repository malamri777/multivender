@extends('frontend.layouts.app')

@section('content')

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Supplier List
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="archive-header-2 text-center">
            <h1 class="display-2 mb-50">Supplier List</h1>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="sidebar-widget-2 widget_search mb-50">
                        <div class="search-form">
                            <form action="#">
                                <input type="text" placeholder="Search Supplier (by name or ID)..." />
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-50">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We have <strong class="text-brand">{{ $supplierCount }}</strong> Supplier now</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">50</a></li>
                                    <li><a href="#">100</a></li>
                                    <li><a href="#">150</a></li>
                                    <li><a href="#">200</a></li>
                                    <li><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">Mall</a></li>
                                    <li><a href="#">Featured</a></li>
                                    <li><a href="#">Preferred</a></li>
                                    <li><a href="#">Total items</a></li>
                                    <li><a href="#">Avg. Rating</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row vendor-grid">
            @foreach ($suppliers as $supplier)
                <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                    <div class="vendor-wrap style-2 mb-40">
                        {{-- <div class="product-badges product-badges-position product-badges-mrg">
                            <span class="hot">Mall</span>
                        </div> --}}
                        <div class="vendor-img-action-wrap">
                            <div class="vendor-img">
                                <a href="vendor-details-1.html">
                                    <img class="default-img" src="{{ uploaded_asset($supplier->logo) }}" alt="" />
                                </a>
                            </div>
                            <div class="mt-10">
                                <span class="font-small total-product">{{ $supplier->warehouseProudct->count() ?? 0}} products</span>
                            </div>
                        </div>
                        <div class="vendor-content-wrap">
                            <div class="mb-30">
                                <div class="product-category">
                                    <span class="text-muted">Since {{ $supplier->created_at->format('Y') }}</span>
                                </div>
                                <h4 class="mb-5"><a href="#">{{ $supplier->name }}</a></h4>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="vendor-info d-flex justify-content-between align-items-end mt-30">
                                    <ul class="contact-infor text-muted">
                                        <li>
                                            <img src="assets/imgs/theme/icons/icon-location.svg" alt="" />
                                            <strong>Address:</strong>
                                            <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span>
                                        </li>
                                        <li>
                                            <img src="assets/imgs/theme/icons/icon-contact.svg" alt="" />
                                            <strong>Call Us:</strong><span>(+966) - 540-025-124553</span>
                                        </li>
                                    </ul>
                                    <a href="#" class="btn btn-xs">
                                        Visit Store
                                        <i class="fi-rs-arrow-small-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-area mt-20 mb-20">
            {{ $suppliers->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection
