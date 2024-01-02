<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\PurchaseController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
 Route::get('customers', [CustomerController::class, 'index']);
 Route::get('customers/{customer}', [CustomerController::class, 'show']);
 Route::post('customers', [CustomerController::class, 'store']);
 Route::put('customers/{customer}', [CustomerController::class, 'update']);
 Route::patch('customers/{customer}', [CustomerController::class, 'update']);
 Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);


 Route::get('drugs', [DrugController::class, 'index']);
 Route::get('drugs/{drug}', [DrugController::class, 'show']);
 Route::post('drugs', [DrugController::class, 'store']);
 Route::put('drugs/{drug}', [DrugController::class, 'update']);
 Route::patch('drugs/{drug}', [DrugController::class, 'update']);
 Route::delete('drugs/{drug}', [DrugController::class, 'destroy']);


 Route::get('purchases', [PurchaseController::class, 'index']);
 Route::get('purchases/{purchase}', [PurchaseController::class, 'show']);
 Route::post('purchases', [PurchaseController::class, 'store']);
 Route::put('purchases/{purchase}', [PurchaseController::class, 'update']);
 Route::patch('purchases/{purchase}', [PurchaseController::class, 'update']);
 Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy']);


 Route::apiResource('drugs', DrugController::class);
 Route::apiResource('customers', CustomerController::class);
 Route::apiResource('purchases', PurchaseController::class); 


 Route::post('drugs/bulk', [DrugController::class, 'bulkStore']);
 Route::post('customers/bulk', [CustomerController::class, 'bulkStore']);
 Route::post('purchases/bulk', [PurchaseController::class, 'bulkStore']); 

});