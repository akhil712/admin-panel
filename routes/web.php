<?php
namespace App\Http\Controllers;
use App\Http\Middleware\RouteMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [HomeController::class, 'home'])->name('home');


Route::middleware(['auth','permission'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('roles',RoleController::class)->except(['show','update']);
    Route::prefix('roles')->name('roles.hierarchy.')->group(function () {
        Route::get('hierarchy',[RoleController::class,'hierarchyIndex'])->name('index'); 
        Route::post('hierarchy',[RoleController::class,'hierarchyStore'])->name('store'); 
    });
    Route::resource('permissions',PermissionController::class)->except(['show','update','edit','create']);
    Route::resource('role-permissions',RolePermissionController::class)->except(['show','update']);
    Route::resource('users',UserController::class)->except(['show','update']);
    Route::post('add-component',[CommonController::class,'addComponent'])->name('add.component');
    Route::resource('projects',ProjectController::class)->except(['show','update']);
});