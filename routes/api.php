<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpensesController;

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

//User
Route::get('user/lists', [UserController::class, 'show'])->name('apiUsers');
Route::post('user/store', [UserController::class, 'store'])->name('apiStoreUsers');
Route::get('user/{userID}', [UserController::class, 'edit'])->name('apiUserGet');
Route::put('user/{userID}/edit', [UserController::class, 'update'])->name('apiUpdateUsers');
Route::put('user/{userID}/delete', [UserController::class, 'destroy'])->name('apiDeleteUsers');

//Roles
Route::get('role/lists', [RolesController::class, 'getRoles'])->name('apiRoles');
Route::post('role/store', [RolesController::class, 'store'])->name('apiAddRoles');
Route::get('role/{roleID}', [RolesController::class, 'edit'])->name('apiDisplayRole');
Route::put('role/{roleID}/edit', [RolesController::class, 'update'])->name('apiUpdateRoles');
Route::put('role/{roleID}/delete', [RolesController::class, 'destroy'])->name('apiDeleteRoles');

//Expense Category
Route::get('expensecategory/lists', [ExpenseCategoryController::class, 'show'])->name('apiExpenseCategory');
Route::post('expensecategory/store', [ExpenseCategoryController::class, 'store'])->name('apiStoreExpenseCategory');
Route::get('expensecategory/{categoryID}', [ExpenseCategoryController::class, 'edit'])->name('apiEditExpenseCategory');
Route::put('expensecategory/{categoryID}/edit', [ExpenseCategoryController::class, 'update'])->name('apiUpdateExpenseCategory');
Route::put('expensecategory/{categoryID}/delete', [ExpenseCategoryController::class, 'destroy'])->name('apiDeleteExpenseCategory');

//Expenses
Route::get('expenses/lists', [ExpensesController::class, 'show'])->name('apiExpenses');
Route::post('expenses/store', [ExpensesController::class, 'store'])->name('apiStoreExpenses');
Route::get('expenses/{expensesID}', [ExpensesController::class, 'edit'])->name('apiEditExpenses');
Route::put('expenses/{expensesID}/edit', [ExpensesController::class, 'update'])->name('apiUpdateExpenses');
Route::put('expenses/{expensesID}/delete', [ExpensesController::class, 'destroy'])->name('apiDeleteExpenses');

//Dashboard
Route::get('dashboard/expenses', [ExpensesController::class, 'index'])->name('apiGetExpenses');