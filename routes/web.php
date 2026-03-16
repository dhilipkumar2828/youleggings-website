<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryTagController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ShippingchargesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\AssignRoleToUserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactformController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PrivacyController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/shop', [IndexController::class, 'shop'])->name('shop');
Route::get('/about-us', [IndexController::class, 'about'])->name('about');
Route::get('/contact-us', [IndexController::class, 'contact'])->name('contact');
Route::post('/contact-us', [IndexController::class, 'contact_submit'])->name('contact.submit');
Route::get('/our-blog', [IndexController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [IndexController::class, 'blog_detail'])->name('blog_detail');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms-conditions', [IndexController::class, 'terms_conditions'])->name('terms_conditions');
Route::get('/shipping-policy', [IndexController::class, 'shipping_policy'])->name('shipping_policy');
Route::get('/cart', [IndexController::class, 'cart'])->name('cart');
Route::get('/checkout', [IndexController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [IndexController::class, 'checkout_store'])->name('checkout.store');
Route::get('/thank-you', [IndexController::class, 'thank_you'])->name('thank_you');
Route::get('/product/{slug}', [IndexController::class, 'product_detail'])->name('product_detail');
Route::post('/product/review/submit', [IndexController::class, 'review_submit'])->name('review.submit');

// Wishlist Routes
Route::get('/wishlist', [IndexController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist/add', [IndexController::class, 'wishlist_add'])->name('wishlist.add');
Route::post('/wishlist/remove', [IndexController::class, 'wishlist_remove'])->name('wishlist.remove');

// Customer Auth
Route::get('/login-user', [IndexController::class, 'login_user'])->name('login_user');
Route::post('/customer-login', [IndexController::class, 'customer_login'])->name('customer.login');
Route::post('/customer-register', [IndexController::class, 'customer_register'])->name('customer.register');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/my-account', [IndexController::class, 'my_account'])->name('my_account');
    Route::get('/my-orders', [IndexController::class, 'my_orders'])->name('my_orders');
    Route::get('/my-addresses', [IndexController::class, 'my_addresses'])->name('my_addresses');
    Route::get('/address-set-default/{id}', [IndexController::class, 'address_set_default'])->name('address.set_default');
    Route::post('/address-update', [IndexController::class, 'address_update'])->name('address.update');
    Route::get('/address-delete/{id}', [IndexController::class, 'address_delete'])->name('address.delete');
    Route::get('/order-invoice/{id}', [IndexController::class, 'order_invoice'])->name('order_invoice');
    Route::post('/account-update', [IndexController::class, 'account_update'])->name('account_update');
    Route::post('/apply-coupon', [IndexController::class, 'apply_coupon'])->name('apply_coupon');
});
Route::post('/get-shipping-charge', [IndexController::class, 'get_shipping_charge'])->name('get_shipping_charge');

// Utility Routes
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return '✅ All caches cleared!';
});
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return '✅ Storage linked!';
});


// Admin Auth (Standard Laravel UI)
Auth::routes(['register' => false]);
Route::get('/admin', [HomeController::class, 'index'])->name('admin.redirect');

// Admin Protected Routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function() {
    
    Route::get('/dashboard', [AdminController::class, 'admin'])->name('admin');
    
    // Catalog
    Route::resource('/category', CategoryController::class);
    Route::post('category_status', [CategoryController::class, 'categoryStatus'])->name('category.status');
    Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');
    
    // Subcategories
    Route::get('/subcategory_view/{id}', [SubcategoryController::class, 'view'])->name('subcategory.view');
    Route::get('/subcategory_add/{id}', [SubcategoryController::class, 'subadd'])->name('subcategory.create');
    Route::get('/subcategory_edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
    Route::post('/subcategory_update/{id}', [SubcategoryController::class, 'update'])->name('subcategory.update');
    Route::post('/subcategory_create', [SubcategoryController::class, 'subcategory_create'])->name('subcategory.store');
    
    Route::resource('/product', ProductController::class)->except(['show']);
    Route::any('product_status', [ProductController::class, 'productStatus'])->name('product.status');
    Route::get('/productlist', [ProductController::class, 'listproduct'])->name('product.listproduct');
    Route::get('/stockoutproduct', [ProductController::class, 'stockoutproduct'])->name('product.stockoutproduct');
    Route::get('/inactiveproduct', [ProductController::class, 'inactiveproduct'])->name('product.inactiveproduct');
    Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulk-delete');
    Route::post('/product/bulkactive', [ProductController::class, 'bulkactive'])->name('product.bulkactive');
    Route::post('/product/bulkdeactive', [ProductController::class, 'bulkdeactive'])->name('product.bulkdeactive');
    Route::post('product_show', [ProductController::class, 'product_show'])->name('product_show');
    Route::post('product_heading', [ProductController::class, 'product_heading'])->name('product_heading');
    Route::post('productattribute', [ProductController::class, 'getAttributeByID'])->name('productattribute');
    Route::post('product_attribute', [ProductController::class, 'getAttributeByID'])->name('product.attribute');
    Route::post('product_variant', [ProductController::class, 'getVariant'])->name('product.variant');
    Route::post('addproduct_attribute/{id}', [ProductController::class, 'add_product_attribute'])->name('addproduct.attribute');
    Route::match(['get', 'post', 'patch'], 'product_updateattribute/{id}', [ProductController::class, 'AttributeUpdate'])->name('product.updateattribute');
    Route::match(['get', 'post', 'delete'], 'product_attribute_destroy/{id}', [ProductController::class, 'add_product_attribute_delete'])->name('product.attribute.destroy');
    Route::get('get_subproducts', [ProductController::class, 'get_subproducts'])->name('get_subproducts');
    Route::get('get_childproducts', [ProductController::class, 'get_childproducts'])->name('get_childproducts');
    Route::post('import-file', [ProductController::class, 'import'])->name('import_file');
    Route::get('export-file', [ProductController::class, 'export'])->name('export_file');
    Route::get('/updatestockmanually/{id}', [ProductController::class, 'updatestockmanually'])->name('updatestockmanually');
    Route::post('/updatestockstore', [ProductController::class, 'updatestockstore'])->name('updatestockstore');
    
    Route::resource('/attribute', AttributeController::class);
    Route::resource('/brand', BrandController::class);
    Route::post('brandStatus', [BrandController::class, 'brandStatus'])->name('brandStatus');
    
    Route::resource('/tax', TaxController::class);
    Route::post('taxstatus', [TaxController::class, 'taxstatus'])->name('tax.status');

    // Orders
    Route::resource('/order', OrderController::class);
    Route::get('/order_search/{id}', [OrderController::class, 'filter'])->name('filter');
    Route::get('/progress', [OrderController::class, 'progress'])->name('progress');
    Route::get('/deliver', [OrderController::class, 'deliver'])->name('deliver');
    Route::post('/order_status', [OrderController::class, 'orderstatus'])->name('order.status');
    Route::post('/reason_status', [OrderController::class, 'reasonStatus'])->name('reason.Status');
    Route::delete('/orders/bulk-delete', [OrderController::class, 'deleteOrders'])->name('delete_orders');
    Route::get('/view_detail/{id}', [OrderController::class, 'view_detail'])->name('view_detail');
    Route::get("/notifications", [OrderController::class, "notifications"])->name('admin.notifications');
    
    // Appearance
    Route::resource('/banner', BannerController::class);
    Route::post('banner_status', [BannerController::class, 'bannerStatus'])->name('banner_status');
    
    // Coupons
    Route::resource('/coupon', CouponController::class);
    Route::post('coupon_status', [CouponController::class, 'status'])->name('coupon.status');
    Route::post('coupon_show', [CouponController::class, 'coupon_show'])->name('coupon_show');
    Route::post('/checkCouponcode', [CouponController::class, 'checkCouponcode'])->name('checkCouponcode');

    // Users & Roles
    Route::get('/user_view', [UserController::class, 'index'])->name('user.index');
    Route::get('/user_add', [UserController::class, 'create'])->name('user.create');
    Route::post('/user_save', [UserController::class, 'store'])->name('user.store');
    Route::get('/user_edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user_update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user_delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('user_status', [UserController::class, 'userStatus'])->name('user.status');
    Route::get('/customer-list', [UserController::class, 'customerlist'])->name('customer.list');
    
    Route::get('/roleview', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roleadd', [RoleController::class, 'add'])->name('role.create');
    Route::post('/rolesave', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roleedit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/roleupdate/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::post('/roledelete/{id}', [RoleController::class, 'delete'])->name('role.destroy');
    
    Route::get('/change_password', [HomeController::class, 'change_password'])->name('change_password');
    Route::post('/update_password', [HomeController::class, 'update_password'])->name('update_password');
    
    Route::resource('/permission', PermissionController::class);
    Route::resource('/permission_group', PermissionGroupController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('shippingchargesedit', [ShippingchargesController::class, 'shippingchargesedit'])->name('shippingchargesedit');
    Route::patch('/shippingcharges/{id}', [ShippingchargesController::class, 'update'])->name('shippingcharges.update');

    // Blogs & CMS
    Route::resource('/blog', BlogController::class);
    Route::resource('/about', AboutController::class);
    Route::resource('/contact', ContactController::class);
    Route::resource('/faqs', FaqsController::class);
    Route::resource('/terms', TermsController::class);
    Route::resource('/delivery', DeliveryController::class);
    Route::resource('/privacy', PrivacyController::class);
    
    // Contact Submissions
    Route::resource('/contactlist', ContactformController::class);

    // Product Reviews
    Route::resource('/product_review', ProductReviewController::class);
    Route::post('product_review_status', [ProductReviewController::class, 'reviewStatus'])->name('product_review.status');

    // Testimonials (Client Feedback)
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('/testimonial/add', [TestimonialController::class, 'add_feedback'])->name('testimonial.create');
    Route::post('/testimonial/save', [TestimonialController::class, 'store_feedback'])->name('testimonial.store');
    Route::post('/update_feedback', [TestimonialController::class, 'update_feedback'])->name('testimonial.update');
    Route::post('/delete_feedback/{id}', [TestimonialController::class, 'delete_feedback'])->name('testimonial.delete');

    // Category Tags (Special)
    Route::get('categorytag', [CategoryTagController::class, 'index'])->name('categorytag.index');
    Route::get('categorytag/create', [CategoryTagController::class, 'create'])->name('categorytag.create');
    Route::post('categorytag/store', [CategoryTagController::class, 'store'])->name('categorytag.store');
    Route::get('categorytag/edit/{id}', [CategoryTagController::class, 'edit'])->name('categorytag.edit');
    Route::post('categorytag/update/{id}', [CategoryTagController::class, 'update'])->name('categorytag.update');
    Route::post('categorytag/delete/{id}', [CategoryTagController::class, 'destroy'])->name('categorytag.destroy');
    Route::get('/get-categories/{isParent}', [CategoryTagController::class, 'getCategories']);
    Route::post('categorytag_status', [CategoryTagController::class, 'CategorytagStatus'])->name('categorytag_status');

    // Filemanager
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});
