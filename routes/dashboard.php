<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CashierController;
use App\Http\Controllers\Dashboard\CashierViewController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\GeneralSettingController;
use App\Http\Controllers\Dashboard\ProviderDashboard\ProviderController;
use App\Http\Controllers\Dashboard\ProviderViewController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SendPushNotification;
use App\Http\Controllers\Dashboard\ServiceProviderController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ServiceProviderBranchController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as'            => 'admins.',
    'prefix'        => 'admin/',
    'middleware'    => ['auth', 'locale']
], function () {
    
    Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('edit-profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('edit-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('edit-password', [ProfileController::class, 'updatePassword'])->name('password.update');

    //--------------------------------------------------

    Route::post('/language-switch', [GeneralSettingController::class, 'switchLanguage'])->name('language.switch');


    //------------------- Roles <-> Permissions --------------------------------

    Route::get('general-settings-edit',[GeneralSettingController::class , 'edit'])->name('settings.edit');
    Route::put('general-settings-update',[GeneralSettingController::class , 'update'])->name('settings.update');

    //----------------------------------------------------------------------

    // Roles
    // Route::group(['controller' => RoleController::class], function () {
    //     Route::get('/roles',  'index')->name('roles.index');
    //     Route::get('/roles/create',  'create')->name('roles.create');
    //     Route::post('/roles',  'store')->name('roles.store');
    //     Route::get('/roles/{role}/edit',  'edit')->name('roles.edit');
    //     Route::put('/roles/{role}',  'update')->name('roles.update');
    //     Route::delete('/roles/{role}',  'destroy')->name('roles.destroy');
    // });

    // // Permissions
    // Route::group(['controller' => PermissionController::class], function () {
    //     Route::get('/permissions', 'index')->name('permissions.index');
    //     Route::get('/permissions/create', 'create')->name('permissions.create');
    //     Route::post('/permissions', 'store')->name('permissions.store');
    //     Route::get('/permissions/{permission}/edit', 'edit')->name('permissions.edit');
    //     Route::put('/permissions/{permission}', 'update')->name('permissions.update');
    //     Route::delete('/permissions/{permission}', 'destroy')->name('permissions.destroy');
    // });
    //---------------------------------------------------

    // Route::resource('categories', CategoryController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,categories')
    //     ->names([
    //         'index'                                         => 'categories.index',
    //         'create'                                        => 'categories.create',
    //         'store'                                         => 'categories.store',
    //         'edit'                                          => 'categories.edit',
    //         'update'                                        => 'categories.update',
    //         'destroy'                                       => 'categories.destroy',
    //     ]);

    // Route::put('categories/{id}/toggle', [CategoryController::class, 'toggleStatus'])
    //     ->middleware('role-or-permission:super-admin,categories')
    //     ->name('categories.toggle');
    // Route::get('search-categories', [CategoryController::class, 'search'])
    //     ->name('categories.search');

    //------------------------------------------------------------
    // Route::resource('packages', PackageController::class)
//        ->except('show')
//        ->middleware('role-or-permission:super-admin,packages')
        // ->names([
        //     'index'                                         => 'packages.index',
        //     'create'                                        => 'packages.create',
        //     'store'                                         => 'packages.store',
        //     'edit'                                          => 'packages.edit',
        //     'show'                                          => 'packages.show',
        //     'update'                                        => 'packages.update',
        //     'destroy'                                       => 'packages.destroy',
        // ]);
    //------------------------------------------------------------

    // Route::resource('main-categories', MainCategoryController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,categories')
    //     ->names([
    //         'index'                                         => 'main-categories.index',
    //         'create'                                        => 'main-categories.create',
    //         'store'                                         => 'main-categories.store',
    //         'edit'                                          => 'main-categories.edit',
    //         'update'                                        => 'main-categories.update',
    //         'destroy'                                       => 'main-categories.destroy',
    //     ]);

    // Route::put('main-categories/{id}/toggle', [MainCategoryController::class, 'toggleStatus'])
    //     ->middleware('role-or-permission:super-admin,categories')
    //     ->name('main-categories.toggle');

    //------------------------------------------------------------

    // Route::resource('service-providers', ServiceProviderController::class)
    //     ->middleware('role-or-permission:super-admin,providers')
    //     ->names([
    //         'index'                                         => 'providers.index',
    //         'create'                                        => 'providers.create',
    //         'store'                                         => 'providers.store',
    //         'show'                                          => 'providers.show',
    //         'edit'                                          => 'providers.edit',
    //         'update'                                        => 'providers.update',
    //         'destroy'                                       => 'providers.destroy',
    //     ]);

    // Route::put('service-providers/{id}/toggle', [ServiceProviderController::class, 'toggleStatus'])
    //     ->middleware('role-or-permission:super-admin,providers')
    //     ->name('providers.toggle');
    // Route::get('search-providers', [ServiceProviderController::class, 'search'])->name('providers.search');

    //----------------------------------------------------------------

    // Route::resource('users', UserController::class)->except(['show', 'create', 'edit', 'update'])
    //     ->middleware('role-or-permission:super-admin,users')
    //     ->names([
    //         'index'                                 => 'users.index',
    //         'destroy'                               => 'users.destroy',
    //     ]);

    // Route::put('users/{id}/toggle', [UserController::class, 'toggleStatus'])
    //     ->middleware('role-or-permission:super-admin,users')
    //     ->name('users.toggle');
    // Route::post('users/export', [UserController::class, 'export'])
    //     ->middleware('role-or-permission:super-admin,users')
    //     ->name('users.export');

    //-------------------------------------------------

    // Route::resource('services', ServiceController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,services')
    //     ->names([
    //         'index'                             => 'services.index',
    //         'create'                            => 'services.create',
    //         'edit'                              => 'services.edit',
    //         'update'                            => 'services.update',
    //         'destroy'                           => 'services.destroy',
    //     ]);

    //-------------------------------------------

    // Route::resource('cities', CityController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,cities')
    //     ->names([
    //         'index'                             => 'cities.index',
    //         'create'                            => 'cities.create',
    //         'store'                             => 'cities.store',
    //         'edit'                              => 'cities.edit',
    //         'update'                            => 'cities.update',
    //         'destroy'                           => 'cities.destroy',
    //     ]);
    // Route::get('search-cities', [CityController::class, 'search'])
    //     ->name('cities.search');

    //-----------------------------------------------

    // Route::resource('banners', BannerController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,banners')
    //     ->names([
    //         'index'                             => 'banners.index',
    //         'create'                            => 'banners.create',
    //         'store'                             => 'banners.store',
    //         'edit'                              => 'banners.edit',
    //         'update'                            => 'banners.update',
    //         'destroy'                           => 'banners.destroy',
    //     ]);

    //----------------------------------------------------

    // Route::resource('cashiers', CashierController::class)->except('show')
    //     ->middleware('role-or-permission:super-admin,cashiers')
    //     ->names([
    //         'index'                             => 'cashiers.index',
    //         'create'                            => 'cashiers.create',
    //         'store'                             => 'cashiers.store',
    //         'edit'                              => 'cashiers.edit',
    //         'update'                            => 'cashiers.update',
    //         'destroy'                           => 'cashiers.destroy',
    //     ]);

    //-------------------------------------------------------------------

    // Route::get('cards', [CardController::class, 'index'])
    //     ->middleware('role-or-permission:super-admin,cards')
    //     ->name('cards.index');
    // Route::get('cards/edit', [CardController::class, 'edit'])
    //     ->middleware('role-or-permission:super-admin,cards')
    //     ->name('cards.edit');
    // Route::put('cards/update', [CardController::class, 'update'])
    //     ->middleware('role-or-permission:super-admin,cards')
    //     ->name('cards.update');

    //--------------------------------------------------------------------------

    // Route::get('orders', [OrderController::class, 'index'])
    //     ->middleware('role-or-permission:super-admin,orders')
    //     ->name('orders.index');
    // Route::get('orders/export', [OrderController::class, 'export'])
    //     ->middleware('role-or-permission:super-admin,orders')
    //     ->name('orders.export');
    // Route::post('orders/export', [OrderController::class, 'download'])
    //     ->middleware('role-or-permission:super-admin,orders')
    //     ->name('orders.download');

    //----------------------------------------------------------------------------

    // Route::resource('admins', AdminController::class)->except('show')
    //     ->middleware('role:super-admin')
    //     ->names([
    //         'index'                             => 'admins.index',
    //         'create'                            => 'admins.create',
    //         'store'                             => 'admins.store',
    //         'edit'                              => 'admins.edit',
    //         'update'                            => 'admins.update',
    //         'destroy'                           => 'admins.destroy',
    //     ]);

    //------------------------------------------------------------------

    // Route::get('notify-users', [SendPushNotification::class, 'notifyUsers'])->name('notifications.user');
    // Route::post('notify-users', [SendPushNotification::class, 'sendUsersNotification'])->name('notifications.user');
    // Route::get('notify-cashiers', [SendPushNotification::class, 'notifyCashiers'])->name('notifications.cashier');
    // Route::post('notify-cashiers', [SendPushNotification::class, 'sendCashierNotification'])->name('notifications.cashier');

    //----------------------------------------------------------

    // Route::resource('service-providers-branches', ServiceProviderBranchController::class)
    //     ->except('show')
    //     ->middleware('role-or-permission:super-admin,providers')
    //     ->names([
    //         'index'                                         => 'branches.index',
    //         'create'                                        => 'branches.create',
    //         'store'                                         => 'branches.store',
    //         'edit'                                          => 'branches.edit',
    //         'update'                                        => 'branches.update',
    //         'destroy'                                       => 'branches.destroy',
    //     ]);

    // Route::get('service-providers-branches/duplicate', [ServiceProviderBranchController::class, 'duplicate'])
    //     ->name('branches.duplicate');
    // Route::get('service-providers-branches/branches/search', [ServiceProviderBranchController::class, 'searchBranches'])
    //     ->name('branches.search');

    //--------------------------------------------------------------------
});

// Route::group([
//     'as'            => 'moderators.',
//     'prefix'        => 'moderators/',
//     'middleware'    => ['auth', 'locale']
// ], function () {

//     Route::group([
//         'controller' => ProviderViewController::class,
//     ], function () {
//         Route::get('provider-moderator/orders/index', 'latestOrders')->name('orders.index');
//         Route::get('provider-moderator/orders/export','exportOrders')->name('orders.export');
//         Route::post('provider-moderator/orders/export','download')->name('orders.download');
//         Route::get('provider-moderator/details','providerDetails')->name('provider.details');
//         Route::get('provider-moderator/cashiers','providerCashiers')->name('provider.cashiers');
//         Route::get('provider-moderator/branches','providerBranches')->name('provider.branches');
//         Route::get('provider-moderator/subscription-details','subscriptionsDetails')->name('provider.subscription-details');
//         Route::get('provider-moderator/{provider}/subscription-history','subscriptionHistory')->name('provider.subscription-history');
//     });

//     Route::post('subscribe/{package}', [ProviderController::class, 'subscribe'])->name('provider.subscribe');
//     Route::post('unsubscribe', [ProviderController::class, 'unsubscribe'])->name('provider.unsubscribe');
//     Route::post('change-subscribe/{package}', [ProviderController::class, 'subscribe'])->name('provider.update-subscribe');

// });

// Route::group([
//     'as'            => 'cashiers.',
//     'prefix'        => 'cashiers/',
//     'middleware'    => ['auth', 'locale']
// ], function () {
//     Route::get('orders/index',[CashierViewController::class , 'latestOrders'])->name('orders.index');
//     Route::get('orders/create',[CashierViewController::class , 'create'])->name('orders.create');
//     Route::get('orders/get-payable-details',[CashierViewController::class , 'getClientPayableAmount'])->name('orders.getPayableDetails');
//     Route::post('orders/create',[CashierViewController::class , 'store'])->name('orders.store');
// });
