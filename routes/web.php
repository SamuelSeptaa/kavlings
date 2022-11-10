<?php

use App\Http\Controllers\Kavling;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Login;
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


Route::get('/', function () {
    return view('guest.index');
});
Route::get('/about', function () {
    return view('guest.about');
});
Route::get('/contact', function () {
    return view('guest.contact');
});
Route::get('/cart', function () {
    return view('guest.cart');
});
Route::get('/checkout', function () {
    return view('guest.checkout');
});
Route::get('/kavling', function () {
    return view('guest.kavling');
});

Route::get('/login', [Login::class, 'login'])->middleware('guest')->name('login');
Route::post('/sign-in', [Login::class, 'sign_in'])->middleware('guest')->name('sign-in');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/dashboard', [Dashboard::class, 'index'])->name("dashboard");

    Route::get('/user-list', [UserList::class, 'index'])->name("userlist");
    Route::post('user-list/show', [UserList::class, 'show'])->name("show-user-list");
    Route::get('user-list/detail', [UserList::class, 'detail'])->name("detail-user-list");
    Route::post('user-list/update', [UserList::class, 'update'])->name("update-userlist");
    Route::post('user-list/delete', [UserList::class, 'delete'])->name("delete-userlist");
    Route::get('user-list/add', [UserList::class, 'add'])->name("add-user-list");
    Route::post('user-list/store', [UserList::class, 'store'])->name("store-userlist");
});
