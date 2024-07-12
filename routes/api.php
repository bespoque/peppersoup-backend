<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::namespace('App\Http\Controllers')->group(function () {

    Route::any('/system-health-check/ping', 'HealthCheckController@getHealthCheckStatus');

    Route::prefix("core")->group(function () {

        Route::prefix("account")->group(function () {
            Route::post('login', 'Auth\AuthController@login');
            Route::post('register', 'Auth\AuthController@register');
            Route::post('otp-verification', 'Auth\AuthController@otpVerification');
            Route::post('resend-otp', 'Auth\AuthController@retryingOtpRequest');
        });


        Route::middleware('jwt.verify')->group(function () {
            Route::prefix("user")->group(function () {
                Route::get('dashboard', 'User\UserController@getDashboard');
                Route::post('update-profile-photo', 'User\UserController@updateProfileImage');
                Route::get('account', 'User\UserController@accountInformation');
                Route::put('update-profile', 'User\UserController@updateProfile');

            });
        });


        Route::group(['middleware' => ['admin', 'permission', 'jwt.verify']], function () {

            Route::prefix("admin")->group(function () {

                Route::get('dashboard', 'Admin\AdminController@getDashboard')->name('dashboard');
                Route::get('audits', 'Admin\AdminController@getAllAudits')->name('audits');


                Route::get('roles', 'Admin\Permissions\RolesController@index')->name('roles.index');
                Route::get('roles/team', 'Admin\Permissions\RolesController@teamRoles')->name('roles.team');
                Route::get('roles/team/assign', 'Admin\Permissions\RolesController@assignUserARole')->name('roles.team.assign');
                Route::post('roles/team', 'Admin\Permissions\RolesController@store')->name('roles.team.store');
                Route::put('roles/team', 'Admin\Permissions\RolesController@update')->name('roles.team.update');
                Route::delete('roles/team', 'Admin\Permissions\RolesController@destroy')->name('roles.team.destroy');

                Route::get('permissions', 'Admin\Permissions\PermissionsController@index')->name('permissions.index');
                Route::get('permissions/team', 'Admin\Permissions\PermissionsController@userPermission')->name('permissions.user');
                Route::post('permissions', 'Admin\Permissions\PermissionsController@store')->name('permissions.store');
                Route::delete('permissions', 'Admin\Permissions\PermissionsController@destroy')->name('permissions.remove');


                Route::prefix("team")->group(function () {
                    Route::post('create', 'Admin\AdminController@createTeamMembers')->name('team.create');
                    Route::post('action', 'Admin\AdminController@disableTeamMember')->name('team.action');
                });


            });
        });

    });
});
