<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\BrandList;
use App\Http\Livewire\Admin\ModeloList;
use App\Http\Livewire\Admin\ProductList;
use App\Http\Livewire\Admin\CategoryList;
use App\Http\Livewire\Admin\CategoryListd;
use App\Http\Controllers\admin\TableController;
use App\Http\Livewire\Admin\ProductcompuestoList;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Livewire\Admin\ProductcompuestoCreate;
use App\Http\Livewire\Admin\ProductfamilieCreateaa;
use App\Http\Livewire\Admin\ProductcompuestoCreatea;
use App\Http\Controllers\admin\ProductfamilieController;
use App\Http\Livewire\Admin\ProductcompuestoEdit;
use App\Http\Livewire\Admin\InventoryList;

//Route::get('/', [HomeController::class, 'home'])->name('admin.home');
Route::get('/tables', [TableController::class, 'showtables'])->name('admin.showtables');

Route::get('/categories', CategoryList::class)->name('category.list');
Route::get('/modelos', ModeloList::class)->name('modelo.list');
Route::get('/marcas', BrandList::class)->name('brand.list');
Route::get('/inventarioinicial', InventoryList::class)->name('inventory.list');


//Route::get('categories', [CategoryController::class, 'index']);
Route::get('categoriess', CategoryListd::class)->name('category.listd');
Route::get('products', ProductList::class)->name('product.list');
Route::get('productcompuesto/{product}', ProductcompuestoCreate::class)->name('productcompuesto.create');
Route::get('productcompuestoedit/{product}', ProductcompuestoEdit::class)->name('productcompuesto.edit');

//Route::get('productfamily', ProductfamilieCreateaa::class)->name('productfamilie.createaa');
Route::get('productfamily/{category}', ProductfamilieCreateaa::class)->name('productfamilie.createaa');

Route::get('productcompuestolist/{product}', ProductcompuestoList::class)->name('productcompuesto.list');


Route::get('/xxx', [ProductfamilieController::class, 'create'])->name('admin.create');
