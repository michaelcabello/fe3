<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TableController;
use App\Http\Livewire\Admin\CategoryList;
use App\Http\Livewire\Admin\ModeloList;


//Route::get('/', [HomeController::class, 'home'])->name('admin.home');
Route::get('/tables', [TableController::class, 'showtables'])->name('admin.showtables');

Route::get('/categories', CategoryList::class)->name('category.list'); 
Route::get('/modelos', ModeloList::class)->name('modelo.list'); 
