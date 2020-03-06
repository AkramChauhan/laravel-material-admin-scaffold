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

// Route::get('/', function () {
//     return view('layouts.users.home');
// });
Route::get('/','HomeController@index')->name('welcome');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Admin Routes
Route::prefix('admin')->group(function() {

    Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');
    
    Route::post('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
    
    Route::get('/dashboard', 'AdminDashboardController@index')->name('admin.dashboard');
    Route::get('/manage_users','UsersController@index')->name('admin.manage_users');
    
    Route::post('/admin_manage_users','UsersController@admin_manage_users')->name('admin-manage-users');
    
    Route::post('/admin-manage-groups', 'GroupsController@admin_manage_groups')->name('admin-manage-groups');
    
});