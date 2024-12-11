<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminBannerController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect()->route('admin_login');
});

/*---------------------------------------Admin-Routes---------------------------------------------- */
/**Auth Routes */
    Route::get('/admin-login', [AdminAuthController::class, 'login'])->name('admin_login');
    Route::post('/admin/login-data', [AdminAuthController::class, 'login_data'])->name('login_data_page');
    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');

/**Admin Auth Middleware Starts */
Route::group(['middleware'=>['admin']], function(){


    /**Dashboard Routes */
        Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin_dashboard');

    /**Schdule Routes */
    Route::post('/admin/schedule/add-edit/{schedule?}', [DashboardController::class, 'admin_schedule_add_edit'])->name('admin.schedule.add.edit');
    Route::get('/admin/schedule/add', [DashboardController::class, 'admin_schedule_add'])->name('admin.schedule.add');
    Route::get('/admin/schedule/list', [DashboardController::class, 'admin_schedule_list'])->name('admin.schedule.list');
    Route::get('/admin/schedule/edit/{id}', [DashboardController::class, 'admin_schedule_edit'])->name('admin.schedule.edit');
    Route::get('/admin/schedule/delete/{id}', [DashboardController::class, 'admin_schedule_delete'])->name('admin.schedule.delete');

    /**Profile Routes */
        Route::get('/admin/profile', [AdminAuthController::class, 'admin_profile'])->name('admin_profile');
        Route::post('/admin/profile-update/{user?}', [AdminAuthController::class, 'admin_profile_update'])->name('admin_profile_update');
        Route::post('/admin/profile-pass-update/{user?}', [AdminAuthController::class, 'admin_password_update'])->name('admin_password_update');

    

    /**User Routes*/
        Route::get('/admin/user-list', [AdminAuthController::class, 'user_list'])->name('admin_users');
        Route::get('/admin/user-add', [AdminAuthController::class, 'user_add'])->name('admin_users_add');
        Route::get('/admin/user-edit/{id?}', [AdminAuthController::class, 'user_edit'])->name('admin_users_edit');
        Route::get('/admin/user-delete/{user?}', [AdminAuthController::class, 'user_delete'])->name('admin_users_delete');
        Route::post('/admin/user-add-edit/{user?}', [AdminAuthController::class, 'user_add_edit_data'])->name('admin_users_add_edit');
        Route::get('/admin/users-attendance', [AdminAuthController::class, 'users_attendance'])->name('admin_users_attendance');
        Route::get('/admin/leave-approved', [AdminAuthController::class, 'leave_approved'])->name('admin_leave_approved');
        Route::post('/admin/leave-user-edit/{leave?}', [AdminAuthController::class, 'leave_user_edit_data'])->name('admin_leave_user_edit');
        Route::get('/admin/leave-edit/{id?}', [AdminAuthController::class, 'leave_edit'])->name('admin_leave_edit');

    /** Department Routes */
    Route::get('/admin/department-list', [AdminAuthController::class, 'department_list'])->name('admin_department');
    Route::get('/admin/department-add', [AdminAuthController::class, 'department_add'])->name('admin_department_add');
    Route::get('/admin/department-edit/{id?}', [AdminAuthController::class, 'department_edit'])->name('admin_department_edit');
    Route::get('/admin/sub-department-edit/{id?}', [AdminAuthController::class, 'sub_department_edit'])->name('admin_sub_department_edit');
    Route::get('/admin/sub-department-add', [AdminAuthController::class, 'sub_department_add'])->name('admin_sub_department_add');
    Route::post('/admin/department-add-edit/{department?}', [AdminAuthController::class, 'department_add_edit_data'])->name('admin_department_add_edit');
    Route::post('/admin/sub-department-add-edit/{sub_department?}', [AdminAuthController::class, 'sub_department_add_edit_data'])->name('admin_sub_department_add_edit');

    /**Designation Routes*/
    Route::get('/admin/designation-list', [AdminAuthController::class, 'designation_list'])->name('admin_designation');
    Route::get('/admin/designation-add', [AdminAuthController::class, 'designation_add'])->name('admin_designation_add');
    Route::post('/admin/designation-add-edit/{designation?}', [AdminAuthController::class, 'designation_add_edit_data'])->name('admin_designation_add_edit');
    Route::get('/admin/designation-edit/{id?}', [AdminAuthController::class, 'designation_edit'])->name('admin_designation_edit');
});


Route::group(['middleware'=>['user']], function(){


    /**Dashboard Routes */
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/user/check-in', [UserController::class, 'check_in'])->name('check.in');
        Route::get('/user/break-in/{id}', [UserController::class, 'break_in'])->name('break.in');
        Route::get('/user/check-out/{id}', [UserController::class, 'check_out'])->name('check.out');
        Route::get('/user/break-out/{id}', [UserController::class, 'break_out'])->name('break.out');
        
    /**Profile Routes */
        Route::get('/user/profile', [UserController::class, 'user_profile'])->name('user_profile');

    

    /**User Routes*/
        Route::get('/user/attendance', [UserController::class, 'user_attendance'])->name('user.attendance');
        //Route::get('/user/leave-add', [UserController::class, 'user_leave'])->name('user.leave');
        Route::get('/user/leave-list', [UserController::class, 'leave_list'])->name('user_leave');
        Route::get('/user/leave-approved', [UserController::class, 'leave_approved'])->name('user_leave_approved');
        Route::get('/user/leave-add', [UserController::class, 'leave_add'])->name('user_leave_add');
        Route::post('/user/leave-add-edit/{leave?}', [UserController::class, 'leave_add_edit_data'])->name('user_leave_add_edit');
        Route::post('/user/leave-user-edit/{leave?}', [UserController::class, 'leave_user_edit_data'])->name('leave_user_edit');
        Route::get('/user/leave-edit/{id?}', [UserController::class, 'leave_edit'])->name('user_leave_edit');
        // Route::get('/admin/user-add', [UserController::class, 'user_add'])->name('admin_users_add');
        // Route::get('/admin/user-edit/{id?}', [UserController::class, 'user_edit'])->name('admin_users_edit');
        // Route::get('/admin/user-delete/{user?}', [UserController::class, 'user_delete'])->name('admin_users_delete');
        // Route::post('/admin/user-add-edit/{user?}', [UserController::class, 'user_add_edit_data'])->name('admin_users_add_edit');


});
/**Admin Auth Middleware Ends */
