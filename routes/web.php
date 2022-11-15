<?php

use App\Http\Controllers\AddOns;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Checkout;
use App\Http\Controllers\Kavlings;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Index;
use App\Http\Controllers\KavlingController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Testimonials;
use App\Http\Controllers\UserList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/404', function () {
    return view('errors.404');
})->name('eror404');


Route::get('/', [Index::class, 'index'])->name('index');
Route::get('/about', function () {
    return view('guest.about');
})->name('about');
Route::get('/contact', function () {
    return view('guest.contact');
})->name('contact');
Route::get('/cart', function () {
    return view('guest.cart');
})->name('cart');
Route::get('/checkout', [Checkout::class, 'index'])->name('checkout');
Route::post('/place-order', [Checkout::class, 'placeOrder'])->name('place-order');

Route::get('/kavling', [Kavlings::class, 'index'])->name('kavling');
Route::get('/login', [Login::class, 'login'])->middleware('guest')->name('login');
Route::post('/sign-in', [Login::class, 'sign_in'])->middleware('guest')->name('sign-in');


Route::post('/add-to-cart', [CartController::class, 'addtocart'])->name('add-to-cart');


Route::post('/payment-notify', function () {
    return "aaa";
})->name('payment-notify');

Route::get('/cartcontent', [CartController::class, 'cartcontent'])->name('cartcontent');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/dashboard', [Dashboard::class, 'index'])->name("dashboard");


    //CRUD USER/ADMIN
    Route::get('/user-list', [UserList::class, 'index'])->name("userlist");
    Route::post('/user-list/show', [UserList::class, 'show'])->name("show-user-list");
    Route::get('/user-list/detail', [UserList::class, 'detail'])->name("detail-user-list");
    Route::post('/user-list/update', [UserList::class, 'update'])->name("update-userlist");
    Route::post('/user-list/delete', [UserList::class, 'delete'])->name("delete-userlist");
    Route::get('/user-list/add', [UserList::class, 'add'])->name("add-user-list");
    Route::post('/user-list/store', [UserList::class, 'store'])->name("store-userlist");

    //CRUD Kavling
    Route::get('/kavling-list', [KavlingController::class, 'index'])->name('list-kavling');
    Route::post('/kavling-list/show', [KavlingController::class, 'show'])->name("show-kavling");
    Route::post('/kavling-list/nonactive', [KavlingController::class, 'destroy'])->name("nonactive-kavling");
    Route::post('/kavling-list/activing', [KavlingController::class, 'activing'])->name("activing-kavling");

    Route::get('/add-on-list', [AddOns::class, 'index'])->name('add-ons');
    Route::post('/add-on-list/show', [AddOns::class, 'show'])->name('show-add-ons');
    Route::get('/add-on-list/add', [AddOns::class, 'add'])->name('add-add-ons');
    Route::post('/add-on-list/store', [AddOns::class, 'store'])->name('store-add-ons');
    Route::get('/add-on-list/detail', [AddOns::class, 'detail'])->name('detail-add-ons');
    Route::post('/add-on-list/update', [AddOns::class, 'update'])->name('update-add-ons');
    Route::post('/add-on-list/nonactiving', [AddOns::class, 'destroy'])->name("nonactiving-add-ons");
    Route::post('/add-on-list/activing', [AddOns::class, 'activing'])->name("activing-add-ons");

    Route::get('/testimonials', [Testimonials::class, 'index'])->name('testimonials');
    Route::post('/testimonials/show', [Testimonials::class, 'show'])->name('show-testimonials');
    Route::get('/testimonials/add', [Testimonials::class, 'add'])->name('add-testimonials');
    Route::post('/testimonials/store', [Testimonials::class, 'store'])->name('store-testimonials');
    Route::get('/testimonials/detail', [Testimonials::class, 'detail'])->name('detail-testimonials');
    Route::post('/testimonials/update', [Testimonials::class, 'update'])->name('update-testimonials');
    Route::post('/testimonials/delete', [Testimonials::class, 'destroy'])->name('delete-testimonials');
});


Route::get('/test-send-email', [Controller::class, 'test']);
