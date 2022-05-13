<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\CategoryList;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});



Route::group(['middleware'=>['auth:sanctum','verified'],'prefix'=>'admin'], function(){

    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');


    Route::get('/categories', CategoryList::class)->name('category.list'); 

    Route::get('/brands', function () {
        return view('admin.brands');
    })->name('admin.brands'); 
    /* de esta forma no es necesario poner el slot y los divs */

});


/* 

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/admin', function () {
        return view('admin.categories');
    })->name('admin.categories');
    
});
 */