<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryTagController;

use App\Models\Category;
use Maatwebsite\Excel\Row;
use App\Http\Controllers\Frontend\WhatisnewController;
use App\Http\Controllers\LogViewerController;
use App\Models\About;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Contactform;
use App\Models\Faqs;
use App\Models\Terms;
use App\Models\Delivery;
use App\Models\Privacy;
use App\Models\Order;
use App\Models\CategoryTag;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return '✅ All caches cleared!';
});
Route::get('/send-mail', function () {
    $details = [
        'name' => 'John Doe',
        'message' => 'This is a test email from Laravel!'
    ];

    Mail::to('recipient@example.com')->send(new SampleMail($details));

    return "Email Sent!";
});

Route::get('/clear', function () {
    Artisan::call('view:clear');
});
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/publish', function () {
    Artisan::call('vendor:publish --tag=lfm_config');
});
Route::get('/publish_public', function () {
    shell_exec('php ../php artisan vendor:publish --tag=lfm_public');

    return 'success';
});
//Route::get('/test', [App\Http\Controllers\Frontend\IndexController::class, 'guestlogin'])->name('user.guest');

Route::get('test-ses', [App\Http\Controllers\Frontend\CheckoutController::class, 'testSes'])->name('TestSes');
// Route::get('/test', function () {
//     $o=Order::find('19');
//     dd($o->items->groupBy('vendor_id'));
// });
// php artisan vendor:publish --tag=lfm_config
// php artisan vendor:publish --tag=lfm_public
Route::group(['middleware'=>'auth::user'],function(){
    return view('frontend.Auth.auth');
});
Route::get('razorpay-payment', [App\Http\Controllers\RaserpayController::class, 'create'])->name('pay.with.razorpay');
Route::post('payment', [App\Http\Controllers\RaserpayController::class, 'payment'])->name('payment');
Route::post('add_payment', [App\Http\Controllers\RaserpayController::class, 'add_payment'])->name('add_payment');
// Route::get('handle-payment', [App\Http\Controllers\PayPalPaymentController::class, 'handlePayment'])->name('make.payment');
//Route::get('payment', 'PayPalController@payment')->name('payment');
// Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
// Route::get('payment/success', 'PayPalController@success')->name('payment.success');
//Route::get('handle-payment', 'PayPalPaymentController@handlePayment')->name('make.payment');
// Route::get('cancel-payment', 'PayPalPaymentController@paymentCancel')->name('cancel.payment');
// Route::get('payment-success', 'PayPalPaymentController@paymentSuccess')->name('success.payment');
//subscriber controller
Route::get('user/auth', [App\Http\Controllers\Frontend\IndexController::class, 'userAuth'])->name('user.auth');
Route::get('guest/auth', [App\Http\Controllers\Frontend\IndexController::class, 'guestAuth'])->name('guest.auth');

Route::get('user1/auth', [App\Http\Controllers\Frontend\IndexController::class, 'user1Auth'])->name('user1.auth');

Route::get('/register', [App\Http\Controllers\Frontend\IndexController::class, 'authregister'])->name('authregister');
Route::post('user/login',[App\Http\Controllers\Frontend\IndexController::class, 'loginsumbit'])->name('login.sumbit');

Route::get('user/guest', [App\Http\Controllers\Frontend\IndexController::class, 'guestlogin'])->name('user.guest');

Route::post('generateotp',[App\Http\Controllers\Frontend\IndexController::class, 'generateotp'])->name('generateotp');
Route::post('verifyotp',[App\Http\Controllers\Frontend\IndexController::class, 'verifyotp'])->name('verifyotp');

Route::post('guestgenerateotp',[App\Http\Controllers\Frontend\IndexController::class, 'guestgenerateotp'])->name('guestgenerateotp');
Route::post('guestverifyOtp',[App\Http\Controllers\Frontend\IndexController::class, 'guestverifyOtp'])->name('guestverifyOtp');
Route::get('/logs', [LogViewerController::class, 'view']);

Route::middleware(['guest.auth'])->group(function () {

    // Routes that require guest authentication
});

Route::post('user/register',[App\Http\Controllers\Frontend\IndexController::class, 'Registersumbit'])->name('register.sumbit');
Route::get('user/logout',[App\Http\Controllers\Frontend\IndexController::class, 'userlogout'])->name('user.logout');
Route::get('/sea', [App\Http\Controllers\Frontend\WhatisnewController::class, 'sea'])->name('sea');
Route::post('/reset_password', [App\Http\Controllers\Frontend\IndexController::class, 'reset_password'])->name('reset_password');
Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'index'])->name('index');
Route::get('/indexnew', [App\Http\Controllers\Frontend\IndexController::class, 'indexnew'])->name('indexnew');
Route::get('/get-subcategories/{categoryId}', [App\Http\Controllers\Frontend\IndexController::class, 'getSubcategories'])->name('getSubcategories');

Route::post('remove_coupon',[App\Http\Controllers\Frontend\IndexController::class, 'remove_coupon']);
Route::get('/index', [App\Http\Controllers\Frontend\IndexController::class, 'index'])->name('index');
Route::get('/catalogue_pdf/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'catalogue_pdf']);
Route::get('/forget_password', [App\Http\Controllers\Frontend\IndexController::class, 'forget_password']);
Route::get('/get_modalvalues', [App\Http\Controllers\Frontend\IndexController::class, 'get_modalDetails'])->name('get_modalDetails');
Route::get('/sitemap', [App\Http\Controllers\Frontend\IndexController::class, 'sitemap'])->name('sitemap');
Route::get('/whatisnew', [App\Http\Controllers\Frontend\WhatisnewController::class, 'whatisnew'])->name('whatisnew');
Route::post('/search_products', [App\Http\Controllers\Frontend\WhatisnewController::class,'search_products']);
Route::post('/search', [App\Http\Controllers\Frontend\WhatisnewController::class,'search']);
Route::get('/order_pdf/{id}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'order_pdf']);
Route::post('/update_address', [App\Http\Controllers\Frontend\WhatisnewController::class,'update_address']);
Route::post('/update_userdetails', [App\Http\Controllers\Frontend\WhatisnewController::class,'update_userdetails']);
Route::get('/slider_filter', [App\Http\Controllers\Frontend\WhatisnewController::class,'slider_filter']);
//Route::get('/test', [App\Http\Controllers\Frontend\IndexController::class, 'test'])->name('test');
Route::get('/searchsug', [App\Http\Controllers\Frontend\WhatisnewController::class, 'searchsug'])->name('searchsug');
Route::get('/product_list', [App\Http\Controllers\Frontend\WhatisnewController::class, 'product']);
Route::get('/product_list/{id}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'product']);
Route::get('/product_list_test/{id}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'product_list_test']);
Route::get('/newarrival_list', [App\Http\Controllers\Frontend\WhatisnewController::class, 'newarrival']);

Route::get('/product_list_new/{id}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'productnew']);
Route::get('/all_products',[App\Http\Controllers\Frontend\WhatisnewController::class, 'all_products']);

Route::post('/product_filter', [App\Http\Controllers\Frontend\WhatisnewController::class, 'product_filter']);
Route::post('/newarrival_product_filter', [App\Http\Controllers\Frontend\WhatisnewController::class, 'newarrival_product_filter']);

Route::resource('/product-review',\App\Http\Controllers\Admin\ProductReviewsController::class);
Route::post('/product-review',[\App\Http\Controllers\Admin\ProductReviewsController::class,'productReview'])->name('product.review');
Route::get('/product_viewmore',[\App\Http\Controllers\Admin\ProductReviewsController::class,'viewmore']);
Route::get('/aboutus', [App\Http\Controllers\Frontend\IndexController::class, 'about'])->name('about');

Route::get('/help', [App\Http\Controllers\Frontend\IndexController::class, 'help'])->name('help');

Route::get('/reviews', [App\Http\Controllers\Frontend\IndexController::class, 'reviews'])->name('reviews');
Route::post('/updatereviews', [App\Http\Controllers\Frontend\IndexController::class, 'updatereviews'])->name('updatereviews');

Route::get('/offers', [App\Http\Controllers\Frontend\IndexController::class, 'offers'])->name('offers');
Route::get('/compare_products/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'compare_products'])->name('compare_products');
Route::get('/blogs', [App\Http\Controllers\Frontend\IndexController::class, 'blogs'])->name('blogs');
Route::get('/contactus', [App\Http\Controllers\Frontend\IndexController::class, 'contactus'])->name('contactus');
Route::get('/sendEmail', [App\Http\Controllers\ContactController::class, 'sendEmail'])->name('sendEmail');

Route::post('/contactform', [App\Http\Controllers\Frontend\IndexController::class, 'contactform'])->name('contactform');
Route::get('/faq', [App\Http\Controllers\Frontend\IndexController::class, 'faq'])->name('faq');
Route::get('/deliveryreturn', [App\Http\Controllers\Frontend\IndexController::class, 'deliveryr'])->name('deliveryreturn');
Route::get('/privacypolicy', [App\Http\Controllers\Frontend\IndexController::class, 'privacyp'])->name('privacypolicy');
Route::get('/termscondition', [App\Http\Controllers\Frontend\IndexController::class, 'termsc'])->name('termscondition');
Route::post('/contact_form', [App\Http\Controllers\Frontend\IndexController::class, 'contact_form'])->name('contact_form');
Route::post('/client_feedback', [App\Http\Controllers\Frontend\IndexController::class, 'client_feedback'])->name('client_feedback');
// Route::post('/order_tracking', [App\Http\Controllers\Frontend\IndexController::class, 'order_tracking'])->name('order_tracking');
Route::get('/order_tracking/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'order_tracking'])->name('order_tracking');
Route::get('/product_track/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'product_track'])->name('product_track');
Route::get('/forget_password', [App\Http\Controllers\Frontend\IndexController::class, 'forget_password']);
Route::post('/reset_password', [App\Http\Controllers\Frontend\IndexController::class, 'reset_password'])->name('reset_password');
Route::post('/update_userdetails', [App\Http\Controllers\Frontend\WhatisnewController::class,'update_userdetails']);
Route::get('/category', [App\Http\Controllers\Frontend\WhatisnewController::class, 'category'])->name('category');

Route::get('/category', [App\Http\Controllers\Frontend\WhatisnewController::class, 'category'])->name('category');

Route::post('apply_coupon',[App\Http\Controllers\Frontend\IndexController::class, 'apply_coupon']);
Auth::routes(['register'=>false]);
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.login_redirect');

//subscribe_send
Route::post('/subscribe_send', [App\Http\Controllers\Frontend\SubscriberController::class, 'subscribe_send']);
Route::get('/send_email', [App\Http\Controllers\Frontend\SubscriberController::class, 'send_email']);
Route::get('/subscribers', [App\Http\Controllers\Frontend\SubscriberController::class, 'subscribers']);
//Route::group(['prefix'=>'admin','middleware'=>'auth',['admin']],function(){
 Route::group(['middleware'=>'auth','web','role:admin'],function(){
    Route::resource('/user',\App\Http\Controllers\Admin\UserController::class);
    Route::resource('/permission',\App\Http\Controllers\PermissionController::class);
    Route::resource('/permission_group',\App\Http\Controllers\PermissionGroupController::class);
    Route::get('/admin',[\App\Http\Controllers\AdminController::class,'admin'])->name('admin');
    // Route::get('/password',[\App\Http\Controllers\AdminController::class,'password'])->name('password');
    // Route::post('/update_password',[\App\Http\Controllers\AdminController::class,'update_password'])->name('update_password');

    //role
Route::resource('/user',\App\Http\Controllers\Admin\UserController::class);
Route::get('/visitors',[\App\Http\Controllers\Admin\UserController::class,'visitors'])->name('visitors');

Route::resource('/Assign_role_user',\App\Http\Controllers\AssignRoleToUserController::class);
    //role

    Route::get('/roleview',[\App\Http\Controllers\RoleController::class,'index']);
    Route::get('/roleadd',[\App\Http\Controllers\RoleController::class,'add']);
    Route::get('/roleedit/{id}',[\App\Http\Controllers\RoleController::class,'edit']);
    Route::post('/roleupdate/{id}',[\App\Http\Controllers\RoleController::class,'update']);
    Route::post('/roledelete/{id}',[\App\Http\Controllers\RoleController::class,'delete']);
    Route::post('/rolesave',[\App\Http\Controllers\RoleController::class,'store']);

//User controller
Route::post('/user_save',[\App\Http\Controllers\Admin\UserController::class,'store']);
Route::get('/user_view',[\App\Http\Controllers\Admin\UserController::class,'index']);
Route::get('/user_add',[\App\Http\Controllers\Admin\UserController::class,'create']);
Route::get('/user_edit/{id}',[\App\Http\Controllers\Admin\UserController::class,'edit']);
Route::post('/user_delete/{id}',[\App\Http\Controllers\Admin\UserController::class,'destroy']);
Route::post('/user_update/{id}',[\App\Http\Controllers\Admin\UserController::class,'update']);

//Roles Permission
// Route::get('/rolepermissionview',[\App\Http\Controllers\RolesPermissionController::class,'index']);
// Route::get('/rolepermissionadd',[\App\Http\Controllers\RolesPermissionController::class,'add']);
// Route::get('/rolepermissionedit',[\App\Http\Controllers\RolesPermissionController::class,'edit']);
//banner section
 Route::resource('/banner',\App\Http\Controllers\BannerController::class);
Route::get('/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('change_password');
Route::post('/update_password', [App\Http\Controllers\HomeController::class, 'update_password'])->name('update_password');

 Route::resource('/advertisement',\App\Http\Controllers\AdvertisementController::class);
 Route::post('advertisementStatus',[\App\Http\Controllers\AdvertisementController::class,'advertisementStatus']);


 //youtube
 Route::resource('/youtube',\App\Http\Controllers\YoutubeController::class);
 Route::post('youtubeStatus',[\App\Http\Controllers\YoutubeController::class,'youtubeStatus']);

//  Route::get('banner/add',\App\Http\Controllers\BannerController::class,'create')->name('banner.add');
//  ('banner',[BannerController::class, 'index'])->name('banner');
Route::post('banner_status',[\App\Http\Controllers\BannerController::class,'bannerStatus'])->name('banner_status');
Route::post('deals_status',[\App\Http\Controllers\DealsController::class,'deals_status'])->name('deals_status');
Route::post('deals_update',[\App\Http\Controllers\DealsController::class,'deals_update'])->name('deals_update');
Route::get('offer_bannercreate',[\App\Http\Controllers\DealsController::class,'create'])->name('create');
Route::post('offer_banner_store',[\App\Http\Controllers\DealsController::class,'store'])->name('store');
Route::get('offer_banner_edit/{id}',[\App\Http\Controllers\DealsController::class,'edit'])->name('edit');
Route::post('offer_banner_update/{id}',[\App\Http\Controllers\DealsController::class,'update'])->name('update');
Route::post('offer_banner_delete/{id}',[\App\Http\Controllers\DealsController::class,'delete'])->name('delete');
Route::post('total_offerbanner_status',[\App\Http\Controllers\DealsController::class,'status'])->name('status');

// Route::group(['prefix' => 'filemanager'], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

//Filemanager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:web']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });

 //feedback
 Route::get('view_feedback',[\App\Http\Controllers\Admin\FeedbackController::class,'view']);
 Route::post('delete_feedback/{id}',[\App\Http\Controllers\Admin\FeedbackController::class,'delete']);
 Route::post('update_feedback',[\App\Http\Controllers\Admin\FeedbackController::class,'update']);

 //hotoffer
 Route::get('view_hotoffer',[\App\Http\Controllers\Admin\HotofferController::class,'view']);
 Route::get('add_hotoffer',[\App\Http\Controllers\Admin\HotofferController::class,'add']);
 Route::get('edit_hotoffer/{id}',[\App\Http\Controllers\Admin\HotofferController::class,'edit']);
 Route::post('save_hotoffer',[\App\Http\Controllers\Admin\HotofferController::class,'store']);
 Route::post('updatestatus_hotoffer',[\App\Http\Controllers\Admin\HotofferController::class,'update_status']);
 Route::post('delete_hotoffer/{id}',[\App\Http\Controllers\Admin\HotofferController::class,'delete']);
 Route::post('update_hotoffer/{id}',[\App\Http\Controllers\Admin\HotofferController::class,'update']);
//promo
Route::resource('/promo',\App\Http\Controllers\Admin\PromoController::class);
Route::post('status_promo',[\App\Http\Controllers\Admin\PromoController::class,'promo_status'])->name('promo.status');
//Categories section
// Route::resource('/category-group',\App\Http\Controllers\Admin\CategoryGroupController::class);
Route::post('categorygroup_status',[\App\Http\Controllers\Admin\CategoryGroupController::class,'categoryStatus'])->name('categorygroup.status');
Route::post('category-group/{id}/child',[\App\Http\Controllers\Admin\CategoryGroupController::class,'getChildByParentID']);
//Categories section
// Route::resource('/category-sub-group',\App\Http\Controllers\Admin\CategorySubGroupController::class);
Route::post('categorysubgroup_status',[\App\Http\Controllers\Admin\CategorySubGroupController::class,'categoryStatus'])->name('categorysubgroup.status');
Route::post('category-sub-group/{id}/child',[\App\Http\Controllers\Admin\CategorySubGroupController::class,'getChildByParentID']);
//Categories section
Route::resource('/category',\App\Http\Controllers\Admin\CategoryController::class);
Route::get('category_sorting',[\App\Http\Controllers\Admin\CategoryController::class,'category_sorting']);
Route::get('category_sorting/homepage',[\App\Http\Controllers\Admin\CategoryController::class,'homepage_sorting']);
Route::get('category_sorting/headerpage',[\App\Http\Controllers\Admin\CategoryController::class,'header_sorting']);

Route::delete('/categories/bulk-delete', [\App\Http\Controllers\Admin\CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');

Route::post('updates/homepage',[\App\Http\Controllers\Admin\CategoryController::class,'homeorder']);
Route::post('updates/headerpage',[\App\Http\Controllers\Admin\CategoryController::class,'headerorder']);
Route::get('category_sorting/header',[\App\Http\Controllers\Admin\CategoryController::class,'header_sorting']);
Route::post('category_status',[\App\Http\Controllers\Admin\CategoryController::class,'categoryStatus'])->name('category.status');
Route::post('category/{id}/child',[\App\Http\Controllers\Admin\CategoryController::class,'getChildByParentID']);

//brand section
Route::resource('/brand',\App\Http\Controllers\Admin\BrandController::class);
Route::post('brandStatus',[\App\Http\Controllers\Admin\BrandController::class,'brandStatus'])->name('brandStatus');
Route::post('brand_show',[\App\Http\Controllers\Admin\BrandController::class,'brand_show'])->name('brand_show');
//attribute
Route::resource('/attribute',\App\Http\Controllers\Admin\AttributeController::class);
//product section
Route::resource('/product',\App\Http\Controllers\Admin\ProductController::class);
Route::post('product_heading',[\App\Http\Controllers\Admin\ProductController::class,'product_heading']);
Route::get('get_subproducts',[\App\Http\Controllers\Admin\ProductController::class,'get_subproducts']);

Route::get('/updatestockmanually/{id}',[\App\Http\Controllers\Admin\ProductController::class,'updatestockmanually'])->name('updatestockmanually');

Route::post('/updatestockstore',[\App\Http\Controllers\Admin\ProductController::class,'updatestockstore'])->name('updatestockstore');

Route::get('/viewstocklogs/{id}',[\App\Http\Controllers\Admin\ProductController::class,'viewstocklogs'])->name('viewstocklogs');

Route::get('get_childproducts',[\App\Http\Controllers\Admin\ProductController::class,'get_childproducts']);

Route::post('/product/bulk-delete', [\App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('product.bulk-delete');

Route::post('/product/bulkactive', [\App\Http\Controllers\Admin\ProductController::class, 'bulkactive'])->name('product.bulkactive');

Route::post('/product/bulkdeactive', [\App\Http\Controllers\Admin\ProductController::class, 'bulkdeactive'])->name('product.bulkdeactive');

Route::post('product_status',[\App\Http\Controllers\Admin\ProductController::class,'productStatus'])->name('product.status');
Route::get('import',[\App\Http\Controllers\Admin\ProductController::class,'importform']);
Route::post('import-file',[\App\Http\Controllers\Admin\ProductController::class,'import'])->name('import_file');
Route::get('export-file',[\App\Http\Controllers\Admin\ProductController::class,'export'])->name('export_file');
Route::post('add-product-attribute/{id}',[\App\Http\Controllers\Admin\ProductController::class,'add_product_attribute'])->name('addproduct.attribute');
Route::delete('product-attribute-delete/{id}',[\App\Http\Controllers\Admin\ProductController::class,'add_product_attribute_delete'])->name('product.attribute.destroy');
Route::post('productattribute',[\App\Http\Controllers\Admin\ProductController::class,'getAttributeByID'])->name('product.attribute');
Route::post('productvariant',[\App\Http\Controllers\Admin\ProductController::class,'getVariant'])->name('product.variant');
Route::post('product/update/{id}',[\App\Http\Controllers\Admin\ProductController::class,'AttributeUpdate'])->name('product.updateattribute');
// Route::post('product/{id}/child',[\App\Http\Controllers\Admin\ProductController::class,'getChildByParentID']);
Route::get('/productlist',[\App\Http\Controllers\Admin\ProductController::class,'listproduct'])->name('product.listproduct');

Route::get('/stockoutproduct',[\App\Http\Controllers\Admin\ProductController::class,'stockoutproduct'])->name('product.stockoutproduct');;
Route::get('/inactiveproduct',[\App\Http\Controllers\Admin\ProductController::class,'inactiveproduct'])->name('product.inactiveproduct');;

Route::post('product_show',[\App\Http\Controllers\Admin\ProductController::class,'product_show'])->name('product_show');
Route::get('/add_stock/{id}',[\App\Http\Controllers\Admin\ProductController::class,'add_stock'])->name('add_stock');
// productreviewes  product_riviewes.status
Route::get('product_riviewes',[\App\Http\Controllers\Admin\ProductController::class,'productriviewes'])->name('product.riviewes');
Route::post('product_riviewes_status',[\App\Http\Controllers\Admin\ProductController::class,'productriviewesStatus'])->name('product_riviewes.status');
Route::delete('productriviewes_delete/{id}',[\App\Http\Controllers\Admin\ProductController::class,'delete'])->name('productriviewes.delete');

Route::get('client_feedback',[\App\Http\Controllers\Admin\ProductController::class,'clientreviewes'])->name('client.riviewes');
Route::post('client_riviewes_status',[\App\Http\Controllers\Admin\ProductController::class,'clientriviewesStatus'])->name('client_riviewes.status');

//coupon
Route::resource('/coupon',\App\Http\Controllers\Admin\CouponController::class);
// Route::get('create',[\App\Http\Controllers\Admin\CouponController::class,'create']);
Route::post('status',[\App\Http\Controllers\Admin\CouponController::class,'status'])->name('status');
//payment
Route::resource('/payment-method',\App\Http\Controllers\Admin\PaymentMethodController::class);
Route::get('/transactions',[\App\Http\Controllers\Admin\PaymentMethodController::class,'transactions'])->name('transactions');
Route::get('/all_Payments',[\App\Http\Controllers\Admin\PaymentMethodController::class,'all_Payments'])->name('allPayments');
Route::get('/payment_pending',[\App\Http\Controllers\Admin\PaymentMethodController::class,'payment_pending'])->name('payment_pending');
Route::get('/Approved_Payments',[\App\Http\Controllers\Admin\PaymentMethodController::class,'Approved_Payments'])->name('Approved_Payments');
Route::get('/payment-method',[\App\Http\Controllers\Admin\PaymentMethodController::class,'index'])->name('payment-method');
Route::post('/Cash_On_Delivery',[\App\Http\Controllers\Admin\PaymentMethodController::class,'CashOnDelivery'])->name('Cash_On_Delivery');
Route::post('/Stripe',[\App\Http\Controllers\Admin\PaymentMethodController::class,'Stripe'])->name('Stripe');
Route::post('/Paypal',[\App\Http\Controllers\Admin\PaymentMethodController::class,'Paypal'])->name('Paypal');
Route::post('/RazorPay',[\App\Http\Controllers\Admin\PaymentMethodController::class,'RazorPay'])->name('RazorPay');
Route::post('/Display_Paytm',[\App\Http\Controllers\Admin\PaymentMethodController::class,'Display_Paytm'])->name('Display_Paytm');
Route::post('/SSL_Commerz',[\App\Http\Controllers\Admin\PaymentMethodController::class,'SSL_Commerz'])->name('SSL_Commerz');
Route::post('payment_status',[\App\Http\Controllers\Admin\PaymentMethodController::class,'Paymentstatus'])->name('payment_status');
Route::post('transaction_status',[\App\Http\Controllers\Admin\PaymentMethodController::class,'transactionstatus'])->name('transaction.status');
Route::post('brand_status',[\App\Http\Controllers\Admin\CouponController::class,'status'])->name('brand_status');
Route::post('coupon_show',[\App\Http\Controllers\Admin\CouponController::class,'coupon_show'])->name('coupon_show');
//orders
Route::resource('/order',\App\Http\Controllers\Admin\OrderController::class);

Route::get('/order_search/{id}',[\App\Http\Controllers\Admin\OrderController::class,'filter'])->name('filter');

Route::get('generate-pdf', [\App\Http\Controllers\Admin\OrderController::class,'pdfdownload']);

Route::get("/notifications", [\App\Http\Controllers\Admin\OrderController::class, "notifications"]);
Route::get("/pdf/{id}", [\App\Http\Controllers\Admin\OrderController::class, "pdf"]);
Route::resource('/shipping',\App\Http\Controllers\ShippingController::class);
Route::post('Shipping_status',[\App\Http\Controllers\ShippingController::class,'shippingstatus'])->name('Shipping.status');
//orders
Route::resource('/order',\App\Http\Controllers\Admin\OrderController::class);
Route::post('/order_status',[\App\Http\Controllers\Admin\OrderController::class,'orderstatus'])->name('order.status');
Route::get('/progress',[\App\Http\Controllers\Admin\OrderController::class,'progress'])->name('progress');
Route::get('/cancel',[\App\Http\Controllers\Admin\OrderController::class,'cancel'])->name('cancel');
Route::get('/confirmed',[\App\Http\Controllers\Admin\OrderController::class,'confirmed'])->name('confirmed');
Route::get('/cod',[\App\Http\Controllers\Admin\OrderController::class,'cod'])->name('cod');
// Route::get('/cod',[\App\Http\Controllers\Admin\OrderController::class,'cash_on'])->name('cod');
Route::get('/deliver',[\App\Http\Controllers\Admin\OrderController::class,'deliver'])->name('deliver');
Route::get('/pending',[\App\Http\Controllers\Admin\OrderController::class,'pending'])->name('pending');
Route::get('/return',[\App\Http\Controllers\Admin\OrderController::class,'return'])->name('return');
Route::post('reason_Status',[\App\Http\Controllers\Admin\OrderController::class,'reasonStatus'])->name('reason.Status');
Route::get('/view_detail/{id}',[\App\Http\Controllers\Admin\OrderController::class,'view_detail'])->name('view_detail');
Route::get('/suborders',[\App\Http\Controllers\Admin\OrderController::class,'suborders'])->name('suborders.suborders');
Route::get('/suborders_items/{id}',[\App\Http\Controllers\Admin\OrderController::class,'suborders_items'])->name('suborders_items.suborders_items');
Route::post('update_suborders',[\App\Http\Controllers\Admin\OrderController::class,'update_suborders'])->name('update_suborders.update_suborders');
Route::post('/approve_request',[\App\Http\Controllers\Admin\OrderController::class,'approve_request'])->name('approve_request.approve_request');

Route::delete('/orders/delete', [\App\Http\Controllers\Admin\OrderController::class, 'deleteOrders'])->name('delete_orders');

//vendor
Route::resource('/vendors',\App\Http\Controllers\Admin\VendorController::class);
Route::post('/duplicate_user',[\App\Http\Controllers\Admin\VendorController::class,'duplicate_user'])->name('duplicate_user');
Route::post('vendor_status',[\App\Http\Controllers\Admin\VendorController::class,'vendor_status'])->name('vendor_status');
Route::get('/merchants',[\App\Http\Controllers\Admin\VendorController::class,'merchants'])->name('merchants');
Route::get('/merchants-edit/{id}',[\App\Http\Controllers\Admin\VendorController::class,'merchants_edit'])->name('merchants_edit');
Route::patch('/merchants-update/{id}',[\App\Http\Controllers\Admin\VendorController::class,'merchants_update'])->name('merchants_update');
//supplier
Route::resource('/suppliers',\App\Http\Controllers\Admin\SuppliersController::class);
Route::post('/supplier-status',[\App\Http\Controllers\Admin\SuppliersController::class,'supplier_status'])->name('supplier_status');
Route::resource('/vendoritem',\App\Http\Controllers\Admin\VendorItemController::class);
Route::post('status',[\App\Http\Controllers\Admin\VendorItemController::class,'status'])->name('status');
Route::post('getvalues',[\App\Http\Controllers\Admin\VendorItemController::class,'getvalues'])->name('getvalues');
//purchase
Route::resource('/purchase',\App\Http\Controllers\Admin\PurchaseController::class);
Route::post('vendorproduct',[\App\Http\Controllers\Admin\PurchaseController::class,'vendorproduct'])->name('vendorproduct');
Route::post('vendorproductitem',[\App\Http\Controllers\Admin\PurchaseController::class,'vendorproductitem'])->name('vendorproductitem');
Route::post('purchasestatus',[\App\Http\Controllers\Admin\PurchaseController::class,'purchasestatus'])->name('purchasestatus');
//user section
Route::post('user_status',[\App\Http\Controllers\Admin\UserController::class,'userStatus'])->name('user.status');
//quotation
Route::resource('/quotation',\App\Http\Controllers\Admin\QuotationController::class);
Route::post('quotationstatus',[\App\Http\Controllers\Admin\PurchaseController::class,'quotationstatus'])->name('quotationstatus');
Route::post('createorder',[\App\Http\Controllers\Admin\QuotationController::class,'createorder'])->name('createorder');
//purchase order
Route::resource('/purchaseorder',\App\Http\Controllers\Admin\PurchaseOrderController::class);
//invoice
Route::resource('/invoice',\App\Http\Controllers\Admin\InvoiceController::class);
//invoice pdf
Route::get('/invoice/{id}/pdf-invoice',[\App\Http\Controllers\Admin\InvoiceController::class,'savePdfInvoice'])->name('savePdfInvoice');
//inventory
Route::resource('/inventory',\App\Http\Controllers\Admin\InventoryController::class);
Route::get('/delivery-docket',[\App\Http\Controllers\Admin\InventoryController::class,'delivery_docket'])->name('delivery-docket');
Route::post('delivery_docket_details',[\App\Http\Controllers\Admin\InventoryController::class,'delivery_docket_details'])->name('delivery_docket_details');
Route::get('loss-adjust',[\App\Http\Controllers\Admin\InventoryController::class,'lossadjust'])->name('inventory.loss-adjust');
Route::get('loss-view/{id}',[\App\Http\Controllers\Admin\InventoryController::class,'view'])->name('inventory.loss-view');
Route::get('inventory-history',[\App\Http\Controllers\Admin\InventoryController::class,'inventory_history'])->name('inventory.inventoryhistory');
//warehouse
Route::resource('/warehouse',\App\Http\Controllers\Admin\WarehouseController::class);
Route::get('/warehouse-status',[\App\Http\Controllers\Admin\WarehouseController::class,'warehouse_status'])->name('warehouse.status');
Route::get('/customer-list', [App\Http\Controllers\Frontend\IndexController::class, 'customerlist'])->name('customer.list');
Route::get('/customer-view/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'customerview'])->name('customer.view');
});
//product detailes
Route::resource('/product_detail',\App\Http\Controllers\Frontend\WhatisnewController::class);
Route::get('/product_detail/{$id}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'single_products'])->name('product_detail');
Route::post('/view_product_details',[App\Http\Controllers\Frontend\WhatisnewController::class, 'view_product_details'])->name('view_product_details');
Route::get('/products/{slug}', [App\Http\Controllers\Frontend\WhatisnewController::class, 'single_products'])->name('single_products');

Route::get('/getproductvarientssize', [App\Http\Controllers\Frontend\WhatisnewController::class, 'getproductvarientssize'])->name('getproductvarientssize');

Route::get('/getproductgst', [App\Http\Controllers\Frontend\WhatisnewController::class, 'getproductgst'])->name('getproductgst');

Route::get('/getcancelrequest', [App\Http\Controllers\Frontend\WhatisnewController::class, 'getcancelrequest'])->name('getcancelrequest');
Route::get('/getreturnrequest', [App\Http\Controllers\Frontend\WhatisnewController::class, 'getreturnrequest'])->name('getreturnrequest');

//Tax
Route::resource('/tax',\App\Http\Controllers\Admin\TaxController::class);
Route::post('taxstatus',[\App\Http\Controllers\Admin\TaxController::class,'taxstatus'])->name('tax.status');

//Shippingcharges
Route::resource('/shippingcharges',\App\Http\Controllers\Admin\ShippingchargesController::class);
Route::get('shippingchargesedit',[\App\Http\Controllers\Admin\ShippingchargesController::class,'shippingchargesedit'])->name('shippingchargesedit');
Route::post('/shippingupdate',[\App\Http\Controllers\Admin\ShippingchargesController::class,'shippingupdate'])->name('shippingcharges.shippingupdate');
//Report
Route::resource('/report',\App\Http\Controllers\Admin\ReportController::class);
Route::get('product-sales-report',[\App\Http\Controllers\Admin\ReportController::class,'productsalesreport'])->name('report.productsalesreport');
Route::get('product-purchase-report',[\App\Http\Controllers\Admin\ReportController::class,'productpurchasereport'])->name('report.productpurchasereport');
Route::get('product-stock-report',[\App\Http\Controllers\Admin\ReportController::class,'productstockreport'])->name('report.productstockreport');
Route::get('tax-report',[\App\Http\Controllers\Admin\ReportController::class,'taxreport'])->name('report.taxreport');
Route::get('expense-report',[\App\Http\Controllers\Admin\ReportController::class,'expensereport'])->name('report.expensereport');
Route::post('expense-report-pdf',[\App\Http\Controllers\Admin\ReportController::class,'expensepdf'])->name('report.pdf');
///cart userDetails
Route::get('/cart',[App\Http\Controllers\Frontend\CartController::class, 'cart'])->name('cart');
Route::post('/cart_save', [App\Http\Controllers\Frontend\CartController::class, 'cartstore']);
Route::post('/cartdelete', [App\Http\Controllers\Frontend\CartController::class, 'cartDelete'])->name('cart.delete');
Route::post('/render_carttable', [App\Http\Controllers\Frontend\CartController::class, 'render_carttable']);
Route::post('/cart/bynow', [App\Http\Controllers\Frontend\CartController::class, 'bynow'])->name('cart.bynow');
Route::post('/sessionDelete',[App\Http\Controllers\Frontend\CartController::class, 'sessionDelete']);
Route::post('/updatecart', [App\Http\Controllers\Frontend\CartController::class, 'cartUpdate'])->name('cart.update');
Route::post('/coupon/add',[App\Http\Controllers\Frontend\CartController::class, 'couponAdd'])->name('coupon.add');
Route::post('/product_check',[App\Http\Controllers\Frontend\CartController::class, 'product_check'])->name('product_check');
Route::post('/gettotalamt',[App\Http\Controllers\Frontend\CartController::class, 'getTotalAmount'])->name('get_total_amount');
Route::post('/changecartquantity', [App\Http\Controllers\Frontend\CartController::class, 'changeCartQuantity'])->name('change_cart_quantity');
Route::get('/session', [App\Http\Controllers\Frontend\CartController::class, 'getSessionData'])->name('get_session_data');
//wishlist section
Route::get('/Wishlist',[App\Http\Controllers\Frontend\WishlistController::class, 'Wishlist'])->name('Wishlist');
Route::post('/wishlist_save',[App\Http\Controllers\Frontend\WishlistController::class, 'WishlistStore'])->name('Wishlist.store');
Route::post('/Wishlist/move-to-cart',[App\Http\Controllers\Frontend\WishlistController::class, 'movetoCart'])->name('wishlist.move.cart');
Route::post('/wishlistdelete',[App\Http\Controllers\Frontend\WishlistController::class, 'wishlistDelete'])->name('wishlist.delete');

Route::post('/wishlist_to_cart',[App\Http\Controllers\Frontend\WishlistController::class, 'wishlist_to_cart']);
 //Subcategory
 Route::resource('/subcategory',\App\Http\Controllers\Admin\SubcategoryController::class);
  Route::get('subcategory_add/{id}',[\App\Http\Controllers\Admin\SubcategoryController::class,'subadd'])->name('subcategory.subadd');
 Route::get('subcategory_view/{id}',[\App\Http\Controllers\Admin\SubcategoryController::class,'view'])->name('subcategory.view');
 Route::get('subcategory_edit/{id}',[\App\Http\Controllers\Admin\SubcategoryController::class,'edit'])->name('subcategory.edit');
 Route::post('subcategory_update/{id}',[\App\Http\Controllers\Admin\SubcategoryController::class,'update'])->name('subcategory.update');
  Route::post('subcategory_create',[\App\Http\Controllers\Admin\SubcategoryController::class,'subcategory_create'])->name('subcategory_create');

//checkout section
Route::get('/view/checkout',[App\Http\Controllers\Frontend\CheckoutController::class, 'checkout1'])->name('checkout1');
Route::post('/checkout_store',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkout_store']);
Route::post('/checkout_store_payment',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkout_store_payment']);

Route::get('/processphonepe/{id}',[\App\Http\Controllers\Frontend\CheckoutController::class,'processphonepe']);
Route::post('/checkout_store_phonepe_payment',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkout_store_phonepe_payment']);

Route::get('/payment_success/{id}',[\App\Http\Controllers\Frontend\CheckoutController::class,'payment_success']);
//Route::post('checkout-first',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkoutStore'])->name('checkout.store');
// Route::post('checkout-two',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkout2Store'])->name('checkout2.store');
// Route::post('checkout-three',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkout3Store'])->name('checkout3.store');
 //Route::get('checkout',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkoutStore'])->name('checkout.store');
 Route::get('checkout',[\App\Http\Controllers\Frontend\CheckoutController::class,'checkoutStore'])->name('checkout.store');
 Route::get('change_shippingprice',[\App\Http\Controllers\Frontend\CheckoutController::class,'change_shippingprice']);
 Route::get('complete/{order}',[\App\Http\Controllers\Frontend\CheckoutController::class,'complete'])->name('complete');
 Route::get('/edit_address',[\App\Http\Controllers\Frontend\CheckoutController::class,'edit_address'])->name('edit_address');
 Route::post('/ccavenue/response',[\App\Http\Controllers\Frontend\CheckoutController::class,'ccavenueResponse'])->name('ccavenue_response');
  Route::get('payment_failure',[\App\Http\Controllers\Frontend\CheckoutController::class,'payment_failure']);
Route::group(['prefix'=>'customer'],function(){
    Route::get('/userAccount',[App\Http\Controllers\Frontend\IndexController::class, 'userAccount'])->name('user.Account');
    Route::get('/order_detail/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'order_details'])->name('order_detail');
    Route::get('/view_details/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'view_details'])->name('view_details');
    Route::get('/tracking/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'tracking'])->name('tracking');
    Route::get('/cancle/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'cancel'])->name('cancle');
    Route::get('/my_account',[App\Http\Controllers\Frontend\WhatisnewController::class, 'my_account'])->name('my_account');
    Route::post('/billing/address/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'billingAddress'])->name('billing.address');
    Route::post('/shipping/address/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'shippingAddress'])->name('shipping.address');
    Route::post('/account/update/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'accountUpdate'])->name('account.update');
    Route::get('/downloadPdf/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'downloadPdf'])->name('downloadPdf');
});
///cart

Route::post('/checkCouponcode', [\App\Http\Controllers\Admin\CouponController::class, 'checkCouponcode'])->name('checkCouponcode');

Route::resource('/contact',\App\Http\Controllers\ContactController::class);
Route::resource('/about',\App\Http\Controllers\AboutController::class);
Route::resource('/faqs',\App\Http\Controllers\FaqsController::class);
Route::resource('/contactlist',\App\Http\Controllers\ContactformController::class);
Route::resource('/blog',\App\Http\Controllers\BlogController::class);
Route::resource('/terms',\App\Http\Controllers\TermsController::class);
Route::resource('/delivery',\App\Http\Controllers\DeliveryController::class);
Route::resource('/deals',\App\Http\Controllers\DealsController::class);
Route::resource('/privacy',\App\Http\Controllers\PrivacyController::class);

Route::resource('/categorytag', \App\Http\Controllers\CategoryTagController::class);

///order delete
Route::post('/reason_status',[\App\Http\Controllers\Frontend\IndexController::class,'reason_status'])->name('reason_status');

Route::get('/my_orders', [\App\Http\Controllers\Frontend\WhatisnewController::class, 'ordernew_pdf']);

Route::get('/{id}', [\App\Http\Controllers\Frontend\WhatisnewController::class, 'order_pdf'])->where('id', '[0-9]+');
Route::get('/fetch-subcategories/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'fetchSubcategories']);

//categorytag

Route::post('categorytag/store', [CategoryTagController::class, 'store'])->name('categorytag.store');
Route::get('categorytag/create', [CategoryTagController::class, 'create'])->name('categorytag.create');
Route::get('/get-categories/{isParent}', [CategoryTagController::class, 'getCategories']);
Route::post('categorytag_status',[\App\Http\Controllers\CategoryTagController::class,'CategorytagStatus'])->name('categorytag_status');
