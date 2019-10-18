<?php

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

Route::prefix('rightsmanagement')->group(function () {
  Route::get('/', function ()  {
    return view('rightsmanagement::index');
  });

  // Route::group(['middleware' => ['role:super_admin']], function () {
  // Role
  Route::get('roles/datatable', 'RolesController@getDatatable');
  Route::resource('roles', 'RolesController');

  // Permission
  Route::get('permission/datatable', 'PermissionController@getDatatable');
  Route::resource('permission', 'PermissionController');

  Route::get('role-permission/datatable', 'RolePermissionController@getDatatable');
  Route::resource('role-permission', 'RolePermissionController');
  // });
  Route::get('admins/datatable', 'AdminController@getDatatable');
  Route::resource('admins', 'AdminController');
});