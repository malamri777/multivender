<?php

use App\Http\Controllers\Api\V2\UserController;

Route::group([
    'prefix'     => 'v2/',
    'as'         => 'api.public.',
    'middleware' => ['app_language', 'throttle:60,10']
], function () {
    Route::get('suppliers', 'RestaurantPublicController@supplierList');
    Route::get('app', 'RestaurantPublicController@app');
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('supplier/{supplier}', 'RestaurantPublicController@productBySupplier');
        Route::get('related/{id}', 'RestaurantPublicController@related')->name('related');
        Route::get('show/{id}', 'RestaurantPublicController@show')->name('show');
        Route::get('suppliers', 'RestaurantPublicController@supplierList')->middleware('throttle:60,3');
        Route::group(['prefix' => 'products', 'middleware' => 'throttle:60,10', 'public.products.'], function() {
            Route::get('supplier/{supplier}', 'RestaurantPublicController@productBySupplier');
            Route::get('related/{id}', 'RestaurantPublicController@related')->name('related');
            Route::get('show/{id}', 'RestaurantPublicController@show')->name('show');
        });
    });
});

Route::group([
    'prefix'     => 'v2/restaurant',
    'as'         => 'v2/restaurant.',
    'middleware' => ['app_language']
], function() {
    Route::post('auth/login', 'RestaurantAuthController@login');
    // Route::post('auth/signup', 'RestaurantAuthController@signup');
    Route::post('auth/confirm_code', 'RestaurantAuthController@confirmCode')->middleware('throttle:60,3');



    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::get('auth/logout', 'RestaurantAuthController@logout');
        Route::get('auth/user', 'RestaurantAuthController@user');
        Route::put('auth/user/update', 'RestaurantAuthController@userUpdate');
        Route::post('auth/profile/image-upload', 'ProfileController@imageUpload');

        Route::post('search_user', 'RestaurantUserController@findUser')->middleware('throttle:60,3');
        Route::get('assign-user-to-restaurant/{user:uuid}', 'RestaurantUserController@assignUserToRestaurant');

        Route::post('upload', 'UploadController@upload');
        Route::post('store', 'RestaurantController@store');
        Route::get('show', 'RestaurantController@show');
    });
});


// ======================================
Route::group(['prefix' => 'v2/auth', 'middleware' => ['app_language']], function() {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('social-login', 'AuthController@socialLogin');
    Route::post('password/forget_request', 'PasswordResetController@forgetRequest');
    Route::post('password/confirm_reset', 'PasswordResetController@confirmReset');
    Route::post('password/resend_code', 'PasswordResetController@resendCode');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
    Route::post('resend_code', 'AuthController@resendCode');
    Route::post('confirm_code', 'AuthController@confirmCode');
});

Route::group(['prefix' => 'v2', 'as' => 'api.', 'middleware' => ['app_language']], function() {
    Route::prefix('delivery-boy')->group(function () {
        Route::get('dashboard-summary/{id}', 'DeliveryBoyController@dashboard_summary')->middleware('auth:sanctum');
        Route::get('deliveries/completed/{id}', 'DeliveryBoyController@completed_delivery')->middleware('auth:sanctum');
        Route::get('deliveries/cancelled/{id}', 'DeliveryBoyController@cancelled_delivery')->middleware('auth:sanctum');
        Route::get('deliveries/on_the_way/{id}', 'DeliveryBoyController@on_the_way_delivery')->middleware('auth:sanctum');
        Route::get('deliveries/picked_up/{id}', 'DeliveryBoyController@picked_up_delivery')->middleware('auth:sanctum');
        Route::get('deliveries/assigned/{id}', 'DeliveryBoyController@assigned_delivery')->middleware('auth:sanctum');
        Route::get('collection-summary/{id}', 'DeliveryBoyController@collection_summary')->middleware('auth:sanctum');
        Route::get('earning-summary/{id}', 'DeliveryBoyController@earning_summary')->middleware('auth:sanctum');
        Route::get('collection/{id}', 'DeliveryBoyController@collection')->middleware('auth:sanctum');
        Route::get('earning/{id}', 'DeliveryBoyController@earning')->middleware('auth:sanctum');
        Route::get('cancel-request/{id}', 'DeliveryBoyController@cancel_request')->middleware('auth:sanctum');
        Route::post('change-delivery-status', 'DeliveryBoyController@change_delivery_status')->middleware('auth:sanctum');
        //Delivery Boy Order
        Route::get('purchase-history-details/{id}', 'DeliveryBoyController@details')->middleware('auth:sanctum');
        Route::get('purchase-history-items/{id}', 'DeliveryBoyController@items')->middleware('auth:sanctum');
    });

    Route::prefix('seller')->group(function () {
        Route::get('orders', 'SellerController@getOrderList')->middleware('auth:sanctum');;
        Route::get('orders-details/{id}', 'SellerController@getOrderDetails')->middleware('auth:sanctum');
    });


    Route::get('get-search-suggestions', 'SearchSuggestionController@getList');
    Route::get('languages', 'LanguageController@getList');

    Route::get('chat/conversations', 'ChatController@conversations')->middleware('auth:sanctum');
    Route::get('chat/messages/{id}', 'ChatController@messages')->middleware('auth:sanctum');
    Route::post('chat/insert-message', 'ChatController@insert_message')->middleware('auth:sanctum');
    Route::get('chat/get-new-messages/{conversation_id}/{last_message_id}', 'ChatController@get_new_messages')->middleware('auth:sanctum');
    Route::post('chat/create-conversation', 'ChatController@create_conversation')->middleware('auth:sanctum');

    Route::apiResource('banners', 'BannerController')->only('index');

    Route::get('brands/top', 'BrandController@top');
    Route::apiResource('brands', 'BrandController')->only('index');

    Route::apiResource('business-settings', 'BusinessSettingController')->only('index');

    Route::get('categories/featured', 'CategoryController@featured');
    Route::get('categories/home', 'CategoryController@home');
    Route::get('categories/top', 'CategoryController@top');
    Route::apiResource('categories', 'CategoryController')->only('index');
    Route::get('sub-categories/{id}', 'SubCategoryController@index')->name('subCategories.index');

    Route::apiResource('colors', 'ColorController')->only('index');

    Route::apiResource('currencies', 'CurrencyController')->only('index');

    Route::apiResource('customers', 'CustomerController')->only('show');

    Route::apiResource('general-settings', 'GeneralSettingController')->only('index');

    Route::apiResource('home-categories', 'HomeCategoryController')->only('index');

    //Route::get('purchase-history/{id}', 'PurchaseHistoryController@index')->middleware('auth:sanctum');
    //Route::get('purchase-history-details/{id}', 'PurchaseHistoryDetailController@index')->name('purchaseHistory.details')->middleware('auth:sanctum');

    Route::get('purchase-history', 'PurchaseHistoryController@index')->middleware('auth:sanctum');
    Route::get('purchase-history-details/{id}', 'PurchaseHistoryController@details')->middleware('auth:sanctum');
    Route::get('purchase-history-items/{id}', 'PurchaseHistoryController@items')->middleware('auth:sanctum');

    Route::get('filter/categories', 'FilterController@categories');
    Route::get('filter/brands', 'FilterController@brands');

    Route::get('products/admin', 'ProductController@admin');
    Route::get('products/seller/{id}', 'ProductController@seller');
    Route::get('products/category/{id}', 'ProductController@category')->name('products.category');
    Route::get('products/sub-category/{id}', 'ProductController@subCategory')->name('products.subCategory');
    Route::get('products/sub-sub-category/{id}', 'ProductController@subSubCategory')->name('products.subSubCategory');
    Route::get('products/brand/{id}', 'ProductController@brand')->name('products.brand');
    Route::get('products/todays-deal', 'ProductController@todaysDeal');
    Route::get('products/featured', 'ProductController@featured');
    Route::get('products/best-seller', 'ProductController@bestSeller');
    Route::get('products/related/{id}', 'ProductController@related')->name('products.related');

    Route::get('products/featured-from-seller/{id}', 'ProductController@newFromSeller')->name('products.featuredromSeller');
    Route::get('products/search', 'ProductController@search');
    Route::get('products/variant/price', 'ProductController@variantPrice');
    Route::get('products/home', 'ProductController@home');
    Route::apiResource('products', 'ProductController')->except(['store', 'update', 'destroy']);

    Route::get('cart-summary', 'CartController@summary')->middleware('auth:sanctum');
    Route::post('carts/process', 'CartController@process')->middleware('auth:sanctum');
    Route::post('carts/add', 'CartController@add')->middleware('auth:sanctum');
    Route::post('carts/change-quantity', 'CartController@changeQuantity')->middleware('auth:sanctum');
    Route::apiResource('carts', 'CartController')->only('destroy')->middleware('auth:sanctum');
    Route::post('carts', 'CartController@getList')->middleware('auth:sanctum');


    Route::post('coupon-apply', 'CheckoutController@apply_coupon_code')->middleware('auth:sanctum');
    Route::post('coupon-remove', 'CheckoutController@remove_coupon_code')->middleware('auth:sanctum');

    Route::post('update-address-in-cart', 'AddressController@updateAddressInCart')->middleware('auth:sanctum');

    Route::get('payment-types', 'PaymentTypesController@getList');

    Route::get('reviews/product/{id}', 'ReviewController@index')->name('api.reviews.index');
    Route::post('reviews/submit', 'ReviewController@submit')->name('api.reviews.submit')->middleware('auth:sanctum');

    Route::get('shop/user/{id}', 'ShopController@shopOfUser')->middleware('auth:sanctum');
    Route::get('shops/details/{id}', 'ShopController@info')->name('shops.info');
    Route::get('shops/products/all/{id}', 'ShopController@allProducts')->name('shops.allProducts');
    Route::get('shops/products/top/{id}', 'ShopController@topSellingProducts')->name('shops.topSellingProducts');
    Route::get('shops/products/featured/{id}', 'ShopController@featuredProducts')->name('shops.featuredProducts');
    Route::get('shops/products/new/{id}', 'ShopController@newProducts')->name('shops.newProducts');
    Route::get('shops/brands/{id}', 'ShopController@brands')->name('shops.brands');
    Route::apiResource('shops', 'ShopController')->only('index');

    Route::apiResource('sliders', 'SliderController')->only('index');

    Route::get('wishlists-check-product', 'WishlistController@isProductInWishlist')->middleware('auth:sanctum');
    Route::get('wishlists-add-product', 'WishlistController@add')->middleware('auth:sanctum');
    Route::get('wishlists-remove-product', 'WishlistController@remove')->middleware('auth:sanctum');
    Route::get('wishlists', 'WishlistController@index')->middleware('auth:sanctum');
    Route::apiResource('wishlists', 'WishlistController')->except(['index', 'update', 'show']);

    Route::get('policies/seller', 'PolicyController@sellerPolicy')->name('policies.seller');
    Route::get('policies/support', 'PolicyController@supportPolicy')->name('policies.support');
    Route::get('policies/return', 'PolicyController@returnPolicy')->name('policies.return');

    // Route::get('user/info/{id}', 'UserController@info')->middleware('auth:sanctum');
    // Route::post('user/info/update', 'UserController@updateName')->middleware('auth:sanctum');
    Route::get('user/shipping/address', 'AddressController@addresses')->middleware('auth:sanctum');
    Route::post('user/shipping/create', 'AddressController@createShippingAddress')->middleware('auth:sanctum');
    Route::post('user/shipping/update', 'AddressController@updateShippingAddress')->middleware('auth:sanctum');
    Route::post('user/shipping/update-location', 'AddressController@updateShippingAddressLocation')->middleware('auth:sanctum');
    Route::post('user/shipping/make_default', 'AddressController@makeShippingAddressDefault')->middleware('auth:sanctum');
    Route::get('user/shipping/delete/{address_id}', 'AddressController@deleteShippingAddress')->middleware('auth:sanctum');

    Route::get('clubpoint/get-list', 'ClubpointController@get_list')->middleware('auth:sanctum');
    Route::post('clubpoint/convert-into-wallet', 'ClubpointController@convert_into_wallet')->middleware('auth:sanctum');

    Route::get('refund-request/get-list', 'RefundRequestController@get_list')->middleware('auth:sanctum');
    Route::post('refund-request/send', 'RefundRequestController@send')->middleware('auth:sanctum');

    Route::post('get-user-by-access_token', 'UserController@getUserInfoByAccessToken');

    Route::get('cities', 'AddressController@getCities');
    Route::get('states', 'AddressController@getStates');
    Route::get('countries', 'AddressController@getCountries');

    Route::get('cities-by-state/{state_id}', 'AddressController@getCitiesByState');
    Route::get('states-by-country/{country_id}', 'AddressController@getStatesByCountry');

    Route::post('shipping_cost', 'ShippingController@shipping_cost')->middleware('auth:sanctum');

    // Route::post('coupon/apply', 'CouponController@apply')->middleware('auth:sanctum');


    Route::any('stripe', 'StripeController@stripe');
    Route::any('/stripe/create-checkout-session', 'StripeController@create_checkout_session')->name('stripe.get_token');
    Route::any('/stripe/payment/callback', 'StripeController@callback')->name('stripe.callback');
    Route::any('/stripe/success', 'StripeController@success')->name('stripe.success');
    Route::any('/stripe/cancel', 'StripeController@cancel')->name('stripe.cancel');

    Route::any('paypal/payment/url', 'PaypalController@getUrl')->name('paypal.url');
    Route::any('paypal/payment/done', 'PaypalController@getDone')->name('paypal.done');
    Route::any('paypal/payment/cancel', 'PaypalController@getCancel')->name('paypal.cancel');

    Route::any('razorpay/pay-with-razorpay', 'RazorpayController@payWithRazorpay')->name('razorpay.payment');
    Route::any('razorpay/payment', 'RazorpayController@payment')->name('razorpay.payment1');
    Route::post('razorpay/success', 'RazorpayController@success')->name('razorpay.success');

    Route::any('paystack/init', 'PaystackController@init')->name('paystack.init');
    Route::post('paystack/success', 'PaystackController@success')->name('paystack.success');

    Route::any('iyzico/init', 'IyzicoController@init')->name('iyzico.init');
    Route::any('iyzico/callback', 'IyzicoController@callback')->name('iyzico.callback');
    Route::post('iyzico/success', 'IyzicoController@success')->name('iyzico.success');

    Route::get('bkash/begin', 'BkashController@begin')->middleware('auth:sanctum');
    Route::get('bkash/api/webpage/{token}/{amount}', 'BkashController@webpage')->name('bkash.webpage');
    Route::any('bkash/api/checkout/{token}/{amount}', 'BkashController@checkout')->name('bkash.checkout');
    Route::any('bkash/api/execute/{token}', 'BkashController@execute')->name('bkash.execute');
    Route::any('bkash/api/fail', 'BkashController@fail')->name('bkash.fail');
    Route::any('bkash/api/success', 'BkashController@success')->name('bkash.success');
    Route::post('bkash/api/process', 'BkashController@process')->name('bkash.process');

    Route::get('nagad/begin', 'NagadController@begin')->middleware('auth:sanctum');
    Route::any('nagad/verify/{payment_type}', 'NagadController@verify')->name('app.nagad.callback_url');
    Route::post('nagad/process', 'NagadController@process');

    Route::get('sslcommerz/begin', 'SslCommerzController@begin');
    Route::post('sslcommerz/success', 'SslCommerzController@payment_success');
    Route::post('sslcommerz/fail', 'SslCommerzController@payment_fail');
    Route::post('sslcommerz/cancel', 'SslCommerzController@payment_cancel');

    Route::any('flutterwave/payment/url', 'FlutterwaveController@getUrl')->name('flutterwave.url');
    Route::any('flutterwave/payment/callback', 'FlutterwaveController@callback')->name('flutterwave.callback');

    Route::any('paytm/payment/pay', 'PaytmController@pay')->name('paytm.pay');
    Route::any('paytm/payment/callback', 'PaytmController@callback')->name('paytm.callback');

    Route::post('payments/pay/wallet', 'WalletController@processPayment')->middleware('auth:sanctum');
    Route::post('payments/pay/cod', 'PaymentController@cashOnDelivery')->middleware('auth:sanctum');
    Route::post('payments/pay/manual', 'PaymentController@manualPayment')->middleware('auth:sanctum');

    Route::post('offline/payment/submit', 'OfflinePaymentController@submit')->name('offline.payment.submit');

    Route::post('order/store', 'OrderController@store')->middleware('auth:sanctum');
    Route::get('profile/counters', 'ProfileController@counters')->middleware('auth:sanctum');
    Route::post('profile/update', 'ProfileController@update')->middleware('auth:sanctum');
    Route::post('profile/update-device-token', 'ProfileController@update_device_token')->middleware('auth:sanctum');
    Route::post('profile/update-image', 'ProfileController@updateImage')->middleware('auth:sanctum');
    Route::post('profile/image-upload', 'ProfileController@imageUpload')->middleware('auth:sanctum');
    Route::post('profile/check-phone-and-email', 'ProfileController@checkIfPhoneAndEmailAvailable')->middleware('auth:sanctum');

    Route::post('file/image-upload', 'FileController@imageUpload')->middleware('auth:sanctum');

    Route::get('wallet/balance', 'WalletController@balance')->middleware('auth:sanctum');
    Route::get('wallet/history', 'WalletController@walletRechargeHistory')->middleware('auth:sanctum');
    Route::post('wallet/offline-recharge', 'WalletController@offline_recharge')->middleware('auth:sanctum');

    Route::get('flash-deals', 'FlashDealController@index');
    Route::get('flash-deal-products/{id}', 'FlashDealController@products');

    //Addon list
    Route::get('addon-list', 'ConfigController@addon_list');
    //Activated social login list
    Route::get('activated-social-login', 'ConfigController@activated_social_login');

    //Business Sttings list
    Route::post('business-settings', 'ConfigController@business_settings');
    //Pickup Point list
    Route::get('pickup-list', 'ShippingController@pickup_list');
});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
