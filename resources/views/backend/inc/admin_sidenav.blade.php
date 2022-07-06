<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @if(get_setting('system_logo_white') != null)
                    <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white', static_asset('assets/img/logo.png'))) }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>

                <!-- Supplier -->
                @if(isAdmin() || in_array('26', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tasks aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Supplier')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(Auth::user()->user_type == 'super_admin')
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{route('admin.suppliers.create')}}">
                                        <span class="aiz-side-nav-text">{{translate('Add New Suppliers')}}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.suppliers.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.suppliers.index', 'admin.suppliers.create', 'admin.suppliers.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Supplier List')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.suppliers.warehouses.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.suppliers.warehouses.index', 'admin.suppliers.warehouses.create', 'admin.suppliers.warehouses.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Warehouse List')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.suppliers.users.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.suppliers.users.index','admin.suppliers.users.create','admin.suppliers.users.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Supplier User List')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.suppliers.warehouses.users.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.suppliers.warehouses.Windex', 'admin.suppliers.warehouses.Wcreate', 'admin.suppliers.warehouses.Wedit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Warehouse User List')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Restaurant -->
                @if(isAdmin() || in_array('27', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tasks aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Restaurant')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(Auth::user()->user_type == 'super_admin')
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{route('admin.restaurants.create')}}">
                                        <span class="aiz-side-nav-text">{{translate('Add New Restaurants')}}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.restaurants.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.restaurants.index', 'admin.restaurants.create','admin.restaurants.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Restaurant List')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.restaurants.branches.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.restaurants.branches.index', 'admin.restaurants.branches.create', 'admin.restaurants.branches.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Branch List')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.restaurants.users.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.restaurants.users.index','admin.restaurants.users.create','admin.restaurants.users.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Restaurant User List')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- POS Addon-->
                @if (addon_is_activated('pos_system'))
                    @if(isAdmin() || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-tasks aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('POS System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('poin-of-sales.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])}}">
                                        <span class="aiz-side-nav-text">{{translate('POS Manager')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('poin-of-sales.activation')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('POS Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Product -->
                @if(isAdmin() || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Products')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{route('admin.products.create')}}">
                                    <span class="aiz-side-nav-text">{{translate('Add New product')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.products.all')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.products.admin')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.products.admin', 'admin.products.create', 'admin.products.admin.edit']) }}" >
                                    <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>
                                </a>
                            </li>
                            @if(get_setting('vendor_system_activation') == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.products.seller')}}" class="aiz-side-nav-link {{ areActiveRoutes(['products.seller', 'products.seller.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.digitalproducts.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.digitalproducts.index', 'admin.digitalproducts.create', 'admin.digitalproducts.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Digital Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.product_bulk_upload.index') }}" class="aiz-side-nav-link" >
                                    <span class="aiz-side-nav-text">{{ translate('Bulk Import') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.product_bulk_export.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Bulk Export')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.categories.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.brands.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.brands.index', 'admin.brands.create', 'admin.brands.edit'])}}" >
                                    <span class="aiz-side-nav-text">{{translate('Brand')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.attributes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.colors')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Colors')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.reviews.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Product Reviews')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Auction Product -->
                @if(addon_is_activated('auction'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-gavel aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Auction Products')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{route('auction_product_create.admin')}}">
                                    <span class="aiz-side-nav-text">{{translate('Add New auction product')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('auction.all_products')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_product_edit.admin','product_bids.admin']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Auction Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('auction.inhouse_products')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Inhouse Auction Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('auction.seller_products')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Auction Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('auction_products_orders')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_products_orders.index']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Auction Products Orders') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Wholesale Product -->
                @if(addon_is_activated('wholesale'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-luggage-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Wholesale Products')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{route('wholesale_product_create.admin')}}">
                                    <span class="aiz-side-nav-text">{{translate('Add New Wholesale Product')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('wholesale_products.all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Wholesale Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('wholesale_products.in_house')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Wholesale Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('wholesale_products.seller')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Wholesale Products') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Sale -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Sales')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        @if(isAdmin() || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.all_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.all_orders.index', 'admin.all_orders.show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All Orders')}}</span>
                                </a>
                            </li>
                        @endif

                        @if(isAdmin() || in_array('4', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.inhouse_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.inhouse_orders.index', 'admin.inhouse_orders.show'])}}" >
                                    <span class="aiz-side-nav-text">{{translate('Inhouse orders')}}</span>
                                </a>
                            </li>
                        @endif
                        @if(isAdmin() || in_array('5', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_orders.index', 'admin.seller_orders.show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Seller Orders')}}</span>
                                </a>
                            </li>
                        @endif
                        @if(isAdmin() || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.pick_up_point.order_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.pick_up_point.order_index','admin.pick_up_point.order_show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pick-up Point Order')}}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Deliver Boy Addon-->
                @if (addon_is_activated('delivery_boy'))
                    @if(isAdmin() || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-truck aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Delivery Boy')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boys.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('All Delivery Boy')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boys.create')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Add Delivery Boy')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boys-payment-histories')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Payment Histories')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boys-collection-histories')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Collected Histories')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boy.cancel-request')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Cancel Request')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('delivery-boy-configuration')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Refund addon -->
                @if (addon_is_activated('refund_request'))
                    @if(isAdmin() || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Refunds') }}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refund_requests_all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['refund_requests_all', 'reason_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Refund Requests')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('paid_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Approved Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('rejected_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('rejected Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refund_time_config')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Refund Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif


                <!-- Customers -->
                @if(isAdmin() || in_array('8', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.customers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                </a>
                            </li>
                            @if(get_setting('classified_product') == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.classified_products')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.customer_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.customer_packages.index', 'admin.customer_packages.create', 'admin.customer_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Sellers -->
                @if((isAdmin() || in_array('9', json_decode(Auth::user()->staff->role->permissions))) && get_setting('vendor_system_activation') == 1)
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                @php
                                    $sellers = \App\Models\Shop::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                                @endphp
                                <a href="{{ route('admin.sellers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.sellers.index', 'admin.sellers.create', 'admin.sellers.edit', 'admin.sellers.payment_history','admin.sellers.approved','admin.sellers.profile_modal','admin.sellers.show_verification_request'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>
                                    @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.sellers.payment_histories') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.withdraw_requests_all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.business_settings.vendor_commission') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Commission') }}</span>
                                </a>
                            </li>

                            @if (addon_is_activated('seller_subscription'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('seller_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>
                                        @if (env("DEMO_MODE") == "On")
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_verification_form.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Verification Form') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(isAdmin() || in_array('22', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('admin.uploaded-files.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.uploaded-files.create'])}}">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                        </a>
                    </li>
                @endif

                <!-- Reports -->
                @if(isAdmin() || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.in_house_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.in_house_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.stock_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.stock_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products Stock') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.wish_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.wish_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.user_search_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.user_search_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.commission-log.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.wallet-history.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!--Blog System-->
                @if(isAdmin() || in_array('23', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Blog System') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.blog.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.blog.create', 'admin.blog.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Posts') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.blog-category.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.blog-category.create', 'admin.blog-category.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Categories') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- marketing -->
                @if(isAdmin() || in_array('11', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(isAdmin() || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.flash_deals.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.flash_deals.index', 'admin.flash_deals.create', 'admin.flash_deals.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(isAdmin() || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.newsletters.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>
                                @if (addon_is_activated('otp_system'))
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.sms.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>
                                            @if (env("DEMO_MODE") == "On")
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                            @if (get_setting('coupon_system') == 1)
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.coupon.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.coupon.index','admin.coupon.create','admin.coupon.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Support -->
                @if(isAdmin() || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-link aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Support')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(isAdmin() || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                                @php
                                    $support_ticket = DB::table('tickets')
                                                ->where('viewed', 0)
                                                ->select('id')
                                                ->count();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.support_ticket.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.support_ticket.admin_index', 'admin.support_ticket.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Ticket')}}</span>
                                        @if($support_ticket > 0)<span class="badge badge-info">{{ $support_ticket }}</span>@endif
                                    </a>
                                </li>
                            @endif

                            @php
                                $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();
                            @endphp
                            @if(isAdmin() || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.conversations.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.conversations.admin_index', 'admin.conversations.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Product Queries')}}</span>
                                        @if (count($conversation) > 0)
                                            <span class="badge badge-info">{{ count($conversation) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Affiliate Addon -->
                @if (addon_is_activated('affiliate_system'))
                    @if(isAdmin() || in_array('15', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-link aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Affiliate System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.configs')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Registration Form')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.users')}}" class="aiz-side-nav-link {{ areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refferals.users')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Referral Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.withdraw_requests')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.logs.admin')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Logs')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Offline Payment Addon-->
                @if (addon_is_activated('offline_payment'))
                    @if(isAdmin() || in_array('16', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Offline Payment System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('manual_payment_methods.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Manual Payment Methods')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('offline_wallet_recharge_request.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>
                                    </a>
                                </li>
                                @if(get_setting('classified_product') == 1)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_customer_package_payment_request.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (addon_is_activated('seller_subscription'))
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_seller_package_payment_request.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>
                                            @if (env("DEMO_MODE") == "On")
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Paytm Addon -->
                @if (addon_is_activated('paytm'))
                    @if(isAdmin() || in_array('17', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-mobile-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Asian Payment Gateway')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('paytm.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set Asian PG Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Club Point Addon-->
                @if (addon_is_activated('club_point'))
                    @if(isAdmin() || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="lab la-btc aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Club Point System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('club_points.configs') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Club Point Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('set_product_points')}}" class="aiz-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Set Product Point')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('club_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details'])}}">
                                        <span class="aiz-side-nav-text">{{translate('User Points')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!--OTP addon -->
                @if (addon_is_activated('otp_system'))
                    @if(isAdmin() || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.otp.configconfiguration') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.sms-templates.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('SMS Templates')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.otp_credentials.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                @if(addon_is_activated('african_pg'))
                    @if(isAdmin() || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('African Payment Gateway Addon')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('african.configuration') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('African PG Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('african_credentials.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set African PG Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Website Setup -->
                @if(isAdmin() || in_array('13', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link {{ areActiveRoutes(['admin.website.footer', 'admin.website.header'])}}" >
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.header') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Header')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.footer', ['lang'=>  App::getLocale()] ) }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.website.footer'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Footer')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.pages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.website.pages', 'admin.custom-pages.create' ,'admin.custom-pages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.appearance') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Setup & Configurations -->
                @if(isAdmin() || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.general_setting.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('General Settings')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.activation.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Features activation')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.languages.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.languages.index', 'admin.languages.create', 'admin.languages.store', 'admin.languages.show', 'admin.languages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.currency.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Currency')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.tax.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.tax.index', 'admin.tax.create', 'admin.tax.store', 'admin.tax.show', 'admin.tax.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Vat & TAX')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.pick_up_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.pick_up_points.index','admin.pick_up_points.create','admin.pick_up_points.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pickup point')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.smtp_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('SMTP Settings')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.payment_method.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.order_configuration.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Order Configuration')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.file_system.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('File System & Cache Configuration')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.social_login.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Social media Logins')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Facebook')}}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.facebook_chat.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.facebook-comment') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google')}}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.google_analytics.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.google_recaptcha.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.google-map.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Google Map')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.google-firebase.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Google Firebase')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Shipping')}}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.shipping_configuration.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.shipping_configuration.index','admin.shipping_configuration.edit','admin.shipping_configuration.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.countries.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.countries.index','admin.countries.edit','admin.countries.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.states.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.states.index','admin.states.edit','admin.states.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping States')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.cities.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.cities.index','admin.cities.edit','admin.cities.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.districts.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.districts.index','admin.districts.edit','admin.districts.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping District')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif

                <!-- Staffs -->
                @if(isAdmin() || in_array('20', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.staffs.index', 'admin.staffs.create', 'admin.staffs.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All staffs')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.roles.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.roles.index', 'admin.roles.create', 'admin.roles.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(isAdmin() || in_array('24', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('System')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.system_update') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Update')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.system_server')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Addon Manager -->
                @if(isAdmin() || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="{{route('admin.addons.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['admin.addons.index', 'admin.addons.create'])}}">
                            <i class="las la-wrench aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endif
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
