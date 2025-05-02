<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\brand\BrandApiController;
use App\Http\Controllers\api\order\OrderApiController;
use App\Http\Controllers\api\payment\PaymentApiController;
use App\Http\Controllers\api\product\ProductApiController;
use App\Http\Controllers\api\Category\CategoryApiController;
use App\Http\Controllers\api\product\WhitelistApiController;
use App\Http\Controllers\api\main_category\MainCategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);
Route::post('logout', [AuthApiController::class, 'logout']);

Route::post('/forgotpassword', [AuthApiController::class, 'sendResetLinkEmail']);
Route::post('/otp-validation', [AuthApiController::class, 'otpValidation']);
Route::post('/register-otp-validation', [AuthApiController::class, 'otpValidationRegister']);
Route::post('/reset-password', [AuthApiController::class, 'resetPassword']);

// User Not Login

// For Brand
Route::get('/all-brands', [BrandApiController::class, 'index']);
Route::get('/all-brands/{id}', [BrandApiController::class, 'getBrand']);

// For Main Category
Route::get('/main-category', [MainCategoryApiController::class, 'index']);
Route::get('main-category/{id}',[MainCategoryApiController::class,"getMainCategoryById"]);

// For Category
Route::get('/all-categories', [CategoryApiController::class, 'index']);
Route::get('/all-categories/{id}', [CategoryApiController::class, 'getCategory']);

//For Home
Route::get('/home', [MainCategoryApiController::class, 'home']);
Route::post('/global_search', [MainCategoryApiController::class, 'globalSearch']);

// For Product
Route::get('/all-products', [ProductApiController::class, 'index']);
Route::get('/all-news', [ProductApiController::class, 'getAllNewProducts']);
Route::get('/recommend-products', [ProductApiController::class, 'RecommendProducts']);

Route::get('/all-products/{id}', [ProductApiController::class, 'getProduct']);
Route::get('/products-after-details', [ProductApiController::class, 'specificProduct']);
Route::get('/products-after-checkouts', [ProductApiController::class, 'specificProduct2']);

//  Route::get('/whitelists', [WhitelistApiController::class, 'getWhitelist']);
//  Route::middleware('auth:api')->get('/whitelist', [WhitelistApiController::class, 'getWhitelist']);
//  Route::middleware('auth:api')->get('/whitelist', [WhitelistApiController::class, 'getWhitelist']);
//  Route::middleware('auth:api')->get('/whitelist', [WhitelistApiController::class, 'getWhitelist']);

Route::middleware( ['auth:api', 'check.token'])->group(function () {
    Route::post('/change-password', [AuthApiController::class, 'changePassword']);
    Route::get('user/{id}',[AuthApiController::class,"UserbyId"]);
    Route::put('/user-update/{id}', [AuthApiController::class, 'updateUser']);

    // whilist
    Route::get('/whitelists', [WhitelistApiController::class, 'getWhitelist']);
    Route::post('/whitelists/add', [WhitelistApiController::class, 'addToWhitelist']);
    Route::post('/whitelists/remove', [WhitelistApiController::class, 'removeFromWhitelist']);

    // add to cart
    Route::post('/add-to-cart/add', [CartController::class, 'addToCart']); // Add to
    Route::get('/add-to-cart/all', [CartController::class, 'viewCart']); // View cart
    Route::put('/add-to-cart/{id}', [CartController::class, 'updateCart']); // Update cart
    Route::delete('/add-to-cart/{id}', [CartController::class, 'removeFromCart']);

    Route::get('/payment', [PaymentApiController::class, 'index']);
    Route::post('/orders/create-order', [OrderApiController::class, 'createOrder']);
    Route::post('/orders/user-order/', [OrderApiController::class, 'getOrder']);
    Route::post('/orders/user-order-details/{id}', [OrderApiController::class, 'show']);

    // For Brand
    // For MainCategory

    // For  Main Category

    // For Product
    Route::get('/all-products-auth/{id}', [ProductApiController::class, 'getProductAfterLogin']);


    // For Order

    // For Payment
});

// For Brand

# MAIL_MAILER=smtp
# MAIL_HOST=sandbox.smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=24b2cb7e3e4fc3
# MAIL_PASSWORD=e076c8d26fbc56
# MAIL_ENCRYPTION=null
# MAIL_FROM_ADDRESS="hello@example.com"
# MAIL_FROM_NAME="${APP_NAME}"
