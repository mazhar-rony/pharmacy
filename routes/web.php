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
    Route::resource('bank', 'BankController');
    Route::resource('branch', 'BankBranchController');
    Route::resource('customer', 'CustomerController');

    //dependency dropdown
    Route::get('invoice/products', 'InvoiceController@getProducts')->name('invoice.getProducts');
    Route::get('invoice/quantity', 'InvoiceController@getQuantity')->name('invoice.getQuantity');
    Route::get('invoice/account', 'InvoiceController@getBankAccounts')->name('invoice.getBankAccounts');

    Route::resource('invoice', 'InvoiceController');

    //dependency dropdown
    Route::get('account/branches', 'BankAccountController@getBranches')->name('account.getBranches');

    Route::resource('account', 'BankAccountController');
    Route::get('account/{account}/transaction', 'BankAccountController@transaction')->name('account.transaction');
    Route::put('account/deposite/{account}', 'BankAccountController@deposite')->name('account.deposite');
    Route::put('account/withdraw/{account}', 'BankAccountController@withdraw')->name('account.withdraw');
    Route::put('account/interest/{account}', 'BankAccountController@interest')->name('account.interest');

    Route::put('product/quantity/{product}', 'ProductController@updatePrice')->name('product.price');
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});
