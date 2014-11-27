<?php

/*
  |--------------------------------------------------------------------------
  | Public side
  |--------------------------------------------------------------------------
  |
  */
use Illuminate\Session\TokenMismatchException;

/**
 * User login and logout
 */
Route::get('/payadmin/login', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getAdminLogin");
Route::get('/login', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getClientLogin");
Route::get('/user/logout', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getLogout");
Route::post('/user/login', [
        "before" => "csrf",
        "uses"   => "Mentordeveloper\\Authentication\\Controllers\\AuthController@postAdminLogin"
]);
Route::post('/login', [
        "before" => "csrf",
        "uses"   => "Mentordeveloper\\Authentication\\Controllers\\AuthController@postClientLogin"
]);
/**
 * Password recovery
 */
Route::get('/user/change-password', 'Mentordeveloper\Authentication\Controllers\AuthController@getChangePassword');
Route::get('/user/recover-password', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getReminder");
Route::post('/user/change-password/', [
        "before" => "csrf",
        'uses'   => "Mentordeveloper\\Authentication\\Controllers\\AuthController@postChangePassword"
]);
Route::get('/user/change-password-success', function ()
{
    return View::make('laravel-authentication-acl::client.auth.change-password-success');
});
Route::post('/user/reminder', [
        "before" => "csrf",
        'uses'   => "Mentordeveloper\\Authentication\\Controllers\\AuthController@postReminder"
]);
Route::get('/user/reminder-success', function ()
{
    return View::make('laravel-authentication-acl::client.auth.reminder-success');
});
/**
 * User signup
 */
Route::post('/user/signup', [
        "before" => "csrf",
        'uses'   => "Mentordeveloper\\Authentication\\Controllers\\UserController@postSignup"
]);
Route::get('/user/signup', [
        'uses' => "Mentordeveloper\\Authentication\\Controllers\\UserController@signup"
]);
Route::post('captcha-ajax', [
        "before" => "captcha-ajax",
        'uses'   => "Mentordeveloper\\Authentication\\Controllers\\UserController@refreshCaptcha"
]);
Route::get('/user/email-confirmation', ['uses' => "Mentordeveloper\\Authentication\\Controllers\\UserController@emailConfirmation"]);
Route::get('/user/signup-success', 'Mentordeveloper\Authentication\Controllers\UserController@signupSuccess');

/*
  |--------------------------------------------------------------------------
  | Admin side
  |--------------------------------------------------------------------------
  |
  */
Route::group(['before' => ['admin_logged', 'can_see']], function ()
{
    /**
     * dashboard
     */
    Route::get('/payadmin/users/dashboard', [
            'as'   => 'dashboard.default',
            'uses' => 'Mentordeveloper\Authentication\Controllers\DashboardController@base'
    ]);

    /**
     * user
     */
    Route::get('/payadmin/users/list', [
            'as'   => 'users.list',
            'uses' => 'Mentordeveloper\Authentication\Controllers\UserController@getList'
    ]);
    Route::get('/payadmin/users/edit', [
            'as'   => 'users.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\UserController@editUser'
    ]);
    Route::post('/payadmin/users/edit', [
            "before" => "csrf",
            'as'     => 'users.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@postEditUser'
    ]);
    Route::get('/payadmin/users/delete', [
            "before" => "csrf",
            'as'     => 'users.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@deleteUser'
    ]);
    Route::post('/payadmin/users/groups/add', [
            "before" => "csrf",
            'as'     => 'users.groups.add',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@addGroup'
    ]);
    Route::post('/payadmin/users/groups/delete', [
            "before" => "csrf",
            'as'     => 'users.groups.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@deleteGroup'
    ]);
    Route::post('/payadmin/users/editpermission', [
            "before" => "csrf",
            'as'     => 'users.edit.permission',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@editPermission'
    ]);
    Route::get('/payadmin/users/profile/edit', [
            'as'   => 'users.profile.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\UserController@editProfile'
    ]);
    Route::post('/payadmin/users/profile/edit', [
            'before' => 'csrf',
            'as'     => 'users.profile.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@postEditProfile'
    ]);
    Route::post('/payadmin/users/profile/addField', [
            'before' => 'csrf',
            'as'     => 'users.profile.addfield',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@addCustomFieldType'
    ]);
    Route::post('/payadmin/users/profile/deleteField', [
            'before' => 'csrf',
            'as'     => 'users.profile.deletefield',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@deleteCustomFieldType'
    ]);
    Route::post('/payadmin/users/profile/avatar', [
            'before' => 'csrf',
            'as'     => 'users.profile.changeavatar',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\UserController@changeAvatar'
    ]);
    Route::get('/payadmin/users/profile/self', [
        'as' => 'users.selfprofile.edit',
        'uses' => 'Mentordeveloper\Authentication\Controllers\UserController@editOwnProfile'
    ]);

    /**
     * groups
     */
    Route::get('/payadmin/groups/list', [
            'as'   => 'groups.list',
            'uses' => 'Mentordeveloper\Authentication\Controllers\GroupController@getList'
    ]);
    Route::get('/payadmin/groups/edit', [
            'as'   => 'groups.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\GroupController@editGroup'
    ]);
    Route::post('/payadmin/groups/edit', [
            "before" => "csrf",
            'as'     => 'groups.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\GroupController@postEditGroup'
    ]);
    Route::get('/payadmin/groups/delete', [
            "before" => "csrf",
            'as'     => 'groups.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\GroupController@deleteGroup'
    ]);
    Route::post('/payadmin/groups/editpermission', [
            "before" => "csrf",
            'as'     => 'groups.edit.permission',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\GroupController@editPermission'
    ]);

    /**
     * permissions
     */
    Route::get('/payadmin/permissions/list', [
            'as'   => 'permission.list',
            'uses' => 'Mentordeveloper\Authentication\Controllers\PermissionController@getList'
    ]);
    Route::get('/payadmin/permissions/edit', [
            'as'   => 'permission.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\PermissionController@editPermission'
    ]);
    Route::post('/payadmin/permissions/edit', [
            "before" => "csrf",
            'as'     => 'permission.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\PermissionController@postEditPermission'
    ]);
    Route::get('/payadmin/permissions/delete', [
            "before" => "csrf",
            'as'     => 'permission.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\PermissionController@deletePermission'
    ]);
    
     /**
     * Company
     */
    Route::get('/payadmin/client/list', [
            'as'   => 'client.list',
            'uses' => 'Mentordeveloper\Authentication\Controllers\CompanyController@getList'
    ]);
    Route::get('/payadmin/client/edit', [
            'as'   => 'client.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\CompanyController@editCompany'
    ]);
    Route::post('/payadmin/client/edit', [
            "before" => "csrf",
            'as'     => 'client.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@postEditCompany'
    ]);
    
    Route::get('/payadmin/client/delete', [
            "before" => "csrf",
            'as'     => 'client.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@deleteCompany'
    ]);
    Route::post('/payadmin/client/groups/add', [
            "before" => "csrf",
            'as'     => 'client.groups.add',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@addGroup'
    ]);
    Route::post('/payadmin/client/groups/delete', [
            "before" => "csrf",
            'as'     => 'client.groups.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@deleteGroup'
    ]);
    Route::post('/payadmin/client/editpermission', [
            "before" => "csrf",
            'as'     => 'users.client.permission',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@editPermission'
    ]);
    Route::get('/payadmin/client/profile/edit', [
            'as'   => 'client.profile.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\CompanyController@editProfile'
    ]);
    Route::post('/payadmin/client/profile/edit', [
            'before' => 'csrf',
            'as'     => 'client.profile.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@postEditProfile'
    ]);
    Route::post('/payadmin/client/profile/addField', [
            'before' => 'csrf',
            'as'     => 'client.profile.addfield',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@addCustomFieldType'
    ]);
    Route::post('/payadmin/client/profile/deleteField', [
            'before' => 'csrf',
            'as'     => 'client.profile.deletefield',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@deleteCustomFieldType'
    ]);
    Route::post('/payadmin/client/profile/avatar', [
            'before' => 'csrf',
            'as'     => 'client.profile.changeavatar',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\CompanyController@changeAvatar'
    ]);
    Route::get('/payadmin/client/profile/self', [
        'as' => 'client.selfprofile.edit',
        'uses' => 'Mentordeveloper\Authentication\Controllers\CompanyController@editOwnProfile'
    ]);
    
    Route::get('/payadmin/employee/list', [
            'as'   => 'employee.list',
            'uses' => 'Mentordeveloper\Authentication\Controllers\PermissionController@getList'
    ]);
    Route::get('/payadmin/employee/edit', [
            'as'   => 'employee.edit',
            'uses' => 'Mentordeveloper\Authentication\Controllers\PermissionController@editPermission'
    ]);
    Route::post('/payadmin/employee/edit', [
            "before" => "csrf",
            'as'     => 'employee.edit',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\PermissionController@postEditPermission'
    ]);
    Route::get('/payadmin/employee/delete', [
            "before" => "csrf",
            'as'     => 'employee.delete',
            'uses'   => 'Mentordeveloper\Authentication\Controllers\PermissionController@deletePermission'
    ]);
});

//////////////////// Other routes //////////////////////////

if(Config::get('laravel-authentication-acl::handle_errors'))
{
    App::error(function (RuntimeException $exception, $code)
    {
        switch($code)
        {
            case '404':
                return View::make('laravel-authentication-acl::client.exceptions.404');
                break;
            case '401':
                return View::make('laravel-authentication-acl::client.exceptions.401');
                break;
            case '500':
                return View::make('laravel-authentication-acl::client.exceptions.500');
                break;
        }
    });

    App::error(function (TokenMismatchException $exception)
    {
        return View::make('laravel-authentication-acl::client.exceptions.500');
    });
}