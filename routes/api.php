<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;

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

Route::get('user/lists', [UserController::class, 'show'])->name('apiUsers');
Route::get('role/lists', [RolesController::class, 'getRoles'])->name('apiRoles');
Route::post('role/store', [RolesController::class, 'store'])->name('apiAddRoles');
Route::get('role/{roleID}', [RolesController::class, 'edit'])->name('apiDisplayRole');
Route::put('role/{roleID}/edit', [RolesController::class, 'update'])->name('apiUpdateRoles');