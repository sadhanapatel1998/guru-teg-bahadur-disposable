<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ReviewController as FrontendReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login/otp', [LoginController::class, 'showOtpForm'])->name('login.otp');
    Route::post('/login/otp/send', [LoginController::class, 'sendOtp'])->name('login.otp.send');
    Route::get('/login/otp/verify', [LoginController::class, 'showOtpForm'])->name('login.otp.verify');
    Route::post('/login/otp/verify', [LoginController::class, 'verifyOtp'])->name('login.otp.verify.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/search', [ShopController::class, 'search'])->name('search');
Route::get('/search/ajax', [ShopController::class, 'ajaxSearch'])->name('search.ajax');
Route::get('/shop/{categorySlug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/{categorySlug}/{subcategorySlug}', [ShopController::class, 'subcategory'])->name('shop.subcategory');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{cartId}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cartId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Wishlist (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/products/{product}/review',[FrontendReviewController::class, 'store'])->name('reviews.store');
});

// Checkout (auth required)
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'process'])->name('process');
    Route::post('/razorpay/callback', [CheckoutController::class, 'razorpayCallback'])->name('razorpay.callback');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/failure', [CheckoutController::class, 'failure'])->name('failure');
});

// Customer Dashboard
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [CustomerDashboardController::class, 'orderShow'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [CustomerDashboardController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{order}/invoice', [CustomerDashboardController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders/{order}/return', [CustomerDashboardController::class, 'returnRequest'])->name('orders.return');
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [CustomerDashboardController::class, 'changePassword'])->name('password.update');
    Route::get('/addresses', [CustomerDashboardController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [CustomerDashboardController::class, 'storeAddress'])->name('addresses.store');
    Route::delete('/addresses/{address}', [CustomerDashboardController::class, 'deleteAddress'])->name('addresses.destroy');
});

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');


Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
// Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
// Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');
// Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::post('/newsletter/subscribe', [PageController::class, 'newsletter'])->name('newsletter.subscribe');





// Sitemap
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots');

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Auth
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout')->middleware('auth:admin');

    // Admin Protected Routes
    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('subcategories', SubcategoryController::class)->except(['show']);

        // Products
        Route::resource('products', ProductController::class);
        Route::delete('products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
        Route::get('categories/{category}/subcategories', [ProductController::class, 'getSubcategories'])->name('categories.subcategories');

        // Orders
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');

        // Customers
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::patch('customers/{customer}/toggle', [CustomerController::class, 'toggleStatus'])->name('customers.toggle');

        // Coupons
        Route::resource('coupons', CouponController::class)->except(['show']);

        // Banners
        Route::resource('banners', BannerController::class)->except(['show']);

        // Blog
        Route::resource('blogs', AdminBlogController::class)->except(['show']);
        Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show']);

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        // Reports
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');

        // Settings
        Route::get('settings/general', [SettingsController::class, 'general'])->name('settings.general');
        Route::post('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');
        Route::get('settings/smtp', [SettingsController::class, 'smtp'])->name('settings.smtp');
        Route::post('settings/smtp', [SettingsController::class, 'updateSmtp'])->name('settings.smtp.update');
        Route::get('settings/seo', [SettingsController::class, 'seo'])->name('settings.seo');
        Route::post('settings/seo', [SettingsController::class, 'updateSeo'])->name('settings.seo.update');


            Route::resource('pages', AdminPageController::class)->except(['show']);

        
       Route::get('settings/storage-link',[SettingsController::class, 'storageLink'])->name('settings.storage-link');

        Route::get('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');


    });
});
