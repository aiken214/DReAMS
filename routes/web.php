<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ItemsListController;
use App\Http\Controllers\Admin\SignatoryController;
use App\Http\Controllers\User\PpmpController;
use App\Http\Controllers\User\PpmpItemController;
use App\Http\Controllers\User\PpmpPrintController;
use App\Http\Controllers\Supply\PpmpCheckController;
use App\Http\Controllers\Supply\PpmpItemCheckController;
use App\Http\Controllers\Supply\PpmpCheckedPrintController;
use App\Http\Controllers\Supply\PoCheckController;
use App\Http\Controllers\Supply\PoItemCheckController;
use App\Http\Controllers\Budget\PpmpVerifyController;
use App\Http\Controllers\Budget\PpmpItemVerifyController;
use App\Http\Controllers\Budget\PpmpVerifiedPrintController;
use App\Http\Controllers\Sds\PpmpApproveController;
use App\Http\Controllers\Sds\PpmpItemApproveController;
use App\Http\Controllers\User\PrController;
use App\Http\Controllers\User\PrItemController;
use App\Http\Controllers\User\PrPrintController;
use App\Http\Controllers\Supply\PrCheckController;
use App\Http\Controllers\Supply\PrItemCheckController;
use App\Http\Controllers\Supply\PrCheckedPrintController;
use App\Http\Controllers\Budget\PrVerifyController;
use App\Http\Controllers\Budget\PrItemVerifyController;
use App\Http\Controllers\Budget\PrVerifiedPrintController;
use App\Http\Controllers\Sds\PrApproveController;
use App\Http\Controllers\Sds\PrItemApproveController;
use App\Http\Controllers\User\FundUtilizationController;
use App\Http\Controllers\User\FundUtilizationDetailsController;
use App\Http\Controllers\Budget\FundAllocationController;
use App\Http\Controllers\Budget\FundAllocationDetailsController;
use App\Http\Controllers\Budget\FundObligationController;
use App\Http\Controllers\Bac\FinalPpmpController;
use App\Http\Controllers\Bac\FinalPpmpItemController;
use App\Http\Controllers\Bac\FinalPrController;
use App\Http\Controllers\Bac\FinalPrItemController;
use App\Http\Controllers\Bac\PoController;
use App\Http\Controllers\Bac\PoItemController;
use App\Http\Controllers\Bac\PoPrintController;
use App\Http\Controllers\Bac\RfqController;
use App\Http\Controllers\Bac\RfqItemController;
use App\Http\Controllers\Bac\RfqPrintController;
use App\Http\Controllers\Bac\AppController;
use App\Http\Controllers\Bac\AppItemController;
use App\Http\Controllers\Bac\AppCseController;
use App\Http\Controllers\Bac\AppNonCseController;
use App\Http\Controllers\Bac\AppPrintController;

//PSMIS
use App\Http\Controllers\Supply\IarController;
use App\Http\Controllers\Supply\IarItemController;
use App\Http\Controllers\Supply\NodController;
use App\Http\Controllers\Supply\NodPrintController;
use App\Http\Controllers\Supply\AssetController;
use App\Http\Controllers\Supply\AssetItemController;
use App\Http\Controllers\Supply\DonationController;
use App\Http\Controllers\Supply\DonationItemController;
use App\Http\Controllers\Supply\IarPrintController;
use App\Http\Controllers\Supply\RisController;
use App\Http\Controllers\Supply\RisItemController;
use App\Http\Controllers\Supply\RisPrintController;
use App\Http\Controllers\Supply\RsmiController;
use App\Http\Controllers\Supply\RsmiItemController;
use App\Http\Controllers\Supply\RsmiPrintController;
use App\Http\Controllers\Supply\IcsHvController;
use App\Http\Controllers\Supply\IcsItemHvController;
use App\Http\Controllers\Supply\IcsHvPrintController;
use App\Http\Controllers\Supply\IcsLvController;
use App\Http\Controllers\Supply\IcsItemLvController;
use App\Http\Controllers\Supply\IcsLvPrintController;
use App\Http\Controllers\Supply\ParController;
use App\Http\Controllers\Supply\ParItemController;
use App\Http\Controllers\Supply\ParPrintController;
use App\Http\Controllers\Supply\RrspHvController;
use App\Http\Controllers\Supply\RrspItemHvController;
use App\Http\Controllers\Supply\RrspLvController;
use App\Http\Controllers\Supply\RrspItemLvController;
use App\Http\Controllers\Supply\RrspPrintController;
use App\Http\Controllers\Supply\RspiHvController;
use App\Http\Controllers\Supply\RspiLvController;
use App\Http\Controllers\Supply\RspiPrintController;
use App\Http\Controllers\Supply\RppeiController;
use App\Http\Controllers\Supply\RppeiPrintController;
use App\Http\Controllers\Supply\RrppeController;
use App\Http\Controllers\Supply\RrppeItemController;
use App\Http\Controllers\Supply\RrppePrintController;
use App\Http\Controllers\Supply\RegppeiController;
use App\Http\Controllers\Supply\RegppeiPrintController;
use App\Http\Controllers\Supply\RegspiHvController;
use App\Http\Controllers\Supply\RegspiLvController;
use App\Http\Controllers\Supply\RegspiPrintController;
use App\Http\Controllers\Supply\StockController;
use App\Http\Controllers\Supply\StockCardController;
use App\Http\Controllers\Supply\StockCardPrintController;
use App\Http\Controllers\Supply\SemiExpendableHvController;
use App\Http\Controllers\Supply\SemiExpendableCardHvController;
use App\Http\Controllers\Supply\SemiExpendableLvController;
use App\Http\Controllers\Supply\SemiExpendableCardLvController;
use App\Http\Controllers\Supply\SemiExpendableCardPrintController;
use App\Http\Controllers\Supply\PropertyController;
use App\Http\Controllers\Supply\PropertyCardController;
use App\Http\Controllers\Supply\PropertyCardPrintController;
use App\Http\Controllers\Supply\SpHvRecipientController;
use App\Http\Controllers\Supply\PpeRecipientController;
use App\Http\Controllers\User\SpLvIssuedController;
use App\Http\Controllers\User\SpHvIssuedController;
use App\Http\Controllers\User\PpeIssuedController;

use App\Http\Controllers\Supply\RpcppeController;
use App\Http\Controllers\Supply\RpcspController;
use App\Http\Controllers\Supply\RpciController;
use App\Http\Controllers\Supply\RpciPrintController;
use App\Http\Controllers\Supply\RpcspPrintController;
use App\Http\Controllers\Supply\RpcppePrintController;
use App\Http\Controllers\Supply\IirupController;
use App\Http\Controllers\Supply\IirupItemController;
use App\Http\Controllers\Supply\IirupPrintController;
use App\Http\Controllers\Supply\IiruspController;
use App\Http\Controllers\Supply\IiruspItemController;
use App\Http\Controllers\Supply\IiruspPrintController;

//Migration
use App\Http\Controllers\MigrationController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');
    Route::resource('employees', 'EmployeeController');



    // Route::get('/admin/employee', 'EmployeeController@index2')->name('admin.employee.index');
    Route::get('admin/employee', 'EmployeeController@index2')->name('admin.employee.index2');

    // Position
    Route::delete('position/destroy', 'PositionController@massDestroy')->name('position.massDestroy');
    Route::post('position/parse-csv-import', 'PositionController@parseCsvImport')->name('position.parseCsvImport');
    Route::post('position/process-csv-import', 'PositionController@processCsvImport')->name('position.processCsvImport');
    Route::resource('position', PositionController::class); //This route should be last to avoid conflict with other rooute like massDestroy

    // Station
    Route::delete('station/destroy', 'StationController@massDestroy')->name('station.massDestroy');
    Route::post('station/parse-csv-import', 'StationController@parseCsvImport')->name('station.parseCsvImport');
    Route::post('station/process-csv-import', 'StationController@processCsvImport')->name('station.processCsvImport');
    Route::resource('station', StationController::class); //This route should be last to avoid conflict with other rooute like massDestroy

    // Unit
    Route::delete('unit/destroy', 'UnitController@massDestroy')->name('unit.massDestroy');
    Route::post('unit/parse-csv-import', 'UnitController@parseCsvImport')->name('unit.parseCsvImport');
    Route::post('unit/process-csv-import', 'UnitController@processCsvImport')->name('unit.processCsvImport');
    Route::resource('unit', UnitController::class);

    // ItemsList
    Route::delete('items_list/destroy', 'ItemsListController@massDestroy')->name('items_list.massDestroy');
    Route::post('items_list/parse-csv-import', 'ItemsListController@parseCsvImport')->name('items_list.parseCsvImport');
    Route::post('items_list/process-csv-import', 'ItemsListController@processCsvImport')->name('items_list.processCsvImport');
    Route::resource('items_list', ItemsListController::class);

    // Signatory
    Route::delete('signatory/destroy', 'SignatoryController@massDestroy')->name('signatory.massDestroy');
    Route::post('signatory/parse-csv-import', 'SignatoryController@parseCsvImport')->name('signatory.parseCsvImport');
    Route::post('signatory/process-csv-import', 'SignatoryController@processCsvImport')->name('signatory.processCsvImport');
    Route::resource('signatory', SignatoryController::class);

    // Blog Post
    Route::delete('blog-posts/destroy', 'BlogPostController@massDestroy')->name('blog-posts.massDestroy');
    Route::resource('blog-posts', 'BlogPostController');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //PPMP
    Route::post('ppmp/parse-csv-import', 'PpmpController@parseCsvImport')->name('ppmp.parseCsvImport');
    Route::post('ppmp/process-csv-import', 'PpmpController@processCsvImport')->name('ppmp.processCsvImport');
    Route::resource('ppmp', PpmpController::class); 
    Route::post('ppmp/finalize/{id?}', [PpmpController::class, 'finalize'])->name('ppmp.finalize');
    Route::post('ppmp/revert/{id?}', [PpmpController::class, 'revert'])->name('ppmp.revert');

    Route::delete('ppmp_item/destroy', 'PpmpItemController@massDestroy')->name('ppmp_item.massDestroy');
    Route::post('ppmp_item/parse-csv-import', 'PpmpItemController@parseCsvImport')->name('ppmp_item.parseCsvImport');
    Route::post('ppmp_item/process-csv-import', 'PpmpItemController@processCsvImport')->name('ppmp_item.processCsvImport');
    Route::resource('ppmp_item', PpmpItemController::class);
    Route::get('ppmp_item/index/{id}', [PpmpItemController::class, 'index'])->name('ppmp_item.index2');
    Route::get('ppmp_item/create/{id}', [PpmpItemController::class, 'create'])->name('ppmp_item.create2');
    Route::get('ppmp_print/{id?}', [PpmpPrintController::class, 'print'])->name('ppmp_print');

    //Purchase Request
    Route::delete('purchase_request/destroy', 'PrController@massDestroy')->name('purchase_request.massDestroy');
    Route::post('purchase_request/parse-csv-import', 'PrController@parseCsvImport')->name('purchase_request.parseCsvImport');
    Route::post('purchase_request/process-csv-import', 'PrController@processCsvImport')->name('purchase_request.processCsvImport');
    Route::resource('purchase_request', PrController::class); 
    Route::post('purchase_request/finalize/{id?}', [PrController::class, 'finalize'])->name('purchase_request.finalize');
    Route::post('purchase_request/revert/{id?}', [PrController::class, 'revert'])->name('purchase_request.revert');

    Route::delete('purchase_request_item/destroy', 'PrItemController@massDestroy')->name('purchase_request_item.massDestroy');
    Route::post('purchase_request_item/parse-csv-import', 'PrItemController@parseCsvImport')->name('purchase_request_item.parseCsvImport');
    Route::post('purchase_request_item/process-csv-import', 'PrItemController@processCsvImport')->name('purchase_request_item.processCsvImport');
    Route::resource('purchase_request_item', PrItemController::class);
    Route::get('purchase_request_item/index/{id}', [PrItemController::class, 'index'])->name('purchase_request_item.index2');
    Route::get('purchase_request_item/create/{id}', [PrItemController::class, 'create'])->name('purchase_request_item.create2');
    Route::get('purchase_request_print/{id?}', [PrPrintController::class, 'print'])->name('purchase_request_print');

    //Fund Utilization
    Route::resource('fund_utilization', FundUtilizationController::class);
    
    Route::get('fund_utilization_details/index/{id}', [FundUtilizationDetailsController::class, 'index'])->name('fund_utilization_details.index2');

    //Issued
    Route::resource('semi_expendable_lv_received', SpLvIssuedController::class); 
    Route::resource('semi_expendable_hv_received', SpHvIssuedController::class); 
    Route::resource('ppe_received', PpeIssuedController::class); 

});

//Supply
Route::group(['prefix' => 'supply', 'as' => 'supply.', 'namespace' => 'Supply', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //PPMP Check
    Route::get('ppmp_check/checked', [PpmpCheckController::class, 'checkPpmp'])->name('ppmp_check.checked'); 
    Route::resource('ppmp_check', PpmpCheckController::class); 
    Route::post('ppmp_check/approve/{id?}', [PpmpCheckController::class, 'approve'])->name('ppmp_check.approve');
    Route::post('ppmp_check/revert/{id?}', [PpmpCheckController::class, 'revert'])->name('ppmp_check.revert');

    Route::resource('ppmp_item_check', PpmpItemCheckController::class);
    Route::get('ppmp_item_check/index/{id}', [PpmpItemCheckController::class, 'index'])->name('ppmp_item_check.index2');

    //Purchase Request Check
    Route::get('purchase_request_check/checked', [PrCheckController::class, 'checkedPr'])->name('purchase_request_check.checked'); 
    Route::resource('purchase_request_check', PrCheckController::class); 
    Route::post('purchase_request_check/approve/{id?}', [PrCheckController::class, 'approve'])->name('purchase_request_check.approve');
    Route::post('purchase_request_check/revert/{id?}', [PrCheckController::class, 'revert'])->name('purchase_request_check.revert');

    Route::resource('purchase_request_item_check', PrItemCheckController::class);
    Route::get('purchase_request_item_check/index/{id}', [PrItemCheckController::class, 'index'])->name('purchase_request_item_check.index2');

    //Purchase Order
    Route::resource('purchase_order_check', PoCheckController::class); 

    Route::resource('purchase_order_item_check', PoItemCheckController::class);
    Route::get('purchase_order_item_check/index/{id}', [PoItemCheckController::class, 'index'])->name('purchase_order_item_check.index2');

    //IAR
    Route::get('iar/create_from_petty_cash', [IarController::class, 'createFromPettyCash'])->name('iar.create_from_petty_cash'); 
    Route::post('iar/store_from_petty_cash', [IarController::class, 'storeFromPettyCash'])->name('iar.store_from_petty_cash'); 
    Route::resource('iar', IarController::class); 
    Route::get('iar/index/{id}', [IarController::class, 'index'])->name('iar.index2');

    Route::get('iar_item/create_from_petty_cash/{id}', [IarItemController::class, 'createFromPettyCash'])->name('iar_item.create_from_petty_cash'); 
    Route::post('iar_item/store_from_petty_cash', [IarItemController::class, 'storeFromPettyCash'])->name('iar_item.store_from_petty_cash'); 
    Route::resource('iar_item', IarItemController::class);
    Route::get('iar_item/index/{id}', [IarItemController::class, 'index'])->name('iar_item.index2');    
    Route::get('iar_item/create/{id}', [IarItemController::class, 'create'])->name('iar_item.create2');
    
    //NoD
    Route::resource('nod', NodController::class); 
    Route::get('nod/index/{id}', [NodController::class, 'index'])->name('nod.index2');

    //Asset
    Route::resource('asset', AssetController::class); 
    Route::get('asset/index/{id}', [AssetController::class, 'index'])->name('asset.index2');

    Route::resource('asset_item', AssetItemController::class);
    Route::get('asset_item/index/{id}', [AssetItemController::class, 'index'])->name('asset_item.index2');    
    Route::get('asset_item/create/{id}', [AssetItemController::class, 'create'])->name('asset_item.create2');

    //Donation
    Route::resource('donation', DonationController::class); 
    Route::get('donation/index/{id}', [DonationController::class, 'index'])->name('donation.index2');

    Route::resource('donation_item', DonationItemController::class);
    Route::get('donation_item/index/{id}', [DonationItemController::class, 'index'])->name('donation_item.index2');    
    Route::get('donation_item/create/{id}', [DonationItemController::class, 'create'])->name('donation_item.create2');

    //RIS
   
    Route::get('ris/index/{id}', [RisController::class, 'index'])->name('ris.index2');
    Route::get('ris/create_from_iar', [RisController::class, 'createFromIar'])->name('ris.create_from_iar'); 
    Route::get('ris/create_from_asset', [RisController::class, 'createFromAsset'])->name('ris.create_from_asset');
    Route::get('ris/create_from_donation', [RisController::class, 'createFromDonation'])->name('ris.create_from_donation');
    Route::get('ris/create_from_petty_cash', [RisController::class, 'createFromPettyCash'])->name('ris.create_from_petty_cash');
    Route::resource('ris', RisController::class); 

    Route::resource('ris_item', RisItemController::class);
    Route::get('ris_item/index/{id}', [RisItemController::class, 'index'])->name('ris_item.index2');    
    Route::get('ris_item/create/{id}', [RisItemController::class, 'create'])->name('ris_item.create2');

    //RSMI
    Route::resource('rsmi', RsmiController::class); 
    Route::get('rsmi/index/{id}', [RsmiController::class, 'index'])->name('rsmi.index2');

    Route::resource('rsmi_item', RsmiItemController::class);
    Route::get('rsmi_item/index/{id}', [RsmiItemController::class, 'index'])->name('rsmi_item.index2');    
    Route::get('rsmi_item/create/{id}', [RsmiItemController::class, 'create'])->name('rsmi_item.create2');

    //ICS
    Route::resource('ics_hv', IcsHvController::class); 
    Route::get('ics_hv/index/{id}', [IcsHvController::class, 'index'])->name('ics_hv.index2');

    Route::resource('ics_item_hv', IcsItemHvController::class);
    Route::get('ics_item_hv/index/{id}', [IcsItemHvController::class, 'index'])->name('ics_item_hv.index2');    
    Route::get('ics_item_hv/create/{id}', [IcsItemHvController::class, 'create'])->name('ics_item_hv.create2');

    Route::resource('ics_lv', IcsLvController::class); 
    Route::get('ics_lv/index/{id}', [IcsLvController::class, 'index'])->name('ics_lv.index2');

    Route::resource('ics_item_lv', IcsItemLvController::class);
    Route::get('ics_item_lv/index/{id}', [IcsItemLvController::class, 'index'])->name('ics_item_lv.index2');    
    Route::get('ics_item_lv/create/{id}', [IcsItemLvController::class, 'create'])->name('ics_item_lv.create2');

    //PAR
    Route::resource('par', ParController::class); 
    Route::get('par/index/{id}', [ParController::class, 'index'])->name('par.index2');

    Route::resource('par_item', ParItemController::class);
    Route::get('par_item/index/{id}', [ParItemController::class, 'index'])->name('par_item.index2');    
    Route::get('par_item/create/{id}', [ParItemController::class, 'create'])->name('par_item.create2');
    Route::get('par_item/transfer/{id}', [ParItemController::class, 'transfer'])->name('par_item.transfer');

    //Recipient
    Route::resource('semi_expendable_lv_recipient', SpLvRecipientController::class); 
    Route::resource('semi_expendable_hv_recipient', SpHvRecipientController::class); 
    Route::resource('ppe_recipient', PpeRecipientController::class); 

    //RRSP
    Route::resource('rrsp_hv', RrspHvController::class); 
    Route::get('rrsp_hv/index/{id}', [RrspHvController::class, 'index'])->name('rrsp_hv.index2');

    Route::resource('rrsp_item_hv', RrspItemHvController::class);
    Route::get('rrsp_item_hv/index/{id}', [RrspItemHvController::class, 'index'])->name('rrsp_item_hv.index2');    
    Route::get('rrsp_item_hv/create/{id}', [RrspItemHvController::class, 'create'])->name('rrsp_item_hv.create2');

    Route::resource('rrsp_lv', RrspLvController::class); 
    Route::get('rrsp_lv/index/{id}', [RrspLvController::class, 'index'])->name('rrsp_lv.index2');

    Route::resource('rrsp_item_lv', RrspItemLvController::class);
    Route::get('rrsp_item_lv/index/{id}', [RrspItemLvController::class, 'index'])->name('rrsp_item_lv.index2');    
    Route::get('rrsp_item_lv/create/{id}', [RrspItemLvController::class, 'create'])->name('rrsp_item_lv.create2');

    //RRPPE
    Route::resource('rrppe', RrppeController::class); 
    Route::get('rrppe/index/{id}', [RrppeController::class, 'index'])->name('rrppe.index2');
    
    Route::resource('rrppe_item', RrppeItemController::class);
    Route::get('rrppe_item/index/{id}', [RrppeItemController::class, 'index'])->name('rrppe_item.index2');    
    Route::get('rrppe_item/create/{id}', [RrppeItemController::class, 'create'])->name('rrppe_item.create2');

    //RSPI
    Route::resource('rspi_hv', RspiHvController::class);
    Route::resource('rspi_lv', RspiLvController::class);

    //RPPEI
    Route::resource('rppei', RppeiController::class);
    
    //RegSPI
    Route::resource('regspi_hv', RegspiHvController::class);
    Route::resource('regspi_lv', RegspiLvController::class);

    //RegPPEI
    Route::resource('regppei', RegppeiController::class);

    //RPCI
    Route::resource('rpci', RpciController::class);

    //RPCSP
    Route::get('rpcsp/create_from_ics_hv', [RpcspController::class, 'createFromIcsHv'])->name('rpcsp.create_from_ics_hv'); 
    Route::post('rpcsp/store_from_ics_hv', [RpcspController::class, 'storeFromIcsHv'])->name('rpcsp.store_from_ics_hv'); 
    Route::resource('rpcsp', RpcspController::class);

    //RPCPPE
    Route::get('rpcppe/create_from_par', [RpcppeController::class, 'createFromPar'])->name('rpcppe.create_from_par'); 
    Route::post('rpcppe/store_from_par', [RpcppeController::class, 'storeFromPar'])->name('rpcppe.store_from_par'); 
    Route::resource('rpcppe', RpcppeController::class);

    //IIRUP
    Route::get('iirup/create_from_rpcppe', [IirupController::class, 'createFromRpcppe'])->name('iirup.create_from_rpcppe'); 
    Route::post('iirup/store_from_rpcppe', [IirupController::class, 'storeFromRpcppe'])->name('iirup.store_from_rpcppe'); 
    Route::resource('iirup', IirupController::class);
    Route::get('iirup/index/{id}', [IirupController::class, 'index'])->name('iirup.index2');
    
    Route::resource('iirup_item', IirupItemController::class);
    Route::get('iirup_item/index/{id}', [IirupItemController::class, 'index'])->name('iirup_item.index2');    
    Route::get('iirup_item/create/{id}', [IirupItemController::class, 'create'])->name('iirup_item.create2');
    Route::get('iirup_item/create_from_rpcppe/{id}', [IirupItemController::class, 'createFromRpcppe'])->name('iirup_item.create_from_rpcppe'); 
    Route::post('iirup_item/store_from_rpcppe', [IirupItemController::class, 'storeFromRpcppe'])->name('iirup_item.store_from_rpcppe'); 
    
    //IIRUSP
    Route::get('iirusp/create_from_rpcsp', [IiruspController::class, 'createFromRpcsp'])->name('iirusp.create_from_rpcsp'); 
    Route::post('iirusp/store_from_rpcsp', [IiruspController::class, 'storeFromRpcsp'])->name('iirusp.store_from_rpcsp'); 
    Route::resource('iirusp', IiruspController::class);
    Route::get('iirusp/index/{id}', [IiruspController::class, 'index'])->name('iirusp.index2');
    
    Route::resource('iirusp_item', IiruspItemController::class);
    Route::get('iirusp_item/index/{id}', [IiruspItemController::class, 'index'])->name('iirusp_item.index2');    
    Route::get('iirusp_item/create/{id}', [IiruspItemController::class, 'create'])->name('iirusp_item.create2');
    Route::get('iirusp_item/create_from_rpcsp/{id}', [IiruspItemController::class, 'createFromRpcsp'])->name('iirusp_item.create_from_rpcsp'); 
    Route::post('iirusp_item/store_from_rpcsp', [IiruspItemController::class, 'storeFromRpcsp'])->name('iirusp_item.store_from_rpcsp'); 

    //Stock
    Route::resource('stock', StockController::class);
    Route::resource('stock_card', StockCardController::class);
    Route::get('stock_card/index/{id}', [StockCardController::class, 'index'])->name('stock_card.index2'); 
    
    //Semi-Expendable
    Route::resource('semi_expendable_hv', SemiExpendableHvController::class);
    Route::resource('semi_expendable_card_hv', SemiExpendableCardHvController::class);
    Route::get('semi_expendable_card_hv/index/{id}', [SemiExpendableCardHvController::class, 'index'])->name('semi_expendable_card_hv.index2');
    
    Route::resource('semi_expendable_lv', SemiExpendableLvController::class);
    Route::resource('semi_expendable_card_lv', SemiExpendableCardLvController::class);
    Route::get('semi_expendable_card_lv/index/{id}', [SemiExpendableCardLvController::class, 'index'])->name('semi_expendable_card_lv.index2');  
    
    //Property
    Route::resource('property', PropertyController::class);
    Route::resource('property_card', PropertyCardController::class);
    Route::get('property_card/index/{id}', [PropertyCardController::class, 'index'])->name('property_card.index2'); 

    //Print
    Route::get('checked_ppmp_print/{from?}/{to?}', [PpmpCheckedPrintController::class, 'print'])->name('checked_ppmp_print');
    Route::get('checked_purchase_request_print/{from?}/{to?}', [PrCheckedPrintController::class, 'print'])->name('checked_purchase_request_print');
    Route::get('purchase_order_check_print/{id?}', [PoPrintController::class, 'print_check'])->name('purchase_order_print_check');
    Route::get('iar_print/{id?}', [IarPrintController::class, 'print'])->name('iar_print');
    Route::get('nod_print/{id?}', [NodPrintController::class, 'print'])->name('nod_print');
    Route::get('ris_print/{id?}', [RisPrintController::class, 'print'])->name('ris_print');
    Route::get('rsmi_print/{id?}', [RsmiPrintController::class, 'print'])->name('rsmi_print');
    Route::get('ics_hv_consol_print/{id?}', [IcsHvPrintController::class, 'print_consol'])->name('ics_hv_consol_print');
    Route::get('ics_hv_print/{id?}', [IcsHvPrintController::class, 'print'])->name('ics_hv_print');
    Route::get('ics_lv_print/{id?}', [IcsLvPrintController::class, 'print'])->name('ics_lv_print');
    Route::get('par_print/{id?}', [ParPrintController::class, 'print'])->name('par_print');
    Route::get('rrsp_hv_print/{id?}', [RrspPrintController::class, 'print_hv'])->name('rrsp_hv_print');
    Route::get('rrsp_lv_print/{id?}', [RrspPrintController::class, 'print_lv'])->name('rrsp_lv_print');
    Route::get('rrppe_print/{id?}', [RrppePrintController::class, 'print'])->name('rrppe_print');
    Route::get('rspi_hv_print/{from?}/{to?}', [RspiPrintController::class, 'print_hv'])->name('rspi_hv_print');
    Route::get('rspi_lv_print/{from?}/{to?}', [RspiPrintController::class, 'print_lv'])->name('rspi_lv_print');
    Route::get('rppei_print/{from?}/{to?}', [RppeiPrintController::class, 'print'])->name('rppei_print');
    Route::get('regspi_hv_print/{from?}/{to?}/{type?}', [RegspiPrintController::class, 'print_hv'])->name('regspi_hv_print');
    Route::get('regspi_lv_print/{from?}/{to?}/{type?}', [RegspiPrintController::class, 'print_lv'])->name('regspi_lv_print');
    Route::get('regppei_print/{from?}/{to?}/{type?}', [RegppeiPrintController::class, 'print'])->name('regppei_print');
    Route::get('rpci_print/{from?}/{to?}/{type?}', [RpciPrintController::class, 'print'])->name('rpci_print');
    Route::get('rpcsp_print/{from?}/{to?}/{type?}', [RpcspPrintController::class, 'print'])->name('rpcsp_print');
    Route::get('rpcppe_print/{from?}/{to?}/{type?}', [RpcppePrintController::class, 'print'])->name('rpcppe_print');
    Route::get('stock_card_print/{id?}', [StockCardPrintController::class, 'print'])->name('stock_card_print');
    Route::get('semi_expendable_card_hv_print/{id?}', [SemiExpendableCardPrintController::class, 'print_hv'])->name('semi_expendable_card_hv_print');
    Route::get('semi_expendable_card_lv_print/{id?}', [SemiExpendableCardPrintController::class, 'print_lv'])->name('semi_expendable_card_lv_print');
    Route::get('property_card_print/{id?}', [PropertyCardPrintController::class, 'print'])->name('property_card_print');
    Route::get('iirup_print/{id?}', [IirupPrintController::class, 'print'])->name('iirup_print');
    Route::get('iirusp_print/{id?}', [IiruspPrintController::class, 'print'])->name('iirusp_print');

    //Migration;
    Route::get('purchase_request_migration', [MigrationController::class, 'purchase_request_migration'])->name('purchase_request.migration');
    Route::post('purchase_request_migration_execute', [MigrationController::class, 'purchase_request_migration_execute'])->name('purchase_request_migration.execute');
    Route::get('purchase_order_migration', [MigrationController::class, 'purchase_order_migration'])->name('purchase_order.migration');
    Route::post('purchase_order_migration_execute', [MigrationController::class, 'purchase_order_migration_execute'])->name('purchase_order_migration.execute');
    Route::get('iar_migration', [MigrationController::class, 'iar_migration'])->name('iar.migration');
    Route::post('iar_migration_execute', [MigrationController::class, 'iar_migration_execute'])->name('iar_migration.execute');
    Route::get('migration_dashboard', [MigrationController::class, 'migration_dashboard'])->name('migration.dashboard');

});

//Budget
Route::group(['prefix' => 'budget', 'as' => 'budget.', 'namespace' => 'Budget', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //PPMP Verify
    Route::get('ppmp_verify/verified', [PpmpVerifyController::class, 'verifiedPpmp'])->name('ppmp_verify.verified'); 
    Route::resource('ppmp_verify', PpmpVerifyController::class); 
    Route::post('ppmp_verify/approve/{id?}', [PpmpVerifyController::class, 'approve'])->name('ppmp_verify.approve');

    Route::resource('ppmp_item_verify', PpmpItemVerifyController::class);
    Route::get('ppmp_item_verify/index/{id}', [PpmpItemVerifyController::class, 'index'])->name('ppmp_item_verify.index2');

    //Purchase Request Verify
    Route::get('purchase_request_verify/verified', [PrVerifyController::class, 'verifiedPr'])->name('purchase_request_verify.verified'); 
    Route::resource('purchase_request_verify', PrVerifyController::class); 
    Route::post('purchase_request_verify/approve/{id?}', [PrVerifyController::class, 'approve'])->name('purchase_request_verify.approve');
    
    Route::resource('purchase_request_item_verify', PrItemVerifyController::class);
    Route::get('purchase_request_item_verify/index/{id}', [PrItemVerifyController::class, 'index'])->name('purchase_request_item_verify.index2');

    //Fund Allocation
    Route::delete('fund_allocation/destroy', 'FundAllocationController@massDestroy')->name('fund_allocation.massDestroy');
    Route::post('fund_allocation/parse-csv-import', 'FundAllocationController@parseCsvImport')->name('fund_allocation.parseCsvImport');
    Route::post('fund_allocation/process-csv-import', 'FundAllocationController@processCsvImport')->name('fund_allocation.processCsvImport');
    Route::resource('fund_allocation', FundAllocationController::class);
    
    Route::get('fund_allocation_details/index/{id}', [FundAllocationDetailsController::class, 'index'])->name('fund_allocation_details.index2');

    //Fund Obligation
    Route::delete('fund_obligation/destroy', 'FundObligationController@massDestroy')->name('fund_obligation.massDestroy');
    Route::resource('fund_obligation', FundObligationController::class); 

    //Printing
    Route::get('verified_ppmp_print/{from?}/{to?}', [PpmpVerifiedPrintController::class, 'print'])->name('verified_ppmp_print');
    Route::get('verified_purchase_request_print/{from?}/{to?}', [PrVerifiedPrintController::class, 'print'])->name('verified_purchase_request_print');
});

//SDS
Route::group(['prefix' => 'sds', 'as' => 'sds.', 'namespace' => 'Sds', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //PPMP Approve
    Route::resource('ppmp_approve', PpmpApproveController::class); 
    Route::post('ppmp_approve/approve/{id?}', [PpmpApproveController::class, 'approve'])->name('ppmp_approve.approve');

    Route::resource('ppmp_item_approve', PpmpItemApproveController::class);
    Route::get('ppmp_item_approve/index/{id}', [PpmpItemApproveController::class, 'index'])->name('ppmp_item_approve.index2');

    //Purchase Request Approve
    Route::resource('purchase_request_approve', PrApproveController::class); 
    Route::post('purchase_request_approve/approve/{id?}', [PrApproveController::class, 'approve'])->name('purchase_request_approve.approve');
    
    Route::resource('purchase_request_item_approve', PrItemApproveController::class);
    Route::get('purchase_request_item_approve/index/{id}', [PrItemApproveController::class, 'index'])->name('purchase_request_item_approve.index2');

});

//BAC
Route::group(['prefix' => 'bac', 'as' => 'bac.', 'namespace' => 'Bac', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Supplier
    Route::delete('supplier/destroy', 'SupplierController@massDestroy')->name('supplier.massDestroy');
    Route::post('supplier/parse-csv-import', 'SupplierController@parseCsvImport')->name('supplier.parseCsvImport');
    Route::post('supplier/process-csv-import', 'SupplierController@processCsvImport')->name('supplier.processCsvImport');
    Route::resource('supplier', SupplierController::class); //This route should be last to avoid conflict with other rooute like massDestroy

    //PPMP Approve
    Route::resource('ppmp_final', FinalPpmpController::class); 
    Route::post('ppmp_final/approve/{id?}', [FinalPpmpController::class, 'approve'])->name('ppmp_final.approve');

    Route::resource('ppmp_item_final', FinalPpmpItemController::class);
    Route::get('ppmp_item_final/index/{id}', [FinalPpmpItemController::class, 'index'])->name('ppmp_item_final.index2');

    //Purchase Request Approve
    Route::resource('purchase_request_final', FinalPrController::class); 
    Route::post('purchase_request_final/approve/{id?}', [FinalPrController::class, 'approve'])->name('purchase_request_final.approve');

    Route::resource('purchase_request_item_final', FinalPrItemController::class);
    Route::get('purchase_request_item_final/index/{id}', [FinalPrItemController::class, 'index'])->name('purchase_request_item_final.index2');

    //Purchase Order
    Route::delete('purchase_order/destroy', 'PoController@massDestroy')->name('purchase_order.massDestroy');
    Route::post('purchase_order/parse-csv-import', 'PoController@parseCsvImport')->name('purchase_order.parseCsvImport');
    Route::post('purchase_order/process-csv-import', 'PoController@processCsvImport')->name('purchase_order.processCsvImport');
    Route::resource('purchase_order', PoController::class); 
    Route::post('purchase_order/approve/{id?}', [PoController::class, 'approve'])->name('purchase_order.approve');

    Route::delete('purchase_order_item/destroy', 'PoItemController@massDestroy')->name('purchase_order_item.massDestroy');
    Route::post('purchase_order_item/parse-csv-import', 'PoItemController@parseCsvImport')->name('purchase_order_item.parseCsvImport');
    Route::post('purchase_order_item/process-csv-import', 'PoItemController@processCsvImport')->name('purchase_order_item.processCsvImport');
    Route::resource('purchase_order_item', PoItemController::class);
    Route::get('purchase_order_item/index/{id}', [PoItemController::class, 'index'])->name('purchase_order_item.index2');
    Route::get('purchase_order_item/create/{id}', [PoItemController::class, 'create'])->name('purchase_order_item.create2');
    Route::get('purchase_order_print/{id?}', [PoPrintController::class, 'print'])->name('purchase_order_print');

    //Request For Quotaion
    Route::delete('request_for_quotation/destroy', 'RfqController@massDestroy')->name('request_for_quotation.massDestroy');
    Route::post('request_for_quotation/parse-csv-import', 'RfqController@parseCsvImport')->name('request_for_quotation.parseCsvImport');
    Route::post('request_for_quotation/process-csv-import', 'RfqController@processCsvImport')->name('request_for_quotation.processCsvImport');
    Route::resource('request_for_quotation', RfqController::class); 

    Route::get('request_for_quotation_item/index/{id}', [RfqItemController::class, 'index'])->name('request_for_quotation_item.index2');
    Route::get('request_for_quotation_print/{id?}', [RfqPrintController::class, 'print'])->name('request_for_quotation_print');

    //APP
    Route::resource('app', AppController::class); 
    Route::post('app/finalize/{id?}', [AppController::class, 'finalize'])->name('app.finalize');
    Route::post('app/revert/{id?}', [AppController::class, 'revert'])->name('app.revert');

    Route::resource('app_item', AppItemController::class); 
    Route::get('app_item/index/{id}', [AppItemController::class, 'index'])->name('app_item.index2');
    Route::get('app_item/create/{id}', [AppItemController::class, 'create'])->name('app_item.create2');
    
    //APP CSE
    Route::resource('app_cse', AppCseController::class); 
    Route::get('app_cse/index/{id}', [AppCseController::class, 'index'])->name('app_cse.index2');
    Route::get('app_cse/create/{id}', [AppCseController::class, 'create'])->name('app_cse.create2');

    //APP Non CSE
    Route::resource('app_non_cse', AppNonCseController::class); 
    Route::get('app_non_cse/index/{id}', [AppNonCseController::class, 'index'])->name('app_non_cse.index2');
    Route::get('app_non_cse/create/{id}', [AppNonCseController::class, 'create'])->name('app_non_cse.create2');

    //APP Print    
    Route::get('app_print/{id?}', [AppPrintController::class, 'app_print'])->name('app_print');
    Route::get('app_cse_print/{id?}', [AppPrintController::class, 'app_cse_print'])->name('app_cse_print');
    Route::get('app_non_cse_print/{id?}', [AppPrintController::class, 'app_non_cse_print'])->name('app_non_cse_print');


});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
