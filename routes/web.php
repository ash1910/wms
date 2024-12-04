<?php

use Illuminate\Support\Facades\Route;

Route::get('/logout', function () {
    session()->forget('user');
	session()->flash('error','Logout Sucessfully!!!');
	return redirect ('/');
});

Route::view('welcome','welcome');
Route::view('/','login');
//post
Route::post('check','App\Http\Controllers\User@check');


Route::group(['middleware'=>['UserAuth']],function()
{
	Route::view('home','home');
	Route::view('home1','home1');
	Route::view('setup','setup');
	Route::view('inventory','inventory');
	Route::view('account','account');
	Route::get('searchby','App\Http\Controllers\vehicleController@searchby');
	Route::get('customer','App\Http\Controllers\customerController@customer');
	Route::post('customerCreate','App\Http\Controllers\customerController@customerCreate');
	Route::get('customerEdit','App\Http\Controllers\customerController@customerEdit');
	Route::get('customerEditOne','App\Http\Controllers\customerController@customerEditOne');
	Route::post('customerEditTwo','App\Http\Controllers\customerController@customerEditTwo');
	// Route::get('customerDel','App\Http\Controllers\customerController@customerDel');
	Route::get('changePassword','App\Http\Controllers\customerController@changePassword');
	Route::post('changePassword01','App\Http\Controllers\customerController@changePassword01');

	Route::post('estimateAdd','App\Http\Controllers\estimateController@estimateAdd');

	Route::get('jobAccept','App\Http\Controllers\jobController@jobAccept');
	Route::get('jobModify','App\Http\Controllers\jobController@jobModify');
	Route::post('jobModifyOne','App\Http\Controllers\jobController@jobModifyOne');
	Route::post('jobModifyDel','App\Http\Controllers\jobController@jobModifyDel');
	Route::get('jobModifyOneBack','App\Http\Controllers\jobController@jobModifyOneBack');
	Route::get('jobCancel','App\Http\Controllers\jobController@jobCancel');

	Route::get('jobSample','App\Http\Controllers\jobController@jobSample');
	Route::post('jobSampleOne','App\Http\Controllers\jobController@jobSampleOne');
	// Stock
	Route::get('in','App\Http\Controllers\stockController@in');
	Route::post('inOne','App\Http\Controllers\stockController@inOne');
	Route::get('inHistory','App\Http\Controllers\stockController@inHistory');
	Route::get('inHistoryOne','App\Http\Controllers\stockController@inHistoryOne');
	Route::get('stock','App\Http\Controllers\stockController@stock');
	Route::get('dateStock','App\Http\Controllers\stockController@dateStock');
	Route::get('dateStock01','App\Http\Controllers\stockController@dateStock01');
	Route::get('purchaseWithSupplier','App\Http\Controllers\stockController@purchaseWithSupplier');
	Route::post('purchaseWithSupplier01','App\Http\Controllers\stockController@purchaseWithSupplier01');
	Route::post('printPurchase02','App\Http\Controllers\stockController@printPurchase02');
    Route::get('stock_wip','App\Http\Controllers\stockController@stock_wip');

	// Bill
	Route::get('bill','App\Http\Controllers\billController@bill');
	Route::get('billAdvance','App\Http\Controllers\billController@billAdvance');
	Route::get('searchClient','App\Http\Controllers\billController@searchClient');
	Route::post('billcard','App\Http\Controllers\billController@billcard');
	Route::view('billMemo','billMemo');
	Route::post('billMemoEdit','App\Http\Controllers\billController@billMemoEdit');
	Route::post('billMemoEditOne','App\Http\Controllers\billController@billMemoEditOne');
	Route::post('billMemoOne','App\Http\Controllers\billController@billMemoOne');
	Route::post('billMemoTwo','App\Http\Controllers\billController@billMemoTwo');
	Route::post('billPrint','App\Http\Controllers\billController@billPrint');
	Route::post('billPrint_as','App\Http\Controllers\billController@billPrint_as');
	Route::post('billPDF_as','App\Http\Controllers\billController@billPDF_as');
	Route::post('billPrintView','App\Http\Controllers\billController@billPrintView');
	Route::post('billPrintRef','App\Http\Controllers\billController@billPrintRef');
	Route::post('billModi','App\Http\Controllers\billController@billModi');
	Route::post('billMemoThree','App\Http\Controllers\billController@billMemoThree');
	Route::post('changeCustomer','App\Http\Controllers\billController@changeCustomer');
	Route::post('changeCustomer01','App\Http\Controllers\billController@changeCustomer01');
	Route::post('changeCustomer02','App\Http\Controllers\billController@changeCustomer02');
	Route::post('changeCustomer03','App\Http\Controllers\billController@changeCustomer03');
	Route::post('changeCustomer04','App\Http\Controllers\billController@changeCustomer04');
	Route::post('changeCustomer05','App\Http\Controllers\billController@changeCustomer05');
	Route::post('changeCustomer06','App\Http\Controllers\billController@changeCustomer06');
	Route::post('changeCustomer07','App\Http\Controllers\billController@changeCustomer07');
	Route::get('ModifyAcceptBill','App\Http\Controllers\billController@ModifyAcceptBill');
	Route::post('ModifyAcceptBill01','App\Http\Controllers\billController@ModifyAcceptBill01');
	Route::post('ModifyAcceptBill03','App\Http\Controllers\billController@ModifyAcceptBill03');
	Route::get('ModifyBillDt','App\Http\Controllers\billController@ModifyBillDt');
	Route::post('ModifyBillDt01','App\Http\Controllers\billController@ModifyBillDt01');

    Route::post('changeBillDetail','App\Http\Controllers\billController@changeBillDetail');
    Route::post('changeBillDetail01','App\Http\Controllers\billController@changeBillDetail01');
    Route::post('changePaymentDate','App\Http\Controllers\billController@changePaymentDate');
    Route::post('changePaymentApprovalDate','App\Http\Controllers\billController@changePaymentApprovalDate');
    Route::post('removePayment','App\Http\Controllers\billController@removePayment');
    Route::post('UpdateParts','App\Http\Controllers\billController@UpdateParts');



	// Estimate
	Route::get('est','App\Http\Controllers\estimateController@est');
	Route::get('searchClientEst','App\Http\Controllers\estimateController@searchClientEst');
	Route::post('billcardEst','App\Http\Controllers\estimateController@billcardEst');
	Route::view('billMemoEst','billMemoEst');
	Route::post('billPrint_asEst','App\Http\Controllers\estimateController@billPrint_asEst');
	Route::post('billMemoOneEst','App\Http\Controllers\estimateController@billMemoOneEst');
	Route::post('billMemoTwoEst','App\Http\Controllers\estimateController@billMemoTwoEst');
	Route::post('billMemoEditEst','App\Http\Controllers\estimateController@billMemoEditEst');
	Route::post('billMemoEditOneEst','App\Http\Controllers\estimateController@billMemoEditOneEst');
	Route::post('billMemoThreeEst','App\Http\Controllers\estimateController@billMemoThreeEst');
	Route::get('approvalEst','App\Http\Controllers\estimateController@approvalEst');
	Route::post('approval01Est','App\Http\Controllers\estimateController@approval01Est');

	Route::post('changeCustomerEst','App\Http\Controllers\estimateController@changeCustomerEst');
	Route::post('changeCustomerEst01','App\Http\Controllers\estimateController@changeCustomerEst01');
	Route::post('changeCustomerEst02','App\Http\Controllers\estimateController@changeCustomerEst02');
	Route::post('changeCustomerEst03','App\Http\Controllers\estimateController@changeCustomerEst03');
	Route::post('changeCustomerEst04','App\Http\Controllers\estimateController@changeCustomerEst04');
	Route::post('changeCustomerEst05','App\Http\Controllers\estimateController@changeCustomerEst05');
	Route::post('changeCustomerEst06','App\Http\Controllers\estimateController@changeCustomerEst06');
	Route::post('changeCustomerEst07','App\Http\Controllers\estimateController@changeCustomerEst07');
    Route::post('cloneEst','App\Http\Controllers\estimateController@cloneEst');

	// Bill report
	Route::get('reports','App\Http\Controllers\billController@reports');
	Route::get('form01','App\Http\Controllers\billController@form01');
	Route::get('form03','App\Http\Controllers\billController@form03');
	Route::get('form04','App\Http\Controllers\billController@form04');
	Route::get('form05','App\Http\Controllers\billController@form05');
	Route::get('form08','App\Http\Controllers\billController@form08');
	Route::get('form09','App\Http\Controllers\billController@form09');
	Route::get('form10','App\Http\Controllers\billController@form10');
	Route::get('form_estimate','App\Http\Controllers\billController@form_estimate');

	Route::get('advance','App\Http\Controllers\billController@advance');
	Route::get('advanceClient','App\Http\Controllers\billController@advanceClient');
	Route::get('advanceClient01','App\Http\Controllers\billController@advanceClient01');

	Route::get('allDueReport','App\Http\Controllers\billController@allDueReport');
	Route::post('allDueReport01','App\Http\Controllers\billController@allDueReport01');

	Route::get('report01','App\Http\Controllers\billController@report01');
	Route::get('report02','App\Http\Controllers\billController@report02');
	Route::get('report03','App\Http\Controllers\billController@report03');
	Route::get('report031','App\Http\Controllers\billController@report031');
	Route::get('report032','App\Http\Controllers\billController@report032');
	Route::get('report04','App\Http\Controllers\billController@report04');
	Route::get('report041','App\Http\Controllers\billController@report041');
	Route::get('report05','App\Http\Controllers\billController@report05');
	Route::get('report051','App\Http\Controllers\billController@report051');
	Route::get('report052','App\Http\Controllers\billController@report052');
	Route::get('report053','App\Http\Controllers\billController@report053');
	Route::get('report054','App\Http\Controllers\billController@report054');
	Route::get('report055','App\Http\Controllers\billController@report055');
	Route::get('report056','App\Http\Controllers\billController@report056');
	Route::get('report057','App\Http\Controllers\billController@report057');
	Route::get('report08','App\Http\Controllers\billController@report08');
	Route::get('report09','App\Http\Controllers\billController@report09');
	Route::get('report10','App\Http\Controllers\billController@report10');
	Route::get('supplierReport','App\Http\Controllers\billController@supplierReport');
	Route::post('supplierReport01','App\Http\Controllers\billController@supplierReport01');
	Route::get('supplierReport02','App\Http\Controllers\billController@supplierReport02');
	Route::get('supplierReport03','App\Http\Controllers\billController@supplierReport03');
	Route::get('supplierReport04','App\Http\Controllers\billController@supplierReport04');
	Route::get('supplierReport05','App\Http\Controllers\billController@supplierReport05');
	Route::get('saleSummary','App\Http\Controllers\billController@saleSummary');
	Route::get('saleSummary01','App\Http\Controllers\billController@saleSummary01');
	Route::get('dueRef','App\Http\Controllers\billController@dueRef');
	Route::get('dueRef01','App\Http\Controllers\billController@dueRef01');
	Route::get('dueRef02','App\Http\Controllers\billController@dueRef02');
	Route::get('dueRef03','App\Http\Controllers\billController@dueRef03');
	Route::get('dueRef04','App\Http\Controllers\billController@dueRef04');
	Route::get('report_estimate','App\Http\Controllers\billController@report_estimate');

    Route::post('moveToDraft','App\Http\Controllers\billController@moveToDraft');
    Route::post('updateBillWork','App\Http\Controllers\billController@updateBillWork');
	// cash in
	Route::get('cashIn','App\Http\Controllers\cashController@cashIn');
	Route::get('form06','App\Http\Controllers\cashController@form06');
	Route::post('pay','App\Http\Controllers\cashController@pay')->name('pay');
	Route::post('pay01','App\Http\Controllers\cashController@pay01');
	Route::post('pay02','App\Http\Controllers\cashController@pay02');
	Route::post('pay04','App\Http\Controllers\cashController@pay04');
	Route::post('pay03','App\Http\Controllers\cashController@pay03');
	Route::post('review01','App\Http\Controllers\cashController@review01');
	Route::post('receipt','App\Http\Controllers\cashController@receipt');
	Route::get('form07','App\Http\Controllers\cashController@form07');
	Route::post('multiPay','App\Http\Controllers\cashController@multiPay');
	Route::post('payAdvance','App\Http\Controllers\cashController@payAdvance')->name('payAdvance');

	Route::post('adjustment','App\Http\Controllers\cashController@adjustment');
	Route::post('adjustment01','App\Http\Controllers\cashController@adjustment01');
	Route::post('adjustment02','App\Http\Controllers\cashController@adjustment02');
	Route::post('adjustment03','App\Http\Controllers\cashController@adjustment03');
	Route::view('wip01','wip01');

	// setup
	Route::get('service','App\Http\Controllers\setupController@service');
	Route::get('serviceAdd','App\Http\Controllers\setupController@serviceAdd');
	Route::post('serviceAddOne','App\Http\Controllers\setupController@serviceAddOne');
	Route::get('serviceEdit','App\Http\Controllers\setupController@serviceEdit');
	Route::post('serviceEditOne','App\Http\Controllers\setupController@serviceEditOne');
	Route::get('user','App\Http\Controllers\setupController@user');
	Route::get('userAdd','App\Http\Controllers\setupController@userAdd');
	Route::post('userAddOne','App\Http\Controllers\setupController@userAddOne');
	Route::get('parts','App\Http\Controllers\setupController@parts');
	Route::get('partsAdd','App\Http\Controllers\setupController@partsAdd');
	Route::get('partsEdit','App\Http\Controllers\setupController@partsEdit');
	Route::post('partsEditOne','App\Http\Controllers\setupController@partsEditOne');
	Route::post('partsAddOne','App\Http\Controllers\setupController@partsAddOne');
	Route::get('supplier','App\Http\Controllers\setupController@supplier');
	Route::get('supplierEdit','App\Http\Controllers\setupController@supplierEdit');
	Route::post('supplierEditOne','App\Http\Controllers\setupController@supplierEditOne');
	Route::get('supplierAdd','App\Http\Controllers\setupController@supplierAdd');
	Route::post('supplierAddOne','App\Http\Controllers\setupController@supplierAddOne');
	Route::get('bomParts','App\Http\Controllers\setupController@bomParts');
	Route::get('bomPartsAdd','App\Http\Controllers\setupController@bomPartsAdd');
	Route::post('bomPartsAddOne','App\Http\Controllers\setupController@bomPartsAddOne');
	Route::get('bomPartsEdit','App\Http\Controllers\setupController@bomPartsEdit');
	Route::post('bomPartsEditOne','App\Http\Controllers\setupController@bomPartsEditOne');
	// approval
	Route::get('approval','App\Http\Controllers\approvalController@approval');
	Route::post('approval01','App\Http\Controllers\approvalController@approval01');
	Route::get('gatePassApproval','App\Http\Controllers\approvalController@gatePassApproval');
	Route::post('gatePassApproval01','App\Http\Controllers\approvalController@gatePassApproval01');
	Route::get('gatePassPrint','App\Http\Controllers\approvalController@gatePassPrint');
	Route::post('gatePassPrint01','App\Http\Controllers\approvalController@gatePassPrint01');
	Route::get('gatepassList','App\Http\Controllers\approvalController@gatepassList');
	Route::post('gatepassList01','App\Http\Controllers\approvalController@gatepassList01');
	Route::get('mfsCheck','App\Http\Controllers\approvalController@mfsCheck');
	Route::post('mfsCheck01','App\Http\Controllers\approvalController@mfsCheck01');
	Route::get('cardCheck','App\Http\Controllers\approvalController@cardCheck');
	Route::post('cardCheck01','App\Http\Controllers\approvalController@cardCheck01');
	Route::get('mfsReceipt','App\Http\Controllers\approvalController@mfsReceipt');
	Route::post('mfsReceipt01','App\Http\Controllers\approvalController@mfsReceipt01');
	Route::get('mfsReceipt02','App\Http\Controllers\approvalController@mfsReceipt02');
	Route::post('mfsReceiptPrint','App\Http\Controllers\approvalController@mfsReceiptPrint');
	Route::post('cardReceiptPrint','App\Http\Controllers\approvalController@cardReceiptPrint');
	Route::get('cardReceipt','App\Http\Controllers\approvalController@cardReceipt');
	Route::post('cardReceipt01','App\Http\Controllers\approvalController@cardReceipt01');
	Route::get('cardReceipt02','App\Http\Controllers\approvalController@cardReceipt02');
	Route::get('advanceCheck','App\Http\Controllers\approvalController@advanceCheck');
	Route::post('advanceCheck01','App\Http\Controllers\approvalController@advanceCheck01');
	Route::post('payAdvance01','App\Http\Controllers\approvalController@payAdvance01');
	Route::post('payAdvance02','App\Http\Controllers\approvalController@payAdvance02');
	Route::post('payAdvance03','App\Http\Controllers\approvalController@payAdvance03');
	Route::post('payAdvance04','App\Http\Controllers\approvalController@payAdvance04');
	Route::post('payAdvance05','App\Http\Controllers\approvalController@payAdvance05');
	Route::post('payAdvance06','App\Http\Controllers\approvalController@payAdvance06');
	Route::post('payAdvance07','App\Http\Controllers\approvalController@payAdvance07');


	// DAY END
	Route::get('dayEnd','App\Http\Controllers\dayEndController@dayEnd');
	// Cash Out
	Route::get('cashOut','App\Http\Controllers\cashOutController@cashOut');
	Route::get('suppliersPayment','App\Http\Controllers\cashOutController@suppliersPayment');
	Route::post('suppliersPayment01','App\Http\Controllers\cashOutController@suppliersPayment01');
	Route::post('suppliersPayment03','App\Http\Controllers\cashOutController@suppliersPayment03');


	// Bom purchase
	Route::get('purchase','App\Http\Controllers\bomController@purchase');
	Route::get('purchaseReturn','App\Http\Controllers\bomController@purchaseReturn');
	Route::post('purchase01','App\Http\Controllers\bomController@purchase01');
	Route::post('purchaseReturn01','App\Http\Controllers\bomController@purchaseReturn01');
	Route::post('purchaseReturn03','App\Http\Controllers\bomController@purchaseReturn03');
	Route::post('purchaseReturn04','App\Http\Controllers\bomController@purchaseReturn04');
	Route::get('purchase02','App\Http\Controllers\bomController@purchase02');
	Route::post('purchase03','App\Http\Controllers\bomController@purchase03');
	Route::get('purchase04','App\Http\Controllers\bomController@purchase04');
	Route::get('purchase05','App\Http\Controllers\bomController@purchase05');
	Route::post('purchase051','App\Http\Controllers\bomController@purchase051');
	Route::post('purchase052','App\Http\Controllers\bomController@purchase052');
	Route::post('purchase041','App\Http\Controllers\bomController@purchase041');
	Route::post('purchase042','App\Http\Controllers\bomController@purchase042');
	Route::post('purchaseDel','App\Http\Controllers\bomController@purchaseDel');
	Route::get('issue','App\Http\Controllers\bomController@issue');
	Route::post('issue01','App\Http\Controllers\bomController@issue01');
	Route::post('issueDel','App\Http\Controllers\bomController@issueDel');
	Route::get('issueModi','App\Http\Controllers\bomController@issueModi');
	Route::post('issueModi01','App\Http\Controllers\bomController@issueModi01');
	Route::post('printPurchase','App\Http\Controllers\stockController@printPurchase');
	Route::get('issueReturn','App\Http\Controllers\bomController@issueReturn');
	Route::post('issueReturn01','App\Http\Controllers\bomController@issueReturn01');
	Route::post('issueReturn02','App\Http\Controllers\bomController@issueReturn02');
	Route::post('issueReturn03','App\Http\Controllers\bomController@issueReturn03');
	//Reports
	Route::get('grossProfit','App\Http\Controllers\bomController@grossProfit');
	Route::get('grossProfit01','App\Http\Controllers\bomController@grossProfit01');
	Route::get('issueReport','App\Http\Controllers\bomController@issueReport');
	Route::get('issueReport01','App\Http\Controllers\bomController@issueReport01');
	Route::get('issueReport03','App\Http\Controllers\bomController@issueReport03');
	Route::get('issueWithDate','App\Http\Controllers\bomController@issueWithDate');
	Route::get('issueWithoutDate','App\Http\Controllers\bomController@issueWithoutDate');
	Route::post('printIssue','App\Http\Controllers\bomController@printIssue');
	Route::get('due','App\Http\Controllers\cashController@due');
	Route::get('refWiseDue','App\Http\Controllers\cashController@refWiseDue');
	Route::get('refWiseDue01','App\Http\Controllers\cashController@refWiseDue01');
	Route::get('refWiseDueEdit','App\Http\Controllers\cashController@refWiseDueEdit');
	Route::post('refWiseDueEdit01','App\Http\Controllers\cashController@refWiseDueEdit01');
	Route::get('receive','App\Http\Controllers\cashController@receive');
	Route::get('financialCharge','App\Http\Controllers\cashController@financialCharge');
	Route::get('moneyReceipt','App\Http\Controllers\cashController@moneyReceipt');
	Route::post('moneyReceipt01','App\Http\Controllers\cashController@moneyReceipt01');
	Route::post('moneyReceipt02','App\Http\Controllers\cashController@moneyReceipt02');
	Route::post('moneyReceipt03','App\Http\Controllers\cashController@moneyReceipt03');
	Route::post('moneyReceipt04','App\Http\Controllers\cashController@moneyReceipt04');
	Route::post('moneyReceipt05','App\Http\Controllers\cashController@moneyReceipt05');
	Route::post('moneyReceipt06','App\Http\Controllers\cashController@moneyReceipt06');
	Route::post('moneyReceipt07','App\Http\Controllers\cashController@moneyReceipt07');
    Route::post('moneyReceipt08','App\Http\Controllers\cashController@moneyReceipt08');

	Route::get('chequeApproval','App\Http\Controllers\cashController@chequeApproval');
	Route::get('chequeConfirm','App\Http\Controllers\cashController@chequeConfirm');
	Route::post('chequeApproval01','App\Http\Controllers\cashController@chequeApproval01');
	Route::post('chequeApproval02','App\Http\Controllers\cashController@chequeApproval02');
	Route::post('chequeApproval03','App\Http\Controllers\cashController@chequeApproval03');
	Route::post('chequeApproval04','App\Http\Controllers\cashController@chequeApproval04');
	Route::post('chequeConfirm01','App\Http\Controllers\cashController@chequeConfirm01');
	Route::post('chequeConfirm02','App\Http\Controllers\cashController@chequeConfirm02');
	Route::post('chequeConfirm03','App\Http\Controllers\cashController@chequeConfirm03');

	Route::get('bankDeclineForm','App\Http\Controllers\cashController@bankDeclineForm');
	Route::post('bankDeclinePayment','App\Http\Controllers\cashController@bankDeclinePayment');
	Route::post('bankDeclinePaymentConfirm','App\Http\Controllers\cashController@bankDeclinePaymentConfirm');
	Route::post('bankDeclinePaymentSubmit','App\Http\Controllers\cashController@bankDeclinePaymentSubmit');

	Route::post('bankDeclinePayment01','App\Http\Controllers\cashController@bankDeclinePayment01');

	Route::get('advanceReceipt','App\Http\Controllers\cashController@advanceReceipt');
	Route::post('refund','App\Http\Controllers\cashController@refund');
	Route::get('advanceRefund','App\Http\Controllers\cashController@advanceRefund');
	Route::get('aitReport','App\Http\Controllers\cashController@aitReport');
	Route::get('vatReport','App\Http\Controllers\cashController@vatReport');
	Route::get('ait','App\Http\Controllers\cashController@ait');
	Route::get('vatProvision','App\Http\Controllers\cashController@vatProvision');
	Route::post('ait01','App\Http\Controllers\cashController@ait01');
	Route::post('vat_pro01','App\Http\Controllers\cashController@vat_pro01');
	Route::post('aitApproval','App\Http\Controllers\cashController@aitApproval');
	Route::post('vat_proApproval','App\Http\Controllers\cashController@vat_proApproval');
	Route::get('aitCollect','App\Http\Controllers\cashController@aitCollect');
	Route::get('vatCollect','App\Http\Controllers\cashController@vatCollect');
	Route::get('vdsCollect','App\Http\Controllers\cashController@vdsCollect');
	Route::get('collectedVat','App\Http\Controllers\cashController@collectedVat');
	Route::get('collectedVat01','App\Http\Controllers\cashController@collectedVat01');
	Route::get('purchaseReport','App\Http\Controllers\bomController@purchaseReport');
	Route::get('purchaseWithoutSupplier','App\Http\Controllers\bomController@purchaseWithoutSupplier');
	Route::post('purchaseWithoutSupplier01','App\Http\Controllers\bomController@purchaseWithoutSupplier01');

	Route::get('declineBankPOS','App\Http\Controllers\cashController@declineBankPOS');

	//accounting
	Route::get('payments','App\Http\Controllers\cashOutController@payments');
	Route::post('payments01','App\Http\Controllers\cashOutController@payments01');
	Route::get('accounting','App\Http\Controllers\cashOutController@accounting');
	Route::get('creditor','App\Http\Controllers\cashOutController@creditor');
	Route::post('creditor01','App\Http\Controllers\cashOutController@creditor01');
	Route::get('creditor02','App\Http\Controllers\cashOutController@creditor02');


	//Product ledger
	Route::get('ledger','App\Http\Controllers\bomController@ledger');
	Route::get('productLedger','App\Http\Controllers\bomController@productLedger');
	Route::post('productLedger01','App\Http\Controllers\bomController@productLedger01');
	Route::get('productLedger02','App\Http\Controllers\bomController@productLedger02');
	Route::get('supplierLedger','App\Http\Controllers\bomController@supplierLedger');
	Route::any('supplierLedger01','App\Http\Controllers\bomController@supplierLedger01');
	Route::get('vehicleLedger','App\Http\Controllers\bomController@vehicleLedger');
	Route::post('vehicleLedger01','App\Http\Controllers\bomController@vehicleLedger01');
	Route::post('vehicleLedger02','App\Http\Controllers\bomController@vehicleLedger02');
	Route::get('jobLedger','App\Http\Controllers\bomController@jobLedger');
	Route::post('jobLedger01','App\Http\Controllers\bomController@jobLedger01');
	Route::get('advanceLedger','App\Http\Controllers\bomController@advanceLedger');
	Route::get('advanceLedger01','App\Http\Controllers\bomController@advanceLedger01');


	//ledger
	Route::get('led_master','App\Http\Controllers\ledgerController@led_master');
	Route::post('led_master01','App\Http\Controllers\ledgerController@led_master01');
	Route::get('led_group','App\Http\Controllers\ledgerController@led_group');
	Route::post('led_group01','App\Http\Controllers\ledgerController@led_group01');
	Route::get('led_subGroup01','App\Http\Controllers\ledgerController@led_subGroup01');
	Route::post('led_sub01','App\Http\Controllers\ledgerController@led_sub01');
	Route::get('led_subGroup02','App\Http\Controllers\ledgerController@led_subGroup02');
	Route::post('led_sub02','App\Http\Controllers\ledgerController@led_sub02');
	Route::get('led_subGroup03','App\Http\Controllers\ledgerController@led_subGroup03');
	Route::post('led_sub03','App\Http\Controllers\ledgerController@led_sub03');
	Route::get('led_subGroup04','App\Http\Controllers\ledgerController@led_subGroup04');
	Route::post('led_sub04','App\Http\Controllers\ledgerController@led_sub04');
	Route::get('led_subGroup05','App\Http\Controllers\ledgerController@led_subGroup05');
	Route::post('led_sub05','App\Http\Controllers\ledgerController@led_sub05');

    Route::get('masTogroup/{id}', 'App\Http\Controllers\ledgerController@masTogroup');
    Route::get('masTogroup01/{id}', 'App\Http\Controllers\ledgerController@masTogroup01');
    Route::get('masTogroup02/{id}', 'App\Http\Controllers\ledgerController@masTogroup02');
    Route::get('masTogroup03/{id}', 'App\Http\Controllers\ledgerController@masTogroup03');
    Route::get('masTogroup04/{id}', 'App\Http\Controllers\ledgerController@masTogroup04');


	Route::get('led_tree','App\Http\Controllers\ledgerController@led_tree');


	Route::get('accounts','App\Http\Controllers\ledgerController@accounts');
	Route::get('groupAccountView','App\Http\Controllers\ledgerController@groupAccountView');
	Route::get('groupAccount','App\Http\Controllers\ledgerController@groupAccount');
	Route::post('groupAccount01','App\Http\Controllers\ledgerController@groupAccount01');
	Route::get('ledgerAccount','App\Http\Controllers\ledgerController@ledgerAccount');
	Route::post('ledgerAccount01','App\Http\Controllers\ledgerController@ledgerAccount01');
	Route::get('journal','App\Http\Controllers\ledgerController@journal');
	Route::get('chartOfAccount','App\Http\Controllers\ledgerController@chartOfAccount');
	Route::get('chartOfAccount01','App\Http\Controllers\ledgerController@chartOfAccount01');
	Route::post('chartOfAccount02','App\Http\Controllers\ledgerController@chartOfAccount02');

	//transactions
	Route::view('transactions','transactions');
	Route::view('payment','payment');
	Route::post('payment01','App\Http\Controllers\ledgerController@payment01');
	Route::post('setLedge','App\Http\Controllers\ledgerController@setLedge');
	Route::post('setLedge01','App\Http\Controllers\ledgerController@setLedge01');
	Route::view('journal01','journal01');
	Route::view('contra','contra');
	Route::post('paymentDel','App\Http\Controllers\ledgerController@paymentDel');
	Route::view('paymentReport','paymentReport');
	Route::get('paymentReport01','App\Http\Controllers\ledgerController@paymentReport01');
	Route::get('paymentReport02','App\Http\Controllers\ledgerController@paymentReport02');


	// DAY END
	Route::get('dayEnd','App\Http\Controllers\dayEndController@dayEnd');
	Route::post('dayEnd01','App\Http\Controllers\dayEndController@dayEnd01');
	Route::post('dayEnd02','App\Http\Controllers\dayEndController@dayEnd02');



	// ACCOUNTS
	Route::get('accounts02', function () {return view('accounts02');});
	Route::get('acc_group_list', function () {return view('acc_group_list');});
	Route::get('acc_group_add', function () {return view('acc_group_add');});
	Route::Post('acc_group_add','App\Http\Controllers\AccountsController@store_acc_group');
	Route::get('/acc_group_add','App\Http\Controllers\AccountsController@edit_acc_group');
	Route::get('/acc_group_list','App\Http\Controllers\AccountsController@delete_acc_group');


	Route::get('acc_head_add', function () {return view('acc_head_add');});
	Route::get('/acc_head_add','App\Http\Controllers\AccountsController@ck_acc_lock');
	Route::Post('acc_head_add','App\Http\Controllers\AccountsController@store_acc_head');

	Route::get('/acc_head_list', function () {return view('acc_head_list');});
	Route::get('/acc_head_list','App\Http\Controllers\AccountsController@delete_acc_head');


	Route::get('acc_voucher_entry', function () {return view('acc_voucher_entry');});
	Route::Post('acc_voucher_entry','App\Http\Controllers\AccountsController@store_voucher_entry');
	Route::get('/acc_voucher_entry','App\Http\Controllers\AccountsController@edit_voucher_entry');

	Route::get('acc_voucher_list', function () {return view('acc_voucher_list');});
	Route::get('/acc_voucher_list','App\Http\Controllers\AccountsController@delete_acc_voucher');



	Route::get('acc_report_voucher/{ref}', function () {return view('acc_report_voucher');});
	Route::get('acc_report_voucher_pin/{ref}', function () {return view('acc_report_voucher_pin');});
	Route::get('acc_report_voucher_pir/{ref}', function () {return view('acc_report_voucher_pir');});
	Route::get('acc_report_voucher_isu/{ref}', function () {return view('acc_report_voucher_isu');});


	Route::get('acc_opening_bal', function () {return view('acc_opening_bal');});
	Route::Post('acc_opening_bal','App\Http\Controllers\AccountsController@store_opening_balance');


	Route::get('acc_opening_bal_list', function () {return view('acc_opening_bal_list');});
	Route::get('/acc_opening_bal_list','App\Http\Controllers\AccountsController@delete_opening_bal');


	Route::get('acc_auto_journal_list', function () {return view('acc_auto_journal_list');});
	Route::get('/acc_auto_journal_list','App\Http\Controllers\AccountsController@delete_auto_voucher');


	Route::get('/acc_report_filter', function () {return view('acc_report_filter');});

	Route::get('acc_report_menu', function () {return view('acc_report_menu');});

	Route::get('acc_test', function () {return view('acc_test');});

	Route::get('acc_report_journal', function () {return view('acc_report_journal');});

	Route::get('acc_report_ledger', function () {return view('acc_report_ledger');});

	Route::get('acc_report_cashbk', function () {return view('acc_report_cashbk');});

	Route::get('acc_report_bankbk', function () {return view('acc_report_bankbk');});

	Route::get('acc_report_receipt_pay', function () {return view('acc_report_receipt_pay');});

	Route::get('acc_report_trial_bal','App\Http\Controllers\AccountsController@LoadTreeview');
	Route::get('acc_report_pl','App\Http\Controllers\AccountsController@LoadTreeview_pl');
	Route::get('acc_report_bs','App\Http\Controllers\AccountsController@LoadTreeview_bs');

	Route::get('acc_report_cust_ledger', function () {return view('acc_report_cust_ledger');});
	Route::get('acc_report_sup_ledger', function () {return view('acc_report_sup_ledger');});

    Route::get('acc_rep_cust_position', function () {return view('acc_rep_cust_position');});

	//Route::get('/acc_report_pl', function () {return view('acc_report_pl');});
	//Route::get('/acc_report_bs', function () {return view('acc_report_bs');});


});


