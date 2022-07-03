 Route::group(['prefix' => 'pos', 'as' => 'pos.'], function () {
            Route::get('', [POSController::class, 'index'])->name('index');
            Route::get('add-new', [POSController::class, 'add_new'])->name('add-new');
            Route::post('store', [POSController::class, 'store'])->name('store');
            Route::get('search-products', [POSController::class, 'search_products'])->name('search-products');
            Route::get('quick-view', [POSController::class, 'quick_view'])->name('quick-view');
            Route::post('variant_price', [POSController::class, 'variant_price'])->name('variant_price');

            Route::post('add-to-cart', [POSController::class, 'addToCart'])->name('add-to-cart');
            Route::get('clear-cart-ids', [POSController::class, 'clear_cart_ids'])->name('clear-cart-ids');
            Route::post('empty-cart', [POSController::class, 'emptyCart'])->name('emptyCart');

            Route::post('remove-from-cart', [POSController::class, 'removeFromCart'])->name('remove-from-cart');
            Route::post('updateQuantity', [POSController::class, 'updateQuantity'])->name('updateQuantity');
            Route::post('cart-items', [POSController::class, 'cart_items'])->name('cart_items');
            Route::post('tax', [POSController::class, 'update_tax'])->name('tax');


            Route::post('place-order' , [POSController::class, 'place_order'])->name('place-order');
            Route::get('orders', [POSController::class, 'order_list'])->name('order-list');
            Route::get('order-details/{id}', [POSController::class, 'order_details'])->name('order-details');
            Route::post('order-search', [POSController::class, 'order_search'])->name('order-search');

            route::get('generate_invoice', [POSController::class, 'generate_invoice'])->name('generate-invoice');

            Route::post('discount', [POSController::class, 'update_discount'])->name('discount');
            Route::post('remove-discount', [POSController::class, 'remove_discount'])->name('remove-discount');

            Route::post('coupon-discount', [POSController::class, 'coupon_discount'])->name('coupon-discount');

            Route::get('customers', [POSController::class, 'get_customers'])->name('customers');
            Route::post('customer-store', [POSController::class, 'customer_store'])->name('customer-store');


        });