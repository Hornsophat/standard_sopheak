<?php
$serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
$serial = explode("\n", $serial);
$serial_arr = [];
foreach ($serial as  $value) {
    $serial_arr[] = trim(str_replace(' ', '', $value));
}
Route::redirect('/', 'dashboard');
Auth::routes();
Route::middleware(['auth'])->group(function () {
	// Dashboard
	Route::get('dashboard', 'DashboardController@index');
    Route::get('locale/{locale}',function($locale){
        Session::put('locale',$locale);
        return redirect()->back();
    });
    //Address
    Route::get('address/get_districts', 'AddressController@get_districts')->name('get_districts');
    Route::get('address/get_communes', 'AddressController@get_communes')->name('get_communes');
    Route::get('address/get_villages', 'AddressController@get_villages')->name('get_villages');
    // CRUD Land
    Route::get('land', 'LandController@index')->name('land');
    Route::get('land/create', 'LandController@create')->name('landCreate');
    Route::post('land/create', 'LandController@store');
    Route::get('land/{id}/edit/{land_owner_id?}', 'LandController@edit')->name('editLand');
    Route::get('land/land_owner/delete/{id}', 'LandController@deleteLandOwner')->name('deleteLandOwner');
    Route::post('land/{id}/edit', 'LandController@update');
    Route::get('land/delete/{id}', 'LandController@destroy');
    Route::post('land/land-owner/{land_id}', 'LandController@createLandOwner')->name("createLandOwner");
    Route::post('getAddress','LandController@getAddress');
    Route::post('land/block_land/{land_id}','LandController@blockLand')->name('blockLand');
    Route::get('land/delete_block_land/{block_land_id}','LandController@deleteBlockLand')->name('deleteBlockLand');
    // CRUD Project
    Route::get('project', 'ProjectController@index')->name('project');
    Route::get('project/create', 'ProjectController@create')->name('projectCreate');
    Route::post('project/create', 'ProjectController@store');
    Route::get('project/{id}/detail', 'ProjectController@show')->name('projectDetail');
    Route::get('project/{id}/edit', 'ProjectController@edit')->name('editProject');
    Route::post('project/{id}/edit', 'ProjectController@update');
    Route::get('project/delete/{id}', 'ProjectController@destroy');
    Route::get('project/delete/image/{id}', 'ProjectController@deleteImage');
    Route::get('project/commission/{project_id}', 'SaleCommissionController@index');
    Route::post('project/commission/{project_id}/store', 'SaleCommissionController@store')->name("storeCommission");
    Route::get('project/commission/{commission_id}/{status}/changeStatus', 'SaleCommissionController@changeStatus')->name("changeStatus");
    Route::get('project/commission/{id}/delete', 'SaleCommissionController@delete')->name("deleteCommission");
    // CRUD Project Zone
    Route::get('projectzone/index/{project_id?}', 'ProjectZoneController@index')->name('projectzone');
    Route::get('projectzone/create', 'ProjectZoneController@create')->name('projectzoneCreate');
    Route::post('projectzone/create', 'ProjectZoneController@store');
    Route::get('projectzone/{id}/edit', 'ProjectZoneController@edit')->name('editProjectzone');
    Route::post('projectzone/{id}/edit', 'ProjectZoneController@update');
    Route::get('projectzone/delete/{id}', 'ProjectZoneController@destroy');
    ///property section
    //CRUD Vehicle
    Route::get('vehicle', 'PropertyController@vehicle')->name('vehicle');
    Route::get('others', 'PropertyController@others')->name('others');
    Route::get('loan_view/{loan_type}', 'PropertyController@loan_view')->name('loan_view');
    // CRUD Property
    Route::post('upload/pdf', 'SalePropertyController@uploadPdf');
    Route::get('property', 'PropertyController@others')->name('property');
    Route::get('property/create', 'PropertyController@create')->name('propertyCreate');
    Route::get('property/vehicle/create', 'PropertyController@vehicle_create')->name('vehicleCreate');
    Route::get('property/others/create', 'PropertyController@others_create')->name('othersCreate');
    Route::post('property/create', 'PropertyController@store');
    Route::post('property/others/create', 'PropertyController@othersStore');
    Route::post('property/vehicle/create', 'PropertyController@vehicleStore');
    Route::get('property/{id}/detail', 'PropertyController@show')->name('propertyDetail');
    Route::get('property/{id}/edit', 'PropertyController@edit')->name('editProperty');
    Route::get('property/vehicle/{id}/edit', 'PropertyController@edit_vehicle')->name('editVehicle');
    Route::get('property/others/{id}/edit', 'PropertyController@edit_others')->name('editOthers');
    Route::post('property/others/{id}/edit', 'PropertyController@update_others');
    Route::post('property/vehicle/{id}/edit', 'PropertyController@update_vehicle');
    Route::post('property/{id}/edit', 'PropertyController@update');
    Route::get('property/delete/{id}', 'PropertyController@destroy');
    Route::get('property/delete/image/{id}', 'PropertyController@deleteImage');
    Route::get('property/get-zone-ajax/{id}', 'PropertyController@getZoneAjax');
    Route::get('property/others/{id}/duplicate', 'PropertyController@duplicate')->name('property.others.duplicate');
    Route::match(['get', 'post'],'property/marge', 'PropertyController@merge')->name('property_merge');
    Route::get('property/merge_get_property', 'PropertyController@merge_get_property')->name('merge_get_property');
    Route::get('property/cancel_merge_property/{id}', 'PropertyController@cancel_merge')->name('property.cancel_merge');
    // CRUD Property Type
    Route::get('propertytype', 'PropertyTypeController@index')->name('propertytype');
    Route::get('propertytype/create', 'PropertyTypeController@create')->name('propertytypeCreate');
    Route::post('propertytype/create', 'PropertyTypeController@store');
    Route::get('propertytype/{id}/edit', 'PropertyTypeController@edit')->name('editPropertytype');
    Route::post('propertytype/{id}/edit', 'PropertyTypeController@update');
    Route::get('propertytype/delete/{id}', 'PropertyTypeController@destroy');
   // Route::resource('items', 'ProductController');
    Route::get('product/{id}/delete', 'ProductController@destroy');
    Route::get('product', 'ProductController@index')->name('productList');
    Route::get('product/create', 'ProductController@create')->name('productCreate');
    Route::post('product/create', 'ProductController@store');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('productEdit');
    Route::post('product/edit/{id}', 'ProductController@update');
    // Route::resource('receivings', 'ReceivingController');
    // Route::resource('receiving-item', 'ReceivingItemController');
    Route::get('sale/payment-paid/{id}', 'SaleController@salePaymentPaid')->name("salePaymentPaid");
    Route::get('sale/payment/{id}', 'SaleController@payment')->name("salePayment");
    Route::get('sale/get-property-by-zone/{id}', 'SaleController@getPropertyByZone');
    Route::get('sale/get-customer-ajax/{id}', 'SaleController@getCustomerAjax');
    Route::get('sale/get-project-ajax/{id}', 'SaleController@getProjectAjax');
    Route::get('sale/get-payment-ajax/{id}', 'SaleController@getPaymentDetailAjax');
    Route::get('sale/get-employee-ajax/{id}', 'SaleController@getEmployeeAjax');
    Route::get('sale/post-actual-payment-date-ajax', 'SaleController@saleActaulPaymentDateAjay');
    Route::resource('sale', 'SaleController');
    Route::resource('payment-timeline', 'PaymentTimelineController');
    Route::get('payment/delete/{id}', 'PaymentTimelineController@destroy');
    Route::get('sale/{id}/show', 'SaleController@show')->name("viewSale");
    Route::get('sale/complete-sale/{id}', 'SaleController@completeSale')->name("completeSale");
    Route::get('sale/cancel-sale/{id}', 'SaleController@cancelSale')->name("cancelSale");
    Route::get('sale/contract/{id}', 'SaleController@contract')->name('sale.contract');
    Route::get('sale/contractLand/{id}', 'SaleController@contractLand')->name('sale.contractLand');
    Route::get('sale/contractother/{id}', 'SaleController@contractother')->name('sale.contractother');
    Route::get('sale/receipt/{sale_id}/{id}', 'SaleController@receipt')->name('sale.receipt');
    Route::get('sale/invoice/{id}', 'SaleController@invoice')->name('sale.invoice');
    Route::get('roles','RoleController@index')->name('roles');
    Route::get('roles/create','RoleController@create')->name('role.create');
    Route::post('roles/create','RoleController@store')->name('role.store');
    Route::get('roles/{id}/edit','RoleController@edit')->name('role.edit');
    Route::post('roles/{id}','RoleController@update')->name('role.update');
    Route::get('roles/{id}/delete','RoleController@destroy')->name('role.destroy');
    Route::get('users','UserController@index')->name('users');
    Route::get('users/create','UserController@create')->name('user.create');
    Route::post('users/store','UserController@store')->name('user.store');
    Route::get('users/{id}/delete','UserController@destroy');
    Route::get('users/{id}/edit','UserController@edit')->name('user.edit');
    Route::post('users/{id}/edit','UserController@update')->name('user.edit');
    Route::get('expense/get-item/{expense_type}', 'ExpenseController@getItem');
    Route::post('expense/store/{project_id}', 'ExpenseController@store');
    Route::get('contract','ContractController@index')->name('contract');
    Route::get('invoice','ContractController@index1')->name('invoice');
    Route::get('contract_cus_house','ContractController@contract_cus_house')->name('contract_cus_house');
    Route::get('contract_cus_land','ContractController@contract_cus_land')->name('contract_cus_land');
    // CRUD Customer
    Route::get('customer', 'CustomerController@index')->name('listCustomer');
    Route::get('customer/add', 'CustomerController@create')->name('addCustomer');
    Route::post('customer/store', 'CustomerController@store')->name('storeCustomer');
    Route::get('customer/{id}/edit', 'CustomerController@edit')->name('editCustomer');
    Route::post('customer/{id}/update', 'CustomerController@update')->name('updateCustomer');
    Route::get('customer/{id}/delete', 'CustomerController@destroy');
    Route::get('customer/{id}/view', 'CustomerController@show')->name('viewCustomer');
    Route::get('customer/{id}/visit', 'CustomerController@visit')->name('visitCustomer');
    Route::post('customer/{id}/customerVisit', 'CustomerController@customerVisit')->name("storeVisit");
    Route::get('customer/{customer_id}/{sale_id}/{remark}/change-sale', 'CustomerController@changeSale');
    Route::get('employee', 'EmployeeController@index')->name('listEmployee');
    Route::get('employee/add', 'EmployeeController@create')->name('addEmployee');
    Route::post('employee/store', 'EmployeeController@store')->name('saveEmployee');
    Route::get('employee/{id}/edit', 'EmployeeController@edit')->name('editEmployee');
    Route::post('employee/{id}/update', 'EmployeeController@update')->name('updateEmployee');
    Route::get('employee/{id}/delete', 'EmployeeController@destroy');
    Route::get('employee/{id}/view', 'EmployeeController@show')->name('viewEmployee');
    Route::get('setting/config', 'SettingController@index');
    Route::post('setting/save', 'SettingController@store');
    Route::get('position/delete/{id}', 'PositionController@delete')->name('position.delete');
    Route::post('position/ajax-store', 'PositionController@ajaxStore')->name('position.ajax-store');
    Route::resource('position', 'PositionController');
    Route::get('department/delete/{id}', 'DepartmentController@delete')->name('department.delete');
    Route::post('department/ajax-store', 'DepartmentController@ajaxStore')->name('department.ajax-store');
    Route::resource('department', 'DepartmentController');
    Route::get('sale-type/delete/{id}', 'SaleTypeController@delete')->name('sale-type.delete');
    Route::post('sale-type/ajax-store', 'SaleTypeController@ajaxStore')->name('sale-type.ajax-store');
    Route::resource('sale-type', 'SaleTypeController');
    Route::get('user/profile/{id}', 'ShowProfile')->name('user.profile');
    Route::post('user/profile/{id}', 'UpdateProfile')->name('user.profile');
    Route::get('user/change-password', 'ChangePassword')->name('user.change-password');
    Route::post('user/update-password', 'UpdatePassword')->name('user.update-password');
    // Route::get('report', 'ReportController@index')->name('report.index');
    // Route::get('report/pdf', 'ReportController@exportToPdfFile')->name('report.pdf');
    // Route::get('report/excel', 'ReportController@exportToExcelFile')->name('report.excel');
    Route::get('report', 'ReportController@index')->name('report.index');
    Route::get('late_payment', 'ReportController@late_payment')->name('late_payment');
    Route::get('land_report', 'ReportController@land_report')->name('land_report');
    Route::get('zone_report', 'ReportController@zone_report')->name('zone_report');
    Route::get('customer_report', 'ReportController@customer_report')->name('customer_report');
    Route::get('property_report', 'ReportController@property_report')->name('property_report');
    Route::get('project_report', 'ReportController@project_report')->name('project_report');
    Route::get('sale_report', 'ReportController@sale_report')->name('sale_report');
    Route::get('payment_report', 'ReportController@payment_report')->name('payment_report');
    Route::get('deposit_report', 'ReportController@deposit_report')->name('deposit_report');
    Route::get('commission_report', 'ReportController@commission_report')->name('commission_report');
    Route::get('receivable_report', 'ReportController@receivable_report')->name('receivable_report');
    Route::get('expense_report', 'ReportController@expense_report')->name('expense_report');
    Route::get('purchase_report', 'ReportController@purchase_report')->name('purchase_report');
    Route::get('purchase_detail_report', 'ReportController@purchase_detail_report')->name('purchase_detail_report');
    Route::get('loan_report', 'ReportController@loan_report')->name('loan_report');
    Route::get('property_price_report', 'ReportController@property_price_report')->name('property_price_report');
    Route::get('sale_detail_report', 'ReportController@sale_detail_report')->name('sale_detail_report');
    
    Route::get('report/pdf', 'ReportController@exportToPdfFile')->name('report.pdf');
    Route::get('report/excel', 'ReportController@exportToExcelFile')->name('report.excel');
    Route::get('get_project_by_land', 'ReportController@get_project_by_land')->name('get_project_by_land');
    Route::get('get_zone_by_pro', 'ReportController@get_zone_by_pro')->name('get_zone_by_pro');
    // ===========================  Expense Group ===================
    Route::get('expense_group', 'ExpenseGroupController@index')->name('expense_groups');
    Route::match(['get', 'post'],'expense_group/create', 'ExpenseGroupController@create')->name('expense_group.create');
    Route::match(['get', 'post'],'expense_group/{id}/edit', 'ExpenseGroupController@edit')->name('expense_group.edit');
    Route::get('expense_group/{id}/delete', 'ExpenseGroupController@destroy')->name('expense_group.destroy');
    // ===========================  General Expense ===================
    Route::get('general_expense', 'GeneralExpenseController@index')->name('general_expenses');
    Route::get('general_expense/get_employee_salary', 'GeneralExpenseController@get_employee_salary')->name('general_expense.get_employee_salary');
    Route::match(['get', 'post'],'general_expense/create', 'GeneralExpenseController@create')->name('general_expense.create');
    Route::match(['get', 'post'],'general_expense/{id}/edit', 'GeneralExpenseController@edit')->name('general_expense.edit');
    Route::get('general_expense/{id}/delete', 'GeneralExpenseController@destroy')->name('general_expense.destroy');
    // ============================ Unit Product =================
    Route::get('product/unit/list', 'ProductController@unit_list')->name('product.units');
    Route::match(['get', 'post'],'product/unit/create', 'ProductController@unit_create')->name('product.unit.create');
    Route::match(['get', 'post'],'product/unit/edit/{id}', 'ProductController@unit_edit')->name('product.unit.edit');
    // ================================ Category Product ================
    Route::get('product/category/list', 'ProductController@category_list')->name('product.categories');
    Route::match(['get', 'post'],'product/category/create', 'ProductController@category_create')->name('product.category.create');
    Route::match(['get', 'post'],'product/category/edit/{id}', 'ProductController@category_edit')->name('product.category.edit');
    // ====================== Inventory ===============================
    Route::get('inventory/list', 'InventoryController@indexInvetory')->name('inventories');
    Route::match(['get', 'post'],'inventory/purchase', 'InventoryController@inventory_purchase')->name('inventory.purchase');
    Route::match(['get', 'post'],'inventory/retrieve', 'InventoryController@inventory_retrieve')->name('inventory.retrieve');
    // ======================== Supplyer================================
    Route::get('supplyer', 'SupplyerController@index')->name('supplyers');
    Route::get('supplyer/add', 'SupplyerController@create')->name('supplyer.create');
    Route::post('supplyer/store', 'SupplyerController@store')->name('supplyer.store');
    
    Route::get('supplyer/{id}/edit', 'SupplyerController@edit')->name('supplyer.edit');
    Route::post('supplyer/{id}/update', 'SupplyerController@update')->name('supplyer.update');
    Route::get('supplyer/{id}/delete', 'SupplyerController@destroy')->name('supplyer.destroy');
    Route::get('supplyer/{id}/view', 'SupplyerController@show')->name('supplyer.view');
    // ======================== Purchase Product =============================
    Route::get('purchase', 'PurchaseController@index')->name('purchases');
    Route::match(['get', 'post'], 'purchase/create', 'PurchaseController@create')->name('purchase.create');
    Route::match(['get', 'post'], 'purchase/edit/{id}', 'PurchaseController@edit')->name('purchase.edit');
    Route::get('purchase/delete/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::get('purchase/view/{id}', 'PurchaseController@view')->name('purchase.view');
    Route::get('purchase/receive/{id}', 'PurchaseController@receive')->name('purchase.receive');
    // ========================= Subtract Inventory ==========================
    Route::get('subtract_inventory', 'SubtractInventoryController@index')->name('subtract_inventories');
    Route::match(['get', 'post'], 'subtract_inventory/create', 'SubtractInventoryController@create')->name('subtract_inventory.create');
    Route::match(['get', 'post'], 'subtract_inventory/edit/{id}', 'SubtractInventoryController@edit')->name('subtract_inventory.edit');
    Route::get('subtract_inventory/delete/{id}', 'SubtractInventoryController@destroy')->name('subtract_inventory.destroy');
    Route::get('subtract_inventory/view/{id}', 'SubtractInventoryController@view')->name('subtract_inventory.view');
    Route::get('subtract_inventory/receive/{id}', 'SubtractInventoryController@receive')->name('subtract_inventory.receive');
    Route::get('subtract_inventory/get_product', 'SubtractInventoryController@get_product')->name('subtract_inventory.get_product');
    Route::get('subtract_inventory/view_subtract_from_inventory', 'SubtractInventoryController@view_subtract_from_inventory')->name('subtract_inventory.view_subtract_from_inventory');
    //================= Sale Property =====================
    Route::match(['get', 'post'],'property/booking/{property}', 'SalePropertyController@booking')->name('sale_property.booking');
    Route::match(['get', 'post'],'property/edit_booking/{id}', 'SalePropertyController@edit_booking')->name('sale_property.edit_booking');
    Route::match(['get', 'post'],'property/delete_booking/{id}', 'SalePropertyController@delete_booking')->name('sale_property.delete_booking');
    Route::match(['get', 'post'],'property/expire_booking/{id}', 'SalePropertyController@expire_booking')->name('sale_property.expire_booking');
    Route::get('property/view_booking', 'SalePropertyController@view_booking')->name('sale_property.view_booking');
    Route::get('property/print_receipt_booking/{id}', 'SalePropertyController@print_receipt_booking')->name('sale_property.print_receipt_booking');
    Route::match(['get', 'post'],'property/sale/{property}', 'SalePropertyController@sale')->name('sale_property.sale');
    Route::get('pdfsroperty/sale/get_preview_schedule_first_pay','SalePropertyController@get_preview_schedule_first_pay')->name('sale_property.get_preview_schedule_first_pay');
    Route::get('property/view_sale/{property}', 'SalePropertyController@view_sale')->name('sale_property.view_sale');
    Route::match(['get', 'post'],'property/sale/payment/{sale_item}/{loan}', 'SalePropertyController@sale_payment')->name('sale_property.sale_payment');
    Route::get('property/view_sale_first_payment', 'SalePropertyController@view_sale_first_payment')->name('sale_property.view_sale_first_payment');
    Route::get('property/sale_payment_receipt/{id}', 'SalePropertyController@sale_payment_receipt')->name('sale_property.sale_payment_receipt');
    Route::match(['get', 'post'],'property/sale/create_loan/{sale_item}', 'SalePropertyController@create_loan')->name('sale_property.create_loan');
    Route::get('property/get_payment_stage_amount', 'SalePropertyController@get_payment_stage_amount')->name('sale_property.get_payment_stage_amount');
    Route::get('property/sale/loan/get_payment_schedule', 'SalePropertyController@get_payment_schedule')->name('sale_property.get_payment_schedule');
    Route::get('property/sale/loan/view_loan_schedule', 'SalePropertyController@view_loan_schedule')->name('sale_property.view_loan_schedule');
    Route::get('property/sale/loan/view_schedule', 'SalePropertyController@view_schedule')->name('sale_property.view_schedule');
    Route::match(['get', 'post'],'property/loan/payment/{payment_schedule}', 'SalePropertyController@loan_payment')->name('sale_property.loan_payment');
    Route::get('property/view_loan_payment', 'SalePropertyController@view_loan_payment')->name('sale_property.view_loan_payment');
    Route::get('property/loan/cancel_loan_payment', 'SalePropertyController@cancel_loan_payment')->name('sale_property.cancel_loan_payment');
    Route::get('property/loan/cancel_loan', 'SalePropertyController@cancel_loan')->name('sale_property.cancel_loan');
    Route::get('property/loan/cancel_sale', 'SalePropertyController@cancel_sale')->name('sale_property.cancel_sale');
    Route::get('property/loan/cancel_sale_payment', 'SalePropertyController@cancel_sale_payment')->name('sale_property.cancel_sale_payment');
    Route::get('property/sales/sale_contract', 'SalePropertyController@sale_contract')->name('sale_property.sale_contract');
    Route::get('property/sales/print_schedule', 'SalePropertyController@print_schedule')->name('sale_property.print_schedule');
    Route::match(['get', 'post'],'property/sale/paid_off/{sale_item}', 'SalePropertyController@paid_off')->name('sale_property.paid_off');
    Route::get('property/sale_paid_off_receipt/{id}', 'SalePropertyController@sale_paid_off_receipt')->name('sale_property.sale_paid_off_receipt');
    Route::get('property/payment/cancel_approve_cancel_payment', 'SalePropertyController@cancel_approve_cancel_payment')->name('sale_property.cancel_approve_cancel_payment');
    Route::get('property/sales/preview_contarct_sample', 'SalePropertyController@preview_contarct_sample')->name('sale_property.preview_contarct_sample');
    // ==================== Payment Stage ===================
    Route::get('payment_stages', 'PaymentStageController@index')->name('payment_stages');
    Route::match(['get', 'post'], 'payment_stage/create', 'PaymentStageController@create')->name('payment_stage.create');
    Route::match(['get', 'post'], 'payment_stage/edit/{payment_stage}', 'PaymentStageController@edit')->name('payment_stage.edit');
    Route::get('payment_stage/destroy/{payment_stage}', 'PaymentStageController@destroy')->name('payment_stage.destroy');
    //================ public holiday ==============================
    Route::get('public_holiday', 'PublicHolidayController@index')->name('public_holidays');
    Route::match(['get', 'post'], 'public_holiday/create', 'PublicHolidayController@create')->name('public_holiday.create');
    Route::match(['get', 'post'], 'public_holiday/edit/{public_holiday}', 'PublicHolidayController@edit')->name('public_holiday.edit');
    Route::get('public_holiday/delete/{public_holiday}', 'PublicHolidayController@destroy')->name('public_holiday.destroy');
    // Penalty Setting 
    Route::get('setting/penalties', 'PenaltyController@index')->name('penalties');
    Route::match(['get', 'post'], 'setting/penalty/create', 'PenaltyController@create')->name('penalty.create');
    Route::match(['get', 'post'], 'setting/penalty/edit/{penalty}', 'PenaltyController@edit')->name('penalty.edit');
    Route::get('setting/penalty/{penalty}', 'PenaltyController@show')->name('penalty.show');
    Route::get('customer/get_partner', 'PartnerController@get_partner')->name('get_partner');
    //Send Mail
    Route::get('send_mail', 'SendMailController@send_mail')->name('send_mail');
    //settting address
    Route::get('setting/address/provinces', 'ProvinceController@index')->name('setting.address.province.index');
    Route::get('setting/address/province/create', 'ProvinceController@create')->name('setting.address.province.create');
    Route::post('setting/address/province/store', 'ProvinceController@store')->name('setting.address.province.store');
    Route::get('setting/address/province/edit/{id}', 'ProvinceController@edit')->name('setting.address.province.edit');
    Route::post('setting/address/province/update/{id}', 'ProvinceController@update')->name('setting.address.province.update');
    Route::get('setting/address/districts/{province_id}', 'DistrictController@index')->name('setting.address.district.index');
    Route::get('setting/address/district/create/{province_id}', 'DistrictController@create')->name('setting.address.district.create');
    Route::post('setting/address/district/store/{province_id}', 'DistrictController@store')->name('setting.address.district.store');
    Route::get('setting/address/district/edit/{id}', 'DistrictController@edit')->name('setting.address.district.edit');
    Route::post('setting/address/district/update/{id}', 'DistrictController@update')->name('setting.address.district.update');
    Route::get('setting/address/communes/{district_id}', 'CommuneController@index')->name('setting.address.commune.index');
    Route::get('setting/address/commune/create/{district_id}', 'CommuneController@create')->name('setting.address.commune.create');
    Route::post('setting/address/commune/store/{district_id}', 'CommuneController@store')->name('setting.address.commune.store');
    Route::get('setting/address/commune/edit/{id}', 'CommuneController@edit')->name('setting.address.commune.edit');
    Route::post('setting/address/commune/update/{id}', 'CommuneController@update')->name('setting.address.commune.update');
    Route::get('setting/address/villages/{commune_id}', 'VillageController@index')->name('setting.address.village.index');
    Route::get('setting/address/village/create/{commune_id}', 'VillageController@create')->name('setting.address.village.create');
    Route::post('setting/address/village/store/{commune_id}', 'VillageController@store')->name('setting.address.village.store');
    Route::get('setting/address/village/edit/{id}', 'VillageController@edit')->name('setting.address.village.edit');
    Route::post('setting/address/village/update/{id}', 'VillageController@update')->name('setting.address.village.update');
    //add other land address
    Route::post('land/address/add/{land_id}', 'LandController@add_other_address')->name('land.address.add');
    Route::get('land/address_edit', 'LandController@edit_other_address')->name('land.address.edit');
    Route::post('land/address_update/{id}', 'LandController@update_other_address')->name('land.address.update');
    Route::post('sale_item/change_address', 'SalePropertyController@change_address')->name('sale_item.change_address');
    Route::get('sale_item/getchange_partner', 'SalePropertyController@getchange_partner')->name('sale_item.getchange_partner');
    Route::post('sale_item/change_partner', 'SalePropertyController@change_partner')->name('sale_item.change_partner');
    Route::get('handle_data/sale_complete', 'HandleController@handle_sale_complete');
});
?>