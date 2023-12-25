<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('get-companies', [CompanyController::class, 'getData'])->name('company.getData');
    Route::get('get-employees', [EmployeeController::class, 'getData'])->name('employee.getData');
    Route::resource('company', CompanyController::class);
    Route::resource('employee', EmployeeController::class);
});

require __DIR__ . '/auth.php';
