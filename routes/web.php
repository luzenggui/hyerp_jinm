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

//Route::get('/', function () {
//    return view('navbarerp');
////    return view('welcome');
//});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('gitpullbybat', function() { return view('gitpullbybat'); });
//Route::get('gitpullbybat', function() {
//    Log::info(getcwd());
//    exec('cd .. && git pull', $output);
//    Log::info($output);
//});

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    //
    Route::get('/', function() { return view('navbarerp'); });
    Route::get('/home', function() { return view('navbarerp'); });
    Route::get('changeuser', 'HelperController@changeuser');
    Route::post('changeuser_store', 'HelperController@changeuser_store');
});
Route::group(['prefix' => 'development', 'namespace' => 'Development', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'fabricdischarges/{id}'], function () {
//        Route::post('finish/{num1}', 'FabricdischargeController@finish');
//        Route::post('finish2/{num2}', 'FabricdischargeController@finish2');
        Route::get('export', 'FabricdischargeController@export');
    });
    Route::get('report', '\App\Http\Controllers\System\ReportController@indexfabricdata');
    Route::group(['prefix' => 'fabricdischarges'], function () {
        Route::post('search', 'FabricdischargeController@search');
        Route::post('finish', 'FabricdischargeController@finish');
        Route::get('updatefinishedpl', 'FabricdischargeController@updatefinishedpl');
        Route::get('updatefinishedzb', 'FabricdischargeController@updatefinishedzb');
    });
    Route::group(['prefix' => 'genbarcode'], function () {
        route::post('changebarcode','GenbarcodeController@changebarcode');
    });
    Route::resource('fabricdischarges', 'FabricdischargeController');
    Route::resource('genbarcode', 'GenbarcodeController');
});




Route::group(['prefix' => 'department6', 'namespace' => 'Department6', 'middleware' => ['web', 'auth']], function() {

    Route::get('report', '\App\Http\Controllers\System\ReportController@indexdepartment6');
    Route::group(['prefix' => 'inquiry_sheets'], function () {
        Route::get('mcreate', 'Inquiry_sheetsController@mcreate');
        Route::post('mstore', 'Inquiry_sheetsController@mstore');
        Route::post('upload_images','\App\Http\Controllers\ArticlesController@uploadImage')->name('upload.images');
        Route::post('winbidding/{id}', 'Inquiry_sheetsController@winbidding');
        Route::post('search',  'Inquiry_sheetsController@search');
        Route::post('copywinbidding/{id}',  'Inquiry_sheetsController@copywinbidding');
        Route::get('{id}/export',  'Inquiry_sheetsController@export');
    });
    Route::group(['prefix' => 'orders'], function () {
        Route::get('mcreate', 'OrderController@mcreate');
        Route::post('mstore', 'OrderController@mstore');
        Route::post('upload_images','\App\Http\Controllers\ArticlesController@uploadImage')->name('upload.images');
        Route::post('search',  'OrderController@search');
        Route::get('{id}/byprocessexport',  'OrderController@byprocessexport');
        Route::get('{id}/byfabircexport',  'OrderController@byfabircexport');
        Route::get('{id}/byingredientexport',  'OrderController@byingredientexport');
    });

    Route::group(['prefix' => 'part'], function () {

        Route::post('copypart/{id}',  'PartController@copypart');
    });

    Route::resource('inquiry_sheets', 'Inquiry_sheetsController');
    Route::resource('orders', 'OrderController');
    Route::resource('process', 'ProcessController');
    Route::resource('part', 'PartController');
    Route::resource('ingredient', 'IngredientController');
});

Route::group(['prefix' => 'personal', 'namespace' => 'Personal', 'middleware' => ['web', 'auth']], function() {

    Route::get('report', '\App\Http\Controllers\System\ReportController@indexpersonal');
    Route::group(['prefix' => 'checkrecords'], function () {
        Route::post('search', 'CheckRecordController@search');
        Route::get('import', 'CheckRecordController@import');
        Route::post('importstore', 'CheckRecordController@importstore');
        Route::get('datasync', 'CheckRecordController@datasync');
        Route::post('synchronization', 'CheckRecordController@synchronization');
        Route::post('export', 'CheckRecordController@export');
    });
    Route::group(['prefix' => 'orgmembers'], function () {
        Route::post('search', 'OrgMemberController@search');
        Route::post('import', 'OrgMemberController@import');
        Route::post('export', 'OrgMemberController@export');
    });
    Route::resource('orgmembers', 'OrgMemberController');
    Route::resource('checkrecords', 'CheckRecordController');
});

Route::group(['prefix' => 'vouch', 'namespace' => 'Vouch', 'middleware' => ['web', 'auth']], function() {

    Route::get('report', '\App\Http\Controllers\System\ReportController@indexvouch');
    Route::group(['prefix' => 'materials'], function () {
        Route::post('search', 'MaterialController@search');
        Route::get('import', 'MaterialController@import');
        Route::post('importstore', 'MaterialController@importstore');
        Route::post('export', 'MaterialController@export');
    });
    Route::group(['prefix' => 'finishproducts'], function () {
        Route::post('search', 'FinishproductController@search');
        Route::get('import', 'FinishproductController@import');
        Route::post('importstore', 'FinishproductController@importstore');
        Route::post('export', 'FinishproductController@export');
    });
    Route::group(['prefix' => 'boms'], function () {
        Route::post('search', 'BomController@search');
        Route::get('import', 'BomController@import');
        Route::post('importstore', 'BomController@importstore');
        Route::post('export', 'BomController@export');
    });
    Route::group(['prefix' => 'materialsheets'], function () {
        Route::post('search', 'MaterialsheetController@search');
        Route::get('import', 'MaterialsheetController@import');
        Route::post('importstore', 'MaterialsheetController@importstore');
        Route::post('export', 'MaterialsheetController@export');
    });
    Route::group(['prefix' => 'finishproductsheets'], function () {
        Route::post('search', 'FinishproductsheetController@search');
        Route::get('import', 'FinishproductsheetController@import');
        Route::post('importstore', 'FinishproductsheetController@importstore');
        Route::post('export', 'FinishproductsheetController@export');
    });
    Route::resource('boms', 'BomController');
    Route::resource('finishproducts', 'FinishproductController');
    Route::resource('materials', 'MaterialController');
    Route::resource('materialsheets', 'MaterialsheetController');
    Route::resource('finishproductsheets', 'FinishproductsheetController');
});
Route::group(['prefix' => 'my', 'namespace' => 'My', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'report'], function() {
          Route::get('fabricdata', 'MyController@index_fabricdata');
    });
//    Route::group(['prefix' => 'bonusbyorder'], function() {
//        Route::get('', 'MyController@bonusbyorder');
//    });
});

Route::group(['prefix' => 'finance', 'namespace' => 'Finance', 'middleware' => ['web', 'auth']], function() {

    Route::get('report', '\App\Http\Controllers\System\ReportController@indexfinance');
    Route::group(['prefix' => 'packinfo'], function () {
        Route::post('search', 'PackinfoController@search');
        Route::get('import', 'PackinfoController@import');
        Route::post('importstore', 'PackinfoController@importstore');
        Route::post('export', 'PackinfoController@export');
    });
    Route::group(['prefix' => 'shipmentinfo'], function () {
        Route::post('search', 'ShipmentinfoController@search');
        Route::get('import', 'ShipmentinfoController@import');
        Route::post('importstore', 'ShipmentinfoController@importstore');
        Route::post('export', 'ShipmentinfoController@export');
    });
    Route::group(['prefix' => 'invoice'], function () {
        Route::post('search', 'InvoiceController@search');
        Route::get('import', 'InvoiceController@import');
        Route::post('importstore', 'InvoiceController@importstore');
        Route::post('export', 'InvoiceController@export');
    });
    Route::group(['prefix' => 'nxshipment'], function () {
        Route::post('search', 'nxshipmentController@search');
        Route::get('import', 'nxshipmentController@import');
        Route::post('importstore', 'nxshipmentController@importstore');
        Route::post('export', 'nxshipmentController@export');
    });

    Route::resource('shipmentinfo', 'ShipmentinfoController');
    Route::resource('packinfo', 'PackinfoController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('nxshipment', 'nxshipmentController');
});


Route::group(['prefix' => 'my', 'namespace' => 'My', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'report'], function() {
        Route::get('fabricdata', 'MyController@index_fabricdata');
    });
//    Route::group(['prefix' => 'bonusbyorder'], function() {
//        Route::get('', 'MyController@bonusbyorder');
//    });
});

Route::group(['prefix' => 'purchaseorderc', 'namespace' => 'Purchaseorderc', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'purchaseordercs'], function () {
        Route::post('search', 'PurchaseordercController@search');
    });
    Route::group(['prefix' => 'purchaseordercs/{id}'], function () {
        Route::get('detail', 'PurchaseordercController@detail');
        Route::get('seperate', 'PurchaseordercController@seperate');
        Route::get('exportpo', 'PurchaseordercController@exportpo');
    });
    Route::resource('purchaseordercs', 'PurchaseordercController');
    Route::get('poitemcs/{headId}/create', 'PoitemcController@createByPoheadId');
    Route::resource('poitemcs', 'PoitemcController');
    Route::group(['prefix' => 'poheadcreceives'], function () {
        Route::post('search', 'PoheadcreceiveController@search');
    });
    Route::group(['prefix' => 'poheadcreceives/{id}'], function () {
        Route::get('detail', 'PoheadcreceiveController@detail');
    });
    Route::resource('poheadcreceives', 'PoheadcreceiveController');
    Route::resource('poitemcreceives', 'PoitemcreceiveController');
});

Route::group(['prefix' => 'purchase', 'namespace' => 'Purchase', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'vendors'], function() {
        Route::get('getitemsbykey/{key}', 'VendorController@getitemsbykey');
    });
    Route::resource('vendors', 'VendorController');
//    Route::resource('vendtypes', 'VendtypesController');
//    Route::group(['prefix' => 'vendbank'], function() {
//        Route::get('getitemsbyvendid/{vendid}', 'VendbankController@getitemsbyvendid');
//    });
//    Route::resource('vendbank', 'VendbankController');
    Route::group(['prefix' => 'purchaseorders/{id}'], function () {
        Route::get('detail', 'PurchaseorderController@detail');
        Route::get('packing', 'PurchaseorderController@packing');
        Route::get('exportcontract', 'PurchaseorderController@exportcontract');
        Route::get('importpacking', 'PurchaseorderController@importpacking');
        Route::post('storeimportpacking', 'PurchaseorderController@storeimportpacking');
//        Route::patch('update_hx', 'PurchaseordersController@update_hx');
//        Route::get('getpoheadtaxrateass_hx', 'PurchaseordersController@getpoheadtaxrateass_hx');
    });
//    Route::group(['prefix' => 'purchaseorders/{purchaseorder}/payments'], function () {
//        Route::get('/', 'PaymentsController@index');
//        Route::get('create', 'PaymentsController@create');
//        Route::post('store', 'PaymentsController@store');
//        Route::delete('destroy/{payment}', 'PaymentsController@destroy');
//
//        Route::get('create_hxold', 'PaymentsController@create_hxold');
//        Route::post('store_hxold', 'PaymentsController@store_hxold');
//    });
    Route::group(['prefix' => 'purchaseorders'], function() {
        Route::get('getitemsbyorderkey/{key?}', 'PurchaseorderController@getitemsbyorderkey');
//        Route::get('create_hx', 'PurchaseordersController@create_hx');
        Route::post('storeseperate', 'PurchaseorderController@storeseperate');
//        Route::post('search_hx', 'PurchaseordersController@search_hx');
    });
//    Route::group(['prefix' => 'poheadtaxrateass'], function() {
//        Route::get('destorybyid/{id}', 'PoheadtaxrateassController@destorybyid');       // use get for page opt.
//    });
    Route::resource('purchaseorders', 'PurchaseorderController');
    Route::group(['prefix' => 'poitems'], function () {
        Route::post('packingstore', 'PoitemController@packingstore');
        Route::get('getitemsbypoheadid/{pohead}', 'PoitemController@getitemsbypoheadid');
    });
    Route::group(['prefix' => 'poitems/{poitem}'], function () {
        Route::get('poitemrolls', 'PoitemController@poitemrolls');
    });
    Route::resource('poitems', 'PoitemController');
    Route::group(['prefix' => 'poitemrolls'], function () {
        Route::get('getitemsbypoitem/{poitem}', 'PoitemrollController@getitemsbypoitem');
    });
    Route::resource('poitemrolls', 'PoitemrollController');
    Route::group(['prefix' => 'asns'], function () {
        Route::post('packingstore', 'AsnController@packingstore');
        Route::post('send', 'AsnController@send');
        Route::get('exportpackinglist', 'AsnController@exportpackinglist');
        Route::get('exportdpl', 'AsnController@exportdpl');
        Route::get('exportinvoice', 'AsnController@exportinvoice');
        Route::get('exportcheckreport', 'AsnController@exportcheckreport');
    });
    Route::group(['prefix' => 'asns/{id}'], function () {
        Route::get('detail', 'AsnController@detail');
        Route::get('asnshipments', 'AsnController@asnshipments');
        Route::get('labelprint', 'AsnController@labelprint');
        Route::get('labelpreprint', 'AsnController@labelpreprint');
        Route::get('export', 'AsnController@export');
    });
    Route::resource('asns', 'AsnController');
    Route::group(['prefix' => 'asnshipments/{asn_id}'], function () {
        Route::get('create', 'AsnshipmentController@create');
    });
    Route::group(['prefix' => 'asnshipments/{asnshipment}'], function () {
        Route::get('edit', 'AsnshipmentController@edit')->name('asnshipments.edit');
        Route::patch('', 'AsnshipmentController@update')->name('asnshipments.update');
        Route::delete('', 'AsnshipmentController@destroy')->name('asnshipments.destroy');
        Route::get('asnorders', 'AsnshipmentController@asnorders');
    });
    Route::group(['prefix' => 'asnshipments'], function () {
        Route::post('store', 'AsnshipmentController@store');
    });
//    Route::resource('asnshipments', 'AsnshipmentController');
    Route::group(['prefix' => 'asnorders/{asnshipment_id}'], function () {
        Route::get('create', 'AsnorderController@create');
        Route::get('asnpackagings', 'AsnorderController@asnpackagings');
    });
    Route::group(['prefix' => 'asnorders'], function () {
        Route::get('asnorderjson', 'AsnorderController@asnorderjson');
    });
    Route::resource('asnorders', 'AsnorderController');
    Route::group(['prefix' => 'asnpackagings/{asnpackaging_id}'], function () {
        Route::get('create', 'AsnpackagingController@create');
        Route::get('asnitems', 'AsnpackagingController@asnitems');
    });
    Route::group(['prefix' => 'asnpackagings'], function () {
        Route::get('asnpackagingjson/{asnorder_id?}', 'AsnpackagingController@asnpackagingjson');
    });
    Route::resource('asnpackagings', 'AsnpackagingController');
    Route::group(['prefix' => 'asnitems/{asnpackaging_id}'], function () {
        Route::get('create', 'AsnitemController@create');
    });
    Route::resource('asnitems', 'AsnitemController');
    Route::resource('uservendors', 'UservendorController');
});

Route::group(['prefix' => 'shipment', 'namespace' => 'Shipment', 'middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'shipments'], function () {
        Route::get('import', 'ShipmentController@import');
        Route::post('importstore', 'ShipmentController@importstore');
        Route::post('search', 'ShipmentController@search');
        Route::post('export', 'ShipmentController@export');
        Route::post('exportpvh', 'ShipmentController@exportpvh');
        Route::get('downloadfile/{filename}', 'ShipmentController@downloadfile')->name('shipment.shipments.downloadfile');
        Route::get('filemonitor', 'ShipmentController@filemonitor');
        Route::post('searchfilemonitor', 'ShipmentController@searchfilemonitor');
        Route::post('uploadfile', 'ShipmentController@uploadfile');
        Route::post('clearfile', 'ShipmentController@clearfile');
        Route::get('shipmenttracking', 'ShipmentController@shipmenttracking');
        Route::post('searchshipmenttracking', 'ShipmentController@searchshipmenttracking');
        Route::post('exportshipmenttracking', 'ShipmentController@exportshipmenttracking');
        Route::get('updatefinished', 'ShipmentController@updatefinished');
    });
    Route::group(['prefix' => 'shipments/{shipment}'], function () {
        Route::get('shipmentitems', 'ShipmentController@shipmentitems');
        Route::get('editshipmenttracking', 'ShipmentController@editshipmenttracking');
        Route::patch('updateshipmenttracking', 'ShipmentController@updateshipmenttracking');
    });
    Route::group(['prefix' => 'packinglists'], function () {
        Route::post('search', 'PackinglistController@search');
    });
    Route::resource('shipments', 'ShipmentController');
    Route::group(['prefix' => 'shipmentitems/{shipment}'], function () {
        Route::get('create', 'ShipmentitemController@create');
    });
    Route::resource('shipmentitems', 'ShipmentitemController');
    Route::resource('userforwarders', 'UserforwarderController');
    Route::resource('shipmentattachmentrecords', 'ShipmentattachmentrecordController');
    Route::resource('packinglists', 'PackinglistController');
    Route::get('report', '\App\Http\Controllers\System\ReportController@indexshipment');
});

Route::middleware(['auth', 'web'])->namespace('System')->prefix('system')->group(function () {
    Route::group(['prefix' => 'users'], function() {
//        Route::post('updateuseroldall', 'UsersController@updateuseroldall');
        Route::post('search', 'UserController@search');              // 搜索功能
//        Route::get('getitemsbykey/{key}', 'UsersController@getitemsbykey');
    });
    Route::group(['prefix' => 'users/{id}'], function() {
        Route::get('editpass', 'UserController@editpass');
        Route::post('updatepass', 'UserController@updatepass');
//        Route::get('google2fa', 'UsersController@google2fa');
//        Route::post('updategoogle2fa', 'UsersController@updategoogle2fa');
    });
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::post('userroles/store', 'UserroleController@store');
    Route::group(['prefix' => 'users/{user}/roles'], function () {
        Route::get('/', 'UserroleController@index');
        Route::get('create', 'UserroleController@create');
        Route::post('store', 'UserroleController@store');
        Route::delete('destroy/{role}', 'UserroleController@destroy');
    });
    Route::group(['prefix' => 'roles/{role}/permissions'], function() {
        Route::get('/', 'RolepermissionController@index');
        Route::get('create', 'RolepermissionController@create');
        Route::delete('destroy/{permission}', 'RolepermissionController@destroy');
    });
    Route::post('rolepermissions/store', 'RolepermissionController@store');
    Route::group(['prefix' => 'reports/{report}'], function() {
        Route::any('statistics/{autostatistics?}', 'ReportController@statistics');
        Route::post('export', 'ReportController@export');
    });
    Route::resource('reports', 'ReportController');
});