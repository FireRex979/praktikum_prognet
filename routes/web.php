<?php

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware(['auth','verified'])->name('home');

//Route Admin
Route::get('/adminLogin', function () {
    return view('admin.login');
})->middleware('guest')->name('loginAdmin');

Route::get('/adminRegister', function () {
    return view('admin.register');
})->middleware('guest');

Route::get('/adminHome', function () {
    return view('admin.home');
})->middleware('authAdmin:admin')->name('homeAdmin');

Route::post('/adminRegister', 'AdminController@register');
Route::post('/adminLogin', 'AdminController@login');
Route::get('/adminLogout', 'AdminController@logout');


//Product
Route::resource('products','ProductController')->middleware('authAdmin:admin');
Route::get('/addImage/{id}', 'ProductController@upload');
Route::post('/addImage/{id}', 'ProductController@upload_image');
Route::get('/products/delete/{id}', 'ProductController@soft_delete');
Route::get('/products-trash', 'ProductController@trash');
Route::get('/products/restore/{id}', 'ProductController@restore');
Route::get('/products-restore-all', 'ProductController@restore_all');
Route::get('/products/destroy/{id}', 'ProductController@delete');
Route::get('/products-delete-all', 'ProductController@delete_all');
Route::resource('product_images','ProductImageController')->middleware('authAdmin:admin');

//Courier
Route::resource('couriers', 'CourierController')->middleware('authAdmin:admin');
Route::get('/couriers/delete/{id}', 'CourierController@soft_delete');
Route::get('/couriers-trash', 'CourierController@trash');
Route::get('/couriers/restore/{id}', 'CourierController@restore');
Route::get('/couriers-restore-all', 'CourierController@restore_all');
Route::get('/couriers/destroy/{id}', 'CourierController@delete');
Route::get('/couriers-delete-all', 'CourierController@delete_all');

//Product_Categories
Route::resource('categories', 'CategoryController')->middleware('authAdmin:admin');
Route::get('/categories/delete/{id}', 'CategoryController@soft_delete');
Route::get('/categories-trash', 'CategoryController@trash');
Route::get('/categories/restore/{id}', 'CategoryController@restore');
Route::get('/categories-restore-all', 'CategoryController@restore_all');
Route::get('/categories/destroy/{id}', 'CategoryController@delete');
Route::get('/categories-delete-all', 'CategoryController@delete_all');

//Product_Category_Detail

Route::resource('product_category_details', 'Product_Category_DetailController')->middleware('authAdmin:admin');