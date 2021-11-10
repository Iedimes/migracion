<?php

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

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('projects')->name('projects/')->group(static function () {
            Route::get('/',                                             'ProjectsController@index')->name('index');
            Route::get('/create',                                       'ProjectsController@create')->name('create');
            Route::post('/',                                            'ProjectsController@store')->name('store');
            Route::get('/{project}/edit',                               'ProjectsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{project}',                                   'ProjectsController@update')->name('update');
            Route::delete('/{project}',                                 'ProjectsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('project-has-expedientes')->name('project-has-expedientes/')->group(static function () {
            Route::get('/',                                             'ProjectHasExpedientesController@index')->name('index');
            Route::get('{projectHasExpediente}/show',                    'ProjectHasExpedientesController@show')->name('show');
            Route::get('{projectHasExpediente}/migracion',               'ProjectHasExpedientesController@migracion')->name('migracion');
            Route::get('{projectHasExpediente}/migracionpersonas',       'ProjectHasExpedientesController@migracionpersonas')->name('migracion');
            Route::get('{projectHasExpediente}/migracionsolicitantes',   'ProjectHasExpedientesController@migracionsolicitantes')->name('migracionsolicitantes');
            Route::get('{projectHasExpediente}/migracionshd',           'ProjectHasExpedientesController@migracionshd')->name('migracionshd');
            Route::get('/beneficiarios/{id}',                           'ProjectHasExpedientesController@beneficiarios')->name('beneficiarios');
            Route::get('/create',                                       'ProjectHasExpedientesController@create')->name('create');
            Route::post('/',                                            'ProjectHasExpedientesController@store')->name('store');
            Route::get('/{projectHasExpediente}/edit',                  'ProjectHasExpedientesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectHasExpedientesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{projectHasExpediente}',                      'ProjectHasExpedientesController@update')->name('update');
            Route::delete('/{projectHasExpediente}',                    'ProjectHasExpedientesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('project-has-postulantes')->name('project-has-postulantes/')->group(static function () {
            Route::get('/',                                             'ProjectHasPostulantesController@index')->name('index');
            Route::get('/create',                                       'ProjectHasPostulantesController@create')->name('create');
            Route::post('/',                                            'ProjectHasPostulantesController@store')->name('store');
            Route::get('/{projectHasPostulante}/edit',                  'ProjectHasPostulantesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectHasPostulantesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{projectHasPostulante}',                      'ProjectHasPostulantesController@update')->name('update');
            Route::delete('/{projectHasPostulante}',                    'ProjectHasPostulantesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('postulantes')->name('postulantes/')->group(static function () {
            Route::get('/',                                             'PostulantesController@index')->name('index');
            Route::get('/create',                                       'PostulantesController@create')->name('create');
            Route::post('/',                                            'PostulantesController@store')->name('store');
            Route::get('/{postulante}/edit',                            'PostulantesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PostulantesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{postulante}',                                'PostulantesController@update')->name('update');
            Route::delete('/{postulante}',                              'PostulantesController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('postulante-has-beneficiaries')->name('postulante-has-beneficiaries/')->group(static function () {
            Route::get('/',                                             'PostulanteHasBeneficiariesController@index')->name('index');
            Route::get('/create',                                       'PostulanteHasBeneficiariesController@create')->name('create');
            Route::post('/',                                            'PostulanteHasBeneficiariesController@store')->name('store');
            Route::get('/{postulanteHasBeneficiary}/edit',              'PostulanteHasBeneficiariesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PostulanteHasBeneficiariesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{postulanteHasBeneficiary}',                  'PostulanteHasBeneficiariesController@update')->name('update');
            Route::delete('/{postulanteHasBeneficiary}',                'PostulanteHasBeneficiariesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('parentescos')->name('parentescos/')->group(static function () {
            Route::get('/',                                             'ParentescoController@index')->name('index');
            Route::get('/create',                                       'ParentescoController@create')->name('create');
            Route::post('/',                                            'ParentescoController@store')->name('store');
            Route::get('/{parentesco}/edit',                            'ParentescoController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ParentescoController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{parentesco}',                                'ParentescoController@update')->name('update');
            Route::delete('/{parentesco}',                              'ParentescoController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('postulante-has-discapacidads')->name('postulante-has-discapacidads/')->group(static function () {
            Route::get('/',                                             'PostulanteHasDiscapacidadController@index')->name('index');
            Route::get('/create',                                       'PostulanteHasDiscapacidadController@create')->name('create');
            Route::post('/',                                            'PostulanteHasDiscapacidadController@store')->name('store');
            Route::get('/{postulanteHasDiscapacidad}/edit',             'PostulanteHasDiscapacidadController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PostulanteHasDiscapacidadController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{postulanteHasDiscapacidad}',                 'PostulanteHasDiscapacidadController@update')->name('update');
            Route::delete('/{postulanteHasDiscapacidad}',               'PostulanteHasDiscapacidadController@destroy')->name('destroy');
        });
    });
});
