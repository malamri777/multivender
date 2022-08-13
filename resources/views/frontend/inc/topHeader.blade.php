<div class="header-top header-top-ptb-1 d-none d-lg-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-4">
                <div class="header-info">
                    <ul>
                        <li><a href="page-about.htlm">About Us</a></li>
                        <li><a href="page-account.html">My Account</a></li>
                        <li><a href="shop-wishlist.html">Wishlist</a></li>
                        <li><a href="shop-order.html">Order Tracking</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-6 col-lg-4">
                <div class="text-center">
                    <div id="news-flash" class="d-inline-block">
                        <ul>
                            <li>100% Secure delivery without contacting the courier</li>
                            <li>Supper Value Deals - Save more with coupons</li>
                            <li>Trendy 25silver jewelry, save up 35% off today</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="header-info header-info-right">
                    <ul>
                        <li>Need help? Call Us: <strong class="text-brand"> + 1800 900</strong></li>
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            } else {
                                $locale = 'en';
                            }

                            $currentLocale = \App\Models\Language::where('status', 1)
                                ->where('code', $locale)
                                ->first();

                            $otherLanguage = \App\Models\Language::where('status', 1)
                                ->where('code', '!=', $locale)
                                ->get();
                        @endphp
                        <li>
                            <a class="language-dropdown-active" href="javascript:void(0)">{{ $currentLocale->name }} <i
                                    class="fi-rs-angle-small-down"></i></a>
                            <ul class="language-dropdown" id="lang-change">
                                @foreach ($otherLanguage as $key => $language)
                                    <li>
                                        <a class="language-dropdown" data-flag="{{ $language->code }}" href="javascript:void(0)">
                                            <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" alt="{{ $language->name }}" />
                                            {{ $language->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
