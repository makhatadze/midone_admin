<?php


use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\TicketsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::middleware('loggedin')->group(function() {
        Route::get('login', [AuthController::class,'loginView'])->name('login-view');
        Route::post('login', [AuthController::class,'login'])->name('login');
        Route::get('register', [AuthController::class,'registerView'])->name('register-view');
        Route::post('register', [AuthController::class,'register'])->name('register');
    });


    Route::middleware('auth')->group(function() {
        Route::get('/', [PageController::class, 'loadPage'])->name('dashboard');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('page/{layout}/{pageName}', [PageController::class, 'loadPage'])->name('page');

        Route::get('active-menu/{activeMenu}', [PageController::class, 'activeMenu'])->name('activeMenu');

        Route::resource('roles', RolesController::class)
            ->middleware('can:isAdmin')
            ->name('index', 'rolesIndex')
            ->name('create', 'rolesCreate')
            ->name('store', 'rolesStore')
            ->name('edit', 'rolesEdit')
            ->name('update', 'rolesUpdate');
            
        Route::get('/messages', [MessageController::class, 'index'])
        ->middleware('can:isAdmin')
        ->name('getAllMessages');

        Route::resource('users', UsersController::class)
            ->middleware('role:admin,manager')
            ->name('create', 'usersCreate')->middleware('can:create_user')
            ->name('edit', 'usersEdit')->middleware('can:update_user')
            ->name('update', 'usersUpdate');

        Route::any('users', [UsersController::class, 'index'])->name('usersIndex')->middleware('can:read_user');
        Route::post('users/store', [UsersController::class, 'store'])->name('usersStore')->middleware('can:create_user');
        Route::delete('users/delete/{user}', [UsersController::class, 'destroy'])->name('usersDelete')->middleware('can:delete_user');


        Route::get('departments', [DepartmentController::class, 'index'])
            ->name('departmentsIndex')
            ->middleware('can:read_department');

        Route::match(['get', 'post'], 'departments/create-departments', [DepartmentController::class, 'createDepartments'])
            ->name('departmentsCreate')->middleware('can:create_department');

        Route::match(['get', 'post'], 'departments/update-departments/{department}', [DepartmentController::class, 'updateDepartments'])
            ->name('departmentsUpdate')->middleware('can:update_department');

        Route::delete('departments/delete-departments/{department}', [DepartmentController::class, 'deleteDepartments'])
            ->name('departmentsDelete')->middleware('can:departmentsDelete');

        Route::match(['get', 'post'], 'departments/create-categories', [DepartmentController::class, 'createCategories'])
            ->name('createCategories')->middleware('can:delete_department');

        Route::match(['get', 'post'], 'departments/update-categories/{category}', [DepartmentController::class, 'categoriesUpdate'])
            ->name('categoriesUpdate')->middleware('can:update_department');

        Route::delete('departments/delete-categories/{category}', [DepartmentController::class, 'deleteCategories'])
            ->name('deleteCategories')->middleware('can:delete_department');

        // Ticket
        Route::get('tickets', [TicketsController::class, 'index'])->name('ticketsIndex');
        Route::get('tickets/departments/{department}', [TicketsController::class, 'departments'])->name('ticketsDepartments');
        Route::post('tickets/store', [TicketsController::class, 'store'])->name('ticketsStore');

        Route::get('tickets-all', [TicketsController::class, 'getAllTickets'])->name('getAllTickets');
        Route::post('tickets/approve/{ticket}', [TicketsController::class, 'ticketApprove'])->name('ticketApprove');

        Route::post('tickets/confirm/{ticket}', [TicketsController::class, 'ticketConfirm'])->name('ticketConfirm');
    });

});

