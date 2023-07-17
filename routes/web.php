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

Route::redirect('/', '/home');
Auth::routes();

Route::middleware('auth')
    ->group(
        function () {
            Route::namespace('Dashboard')
                ->group(
                    function () {
                        Route::get('home', 'DashboardController@index')->name('home');
                        Route::post('progress', 'DashboardController@progress')->name('dashboard.progress');
                        Route::post('chartUser', 'DashboardController@chartUser')->name('dashboard.chartUser');
                        Route::get('language/{lang}/setLang', 'DashboardController@setLang')->name('setLang');
                    }
                );
            // Ajax
            Route::prefix('ajax')
                ->name('ajax.')
                ->group(
                    function () {
                        Route::get('aset-options', 'AjaxController@asetOptions')->name('aset-options');
                        Route::get('city-options', 'AjaxController@cityOptions')->name('city-options');
                        Route::post('cityOptionsRoot', 'AjaxController@cityOptionsRoot')->name('cityOptionsRoot');
                        Route::get('sub-lokasi-options', 'AjaxController@subLokasiOptions')->name('sub-lokasi-options');
                        Route::post('saveTempFiles', 'AjaxController@saveTempFiles')->name('saveTempFiles');
                        Route::get('testNotification/{emails}', 'AjaxController@testNotification')->name('testNotification');
                        Route::post('userNotification', 'AjaxController@userNotification')->name('userNotification');
                        Route::get('userNotification/{notification}/read', 'AjaxController@userNotificationRead')->name('userNotificationRead');
                        // Ajax Modules
                        Route::post('{search}/selectRole', 'AjaxController@selectRole')->name('selectRole');
                        Route::post('{search}/selectStruct', 'AjaxController@selectStruct')->name('selectStruct');
                        Route::post('{search}/selectPosition', 'AjaxController@selectPosition')->name('selectPosition');
                        Route::post('{search}/selectProvince', 'AjaxController@selectProvince')->name('selectProvince');
                        Route::post('{search}/selectUser', 'AjaxController@selectUser')->name('selectUser');
                        Route::post('{search}/selectNip', 'AjaxController@selectNip')->name('selectNip');
                        Route::post('{search}/selectAset', 'AjaxController@selectAset')->name('selectAset');
                        Route::post('{search}/selectAsetWithPrice', 'AjaxController@selectAsetWithPrice')->name('selectAsetWithPrice');
                        Route::get('getAsetOptions', 'AjaxController@getAsetOptions')->name('getAsetOptions');
                        Route::post('getAsetFromOptions', 'AjaxController@getAsetFromOptions')->name('getAsetFromOptions');
                        Route::post('{search}/selectLocation', 'AjaxController@selectLocation')->name('selectLocation');
                        Route::post('{search}/selectSubLocation', 'AjaxController@selectSubLocation')->name('selectSubLocation');
                        Route::post('{search}/selectMaintenanceType', 'AjaxController@selectMaintenanceType')->name('selectMaintenanceType');
                        Route::post('{search}/selectMaintenanceItem', 'AjaxController@selectMaintenanceItem')->name('selectMaintenanceItem');
                        Route::post('{search}/selectVendor', 'AjaxController@selectVendor')->name('selectVendor');
                        Route::post('{search}/selectPriority', 'AjaxController@selectPriority')->name('selectPriority');
                        Route::post('{search}/selectAsset', 'AjaxController@selectAsset')->name('selectAsset');
                        Route::post('{search}/selectOthersCost', 'AjaxController@selectOthersCost')->name('selectOthersCost');
                        Route::post('{search}/selectPlant', 'AjaxController@selectPlant')->name('selectPlant');
                        Route::post('{search}/selectSystem', 'AjaxController@selectSystem')->name('selectSystem');
                        Route::post('systemOptions', 'AjaxController@systemOptions')->name('systemOptions');
                        Route::post('{search}/selectEquipment', 'AjaxController@selectEquipment')->name('selectEquipment');
                        Route::post('equipmentOptions', 'AjaxController@equipmentOptions')->name('equipmentOptions');
                        Route::post('{search}/selectSubUnit', 'AjaxController@selectSubUnit')->name('selectSubUnit');
                        Route::post('subUnitOptions', 'AjaxController@subUnitOptions')->name('subUnitOptions');
                        Route::post('{search}/selectKomponen', 'AjaxController@selectKomponen')->name('selectKomponen');
                        Route::post('komponenOptions', 'AjaxController@komponenOptions')->name('komponenOptions');

                        Route::post('asetStructureOptions', 'AjaxController@asetStructureOptions')->name('asetStructureOptions');
                    }
                );

            // Setting
            Route::namespace('Setting')
                ->prefix('setting')
                ->name('setting.')
                ->group(
                    function () {
                        Route::namespace('Role')
                            ->group(
                                function () {
                                    Route::get('role/import', 'RoleController@import')->name('role.import');
                                    Route::post('role/importSave', 'RoleController@importSave')->name('role.importSave');
                                    Route::get('role/{record}/permit', 'RoleController@permit')->name('role.permit');
                                    Route::patch('role/{record}/grant', 'RoleController@grant')->name('role.grant');
                                    Route::grid('role', 'RoleController');
                                }
                            );
                        Route::namespace('Flow')
                            ->group(
                                function () {
                                    Route::get('flow/import', 'FlowController@import')->name('flow.import');
                                    Route::post('flow/importSave', 'FlowController@importSave')->name('flow.importSave');
                                    Route::grid('flow', 'FlowController');
                                }
                            );
                        Route::namespace('User')
                            ->group(
                                function () {
                                    Route::get('user/import', 'UserController@import')->name('user.import');
                                    Route::post('user/importSave', 'UserController@importSave')->name('user.importSave');
                                    Route::grid('user', 'UserController');

                                    Route::get('profile', 'ProfileController@index')->name('profile.index');
                                    Route::post('profile', 'ProfileController@updateProfile')->name('profile.updateProfile');
                                    Route::get('profile/notification', 'ProfileController@notification')->name('profile.notification');
                                    Route::post('profile/gridNotification', 'ProfileController@gridNotification')->name('profile.gridNotification');
                                    Route::get('profile/activity', 'ProfileController@activity')->name('profile.activity');
                                    Route::post('profile/gridActivity', 'ProfileController@gridActivity')->name('profile.gridActivity');
                                    Route::get('profile/changePassword', 'ProfileController@changePassword')->name('profile.changePassword');
                                    Route::post('profile/changePassword', 'ProfileController@updatePassword')->name('profile.updatePassword');
                                }
                            );
                        Route::namespace('Activity')
                            ->group(
                                function () {
                                    Route::get('activity/export', 'ActivityController@export')->name('activity.export');
                                    Route::grid('activity', 'ActivityController');
                                }
                            );
                    }
                );

            // Master
            Route::namespace('Master')
                ->prefix('master')
                ->name('master.')
                ->group(
                    function () {
                        Route::namespace('Org')
                            ->prefix('org')
                            ->name('org.')
                            ->group(
                                function () {
                                    Route::grid('root', 'RootController');
                                    Route::grid('boc', 'BocController');

                                    Route::get('bod/import', 'BodController@import')->name('bod.import');
                                    Route::post('bod/importSave', 'BodController@importSave')->name('bod.importSave');
                                    Route::grid('bod', 'BodController');

                                    Route::get('division/import', 'DivisionController@import')->name('division.import');
                                    Route::post('division/importSave', 'DivisionController@importSave')->name('division.importSave');
                                    Route::grid('division', 'DivisionController');

                                    Route::get('department/import', 'DepartmentController@import')->name('department.import');
                                    Route::post('department/importSave', 'DepartmentController@importSave')->name('department.importSave');
                                    Route::grid('department', 'DepartmentController');

                                    Route::get('unit/import', 'UnitController@import')->name('unit.import');
                                    Route::post('unit/importSave', 'UnitController@importSave')->name('unit.importSave');
                                    Route::grid('unit', 'UnitController');

                                    Route::get('bagian/import', 'BagianController@import')->name('bagian.import');
                                    Route::post('bagian/importSave', 'BagianController@importSave')->name('bagian.importSave');
                                    Route::grid('bagian', 'BagianController');

                                    Route::get('subbagian/import', 'SubbagianController@import')->name('subbagian.import');
                                    Route::post('subbagian/importSave', 'SubbagianController@importSave')->name('subbagian.importSave');
                                    Route::grid('subbagian', 'SubbagianController');

                                    Route::get('position/import', 'PositionController@import')->name('position.import');
                                    Route::post('position/importSave', 'PositionController@importSave')->name('position.importSave');
                                    Route::grid('position', 'PositionController');
                                }
                            );

                        Route::namespace('Geo')
                            ->name('geo.')
                            ->prefix('geo')
                            ->group(
                                function () {
                                    Route::get('province/import', 'ProvinceController@import')->name('province.import');
                                    Route::post('province/importSave', 'ProvinceController@importSave')->name('province.importSave');
                                    Route::grid('province', 'ProvinceController');

                                    Route::get('city/import', 'CityController@import')->name('city.import');
                                    Route::post('city/importSave', 'CityController@importSave')->name('city.importSave');
                                    Route::grid('city', 'CityController');

                                    Route::get('district/import', 'DistrictController@import')->name('district.import');
                                    Route::post('district/importSave', 'DistrictController@importSave')->name('district.importSave');
                                    Route::grid('district', 'DistrictController');
                                }
                        );
                        Route::namespace('Pendidikan')
                            ->name('pendidikan.')
                            ->prefix('pendidikan')
                            ->group(
                                function () {
                                    Route::grid('pendidikan', 'PendidikanController');
                                    Route::grid('jurusan', 'JurusanController');

                                }
                        );
                    }
                );

            // Web Transaction Modules
            foreach (\File::allFiles(__DIR__ . '/webs') as $file) {
                require $file->getPathname();
            }
        }
    );
