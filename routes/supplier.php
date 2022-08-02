<?php

use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Supplier\OrderController;
use App\Http\Controllers\Supplier\CouponController;
use App\Http\Controllers\Supplier\ReviewController;
use App\Http\Controllers\Supplier\AddressController;
use App\Http\Controllers\Supplier\InvoiceController;
use App\Http\Controllers\Supplier\PaymentController;
use App\Http\Controllers\Supplier\ProductController;
use App\Http\Controllers\Supplier\ProfileController;
use App\Http\Controllers\Supplier\SettingController;
use App\Http\Controllers\Supplier\DashboardController;
use App\Http\Controllers\Supplier\WarehouseController;
use App\Http\Controllers\Supplier\ConversationController;
use App\Http\Controllers\Supplier\NotificationController;
use App\Http\Controllers\Supplier\SupportTicketController;
use App\Http\Controllers\Supplier\DigitalProductController;
use App\Http\Controllers\Supplier\CommissionHistoryController;
use App\Http\Controllers\Supplier\ProductBulkUploadController;
use App\Http\Controllers\Supplier\SellerWithdrawRequestController;

Route::group(['prefix' => 'supplier', 'middleware' => ['supplier', 'verified', 'user'], 'as' => 'supplier.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products');
        Route::get('/product/create', 'create')->name('products.create');
        Route::post('/products/store/', 'store')->name('products.store');
        Route::get('/product/{id}/edit', 'edit')->name('products.edit');
        Route::get('/products/exist', 'exist')->name('products.exist');
        Route::post('/products/sku', 'find_sku')->name('products.sku');
        Route::post('/products/exist/store', 'store_exist')->name('products.exist.store');
        Route::post('/products/update/{product}', 'update')->name('products.update');
        Route::get('/products/duplicate/{id}', 'duplicate')->name('products.duplicate');
        Route::post('/products/sku_combination', 'sku_combination')->name('products.sku_combination');
        Route::post('/products/sku_combination_edit', 'sku_combination_edit')->name('products.sku_combination_edit');
        Route::post('/products/add-more-choice-option', 'add_more_choice_option')->name('products.add-more-choice-option');
        Route::post('/products/seller/featured', 'updateFeatured')->name('products.featured');
        Route::post('/products/published', 'updatePublished')->name('products.published');
        Route::get('/products/destroy/{id}', 'destroy')->name('products.destroy');
    });

    // warehouse
    Route::controller(WarehouseController::class)->group(function () {
        Route::get('/warehouses', 'warehouseIndex')->name('warehouse.index');
        Route::get('/warehouse/create', 'warehouseCreate')->name('warehouse.create');
        Route::post('/warehouse/store', 'warehouseStore')->name('warehouse.store');
        Route::get('/warehouse/edit', 'warehouseEdit')->name('warehouse.edit');
        Route::patch('/warehouse/update', 'warehouseUpdate')->name('warehouse.update');
        Route::get('/warehouse/destroy', 'warehouseDestroy')->name('warehouse.destroy');
        Route::post('warehouse/update_status', 'warehouseUpdateStatus')->name('warehouse.update_status');

        // user
        Route::get('/warehouse/users', 'warehouseUsersPage')->name('warehouse.users.index');
        Route::get('/warehouse/user/edit', 'userEdit')->name('warehouse.user.edit');
        Route::patch('/warehouse/user/update', 'userUpdate')->name('warehouse.user.update');
        Route::get('/warehouse/user/create', 'userCreate')->name('warehouse.user.create');
        Route::post('/warehouse/user/store', 'userStore')->name('warehouse.user.store');
        Route::get('/warehouse/user/delete', 'userDestroy')->name('warehouse.user.destroy');

        // porduct
        Route::get('/warehouse/products', 'warehouseProductsPage')->name('warehouse.products.index');



    });



    // Product Bulk Upload
    Route::controller(ProductBulkUploadController::class)->group(function () {
        Route::get('/product-bulk-upload/index', 'index')->name('product_bulk_upload.index');
        Route::post('/product-bulk-upload/store', 'bulk_upload')->name('bulk_product_upload');
        Route::group(['prefix' => 'bulk-upload/download'], function() {
            Route::get('/category', 'App\Http\Controllers\ProductBulkUploadController@pdf_download_category')->name('pdf.download_category');
            Route::get('/brand', 'App\Http\Controllers\ProductBulkUploadController@pdf_download_brand')->name('pdf.download_brand');
        });
    });

    // Digital Product
    Route::controller(DigitalProductController::class)->group(function () {
        Route::get('/digitalproducts', 'index')->name('digitalproducts');
        Route::get('/digitalproducts/create', 'create')->name('digitalproducts.create');
        Route::post('/digitalproducts/store', 'store')->name('digitalproducts.store');
        Route::get('/digitalproducts/{id}/edit', 'edit')->name('digitalproducts.edit');
        Route::post('/digitalproducts/update/{id}', 'update')->name('digitalproducts.update');
        Route::get('/digitalproducts/destroy/{id}', 'destroy')->name('digitalproducts.destroy');
        Route::get('/digitalproducts/download/{id}', 'download')->name('digitalproducts.download');
    });

    //Upload
    Route::group(['prefix' => '/uploaded-files', 'as' => 'uploaded-files.', 'controller' => AizUploadController::class], function () {
        Route::any('/', 'index')->name('index');
        Route::any('/create', 'create')->name('create');
        Route::any('/file-info', 'file_info')->name('info');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::any('create-folder', 'createFolder')->name('createFolder');
    });

    //Coupon
    Route::resource('coupon', CouponController::class);
    Route::controller(CouponController::class)->group(function () {
        Route::post('/coupon/get_form', 'get_coupon_form')->name('coupon.get_coupon_form');
        Route::post('/coupon/get_form_edit', 'get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
        // Route::get('/coupon/destroy/{id}', 'destroy')->name('coupon.destroy');
    });

    //Order
    Route::resource('orders', OrderController::class);
    Route::controller(OrderController::class)->group(function () {
        Route::post('/orders/update_delivery_status', 'update_delivery_status')->name('orders.update_delivery_status');
        Route::post('/orders/update_payment_status', 'update_payment_status')->name('orders.update_payment_status');
    });
    Route::get('invoice/{order_id}',[InvoiceController::class, 'invoice_download'])->name('invoice.download');

    //Review
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');

    //Shop
    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting', 'index')->name('setting.index');
        Route::post('/setting/update', 'update')->name('setting.update');
        Route::get('/setting/apply_for_verification', 'verify_form')->name('setting.verify');
        Route::post('/setting/verification_info_store', 'verify_form_store')->name('setting.verify.store');
    });

    //Payments
    Route::resource('payments', PaymentController::class);

    // Profile Settings
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/profile/update/{id}', 'update')->name('profile.update');
    });

    // Address
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        Route::post('/get-states', 'getStates')->name('get-state');
        Route::post('/get-cities', 'getCities')->name('get-city');
        // Route::post('/address/update/{id}', 'update')->name('addresses.update');
        // Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
        Route::get('/addresses/set_default/{id}', 'set_default')->name('addresses.set_default');
    });

    // Money Withdraw Requests
    Route::controller(SellerWithdrawRequestController::class)->group(function () {
        Route::get('/money-withdraw-requests', 'index')->name('money_withdraw_requests.index');
        Route::post('/money-withdraw-request/store', 'store')->name('money_withdraw_request.store');
    });

    // Commission History
    Route::get('commission-history', [CommissionHistoryController::class, 'index'])->name('commission-history.index');

    //Conversations
    Route::controller(ConversationController::class)->group(function () {
        Route::get('/conversations', 'index')->name('conversations.index');
        Route::get('/conversations/show/{id}', 'show')->name('conversations.show');
        Route::post('conversations/refresh', 'refresh')->name('conversations.refresh');
        Route::post('conversations/message/store', 'message_store')->name('conversations.message_store');
    });

    // Support Ticket
    Route::controller(SupportTicketController::class)->group(function () {
        Route::get('/support_ticket', 'index')->name('support_ticket.index');
        Route::post('/support_ticket/store', 'store')->name('support_ticket.store');
        Route::get('/support_ticket/show/{id}', 'show')->name('support_ticket.show');
        Route::post('/support_ticket/reply', 'ticket_reply_store')->name('support_ticket.reply_store');
    });

    // Notifications
    Route::get('all-notification', [NotificationController::class, 'index'])->name('all-notification');
});

