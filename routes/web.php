<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RunCourseController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\Admin\CourseController as Course;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnitController;
use App\Models\Staff;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\ChatsController;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\User\PurchasedCourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\CategoryController as UserCategory;

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
//Admin auth
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('login')->middleware('block.login');
Route::post('/admin/login', [LoginController::class,'login'])->name('admin.login');
Route::get('/register', function () {
    return view('admin.auth.register');
});
Route::get('/confirm-email', function () {
    return view('admin.auth.confirm-email');
});
Route::get('/admin/logout', [LogoutController::class,'logoutAdmin'])->name('admin.logout');
Route::post('/admin/login/authenticate', [LoginController::class,'login'])->name('admin.login.authenticate');

// User auth
Route::get('/login', function () {
    return view('user.auth.login');
})->name('user.login')->middleware('block.login.user');
Route::get('/register', function () {
    return view('user.auth.register');
})->name('user.register')->middleware('block.login.user');
Route::get('/forgot-password', function () {
    return view('user.auth.email');
})->name('user.forgot-password')->middleware('block.login.user');
Route::get('/reset-password/{token}', [ForgotPasswordController::class,'getPassword'])->name('user.reset-password');
Route::post('/forgot-password', [ForgotPasswordController::class,'postEmail'])->name('user.forgot-password.check');
Route::post('/reset-password', [ForgotPasswordController::class,'updatePassword'])->name('user.reset-password.check');
Route::post('/register/authenticate', [RegisterController::class,'register'])->name('user.register.authenticate');
Route::post('/login/authenticate', [LoginController::class,'loginUser'])->name('user.login.authenticate');
Route::post('/register/authenticate', [RegisterController::class,'register'])->name('user.register.authenticate');
Route::get('/logout', [LogoutController::class,'logoutUser'])->name('user.logout');
Route::get('/confirm-account/{id}',[RegisterController::class,'confirm'])->name('user.confirm')
    ->middleware('block.login.user');
//Trang Admin
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => ['admin','preventBackHistory']
], function (){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::post('/dashboard/fillter-by-date',[DashboardController::class,'fillter'])->name('admin.dashboard.fillter');
    Route::prefix('settings')->name('settings.')->group(function(){
        Route::get('/{id}', [AdminSetting::class,'settingsIndex'])->name('admin.index');
        Route::post('/update/{id}', [AdminSetting::class,'update'])->name('admin.update');
        Route::post('/change-password/{id}', [AdminSetting::class,'changePassword'])->name('admin.change');
    });
    Route::prefix('staffs')-> name('staffs.')
        ->middleware('permission:editor')->group(function(){
        Route::get('/', [StaffController::class,'index'])->name('index');
        Route::get('/getlist', [StaffController::class,'getList'])->name('getlist');
        Route::post('/', [StaffController::class,'show'])->name('show');
        Route::get('/create', [StaffController::class,'create'])->name('create');
        Route::post('/', [StaffController::class,'store'])->name('store');
        Route::get('/{id}/edit', [StaffController::class,'edit'])->name('edit');
        Route::put('/{id}', [StaffController::class,'update'])->name('update');
        Route::delete('/{id}', [StaffController::class,'destroy'])->name('destroy');
        Route::post('/lock/{id}', [StaffController::class,'lock'])->name('lock');
        Route::post('/resetpassword/{id}',[StaffController::class,'resetPassword'])->name('reset');
        Route::post('/{id}',[StaffController::class,'show'])->name('show');
    });
    Route::prefix('categories')->name('categories.')
        ->middleware('permission:editor')->group(function () {
        Route::get('/',[CategoryController::class,'index'])->name('list');
        Route::get('/getlist',[CategoryController::class,'getlist']);
        Route::get('/create',[CategoryController::class,'create'])->name('create');
        Route::post('/store',[CategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
        Route::post('/update/{id}',[CategoryController::class,'update'])->name('update');
        Route::delete('/{id}',[CategoryController::class,'delete'])->name('delete');
    });
    Route::prefix('users')->name('users.')
        ->middleware('permission:editor')->group(function(){
        Route::get('/', [UserController::class,'index'])->name('index');
        Route::get('/getlist', [UserController::class,'getList'])->name('getlist');
        Route::get('/list/{id}', [UserController::class,'showUser'])->name('list.show');
        Route::post('/lock-user', [UserController::class,'lockUser'])->name('lock');
        Route::post('/send-email', [UserController::class,'sendEmail'])->name('send');
    });
    Route::prefix('/tags')->name('tags.')
        ->middleware('permission:editor')->group(function(){
        Route::get('/',[TagController::class,'index'])->name('list');
        Route::get('/list',[TagController::class,'list']);
        Route::get('/create',[TagController::class,'create'])->name('create');
        Route::post('/store',[TagController::class,'store'])->name('store');
        Route::get('/{id}/edit',[TagController::class,'edit'])->name('edit');
        Route::post('/{id}/update',[TagController::class,'update'])->name('update');
        Route::delete('/{id}',[TagController::class,'destroy'])->name('destroy');
    });
    Route::prefix('orders')->name('orders.')
        ->middleware('permission')->group(function(){
        Route::get('/list/data',[OrderController::class,'list'])->name('getList');
        Route::get('/',[OrderController::class,'index'])->name('index');
        Route::get('/{id}',[OrderController::class,'cancelOrder'])->name('cancelOrder');
        Route::get('/confirmOrder/{id}',[OrderController::class,'confirmOrder'])->name('confirmOrder');
        Route::get('/list/data/{id}', [OrderController::class,'showOrder'])->name('list.show');

        });
    Route::prefix('courses-manager')->name('courses-manager.')
        ->middleware('permission:editor')->group(function(){
        Route::get('/',[Course::class,'index'])->name('index');
        Route::get('/get',[Course::class,'getList'])->name('getList');
        Route::get('/create',[Course::class,'create'])->name('create');
        Route::post('/',[Course::class,'store'])->name('store');
        Route::post('/{id}',[Course::class,'show'])->name('show');
        Route::get('/{id}/edit',[Course::class,'edit'])->name('edit');
        Route::put('/{id}',[Course::class,'update'])->name('update');
        Route::delete('/{id}',[Course::class,'destroy'])->name('destroy');
        Route::get('/download/file/{id}',[Course::class,'download_file'])->name('download.file');
        Route::post('/publishCourse/{id}',[Course::class,'publishCourse'])->name('publishCourse');
    });

    Route::prefix('run-course')->name('run-course.')->middleware('permission:teacher')->group(function(){
        Route::get('/',[RunCourseController::class,'index'])->name('index');
        Route::get('/get',[RunCourseController::class,'getList'])->name('getList');
        Route::post('/startLive/{id}',[RunCourseController::class,'startLive'])->name('startLive');
        Route::post('/{id}',[RunCourseController::class,'show'])->name('show');
    });

    Route::prefix('units')->name('units.')->group(function(){
        Route::get('/{course_id}/',[UnitController::class,'index'])->name('index');
        Route::get('/{course_id}/getList',[UnitController::class,'getList'])->name('getList');
        Route::get('/{course_id}/create',[UnitController::class,'create'])->name('create');
        Route::post('/{course_id}/',[UnitController::class,'store'])->name('store');
        Route::post('/show/{id}',[UnitController::class,'show'])->name('show');
        Route::get('/{id}/edit',[UnitController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[UnitController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[UnitController::class,'destroy'])->name('destroy');
    });



});




// Trang Users
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/details/{id}', [CourseController::class,'show'])->name('courses.details');
Route::get('/categories/list/{id}', [UserCategory::class,'index'])->name('categories.index');
Route::get('/searchCategory', [UserCategory::class,'searchCategory'])->name('categories.searchCategory');
Route::get('/searchTag', [UserCategory::class,'searchTag'])->name('categories.searchTag');
Route::group([
    'namespace' => 'user',
    'prefix' => '/',
    'middleware' => ['auth','preventBackHistory']
], function (){
    Route::prefix('courses')-> name('courses.')->group(function(){
        Route::get('/', [CourseController::class,'index'])->name('index');
        Route::post('/store', [CourseController::class,'store'])->name('store');
    });
    Route::prefix('purchased_courses')->name('purchased_courses.')->group(function(){
        Route::get('/', [PurchasedCourseController::class,'index'])->name('index');
        Route::get('/search', [PurchasedCourseController::class,'liveSearch'])->name('search');
        Route::get('/detail/{id}', [PurchasedCourseController::class,'getCourse'])->name('get-course');
        Route::get('/courses/{course_id}/unit/{id}', [PurchasedCourseController::class,'unit'])->name('unit');
    });
    Route::prefix('settings')->name('settings.')->group(function(){
        Route::get('/{id}', [SettingController::class,'settingsIndex'])->name('edit');
        Route::post('/update/{id}', [SettingController::class,'update'])->name('update');
        Route::post('/change-password/{id}', [SettingController::class,'changePassword'])->name('change');
    });
    Route::post('/store', [PaymentController::class, 'store'])->name('store-order');
    Route::get('/return', [PaymentController::class, 'return']);


});

Route::prefix('/chat')->name('chat.')->group(function (){
    Route::get('/',[ChatsController::class,'index'])->name('index');
    Route::post('/send',[ChatsController::class,'sendMessage'])->name('send');
});
