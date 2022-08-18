<footer class="main">
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col">
                    <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0 wow animate__animated animate__fadeInUp"
                        data-wow-delay="0">
                        <div class="logo mb-30">
                            <a href="{{ route('home') }}">
                                @if(get_setting('footer_logo') != null)
                                    <img src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}">
                                @else
                                    <img src="{{ uploaded_asset(get_setting('header_logo')) }}"
                                        alt="{{ env('APP_NAME') }}" />
                                @endif
                            </a>
                            <p class="font-lg text-heading">{!! get_setting('footer_below_slogan',null,App::getLocale()) !!}</p>
                        </div>
                        <ul class="contact-infor">
                            <li>
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-location.svg') }}" alt="" />
                                <strong>{{ translate('Address') }}:</strong>
                                <span class="mx-1">{{ get_setting('contact_address',null,App::getLocale()) }}</span>
                            </li>
                            <li>
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-contact.svg') }}" alt="" />
                                <strong>{{ translate('Call Us') }}:</strong>
                                <span class="mx-1">
                                    <a style="color: #253D4E" href="tel:{{ get_setting('contact_phone') }}">{{ get_setting('contact_phone') }}</a>
                                </span>
                            </li>
                            <li>
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-email-2.svg') }}" alt="" />
                                <strong>{{ translate('Email') }}:</strong>
                                <span class="mx-1">
                                    <a style="color: #253D4E" href="mailto:{{ get_setting('contact_email') }}">
                                        {{ get_setting('contact_email') }}
                                    </a>
                                </span>
                            </li>
                            <li>
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-clock.svg') }}" alt="" />
                                <strong>Hours:</strong>
                                <span>10:00 - 18:00, Mon - Sat</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <h4 class=" widget-title">Company</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Delivery Information</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Support Center</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <h4 class="widget-title">Account</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">Sign In</a></li>
                        <li><a href="#">View Cart</a></li>
                        <li><a href="#">My Wishlist</a></li>
                        <li><a href="#">Track My Order</a></li>
                        <li><a href="#">Help Ticket</a></li>
                        <li><a href="#">Shipping Details</a></li>
                        <li><a href="#">Compare products</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                    <h4 class="widget-title">Corporate</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">Become a Vendor</a></li>
                        <li><a href="#">Affiliate Program</a></li>
                        <li><a href="#">Farm Business</a></li>
                        <li><a href="#">Farm Careers</a></li>
                        <li><a href="#">Our Suppliers</a></li>
                        <li><a href="#">Accessibility</a></li>
                        <li><a href="#">Promotions</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                    <h4 class="widget-title">Popular</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">Milk & Flavoured Milk</a></li>
                        <li><a href="#">Butter and Margarine</a></li>
                        <li><a href="#">Eggs Substitutes</a></li>
                        <li><a href="#">Marmalades</a></li>
                        <li><a href="#">Sour Cream and Dips</a></li>
                        <li><a href="#">Tea & Kombucha</a></li>
                        <li><a href="#">Cheese</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget widget-install-app col wow animate__animated animate__fadeInUp"
                    data-wow-delay=".5s">
                    <h4 class="widget-title">Install App</h4>
                    <p class="">From App Store or Google Play</p>
                    <div class="download-app">
                        <a href="{{ get_setting('play_store_link') }}" class="hover-up mb-sm-2 mb-lg-0">
                            @if(get_setting('play_store_link') != null)
                                <img class="active"src="{{ static_asset('assets/img/play.png') }}">
                            @else
                                <img class="active" src="{{ asset('assets/frontend/imgs/theme/app-store.jpg') }}" alt="" />
                            @endif
                        </a>
                        <a href="{{ get_setting('app_store_link') }}" class="hover-up mb-sm-2">
                            @if(get_setting('app_store_link') != null)
                                <img src="{{ static_asset('assets/img/app.png') }}">
                            @else
                                <img src="{{ asset('assets/frontend/imgs/theme/google-play.jpg') }}" alt="" />
                            @endif
                        </a>
                    </div>
                    <p class="mb-20">Secured Payment Gateways</p>
                    <img class="" src="{{ asset('assets/frontend/imgs/theme/payment-method.png') }}" alt="" />
                </div>
            </div>
    </section>
    <div class="container pb-30 wow animate__animated animate__fadeInUp" data-wow-delay="0">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <p class="font-sm mb-0">{{ get_setting('frontend_copyright_text',null,App::getLocale()) }}</p>
            </div>
            <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex mr-30">
                    <img src="{{ asset('assets/frontend/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                    <p>1900 - 6666<span>Working 8:00 - 22:00</span></p>
                </div>
                <div class="hotline d-lg-inline-flex">
                    <img src="{{ asset('assets/frontend/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                    <p>1900 - 8888<span>24/7 Support Center</span></p>
                </div>
            </div>
            @if ( get_setting('show_social_links') )
                <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                    <div class="mobile-social-icon">
                        <h6>{{ translate('Follow Us') }}</h6>
                        @if ( get_setting('facebook_link') != null )
                            <a href="{{ get_setting('facebook_link') }}" target="_blank">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-facebook-white.svg') }}" alt="Facebook" />
                            </a>
                        @endif
                        @if ( get_setting('twitter_link') != null )
                            <a href="{{ get_setting('twitter_link') }}" target="_blank">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-twitter-white.svg') }}" alt="Twitter" />
                            </a>
                        @endif
                        @if ( get_setting('instagram_link') != null )
                            <a href="{{ get_setting('instagram_link') }}" target="_blank">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-instagram-white.svg') }}" alt="Instagram" />
                            </a>
                        @endif
                        @if ( get_setting('youtube_link') != null )
                            <a href="{{ get_setting('youtube_link') }}" target="_blank">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-youtube-white.svg') }}" alt="Youtube" />
                            </a>
                        @endif
                        @if ( get_setting('linkedin_link') != null )
                            <a href="{{ get_setting('linkedin_link') }}" target="_blank">
                                <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-youtube-white.svg') }}" alt="LinkedIn" />
                            </a>
                        @endif
                    </div>
                    <p class="font-sm">{!! get_setting('text_below_social_links',null,App::getLocale()) !!}</p>
                </div>
            @endif
        </div>
    </div>
</footer>
