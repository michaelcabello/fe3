<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TableController;
use App\Http\Livewire\Admin\CategoryList;
use App\Http\Livewire\Admin\ModeloList;
use App\Http\Livewire\Admin\BrandList;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Livewire\Admin\CategoryListd;
use App\Http\Livewire\Admin\ProductList;
use App\Http\Livewire\Admin\ProductcompuestoCreate;

//Route::get('/', [HomeController::class, 'home'])->name('admin.home');
Route::get('/tables', [TableController::class, 'showtables'])->name('admin.showtables');

Route::get('/categories', CategoryList::class)->name('category.list'); 
Route::get('/modelos', ModeloList::class)->name('modelo.list'); 
Route::get('/marcas', BrandList::class)->name('brand.list'); 


//Route::get('categories', [CategoryController::class, 'index']);
Route::get('categoriess', CategoryListd::class)->name('category.listd'); 
Route::get('products', ProductList::class)->name('product.list'); 
Route::get('productcompuesto', ProductcompuestoCreate::class)->name('productcompuesto.create'); 