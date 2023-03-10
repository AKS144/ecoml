<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//isAPIAdmin
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class,'login']);
Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function() {

   Route::get('/checkingauthenticated', function() {
      return response()->json(['message' => 'You are in', 'status'=> 200],200);
   });

   Route::get('view-category',[CategoryController::class,'index']);
   Route::post('store-category',[CategoryController::class,'store']);
   Route::get('edit-category/{id}',[CategoryController::class,'edit']);
   Route::put('update-category/{id}',[CategoryController::class,'update']);
   Route::delete('delete-category/{id}',[CategoryController::class,'delete']);

   Route::get('all-category',[CategoryController::class,'allcategory']);

   //product
   Route::post('store-product',[ProductController::class,'store']);
   Route::get('view-product',[ProductController::class,'index']);
   Route::get('edit-product/{id}',[ProductController::class,'edit']);
   Route::post('update-product/{id}',[ProductController::class,'update']);
   Route::delete('delete-product/{id}',[ProductController::class,'delete']);


});

Route::middleware(['auth:sanctum'])->group(function() {

   Route::post('logout',[AuthController::class,'logout']);

});

