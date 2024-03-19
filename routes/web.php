<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return redirect()->route('products.index');
});
Route::resource('/products', ProductsController::class);
