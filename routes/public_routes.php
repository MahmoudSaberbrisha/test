<?php


use App\Http\Controllers\Admin\Stocks\Inveentory\StoreInventoryTableController;
use App\Http\Controllers\Admin\Stocks\Items\StoreItemController;
use App\Http\Controllers\Admin\Stocks\Khazina\StoreKhazinaController;
use App\Http\Controllers\Admin\Stocks\Other\StoreOtherSupplierController;
use App\Http\Controllers\Admin\Stocks\Purchase\StoreHadbackPurchaseController;
use App\Http\Controllers\Admin\Stocks\Purchase\StorePurchasesFatoraController;
use App\Http\Controllers\Admin\Stocks\Purchase\StorePurchasesOthersController;
use App\Http\Controllers\Admin\Stocks\Rasid\StoreMasrofAsnafFar3Controller;
use App\Http\Controllers\Admin\Stocks\Rasid\StoreRasidAyniController;
use App\Http\Controllers\Admin\Stocks\Setting\StoreBranchSettingController;
use App\Http\Controllers\Admin\Stocks\Setting\StoreTasnefSettingController;
use App\Http\Controllers\Admin\Stocks\Setting\StoreUnitsSettingController;
use App\Http\Controllers\Admin\Stocks\Tahwelat\StoreTahwelatAsnafController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Settings\ClientSupplierController;
use App\Http\Controllers\Admin\Settings\GoodController;
use App\Http\Controllers\Admin\Settings\JobController;
use App\Http\Controllers\Admin\Settings\PaymentMethodController;
use App\Http\Controllers\Admin\Settings\ClientTypeController;
use App\Http\Controllers\Admin\Settings\SailingBoatController;
use App\Http\Controllers\Admin\Settings\SalesAreaController;
use App\Http\Controllers\Admin\Settings\GoodSupplierController;
use App\Http\Controllers\Admin\Settings\ExpensesTypeController;
use App\Http\Controllers\Admin\Settings\ExperienceTypeController;
use App\Http\Controllers\Admin\ClientsManagement\ClientController;
use App\Http\Controllers\Admin\ClientsManagement\FeedBackController;
use App\Http\Controllers\Admin\BookingManagement\BookingController;
use App\Http\Controllers\Admin\BookingManagement\BookingGroupController;
use App\Http\Controllers\Admin\ExtraServicesManagement\ExtraServiceController;
use App\Http\Controllers\Admin\ExtraServicesManagement\BookingGroupServiceController;
use App\Http\Controllers\Admin\FinancialManagement\AccountTypeController;
use App\Http\Controllers\Admin\FinancialManagement\AccountController;
use App\Http\Controllers\Admin\FinancialManagement\ExpensesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeTypeController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeNationalityController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeReligionController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeMaritalStatusController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeIdentityTypeController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeCardIssuerController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeesController;
use App\Http\Controllers\Admin\CarManagement\CarSupplierController;
use App\Http\Controllers\Admin\CarManagement\CarContractController;
use App\Http\Controllers\Admin\CarManagement\CarExpensesController;
use App\Http\Controllers\Admin\CarManagement\CarTaskController;

Route::get('/{home?}', [DashboardController::class, 'index'])->where('home', 'dashboard')->name('dashboard');

Route::prefix('settings')->group(function () {
    //Client Suppliers Settings
    Route::resource('client-suppliers', ClientSupplierController::class)->except(['create', 'edit', 'show']);
    Route::post('client-suppliers/changeActive', [ClientSupplierController::class, 'changeActive'])->name('client-supplier-active');
    //Goods Settings
    Route::resource('goods', GoodController::class)->except(['create', 'edit', 'show']);
    Route::post('goods/changeActive', [GoodController::class, 'changeActive'])->name('goods-active');
    //Payment Methods Settings
    Route::resource('payment-methods', PaymentMethodController::class)->except(['create', 'edit', 'show']);
    Route::post('payment-methods/changeActive', [PaymentMethodController::class, 'changeActive'])->name('payment-method-active');
    //Client Types Settings
    Route::resource('client-types', ClientTypeController::class)->except(['create', 'edit', 'show']);
    Route::post('client-types/changeActive', [ClientTypeController::class, 'changeActive'])->name('client-type-active');
    //Sailing Boats Settings
    Route::resource('sailing-boats', SailingBoatController::class)->except(['create', 'edit', 'show']);
    Route::post('sailing-boats/changeActive', [SailingBoatController::class, 'changeActive'])->name('sailing-boat-active');
    //Sales Areas Settings
    Route::resource('sales-areas', SalesAreaController::class)->except(['create', 'edit', 'show']);
    Route::post('sales-areas/changeActive', [SalesAreaController::class, 'changeActive'])->name('sales-area-active');
    //Goods Settings
    Route::resource('goods-suppliers', GoodSupplierController::class)->except(['create', 'edit', 'show']);
    Route::post('goods-suppliers/changeActive', [GoodSupplierController::class, 'changeActive'])->name('goods-suppliers-active');
    //Expenses Types
    Route::resource('expenses-types', ExpensesTypeController::class)->except(['create', 'edit', 'show']);
    Route::post('expenses-types/changeActive', [ExpensesTypeController::class, 'changeActive'])->name('expenses-type-active');
    //Experience Types
    Route::resource('experience-types', ExperienceTypeController::class)->except(['create', 'edit', 'show']);
    Route::post('experience-types/changeActive', [ExperienceTypeController::class, 'changeActive'])->name('experience-type-active');
});

Route::prefix('clients-management')->group(function () {
    //Clients
    Route::resource('clients', ClientController::class)->except(['create', 'edit', 'show']);
    Route::post('clients/changeActive', [ClientController::class, 'changeActive'])->name('client-active');
    Route::post('clients/import-excel', [ClientController::class, 'importExcel'])->name('import-excel');
    Route::get('clients/client-booking/{id}', [ClientController::class, 'clientBooking'])->name('booking-client');
    //Feedbacks
    Route::resource('feedbacks', FeedBackController::class);
});

Route::prefix('booking-management')->group(function () {
    //Booking
    Route::resource('bookings', BookingController::class);
    Route::get('bookings/client-booking/{id}', [BookingController::class, 'clientBooking'])->name('client-booking');
    Route::get('bookings/get-groups/{id}', [BookingController::class, 'getGroups'])->name('get-groups');
    Route::get('bookings/print-reservation-data-pdf/{id}', [BookingController::class, 'printPdf'])->name('print-reservation-data-pdf');
    Route::get('bookings/print-reservation-data-excel/{id}', [BookingController::class, 'printExcel'])->name('print-reservation-data-excel');
    //Booking Groups
    Route::resource('booking-groups', BookingGroupController::class);
    Route::post('booking-groups/changeActive', [BookingGroupController::class, 'changeActive'])->name('booking-group-active');
    Route::get('booking-groups/print-invoice/{id}', [BookingGroupController::class, 'printPdf'])->name('print-invoice');
    Route::get('booking-groups/booking-group-extra-services/{id}', [BookingGroupController::class, 'bookingGroupExtraServices'])->name('booking-group-extra-services');
});

Route::prefix('extra-services-management')->group(function () {
    //Extra Services
    Route::resource('extra-services', ExtraServiceController::class);
    Route::post('extra-services/changeActive', [ExtraServiceController::class, 'changeActive'])->name('extra-service-active');
    //Booking Extra Services
    Route::resource('booking-extra-services', BookingGroupServiceController::class);
    Route::get('booking-extra-services/get-services/{id}', [BookingGroupServiceController::class, 'getServices'])->name('get-services');
    Route::delete('booking-extra-services/delete-service/{id}', [BookingGroupServiceController::class, 'deleteService'])->name('delete-service');
    Route::get('booking-extra-services/print-service-invoices/{id}', [BookingGroupServiceController::class, 'printMultiPdf'])->name('print-service-invoices');
    Route::get('booking-extra-services/print-service-invoice/{id}', [BookingGroupServiceController::class, 'printPdf'])->name('print-service-invoice');
});

Route::prefix('financial-management')->group(function () {
    //Account Types
    Route::resource('account-types', AccountTypeController::class);
    Route::post('account-types/changeActive', [AccountTypeController::class, 'changeActive'])->name('account-type-active');
    //Account
    Route::resource('accounts', AccountController::class);
    Route::post('accounts/changeActive', [AccountController::class, 'changeActive'])->name('account-active');
    //Expanses
    Route::resource('expenses', ExpensesController::class);
});

Route::prefix('employees-management')->group(function () {
    //Employee Types
    Route::resource('employee-types', EmployeeTypeController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-types/changeActive', [EmployeeTypeController::class, 'changeActive'])->name('employee-types-active');
    //Employee Nationality
    Route::resource('employee-nationalities', EmployeeNationalityController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-nationalities/changeActive', [EmployeeNationalityController::class, 'changeActive'])->name('employee-nationalities-active');
    //Employee Religion
    Route::resource('employee-religions', EmployeeReligionController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-religions/changeActive', [EmployeeReligionController::class, 'changeActive'])->name('employee-religions-active');
    //Employee Marital Status
    Route::resource('employee-marital-status', EmployeeMaritalStatusController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-marital-status/changeActive', [EmployeeMaritalStatusController::class, 'changeActive'])->name('employee-marital-status-active');
    //Employee Identity Type
    Route::resource('employee-identity-types', EmployeeIdentityTypeController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-identity-types/changeActive', [EmployeeIdentityTypeController::class, 'changeActive'])->name('employee-identity-types-active');
    //Employee Card Issuers
    Route::resource('employee-card-issuers', EmployeeCardIssuerController::class)->except(['create', 'edit', 'show']);
    Route::post('employee-card-issuers/changeActive', [EmployeeCardIssuerController::class, 'changeActive'])->name('employee-card-issuers-active');
    //Employee Jobs Settings
    Route::resource('jobs', JobController::class)->except(['create', 'edit', 'show']);
    Route::post('jobs/changeActive', [JobController::class, 'changeActive'])->name('job-active');
    //Employees
    Route::resource('employees', EmployeesController::class);
});

Route::prefix('cars-management')->group(function () {
    //Car Suppliers
    Route::resource('car-suppliers', CarSupplierController::class)->except(['create', 'edit', 'show']);
    Route::post('car-suppliers/changeActive', [CarSupplierController::class, 'changeActive'])->name('car-suppliers-active');
    //Car Contracts
    Route::resource('car-contracts', CarContractController::class);
    Route::get('car-contracts/print-invoice/{id}', [CarContractController::class, 'printPdf'])->name('print-car-invoice');
    //Car Expenses
    Route::resource('car-expenses', CarExpensesController::class)->except(['create', 'edit', 'show']);
    Route::post('car-expenses/changeActive', [CarExpensesController::class, 'changeActive'])->name('car-expenses-active');
    //Car Tasks
    Route::resource('car-tasks', CarTaskController::class);
    Route::get('car-tasks/print-invoice/{id}', [CarTaskController::class, 'printPdf'])->name('car-task-invoice');
});

Route::prefix('reports')->group(function () {
    Route::get('print-report', [ReportController::class, 'printReport'])->name('print-report');
    Route::get('detailed-clients-report', [ReportController::class, 'detailedClientsReport'])->name('detailed-clients-report');
    Route::get('clients-report', [ReportController::class, 'clientsReport'])->name('clients-report');
    Route::get('client-suppliers-report', [ReportController::class, 'clientSuppliersReport'])->name('client-suppliers-report');
    Route::get('booking-groups-report', [ReportController::class, 'bookingGroupsReport'])->name('booking-groups-report');
    Route::get('extra-services-report', [ReportController::class, 'extraServicesReport'])->name('extra-services-report');
    Route::get('credit-sales-bookings-report', [ReportController::class, 'creditSalesBookingsReport'])->name('credit-sales-bookings-report');
    Route::get('expenses-report', [ReportController::class, 'expensesReport'])->name('expenses-report');
    Route::get('car-expenses-report', [ReportController::class, 'carExpensesReport'])->name('car-expenses-report');
    Route::get('car-income-report', [ReportController::class, 'carIncomeReport'])->name('car-income-report');
    Route::get('car-income-expenses-report', [ReportController::class, 'carIncomeExpensesReport'])->name('car-income-expenses-report');
    Route::get('car-contract-due-report', [ReportController::class, 'carContractDueReport'])->name('car-contract-due-report');
    Route::get('trip-analysis-report', [ReportController::class, 'tripAnalysisReport'])->name('trip-analysis-report');
    Route::get('trip-analysis-by-sales-area-report', [ReportController::class, 'tripAnalysisBySalesAreaReport'])->name('trip-analysis-by-sales-area-report');
});
Route::prefix('Warehouse-management')->group(function () {
    Route::get('/stocks-master', function () {
        return view('admin.stocks.stocks_master');
    })->name('stocks.master');
    Route::get('storemasrofasnaffar3/available-quantity/{sanf_code}', [StoreMasrofAsnafFar3Controller::class, 'getAvailableQuantity'])->name('storemasrofasnaffar3.availableQuantity');

    Route::get('storemasrofasnaffar3/sub-branches/{mainBranchId}', [StoreMasrofAsnafFar3Controller::class, 'getSubBranchesByMainBranch']);

    // Items routes
    Route::resource('storeitems', StoreItemController::class);

    // Inventory routes
    Route::resource('storeinventorytable', StoreInventoryTableController::class);

    // Khazina routes

    Route::resource('storekhazina', StoreKhazinaController::class);

    Route::get('storekhazina/by-sub-branch/{subBranchId}', [\App\Http\Controllers\Admin\Stocks\Khazina\StoreKhazinaController::class, 'getBoxesBySubBranch'])->name('storekhazina.bySubBranch');

    // Other routes

    Route::resource('storeothersupplier', StoreOtherSupplierController::class);

    Route::get('storeothersupplier/next-code', [StoreOtherSupplierController::class, 'getNextCode'])->name('storeothersupplier.nextCode');
    // Purchase routes
    Route::resource('storehadbackpurchase', StoreHadbackPurchaseController::class);
    Route::resource('storepurchasesothers', StorePurchasesOthersController::class);
    Route::patch('storepurchasesothers/{id}/approve', [StorePurchasesOthersController::class, 'approve'])->name('storepurchasesothers.approve');

    Route::get('storepurchasesothers/get-balance/{box_id}', [StorePurchasesOthersController::class, 'getBalanceByBoxId'])->name('storepurchasesothers.getBalance');


    // Rasid routes
    Route::resource('storemasrofasnaffar3', StoreMasrofAsnafFar3Controller::class);
    Route::resource('storerasidayni', StoreRasidAyniController::class);

    // Setting routes
    Route::resource('storebranchsetting', StoreBranchSettingController::class);
    Route::resource('storetasnefsetting', StoreTasnefSettingController::class);
    Route::resource('storeunitssetting', StoreUnitsSettingController::class);

    // Tahwelat routes
    Route::resource('storetahwelatasnaf', StoreTahwelatAsnafController::class);
});
