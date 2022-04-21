<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\managementController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\variationsController;
use App\Http\Controllers\user\userController;
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
//Dashboard
//login



Route::get('admin', [loginController::class,'adminIndex'])->name('admin.login');
Route::post('admin', [loginController::class,'adminPosted']);


Route::group(['middleware' => 'admin'], function(){
    
 
    Route::get("/admin_panel", [admin_panel\dashboardController::class,'index'])->name('admin.dashboard');

    Route::get('admin/logout', [loginController::class,'adminLogout'])->name('admin.logout');
    //categories
    Route::get('/admin_panel/categories', [admin_panel\categoriesController::class,'index'])->name('admin.categories');
    Route::post('/admin_panel/categories', [admin_panel\categoriesController::class,'posted']);

    Route::get('/admin_panel/categories/edit/{id}', [admin_panel\categoriesController::class,'edit'])->name('admin.categories.edit');
    Route::post('/admin_panel/categories/edit/{id}', [admin_panel\categoriesController::class,'update']);

    Route::get('/admin_panel/categories/delete/{id}', [admin_panel\categoriesController::class,'delete'])->name('admin.categories.delete');
    Route::post('/admin_panel/categories/delete/{id}', [admin_panel\categoriesController::class,'destroy']);


    //products
    Route::get('/admin_panel/products', [admin_panel\productsController::class,'index'])->name('admin.products');

    Route::get('/admin_panel/products/create', [admin_panel\productsController::class,'create'])->name('admin.products.create');
    Route::post('/admin_panel/products/create', [admin_panel\productsController::class,'store']);

    Route::get('/admin_panel/products/edit/{id}', [admin_panel\productsController::class,'edit'])->name('admin.products.edit');
    Route::post('/admin_panel/products/edit/{id}', [admin_panel\productsController::class,'update']);

    Route::get('/admin_panel/products/delete/{id}', [admin_panel\productsController::class,'delete'])->name('admin.products.delete');
    Route::post('/admin_panel/products/delete/{id}', [admin_panel\productsController::class,'destroy']);

    //order management 
    Route::get('/admin_panel/management', [admin_panel\managementController::class,'manage'])->name('admin.orderManagement');
    Route::post('/admin_panel/management', [admin_panel\managementController::class,'update'])->name('admin.orderUpdate');

});

Route::get('/login', [loginController::class,'userIndex'])->name('user.login');
Route::post('/login', [loginController::class,'userPosted'])->name("login");

//signup
Route::get('/signup', [signupController::class,'userIndex'])->name('user.signup');
Route::post('/signup', [signupController::class,'userPosted']);
Route::post('/check_email', [signupController::class,'emailCheck'])->name('user.signup.check_email');


//user
Route::get('/', [user\userController::class,'index'])->name('user.home');
Route::get('/product/{id}', [user\userController::class,'view'])->name('user.product');

Route::get('/search', [user\userController::class,'search'])->name('user.search');
Route::get('/search?c={id}', [user\userController::class,'view'])->name('user.search.cat');



Route::get('/view/{id}', [user\userController::class,'view'])->name('user.view');
Route::post('/view/{id}', [user\userController::class,'post']);

Route::get('/cart', [user\userController::class,'cart'])->name('user.cart');
Route::post('/cart', [user\userController::class,'confirm']);

Route::post('/edit_cart', [user\userController::class,'ditCart'])->name('user.editCart');
Route::post('/delete_item_from_cart', [user\userController::class,'deleteCartItem'])->name('user.deleteCartItem');


Route::post('/logout', [loginController::class,'userLogout'])->name('user.logout');

Route::group(['middleware' => 'user'], function(){
Route::get('/history', [user\userController::class,'history'])->name('user.history');
});
