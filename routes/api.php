<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Brands\BrandController;
use App\Http\Controllers\Carts\CartController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Subcategories\SubcategoryController;
use Illuminate\Support\Facades\Route;



//////////////////////Admin Authentication/////////////////////
Route::group(['prefix'=>'admin'],function () {
    Route::post('/login',[AdminAuthController::class,'login']);
});



////////////////////////Admin Operations/////////////////////
Route::group(['middleware'=>['admin','auth:sanctum']],function () {
    ///////////////////////categories operations////////////////////
    Route::resource('categories', CategoryController::class)->except(['create','show','index','update']);
    Route::post('categories/{id}', [CategoryController::class, 'update']);


    ///////////////////////subcategories operations////////////////////
    Route::resource('subcategories', SubcategoryController::class)->except(['create','show','index','update']);
    Route::post('subcategories/{id}', [SubcategoryController::class, 'update']);


    ///////////////////////brands operations////////////////////
    Route::resource('brands', BrandController::class)->except(['create','show','index','update']);
    Route::post('brands/{id}', [BrandController::class, 'update']);
    
    
    ///////////////////////Products operations////////////////////
    Route::resource('products', ProductController::class)->except(['create','show','index','update']);
    Route::post('products/{id}', [ProductController::class, 'update']);


    ///////////////////////All cart indexes////////////////////
    Route::get('carts', [CartController::class, 'index']);


});




//////////////////////User Authentication/////////////////////
Route::group(['prefix'=>'users'],function () {
    Route::post('/register',[UserAuthController::class,'register']);
    Route::post('/login',[UserAuthController::class,'login'])->middleware('user-verified');

});
Route::group(['middleware'=>['auth:sanctum','user-role']],function () {

    Route::get('users/sendCode',[UserAuthController::class,'sendCode']);
    Route::post('users/verifiyEmail',[UserAuthController::class,'verifiyEmail']);

    ///////////////////////carts operations////////////////////
    Route::resource('carts', CartController::class)->except(['create','edit','index','update']);
    Route::get('carts/{cart}/increase', [CartController::class, 'increase']);
    Route::get('carts/{cart}/decrease', [CartController::class, 'decrease']);

});



////////Routes for Admins and Users
Route::group(['middleware'=>'auth:sanctum'],function () {

    /////////////////////categories////////////////////////////////
    Route::group(['prefix'=>'categories'],function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
    });

    /////////////////////subcategories////////////////////////////////
    Route::group(['prefix'=>'subcategories'],function () {
        Route::get('/', [SubcategoryController::class, 'index']);
        Route::get('/{subcategory}', [SubcategoryController::class, 'show']);
    });

    /////////////////////Brands////////////////////////////////
    Route::group(['prefix'=>'brands'],function () {
        Route::get('/', [BrandController::class, 'index']);
        Route::get('/{brand}', [BrandController::class, 'show']);
    });

    
    /////////////////////products////////////////////////////////
    Route::group(['prefix'=>'products'],function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });


    /////////////////////charts////////////////////////////////
    Route::group(['prefix'=>'carts'],function () {
        Route::get('/{product}', [CartController::class, 'show']);
    });
});