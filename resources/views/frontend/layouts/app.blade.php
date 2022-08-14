<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()?->rtl == 1)
<html lang="ar" dir="rtl" class="rtl">
@else

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">


    @yield('meta')

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ get_setting('meta_title') }}">
    <meta itemprop="description" content="{{ get_setting('meta_description') }}">
    <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
    <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ get_setting('meta_title') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}" />
    <meta property="og:description" content="{{ get_setting('meta_description') }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ uploaded_asset(get_setting('site_icon')) }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/plugins/animate.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}" />
    @if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()?->rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/rtl.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css') }}" />

    <script>
        var AIZ = AIZ || {};
            AIZ.local = {
                nothing_selected: '{!! translate('Nothing selected', null, true) !!}',
                nothing_found: '{!! translate('Nothing found', null, true) !!}',
                choose_file: '{{ translate('Choose file') }}',
                file_selected: '{{ translate('File selected') }}',
                files_selected: '{{ translate('Files selected') }}',
                add_more_files: '{{ translate('Add more files') }}',
                adding_more_files: '{{ translate('Adding more files') }}',
                drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
                browse: '{{ translate('Browse') }}',
                upload_complete: '{{ translate('Upload complete') }}',
                upload_paused: '{{ translate('Upload paused') }}',
                resume_upload: '{{ translate('Resume upload') }}',
                pause_upload: '{{ translate('Pause upload') }}',
                retry_upload: '{{ translate('Retry upload') }}',
                cancel_upload: '{{ translate('Cancel upload') }}',
                uploading: '{{ translate('Uploading') }}',
                processing: '{{ translate('Processing') }}',
                complete: '{{ translate('Complete') }}',
                file: '{{ translate('File') }}',
                files: '{{ translate('Files') }}',
            }
    </script>


    @if (get_setting('google_analytics') == 1)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('TRACKING_ID') }}"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ env('TRACKING_ID') }}');
    </script>
    @endif

    @if (get_setting('facebook_pixel') == 1)
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ env('FACEBOOK_PIXEL_ID') }}');
            fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
    @endif

    @php
    echo get_setting('header_script');
    @endphp

</head>

<body>
    <!-- Quick view -->
    <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-2.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-1.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-3.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-4.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-5.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-6.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('assets/frontend/imgs/shop/product-16-7.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-3.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-4.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-5.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-6.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-7.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-8.jpg') }}"
                                            alt="product image" /></div>
                                    <div><img src="{{ asset('assets/frontend/imgs/shop/thumbnail-9.jpg') }}"
                                            alt="product image" /></div>
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <span class="stock-status out-stock"> Sale Off </span>
                                <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">Seeds of
                                        Change Organic Quinoa, Brown</a></h3>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">$38</span>
                                        <span>
                                            <span class="save-price font-md color3 ml-15">26% Off</span>
                                            <span class="old-price font-md ml-15">$52</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i
                                                class="fi-rs-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul>
                                        <li class="mb-5">Vendor: <span class="text-brand">Nest</span></li>
                                        <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2022</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="header-area header-style-1 header-style-5 header-height-2">
        <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div>
        @include('frontend.inc.topHeader')
        @include('frontend.inc.middleHeader')
        @include('frontend.inc.bottomHeader')
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ env('APP_NAME') }}" />
                    </a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            @include('frontend.partials.mobile_side_menu')
        </div>
    </div>
    <!--End header-->
    <main class="main">
        @yield('content')

    </main>
    @include('frontend.inc.footer')

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('assets/frontend/imgs/theme/loading.gif') }}" alt="Loading..." />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="{{ asset('assets/frontend/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/shop.js') }}"></script>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>

    <script>
        $( document ).ready(function() {
           if ($('#lang-change').length > 0) {
                $('#lang-change li a').each(function() {
                    $(this).on('click', function(e){
                        e.preventDefault();
                        var $this = $(this);
                        var locale = $this.data('flag');
                        $.post('{{ route('language.change') }}',{_token: AIZ.data.csrf, locale:locale}, function(data){
                            location.reload();
                        });

                    });
                });
            }
        });
    </script>

</body>

</html>
