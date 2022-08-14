<div class="header-bottom header-bottom-bg-color sticky-bar">
    <div class="container">
        <div class="header-wrap header-space-between position-relative">
            <div class="logo logo-width-1 d-block d-lg-none">
                <a href="{{ route('home') }}">
                    <img src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ env('APP_NAME') }}" />
                </a>
            </div>
            <div class="header-nav d-none d-lg-flex">
                <div class="main-categori-wrap d-none d-lg-block">
                    <a class="categories-button-active" href="#">
                        <span class="fi-rs-apps"></span> <span class="et">Trending</span> Categories
                        <i class="fi-rs-angle-down"></i>
                    </a>
                    <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                        <div class="d-flex categori-dropdown-inner">
                            <ul>
                                @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(5) as $key => $category)
                                    <li>
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            <img class="lazyload" src="{{ uploaded_asset($category->icon) }}"
                                            width="16" alt="{{ $category->getTranslation('name') }}" />
                                            {{ $category->getTranslation('name') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <ul class="end">
                                @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->skip(5)->take(5) as $key =>
                                $category)
                                <li>
                                    <a href="{{ route('products.category', $category->slug) }}">
                                        <img class="lazyload" src="{{ uploaded_asset($category->icon) }}" width="16"
                                            alt="{{ $category->getTranslation('name') }}" />
                                        {{ $category->getTranslation('name') }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- <div class="more_slide_open" style="display: none">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    <li>
                                        <a href="shop-grid-right.html"> <img
                                                src="assets/frontend/imgs/theme/icons/icon-1.svg" alt="" />Milks and
                                            Dairies</a>
                                    </li>
                                    <li>
                                        <a href="shop-grid-right.html"> <img
                                                src="assets/frontend/imgs/theme/icons/icon-2.svg" alt="" />Clothing &
                                            beauty</a>
                                    </li>
                                </ul>
                                <ul class="end">
                                    <li>
                                        <a href="shop-grid-right.html"> <img
                                                src="assets/frontend/imgs/theme/icons/icon-3.svg" alt="" />Wines &
                                            Drinks</a>
                                    </li>
                                    <li>
                                        <a href="shop-grid-right.html"> <img
                                                src="assets/frontend/imgs/theme/icons/icon-4.svg" alt="" />Fresh
                                            Seafood</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show
                                more...</span></div> --}}
                    </div>
                </div>
                <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                    <nav>
                        <ul>
                            <li class="hot-deals">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-hot-white.svg') }}" alt="hot deals" />
                                <a href="shop-grid-right.html">Deals</a>
                            </li>
                            @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
                                <li>
                                    <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}">{{
                                        translate($value) }}</a>
                                </li>
                            @endforeach

                            <li>
                                <a href="page-contact.html">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            @if (get_setting('helpline_number'))
                <div class="hotline d-none d-lg-flex">
                    <a href="tel:{{ get_setting('helpline_number') }}">
                        <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-headphone-white.svg') }}" alt="hotline" />
                    </a>
                    <p>{{ translate('Help line')}}<span>{{ get_setting('helpline_number') }}</span></p>
                </div>
            @endif
            <div class="header-action-icon-2 d-block d-lg-none">
                <div class="burger-icon burger-icon-white">
                    <span class="burger-icon-top"></span>
                    <span class="burger-icon-mid"></span>
                    <span class="burger-icon-bottom"></span>
                </div>
            </div>
            <div class="header-action-right d-block d-lg-none">
                <div class="header-action-2">
                    <div class="header-action-icon-2">
                        <a href="#">
                            <img alt="Nest" src="{{ asset('assets/frontend/imgs/theme/icons/icon-heart.svg')}}" />
                            <span class="pro-count white">4</span>
                        </a>
                    </div>

                    @include('frontend.partials.cart')
                </div>
            </div>
        </div>
    </div>
</div>
