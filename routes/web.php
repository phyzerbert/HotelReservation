<?php

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
    return redirect(route('login'));
});

Auth::routes();

Route::any('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/updateuser', 'UserController@updateuser')->name('updateuser');
Route::get('/users/index', 'UserController@index')->name('users.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edituser')->name('user.edit');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/hotel/index', 'HotelController@index')->name('hotel.index');
Route::post('/hotel/create', 'HotelController@create')->name('hotel.create');
Route::post('/hotel/edit', 'HotelController@edit')->name('hotel.edit');
Route::get('/hotel/delete/{id}', 'HotelController@delete')->name('hotel.delete');


Route::get('/reservation/index', 'ReservationController@index')->name('reservation.index');
Route::get('/reservation/create', 'ReservationController@create')->name('reservation.create');
Route::post('/reservation/save', 'ReservationController@save')->name('reservation.save');
Route::get('/reservation/edit/{id}', 'ReservationController@edit')->name('reservation.edit');
Route::post('/reservation/update', 'ReservationController@update')->name('reservation.update');
Route::post('/reservation/reply', 'ReservationController@reply')->name('reservation.reply');
Route::get('/reservation/delete/{id}', 'ReservationController@delete')->name('reservation.delete');