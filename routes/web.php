<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 

require __DIR__.'/auth.php';
//admin group middleware
Route::middleware(['auth','role:admin'])->group(function(){

    Route::get('/admin/dashboard', [AdminController::class,'AdminDashboard'])
    ->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class,'AdminLogout'])
    ->name('admin.logout');
    
    Route::get('/admin/profile', [AdminController::class,'Adminprofile'])
    ->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class,'AdminprofileStore'])
    ->name('admin.profile.store');
    
    Route::get('/admin/change/password', [AdminController::class,'AdminChangePassword'])
    ->name('admin.change.password');

    Route::post('/admin/update/password', [AdminController::class,'AdminUpdatePassword'])
    ->name('admin.update.password');

});    //end group Admin Middleware

//agen group middleware
Route::middleware(['auth','role:agent'])->group(function(){

    Route::get('/agent/dashboard', [AgentController::class,'AgentDashboard'])
    ->name('agent.dashboard');
});

Route::get('/admin/login', [AdminController::class,'AdminLogin'])
->name('admin.login');

//admin group middleware
Route::middleware(['auth','role:admin'])->group(function(){


// Property Type All Route
Route::controller(PropertyTypeController::class)->group(function(){

    Route::get('/all/type', 'AllType')->name('all.type');
    Route::get('/add/type', 'AddType')->name('add.type');
    Route::post('/store/type', 'StoreType')->name('store.type');
    Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
    Route::post('/update/type', 'UpdateType')->name('update.type');
    Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
  

});

// Amenities perty Type All Route
Route::controller(PropertyTypeController::class)->group(function(){

    Route::get('/all/amenitie', 'Allamenitie')->name('all.amenitie');
    Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
    Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
    Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
    Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
    Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');
  

});


// Permission All Route
Route::controller(RoleController::class)->group(function(){

    Route::get('/all/permission', 'AllPermission')->name('all.permission');
    Route::get('/add/permission', 'AddPermission')->name('add.permission');
    Route::post('/store/permission', 'StorePermission')->name('store.permission');
    Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
    Route::post('/update/permission', 'UpdatePesmission')->name('update.permission');
    Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

    Route::get('/import/permission', 'ImportPermission')->name('import.permission');

    Route::get('/export', 'Export')->name('export');
    Route::post('/import', 'Import')->name('import');
  

});

});    //end group Admin Middleware







