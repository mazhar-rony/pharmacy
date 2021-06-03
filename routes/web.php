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

    Route::resource('category', 'CategoryController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('product', 'ProductController');
    Route::put('product/quantity/{product}', 'ProductController@updatePrice')->name('product.price');
    Route::resource('bank', 'BankController');
    Route::resource('branch', 'BankBranchController');
    Route::resource('customer', 'CustomerController');

    //dependency dropdown
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
    
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});
