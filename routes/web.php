<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\user\UserController;
use App\Http\Controllers\admin\auth\LoginController;
use App\Http\Controllers\admin\user\AdminController;
use App\Http\Controllers\admin\brand\BrandController;
use App\Http\Controllers\admin\auth\RegisterController;
use App\Http\Controllers\admin\payment\PaymentTypeController;
use App\Http\Controllers\admin\home\HomePageController;
use App\Http\Controllers\admin\product\ProductController;
use App\Http\Controllers\admin\category\CategoryController;
use App\Http\Controllers\admin\category\SubcategoryController;
use App\Http\Controllers\admin\main_category\MainCategoryController;
use App\Http\Controllers\admin\account\AccountController;
use App\Http\Controllers\admin\order\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'admin'])->group(
    function () {

        Route::get('/dashboard', [HomePageController::class, 'index'])->name('home');
        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');
        Route::get('/admin/change-password', [LoginController::class, 'changePassword'])->name('admin.change-password');
        Route::post('admin/password/update', [LoginController::class, 'updatePassword'])->name('password.update');

        // For profile
        Route::get('/admin/profile', [AdminController::class, 'show'])->name('admin.profile');
        Route::post('/admin/profile/upload', [AdminController::class, 'uploadProfilePicture'])->name('admin.profile.upload');
        Route::get('/admin/profile/edit', [AdminController::class, 'edit'])->name('admin.profile.edit');
        Route::post('/admin/profile/update', [AdminController::class, 'updateSettings'])->name('user.settings.update');


        // For all user role
        Route::get('/admin/role/users', [UserController::class, 'index'])->name('admin.user');
        Route::get('/admin/role/user/{id}', [UserController::class, 'userDetails'])->name('admin.user.show');
        Route::get('/admin/role/delete/user/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
        Route::post('/admin/user/status/update', [UserController::class, 'updateStatus'])
            ->name('admin.user.status.update');
        Route::resource('/admin/main_categories', MainCategoryController::class);
        Route::resource('/admin/brands', BrandController::class);
        Route::resource('/admin/categories', CategoryController::class);
        Route::resource('/admin/subcategories', SubcategoryController::class);
        Route::resource('/admin/products', ProductController::class);
        Route::post('admin/subcategories/fetch', [ProductController::class, 'fetchSubcategories'])->name('subcategories.fetch');
        Route::resource('/admin/payment_type', PaymentTypeController::class);
        Route::put('admin/payment_type/{id}', [PaymentTypeController::class, 'update'])->name('payment_type.updatebank');
        Route::delete('admin/payment_type/delete/{id}', [PaymentTypeController::class, 'destroy'])->name('payment_type.deletebank');
        Route::resource('/admin/account', AccountController::class);
        Route::post('/get-bank-type', [AccountController::class, 'getBankType'])->name('get.bank.type');

        //orders
        Route::get('/admin/orders/all', [OrderController::class, 'index'])->name('order.all');
        Route::post('/admin/orders/voucher', [OrderController::class, 'generateVoucher'])->name('order.voucher');
        Route::get('/admin/orders/pending-orders', [OrderController::class, 'pending'])->name('order.pending');
        Route::get('/admin/orders/completed-orders', [OrderController::class, 'completed'])->name('order.completed');
        Route::get('/admin/orders/confirm-orders', [OrderController::class, 'confirm'])->name('order.confirm');
        Route::get('/admin/orders/cancel-orders', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::put('/admin/orders/change-status/{id}', [OrderController::class, 'update'])->name('order.status');
        Route::delete('/admin/orders/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('order.destroy');
        Route::delete('/admin/orders/delete-order-details/{id}', [OrderController::class, 'deleteOrderFromShow'])->name('order.delete');


        Route::put('/admin/orders/change-status-user/{id}', [OrderController::class, 'updateFromUser'])->name('order.status_user');

        Route::get('/admin/orders/show/{id}', [OrderController::class, 'show'])->name('order.show');


    }
);

Route::get('/', [HomePageController::class, 'check'])->name('check');

// Route::get('/mail', [AuthApiController::class, 'mail']);


Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login')->middleware('route');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::get('/admin/forgot_password', [LoginController::class, 'forgotPassword'])->name('admin.forgot_password');
Route::post('/admin/send-email', [LoginController::class, 'sentEmail'])->name('admin.sent_email');
Route::get('/admin/otp-validation', [LoginController::class, 'otp'])->name('admin.otp');
Route::post('/admin/otp-validation-process', [LoginController::class, 'otpValidation'])->name('admin.otp-validate');
Route::get('/admin/reset-password', [LoginController::class, 'reset'])->name('admin.reset-password-confirm');
Route::post('/admin/reset-password/confirm', [LoginController::class, 'resetPassword'])->name('admin.reset-password-success');



Route::get('/admin/register', [RegisterController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'register']);
