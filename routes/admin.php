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
use App\Http\Controllers\Admin\ProductatributeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\UsersRolesController;
use App\Http\Controllers\admin\UsersPermissionsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Livewire\Admin\PermissionList;
use App\Http\Controllers\admin\ConfigurationController;
use App\Http\Livewire\Admin\InventoryListdos;

//Route::get('/', [HomeController::class, 'home'])->name('admin.home');
Route::get('/tables', [TableController::class, 'showtables'])->name('admin.showtables');

Route::get('/categories', CategoryList::class)->name('category.list');
Route::get('/modelos', ModeloList::class)->name('modelo.list');
Route::get('/marcas', BrandList::class)->name('brand.list');
//Route::get('/empezarinventarioinicial', InventoryList::class)->name('inventory.list');
Route::get('/inventarioinicial', InventoryList::class)->name('inventory.list');//lista los inventarios
Route::get('/inventariogeneral', InventoryListdos::class)->name('inventory.listdos');//lista los inventarios dos


//Route::get('categories', [CategoryController::class, 'index']);
Route::get('categoriess', CategoryListd::class)->name('category.listd');
Route::get('products', ProductList::class)->name('product.list');
Route::get('productcompuesto/{product}', ProductcompuestoCreate::class)->name('productcompuesto.create');//creamos el producto productatribute
Route::get('productcompuestoedit/{product}', ProductcompuestoEdit::class)->name('productcompuesto.edit');


Route::resource('productatribute', ProductatributeController::class)->names('admin.productatribute');
Route::get('productatributepricesale/{product}', [ProductatributeController::class, 'pricesale'])->name('admin.productatribute.pricesale');//lista productos generados para modificar precio de venta
Route::get('productatributepricepurchase/{product}', [ProductatributeController::class, 'pricepurchase'])->name('admin.productatribute.pricepurchase');//lista productos generados para modificar precio de compra
Route::get('productatributepricewholesale/{product}', [ProductatributeController::class, 'pricewholesale'])->name('admin.productatribute.pricewholesale');//lista productos generados para modificar precio de venta al por mayor
Route::get('productatributecodigo/{product}', [ProductatributeController::class, 'codigo'])->name('admin.productatribute.codigo');//lista productos generados para modificar codigo

Route::get('productatributedelete/{product}', [ProductatributeController::class, 'delete'])->name('admin.productatribute.delete');//activa para eliminar productos


Route::get('productatributeaddimage/{productatribute}', [ProductatributeController::class, 'addimage'])->name('admin.productatribute.addimage');//vista para agregar imagenes del productoatribute
Route::get('/productatributeaddphoto', [ProductatributeController::class, 'addphoto'])->name('admin.productatribute.addphoto');//vista para agregar imagenes del productoatribute
Route::post('/productatributestorephoto', [ProductatributeController::class, 'storephoto'])->name('admin.productatribute.storephoto');
Route::post('productatributestoreimage/{productatribute}', [ProductatributeController::class, 'storeimage'])->name('admin.productatribute.storeimage');
Route::delete('productatributedestroyimage/{photo}', [ProductatributeController::class, 'destroyimage'])->name('admin.productatribute.destroyimage');


Route::post('productatributepricepurchase', [ProductatributeController::class, 'updatepricepurchase'])->name('admin.productatribute.updatepricepurchase');//actualiza precios
Route::post('productatributepricesale', [ProductatributeController::class, 'updatepricesale'])->name('admin.productatribute.updatepricesale');//actualiza precios
Route::post('productatributepricewholesale', [ProductatributeController::class, 'updatepricewholesale'])->name('admin.productatribute.updatepricewholesale');//actualiza precios

Route::post('productatributesupdatecodigo', [ProductatributeController::class, 'updatecodigo'])->name('admin.productatribute.updatecodigo');//actualiza codigo


//Route::get('productfamily', ProductfamilieCreateaa::class)->name('productfamilie.createaa');
Route::get('productfamily/{category}', ProductfamilieCreateaa::class)->name('productfamilie.createaa');

Route::get('productcompuestolist/{product}', ProductcompuestoList::class)->name('productcompuesto.list');


Route::get('/xxx', [ProductfamilieController::class, 'create'])->name('admin.create');

Route::get('/dropzone', [ProductatributeController::class, 'dropzone'])->name('admin.dropzone');
Route::post('/dropzone', [ProductatributeController::class, 'dropzoneok'])->name('admin.dropzoneok');

//Route::resource('usuarios', UserController::class)->names('admin.usuarios');
Route::resource('user', UserController::class)->names('admin.user');

Route::put('users/{user}/roles', [UsersRolesController::class, 'update'])->name('admin.user.roles.update')->middleware('role:Admin');
Route::put('users/{user}/permissions', [UsersPermissionsController::class, 'update'])->name('admin.users.permissions.update')->middleware('role:Admin');

Route::resource('role', RoleController::class)->names('admin.role');
Route::get('/permission', PermissionList::class)->name('permission.list');


//Route::resource('configuration', ConfigurationController::class)->only(['edit','update'])->names('admin.configuration')->middleware('permission:update Configuration');
Route::resource('configuration', ConfigurationController::class)->only(['edit','update'])->names('admin.configuration');

