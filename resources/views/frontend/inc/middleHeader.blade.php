<div class="header-middle header-middle-ptb-1 d-none d-lg-block">
    <div class="container">
        <div class="header-wrap">
            <div class="logo logo-width-1">
                <a href="{{ route('home') }}">
                    <img src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ env('APP_NAME') }}" />
                </a>
            </div>
            <div class="header-right">
                <div class="search-style-2">
                    <form action="#">
                        <select class="select-active">
                            <option>All Categories</option>
                            @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $key => $category)
                                <option>
                                    {{ $category->getTranslation('name')}}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Search for items..." />
                    </form>
                </div>
                <div class="header-action-right">
                    <div class="header-action-2">
                        <div class="search-location">
                            <form action="#">
                                <select class="select-active">
                                    <option>Your Location</option>
                                    @foreach(\App\Models\City::get() as $key => $city)
                                        <option>{{ $city->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        {{-- <div class="header-action-icon-2">
                            <a href="shop-compare.html">
                                <img class="svgInject" alt="SWO"
                                    src="{{ asset('assets/frontend/imgs/theme/icons/icon-compare.svg') }}" />
                                <span class="pro-count blue">3</span>
                            </a>
                            <a href="shop-compare.html"><span class="lable ml-0">Compare</span></a>
                        </div>
                        <div class="header-action-icon-2">
                            <a href="shop-wishlist.html">
                                <img class="svgInject" alt="SWO"
                                    src="{{ asset('assets/frontend/imgs/theme/icons/icon-heart.svg') }}" />
                                <span class="pro-count blue">6</span>
                            </a>
                            <a href="shop-wishlist.html"><span class="lable">Wishlist</span></a>
                        </div> --}}
                        @include('frontend.partials.cart')

                        @guest
                            <div class="header-action-icon-2">
                                <a href="{{ route('user.login') }}">
                                    <img class="svgInject" alt="{{ env('APP_NAME') }}" src="{{ asset('assets/frontend/imgs/theme/icons/icon-user.svg') }}" />
                                </a>
                                <a href="{{ route('user.registration') }}"><span class="lable ml-0">Register</span></a>
                            </div>
                        @endguest
                        @auth
                            <div class="header-action-icon-2">
                                <a href="page-account.html">
                                    <img class="svgInject" alt="SWO" src="{{ asset('assets/frontend/imgs/theme/icons/icon-user.svg') }}" />
                                </a>
                                <a href="page-account.html"><span class="lable ml-0">Account</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-user mr-10"></i>My
                                                Account</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-location-alt mr-10"></i>Order
                                                Tracking</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-label mr-10"></i>My
                                                Voucher</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>{{ translate('Logout')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
