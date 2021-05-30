<?php

// use view;

use App\Http\Controllers\ItinerarieController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

// 地圖
// ?search=
Route::resource('/maps', 'MapController');

// 註冊登入
Route::view('/sign-in', 'sign-in')->name('sign-in');
Route::view('/sign-up', 'sign-up')->name('sign-up');

// 個人頁面
Route::prefix('/travelers')->group(function () {
    Route::get('/', 'AmigoController@create')->name('traveler.index');
    Route::get('/profile', 'AmigoController@create')->name('traveler.profile');
    // 商人
    Route::resource('/attractions', 'AttractionController')->except('show');
});

// 我關注的地點
// Route::view('/itineraries', 'itineraries.index')->name('itineraries.index');
Route::resource('/itineraries', 'ItinerarieController')->only(['index', 'store']);

// 後台
Route::prefix('/backstage')->group(function () {
    Route::view('/', 'backstage.index');
});

// 測試用路由
Route::view('/mapstest', 'maps.test');

// 會員模組
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
