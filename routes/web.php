<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/aHome', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/department/employees/{department}', [EmployeeController::class, 'departmentEmployees'])->name('department.employees');
    Route::delete('department/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/departments/create', [DepartmentController::class, 'create'])->name('admin.departments.create');

    Route::post('/admin/departments', [DepartmentController::class, 'store'])->name('admin.departments.store');
    
    Route::get('/admin/departments/edit', [DepartmentController::class, 'edit'])->name('admin.departments.edit');
    Route::post('/admin/departments/edit', [DepartmentController::class, 'edit']);

    Route::patch('/admin/departments/{deptName}', [DepartmentController::class, 'update'])->name('admin.departments.update');
    
    Route::get('/admin/departments/delete', [DepartmentController::class, 'delete'])->name('admin.departments.delete');
    Route::post('/admin/departments/delete', [DepartmentController::class, 'delete']);

});

Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('send.message');
Route::get('/get-messages', [HomeController::class, 'getMessages'])->name('get.messages');

Route::get('/update-profile', [UserProfileController::class, 'showUpdateForm'])->name('update.profile');
Route::put('/update-profile', [UserProfileController::class, 'update']);
Route::get('/viewprofile', [UserProfileController::class, 'showUserProfile'])->name('view.profile');