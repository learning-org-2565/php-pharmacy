<?php
$router->get('login', 'LoginController@index');
$router->post('login', 'LoginController@login');
$router->get('logout', 'LoginController@logout');
$router->get('forgotpassword', 'LoginController@forgotpassword');
$router->post('forgotpassword', 'LoginController@forgotAction');
$router->get('resetpassword', 'LoginController@resetpassword');
$router->post('resetpassword', 'LoginController@resetpasswordAction');
$router->get('profile', 'ProfileController@index');
$router->post('profile', 'ProfileController@indexAction');
$router->post('profile/password', 'ProfileController@indexPassword');

$router->get('dashboard', 'DashboardController@index');
$router->get('dashbaordappointment', 'DashboardController@getDashbaordAppointment');
$router->get('info', 'SettingController@index');
$router->post('info', 'SettingController@indexAction');
$router->get('customization', 'SettingController@customization');
$router->post('customization', 'SettingController@customizationAction');

$router->get('customers', 'CustomerController@index');
$router->get('customer/view', 'CustomerController@indexView');
$router->get('customer/add', 'CustomerController@indexAdd');
$router->post('customer/add', 'CustomerController@indexAction');
$router->get('customer/edit', 'CustomerController@indexEdit');
$router->post('customer/edit', 'CustomerController@indexAction');
$router->post('customer/delete', 'CustomerController@indexDelete');
$router->post('customer/sendmail', 'CustomerController@indexMail');
$router->get('customer/search', 'CustomerController@searchPatient');

$router->get('accounts', 'AccountController@index');
$router->get('account/add', 'AccountController@indexAdd');
$router->post('account/add', 'AccountController@indexAction');
$router->get('account/edit', 'AccountController@indexEdit');
$router->post('account/edit', 'AccountController@indexAction');
$router->post('account/delete', 'AccountController@indexDelete');

$router->get('account/transactions', 'AccountController@transactions');
$router->get('account/transaction/add', 'AccountController@transactionAdd');
$router->post('account/transaction/add', 'AccountController@transactionAction');
$router->get('account/transaction/edit', 'AccountController@transactionEdit');
$router->post('account/transaction/edit', 'AccountController@transactionAction');
$router->post('account/transaction/delete', 'AccountController@transactionDelete');

$router->get('users', 'UserController@index');
$router->get('user/add', 'UserController@indexAdd');
$router->post('user/add', 'UserController@indexAction');
$router->get('user/edit', 'UserController@indexEdit');
$router->post('user/edit', 'UserController@indexAction');
$router->post('user/delete', 'UserController@indexDelete');
$router->get('role', 'UserController@userRole');
$router->get('role/add', 'UserController@userRoleAdd');
$router->post('role/add', 'UserController@userRoleAction');
$router->get('role/edit', 'UserController@userRoleEdit');
$router->post('role/edit', 'UserController@userRoleAction');
$router->post('role/delete', 'UserController@userRoleDelete');

$router->get('medicines', 'MedicineController@index');
$router->get('medicine/view', 'MedicineController@indexView');
$router->get('medicine/add', 'MedicineController@indexAdd');
$router->post('medicine/add', 'MedicineController@indexAction');
$router->get('medicine/edit', 'MedicineController@indexEdit');
$router->post('medicine/edit', 'MedicineController@indexAction');
$router->post('medicine/delete', 'MedicineController@indexDelete');
$router->get('getmedicine', 'MedicineController@getMedicine');
$router->post('medicine/upload', 'MedicineController@medicineUpload');
$router->get('medicine/sample', 'MedicineController@medicineSampleDownload');
$router->get('medicine/purchase', 'MedicineController@medicinePurchaseList');
$router->get('medicine/purchase/view', 'MedicineController@medicinePurchaseView');
$router->get('medicine/purchase/pdf', 'MedicineController@medicinePurchasePdf');
$router->get('medicine/purchase/add', 'MedicineController@medicinePurchaseAdd');
$router->post('medicine/purchase/add', 'MedicineController@medicinePurchaseAction');
$router->get('medicine/purchase/edit', 'MedicineController@medicinePurchaseEdit');
$router->post('medicine/purchase/edit', 'MedicineController@medicinePurchaseAction');
$router->post('medicine/purchase/delete', 'MedicineController@medicinePurchaseDelete');
$router->get('medicine/stock', 'MedicineController@stockList');
$router->post('medicine/stock', 'MedicineController@stockUpdate');
$router->post('medicine/stock/delete', 'MedicineController@stockDelete');
$router->get('medicine/billing', 'MedicineController@medicineBilling');
$router->get('medicine/billing/view', 'MedicineController@medicineBillingView');
$router->get('medicine/billing/pdf', 'MedicineController@medicineBillingPdf');
$router->get('medicine/billing/add', 'MedicineController@medicineBillingAdd');
$router->post('medicine/billing/add', 'MedicineController@medicineBillingAction');
$router->get('medicine/billing/edit', 'MedicineController@medicineBillingEdit');
$router->post('medicine/billing/edit', 'MedicineController@medicineBillingAction');
$router->post('medicine/billing/delete', 'MedicineController@medicineBillingDelete');
$router->post('getbatch', 'MedicineController@medicineBillingBatch');
$router->post('getbatchdata', 'MedicineController@medicineBillingBatchData');
$router->get('suppliers', 'SettingController@suppliers');
$router->post('supplier/add', 'SettingController@supplierAction');
$router->post('supplier/edit', 'SettingController@supplierAction');
$router->post('supplier/delete', 'SettingController@supplierDelete');
$router->get('medicine/category', 'MedicineController@mCategory');
$router->post('medicine/category/add', 'MedicineController@mCategoryAction');
$router->post('medicine/category/edit', 'MedicineController@mCategoryAction');
$router->post('medicine/category/delete', 'MedicineController@mCategoryDelete');

$router->get('salarytemplate', 'SalarytemplateController@index');
$router->get('salarytemplate/add', 'SalarytemplateController@indexAdd');
$router->post('salarytemplate/add', 'SalarytemplateController@indexAction');
$router->get('salarytemplate/edit', 'SalarytemplateController@indexEdit');
$router->post('salarytemplate/edit', 'SalarytemplateController@indexAction');
$router->post('salarytemplate/delete', 'SalarytemplateController@indexDelete');
$router->get('managesalary', 'ManagesalaryController@index');
$router->get('managesalary/view', 'ManagesalaryController@indexView');
$router->get('managesalary/add', 'ManagesalaryController@indexAdd');
$router->post('managesalary/add', 'ManagesalaryController@indexAction');
$router->get('managesalary/edit', 'ManagesalaryController@indexEdit');
$router->post('managesalary/edit', 'ManagesalaryController@indexAction');
$router->get('managesalary/history', 'ManagesalaryController@history');
$router->get('managesalary/history/view', 'ManagesalaryController@historyView');
$router->get('managesalary/history/pdf', 'ManagesalaryController@historyPdf');
$router->post('managesalary/history/delete', 'ManagesalaryController@historyDelete');
$router->get('makepayment', 'ManagesalaryController@makepayment');
$router->get('makepayment/add', 'ManagesalaryController@makepaymentAdd');
$router->post('makepayment/add', 'ManagesalaryController@makepaymentAction');
$router->post('checkstaffsalary', 'ManagesalaryController@checkStaffSalary');

$router->get('invoices', 'InvoiceController@index');
$router->get('invoice/view', 'InvoiceController@indexView');
$router->get('invoice/pdf', 'InvoiceController@indexPdf');
$router->post('invoice/sentmail', 'InvoiceController@indexMail');
$router->get('invoice/add', 'InvoiceController@indexAdd');
$router->post('invoice/add', 'InvoiceController@indexAction');
$router->get('invoice/edit', 'InvoiceController@indexEdit');
$router->post('invoice/edit', 'InvoiceController@indexAction');
$router->post('invoice/delete', 'InvoiceController@indexDelete');
$router->post('addpayment', 'InvoiceController@invoicePayment');
$router->get('expenses', 'ExpenseController@index');
$router->get('expense/add', 'ExpenseController@indexAdd');
$router->post('expense/add', 'ExpenseController@indexAction');
$router->get('expense/edit', 'ExpenseController@indexEdit');
$router->post('expense/edit', 'ExpenseController@indexAction');
$router->post('expense/delete', 'ExpenseController@indexDelete');

$router->get('subscribers', 'SubscriberController@index');
$router->get('subscriber/add', 'SubscriberController@indexAdd');
$router->post('subscriber/add', 'SubscriberController@indexAction');
$router->get('subscriber/edit', 'SubscriberController@indexEdit');
$router->post('subscriber/edit', 'SubscriberController@indexAction');
$router->post('subscriber/delete', 'SubscriberController@indexDelete');


$router->get('noticeboard', 'NoticeboardController@index');
$router->get('noticeboard/view', 'NoticeboardController@indexView');
$router->get('noticeboard/add', 'NoticeboardController@indexAdd');
$router->post('noticeboard/add', 'NoticeboardController@indexAction');
$router->get('noticeboard/edit', 'NoticeboardController@indexEdit');
$router->post('noticeboard/edit', 'NoticeboardController@indexAction');
$router->post('noticeboard/delete', 'NoticeboardController@indexDelete');

$router->get('doctors', 'DoctorController@index');
$router->get('doctor/add', 'DoctorController@indexAdd');
$router->post('doctor/add', 'DoctorController@indexAction');
$router->get('doctor/edit', 'DoctorController@indexEdit');
$router->post('doctor/edit', 'DoctorController@indexAction');
$router->post('doctor/delete', 'DoctorController@indexDelete');
$router->get('doctor/search', 'DoctorController@searchDoctor');
$router->get('staffattendance', 'StaffattendanceController@index');
$router->get('staffattendance/view', 'StaffattendanceController@indexView');
$router->get('staffattendance/add', 'StaffattendanceController@indexAdd');
$router->post('staffattendance/add', 'StaffattendanceController@indexAction');

$router->get('items', 'ItemsController@index');
$router->post('item/add', 'ItemsController@indexAction');
$router->post('item/edit', 'ItemsController@indexAction');
$router->post('item/delete', 'ItemsController@indexDelete');
$router->get('item/search', 'ItemsController@indexSearch');
$router->get('expensetype', 'TypesController@expenseType');
$router->post('expensetype/add', 'TypesController@expenseTypeAction');
$router->post('expensetype/edit', 'TypesController@expenseTypeAction');
$router->post('expensetype/delete', 'TypesController@expenseTypeDelete');

$router->get('reports', 'ReportController@index');

$router->get('send/email', 'SenderController@indexMail');
$router->post('send/email', 'SenderController@indexMailAction');
$router->get('sendbulk/email', 'SenderController@indexBulkMail');
$router->post('sendbulk/email', 'SenderController@indexBulkMailAction');
$router->post('get/receiver', 'SenderController@indexUsers');
$router->get('emaillogs', 'SenderController@indexEmailLog');

$router->get('paymentmethod', 'FinanceController@paymentMethod');
$router->post('paymentmethod/add', 'FinanceController@paymentMethodAction');
$router->post('paymentmethod/edit', 'FinanceController@paymentMethodAction');
$router->post('paymentmethod/delete', 'FinanceController@paymentMethodDelete');
$router->get('tax', 'FinanceController@tax');
$router->post('tax/add', 'FinanceController@taxAction');
$router->post('tax/edit', 'FinanceController@taxAction');
$router->post('tax/delete', 'FinanceController@taxDelete');

$router->get('emailtemplate', 'EmailtemplateController@emailTemplate');
$router->post('emailtemplate', 'EmailtemplateController@emailTemplateAction');
$router->get('emailsetting', 'EmailtemplateController@emailSetting');
$router->post('emailsetting', 'EmailtemplateController@emailSettingAction');

$router->post('attach/documents', 'UploadController@attachDocuments');
$router->post('attach/documents/delete', 'UploadController@attachDocumentsDelete');

$router->get('get/media', 'UploadController@getMedia');
$router->post('media/upload', 'UploadController@uploadMedia');
$router->post('media/delete', 'UploadController@mediaDelete');