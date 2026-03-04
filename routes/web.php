<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductTagController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Language switch
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');

// Download produk
Route::get('/download/{token}', DownloadController::class)->name('download');

// Checkout / pembayaran
Route::get('/checkout/finish/{orderNumber}', [CheckoutController::class, 'finish'])->name('checkout.finish');
Route::get('/checkout/{product:slug}', [CheckoutController::class, 'show'])->name('checkout.show')->where('product', '^(?!finish$).*');
Route::post('/checkout/{product:slug}', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order-status', [CheckoutController::class, 'status'])->name('order.status');

// Midtrans webhook (no CSRF)
Route::post('/midtrans/webhook', MidtransWebhookController::class)->name('midtrans.webhook');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/ajax', [SettingController::class, 'ajaxUpdate'])->name('settings.ajax-update');
    Route::post('settings/upload', [SettingController::class, 'ajaxUpload'])->name('settings.ajax-upload');

    // Skills
    Route::resource('skills', SkillController::class)->except(['show']);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    // Portfolio Categories
    Route::resource('portfolio-categories', PortfolioCategoryController::class)->except(['show']);

    // Portfolios
    Route::delete('portfolios/{portfolio}/images/{image}', [AdminPortfolioController::class, 'destroyImage'])->name('portfolios.images.destroy');
    Route::resource('portfolios', AdminPortfolioController::class)->except(['show']);

    // Product Categories
    Route::resource('product-categories', ProductCategoryController::class)->except(['show']);

    // Product Tags
    Route::resource('product-tags', ProductTagController::class)->except(['show']);

    // Products
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('products', AdminProductController::class)->except(['show']);

    // Orders
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);

    // Services
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Contacts / Messages
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);

    // Change Password
    Route::get('change-password', [App\Http\Controllers\Admin\ChangePasswordController::class, 'edit'])->name('change-password');
    Route::put('change-password', [App\Http\Controllers\Admin\ChangePasswordController::class, 'update'])->name('change-password.update');
});

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
