<?php

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function() {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::group(['middleware' => ['auth']], function() {
    Route::resource('customer', 'CustomerController');
});*/

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    //get sales & profit chart data
    Route::get('dashboard/get-chart-data', 'DashboardController@getChartData')->name('dashboard.chart');

    Route::resource('category', 'CategoryController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('purchase', 'PurchaseController');
    Route::resource('product', 'ProductController');
    Route::put('product/quantity/{product}', 'ProductController@updatePrice')->name('product.price');
    Route::resource('bank', 'BankController');
    Route::resource('branch', 'BankBranchController');
    Route::resource('customer', 'CustomerController');

    //dependency dropdown
    Route::get('invoice/employee', 'InvoiceController@getEmployeeSalary')->name('invoice.getEmployeeSalary');
    Route::get('invoice/customer', 'InvoiceController@getCustomer')->name('invoice.getCustomer');
    Route::get('invoice/purchase', 'InvoiceController@getPurchaseNo')->name('invoice.getPurchaseNo');
    Route::get('invoice/invoice', 'InvoiceController@getInvoice')->name('invoice.getInvoice');
    Route::get('invoice/products', 'InvoiceController@getProducts')->name('invoice.getProducts');
    Route::get('invoice/quantity', 'InvoiceController@getQuantity')->name('invoice.getQuantity');
    Route::get('invoice/account', 'InvoiceController@getBankAccounts')->name('invoice.getBankAccounts');

    Route::resource('invoice', 'InvoiceController');

    Route::resource('return', 'ReturnProductController');

    //dependency dropdown
    Route::get('account/branches', 'BankAccountController@getBranches')->name('account.getBranches');

    Route::resource('account', 'BankAccountController');
    Route::get('account/{account}/transaction', 'BankAccountController@transaction')->name('account.transaction');
    Route::put('account/deposite/{account}', 'BankAccountController@deposite')->name('account.deposite');
    Route::put('account/withdraw/{account}', 'BankAccountController@withdraw')->name('account.withdraw');
    Route::put('account/interest/{account}', 'BankAccountController@interest')->name('account.interest');

    Route::get('loan/{account}/transaction', 'BankLoanController@transaction')->name('loan.transaction');
    Route::put('loan/emi/{account}', 'BankLoanController@payEMI')->name('loan.emi');
    Route::put('loan/close/{account}', 'BankLoanController@closeLoan')->name('loan.close');
    Route::resource('loan', 'BankLoanController');
    
    Route::get('creditor/{creditor}/payment', 'CreditorController@payment')->name('creditor.payment');
    Route::put('creditor/payment/{creditor}', 'CreditorController@payToCreditor')->name('creditor.payToCreditor');
    Route::resource('creditor', 'CreditorController');

    Route::get('debtor/{debtor}/payment', 'DebtorController@payment')->name('debtor.payment');
    Route::put('debtor/payment/{debtor}', 'DebtorController@paidByDebtor')->name('debtor.paidByDebtor');
    Route::resource('debtor', 'DebtorController');

    Route::get('expense/create', 'OfficeExpenseController@create')->name('expense.create');
    Route::post('expense', 'OfficeExpenseController@store')->name('expense.store');

    Route::resource('proprietor', 'ProprietorController');
    Route::get('proprietor/{proprietor}/transaction', 'ProprietorController@transaction')->name('proprietor.transaction');
    Route::put('proprietor/deposite/{proprietor}', 'ProprietorController@deposite')->name('proprietor.deposite');
    Route::put('proprietor/withdraw/{proprietor}', 'ProprietorController@withdraw')->name('proprietor.withdraw');
    
    Route::get('employee/{employee}/payment', 'EmployeeController@payment')->name('employee.payment');
    Route::put('employee/salary/{employee}', 'EmployeeController@salary')->name('employee.salary');
    Route::put('employee/advance/{employee}', 'EmployeeController@advance')->name('employee.advance');
    Route::put('employee/bonus/{employee}', 'EmployeeController@bonus')->name('employee.bonus');
    Route::resource('employee', 'EmployeeController');

    // All Reports
    Route::get('report/sold', 'ReportController@soldProducts')->name('report.sold');
    Route::post('report/sold', 'ReportController@showSoldProducts')->name('report.showSold');
    Route::get('report/return', 'ReportController@returnProducts')->name('report.return');
    Route::post('report/return', 'ReportController@showReturnProducts')->name('report.showReturn');
    Route::get('report/purchase', 'ReportController@purchaseProducts')->name('report.purchase');
    Route::post('report/purchase', 'ReportController@showPurchaseProducts')->name('report.showPurchase');
    Route::get('report/cash', 'ReportController@dailyCash')->name('report.cash');
    Route::post('report/cash', 'ReportController@showDailyCash')->name('report.showCash');
    Route::get('report/sales', 'ReportController@sales')->name('report.sales');
    Route::post('report/sales', 'ReportController@showSales')->name('report.showSales');
    Route::get('report/purchases', 'ReportController@purchases')->name('report.purchases');
    Route::post('report/purchases', 'ReportController@showPurchases')->name('report.showPurchases');
    Route::get('report/sales-details', 'ReportController@salesDetails')->name('report.salesDetails');
    Route::post('report/sales-details', 'ReportController@showSalesDetails')->name('report.showSalesDetails');
    Route::get('report/purchase-details', 'ReportController@purchaseDetails')->name('report.purchaseDetails');
    Route::post('report/purchase-details', 'ReportController@showPurchaseDetails')->name('report.showPurchaseDetails');
    Route::get('report/proprietor', 'ReportController@proprietorExpenses')->name('report.proprietorExpenses');
    Route::post('report/proprietor', 'ReportController@showProprietorExpenses')->name('report.showProprietorExpenses');
    Route::get('report/office', 'ReportController@officeExpenses')->name('report.officeExpenses');
    Route::post('report/office', 'ReportController@showOfficeExpenses')->name('report.showOfficeExpenses');
    Route::get('report/bank', 'ReportController@bankTransactions')->name('report.bankTransactions');
    Route::post('report/bank', 'ReportController@showBankTransactions')->name('report.showBankTransactions');
    Route::get('report/salary', 'ReportController@employeeSalary')->name('report.employeeSalary');
    Route::post('report/salary', 'ReportController@showEmployeeSalary')->name('report.showEmployeeSalary');

    // Users
    Route::resource('user', 'UserController');

    // Settings
    Route::get('settings/profile', 'SettingsController@editProfile')->name('profile.edit');
    Route::put('settings/profile', 'SettingsController@updateProfile')->name('profile.update');
    Route::get('settings/change-password', 'SettingsController@editPassword')->name('password.edit');
    Route::post('settings/change-password', 'SettingsController@updatePassword')->name('password.update');
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Settings
    Route::get('settings/profile', 'SettingsController@editProfile')->name('profile.edit');
    Route::put('settings/profile', 'SettingsController@updateProfile')->name('profile.update');
    Route::get('settings/change-password', 'SettingsController@editPassword')->name('password.edit');
    Route::post('settings/change-password', 'SettingsController@updatePassword')->name('password.update');
});
