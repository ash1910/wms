<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class cashController extends Controller
{
    public function cashIn()
	{
		return view ('cashIn');
	}
	public function pay(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		return view ('pay',['bill_no' => $bill_no]);
	}
	public function adjustment(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		return view ('adjustment',['bill_no' => $bill_no]);
	}



	public function adjustment01(Request $r)
	{
		$submit=$r->input('submit');//due left

		$due01=$r->input('due');//due left
		$sales_return=$r->input('sales_return');//post input
		$advance_refund=$r->input('advance_refund');//post input
		$complementary_work=$r->input('complementary_work');//post input
		$rework=$r->input('rework');//post input
		$rework_ref=$r->input('rework_ref');//post input
		$note=$r->input('note');//post input
		$damage_work=$r->input('damage_work');//post input
		$due=($sales_return+$advance_refund+$complementary_work+$rework+$damage_work);//due paid
		$dueLeft=$r->input('dueLeft');//post input
		$pay_type='adjust';//post input

		if($submit=='Account Refund'){$due=$dueLeft;$advance_refund=$dueLeft;$pay_type='A/C Refund';}

		$net_bill=$r->input('net_bill');//post input
		$bill=$r->input('bill_no');//post input
		$bill_dt=$r->input('bill_dt');//post input
		$job_no=$r->input('job_no');//post input
		$customer_id=$r->input('customer_id');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");

		if($submit!='Account Refund')
		{
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`sales_return`,`advance_refund`,`complementary_work`, `rework`,
		`rework_ref`,`damage_work`,`note`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,'0','0'
	,'0','0', round(-$due,2),$dt,$user_id,$pay_type,$sales_return,$advance_refund,$complementary_work,
	$rework,$rework_ref,$damage_work,$note]);
		}
		if($submit=='Account Refund')
		{
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`sales_return`,`advance_refund`,`complementary_work`, `rework`,
		`rework_ref`,`damage_work`,`note`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,
		$customer_id,'0','0','0','0', round(-$due,2),$dt,$user_id,$pay_type,'0',$advance_refund,'0',
	'0','0','0',$note]);

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`sales_return`,`advance_refund`,`complementary_work`, `rework`,
		`rework_ref`,`damage_work`,`note`,`ref`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance','Advance',
		$customer_id,round(-$due,2),'0','0','0', round($due,2),$dt,$user_id,$pay_type,'0','0','0',
	'0','0','0','Refund From Job No: '.$job_no,'Advance']);
		}



		/// HAPS Code  ---For Sales Adjustment--- 30-08-24

		if($sales_return > 0 || $complementary_work > 0 || $rework > 0 || $damage_work > 0){


			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
			foreach($my_Data as $item)
		{

			$work = $item->work;
			$parts = $item->parts;
			$service= $item->service;
			$total = $item->total;
			$bill_dt = $item->bill_dt;
			$customer_nm = $item->customer_nm;


		}


		if ($work =='engineering'){

			$myCustomerAcc = 'Workshop Customer';
		}
		if ($work =='intercompany'){

			$myCustomerAcc = 'Intercompany Customer';
		}
		if ($work =='automobile'){

			$myCustomerAcc = 'Automobile Customer';
		}

		$vat = $total-$parts-$service;

		// Partital sales Adjustment-> amount to be deducted proportionately
		if ($due != $total){

			$vat = ($vat / $total) * $due;
			$parts = ($parts / $total) * $due;
			$service = ($service / $total) * $due;
		}
		//******* */
		$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' ");
		foreach($myRef as $item){$RefNo = $item->id;}
		$Ref = 'SAJ-'.$RefNo;

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}

		$myData1 = '( Sales Refund :'.$sales_return ;
		$myData2 = ', Comp. Work :'.$complementary_work;
		$myData3 = ', Rework:'.$rework ;
		$myData4 = ', Damage:'.$damage_work;
		$myData5 = ' )';

		$narration = $customer_nm . ' '. $myData1 . ' ' . $myData2 . ' '. $myData3 . ' '. $myData4 .' '. $myData5;

		// if ($vat!=0){
		// 	DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		// 	VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, 'VAT Current A/C',$customer_nm, $vat,'0', $customer_id, $job_no]);
		// }

		if ($parts!=0){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, 'Parts Revenue',$customer_nm, $parts+$vat,'0', $customer_id, $job_no]);

		}

		if ($service!=0){
			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, 'Service Revenue',$customer_nm,  $service+$vat, '0', $customer_id, $job_no]);
		}

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $narration, '0', $due, $customer_id, $job_no]);


		}

		if( $advance_refund < 0){

			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
				foreach($my_Data as $item)
			{
				$work = $item->work;
			}

			if ($work =='engineering'){

				$myCustomerAcc = 'Workshop Customer';
			}
			if ($work =='intercompany'){

				$myCustomerAcc = 'Intercompany Customer';
			}
			if ($work =='automobile'){

				$myCustomerAcc = 'Automobile Customer';
			}


			$my_refund_type=$r->input('refund01');

			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
			foreach($my_Data as $item)
			{
				$customer_nm = $item->customer_nm;

			}

			$CashBankAcc = $r->input('CashankAcc');

			$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' and `job_no` ='$job_no';");
			foreach($myRef as $item){$RefNo = $item->id;}



			$myNarration = $customer_id.'-'.$customer_nm;

			if($submit=='Adjustment'){

				if($my_refund_type == 'Advance Refund' || $my_refund_type == 'Receivable Refund'){

					$Ref = 'ADR-'.$RefNo;

					if($my_refund_type == 'Advance Refund'){

						DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
						VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $myNarration, -$advance_refund, '0', $customer_id, $job_no]);

					}

					if($my_refund_type == 'Receivable Refund'){
						DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
						VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $myNarration, -$advance_refund, '0', $customer_id, $job_no]);
					}


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $CashBankAcc, $myNarration, '0', -$advance_refund, $customer_id, $job_no]);



				}
			}


			if($my_refund_type == 'Advance Transfer'){

				$Ref = 'ADT-'.$RefNo;

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, 'Advance from Customer', $myNarration, -$advance_refund, '0', NULL, $job_no]);

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $myNarration, '0', -$advance_refund, NULL, $job_no]);

			}



		}


		//// End HAPS Code ---

		return redirect(route("pay"), 307);
	}







	public function adjustment02(Request $r)
	{
		$pay_type='Service';//post input
		$supplier_name=$r->input('supplier_name');//post input
		$pieces = explode(" - ", $supplier_name);
		$supplier_id = $pieces[0];
		$supplier_adj=$r->input('supplier_adj');//post input
		$bill=$r->input('bill_no');//post input
		$job_no=$r->input('job_no');//post input
		$customer_id=$r->input('customer_id');//post input
		$supplier_ref=$r->input('supplier_ref');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`supplier_name`,`supplier_adj`,`supplier_ref`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,'0','0','0','0',
		round(-$supplier_adj,2),$dt,$user_id,$pay_type,$supplier_name,$supplier_adj,$supplier_ref]);

		DB::insert('INSERT INTO `suppliers_payment`(`supplier_id`,`bill_numbers`,`paid_amount`,
		`created_date`,`mode_of_payment`,`due`,`note`)VALUES (?,?,?,?,?,?,?)',
		[$supplier_id,$supplier_ref,$supplier_adj,$dt,$pay_type,'0',$job_no]);



		/// HAPS Code  ---For Supplier Adjustment--30-08-24

		$supplier_nm = $pieces[1];

		$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
		foreach($my_Data as $item)
		{

		$work = $item->work;
		$parts = $item->parts;
		$service= $item->service;
		$total = $item->total;
		$bill_dt = $item->bill_dt;
		$customer_nm = $item->customer_nm;


		}


		if ($work =='engineering'){

			$myCustomerAcc = 'Workshop Customer';
		}
		if ($work =='intercompany'){

			$myCustomerAcc = 'Intercompany Customer';
		}
		if ($work =='automobile'){

			$myCustomerAcc = 'Automobile Customer';
		}


		$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' ");
		foreach($myRef as $item){$RefNo = $item->id;}
		$Ref = 'SUA-'.$RefNo;

		//dd($Ref);

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

		$check_ref->delete();

		}


		$mySInfo = $supplier_id.'-'.$supplier_nm;
		$myCInfo = $customer_id.'-'.$customer_nm;

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, 'Supplier Accounts',$mySInfo, $supplier_adj,'0', $supplier_id, $job_no]);


		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $myCInfo, '0', $supplier_adj, $customer_id, $job_no]);


		//dd($supplier_adj);

		// End of Code











		return redirect(route("pay"), 307);
	}





	public function adjustment03(Request $r)
	{
		$bill=$r->input('bill_no');//post input
		$job_no=$r->input('job_no');//post input
		$customer_id=$r->input('customer_id');//post input
		$vcustomer_id=$r->input('vcustomer_id');//post input
		$pieces = explode(" - ", $customer_id);
		$customer_id = $pieces[0];
		$customer_nm = $pieces[1];
		$due=$r->input('net_bill');//post input
		$net_bill01=$r->input('net_bill01');//post input
		$pay_type='Adj-Cust';//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$s = date("s");

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$vcustomer_id,'0','0','0','0',
		round(-$due,2),$dt,$user_id,$pay_type]);

		if($due==$net_bill01)
		{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '3']);
		}
		if($due!=$net_bill01)
		{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '2']);
		}

//////////////////////////////////////////////////////////////
		DB::insert('INSERT INTO `bill_mas`(`bill_no`, `customer_id`, `customer_nm`,
		`job_no`, `work`,`user_id`, `net_bill`, `total`,`flag`,`job_dt`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',[$bill.$s,$customer_id,$customer_nm,$job_no.'[adj]','automobile',$user_id,
		$due,$due,'1',$dt]);

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$bill.$s,$job_no.'[adj]',$customer_id,'0','0','0','0',
		round($due,2),$dt,$user_id,'SYS']);


		/// HAPS Code  ---For Customer Adjustment--30-08-24

		///********** for 1 Customer */
		$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
		foreach($my_Data as $item)
		{

		$work = $item->work;
		$parts = $item->parts;
		$service= $item->service;
		$total = $item->total;
		$bill_dt = $item->bill_dt;
		$customer_nm = $item->customer_nm;


		}


		if ($work =='engineering'){

			$myCustomerAcc = 'Workshop Customer';
		}
		if ($work =='intercompany'){

			$myCustomerAcc = 'Intercompany Customer';
		}
		if ($work =='automobile'){

			$myCustomerAcc = 'Automobile Customer';
		}

		///********** for 2 Customer */
		$my_Data2 = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$vcustomer_id'");
		foreach($my_Data2 as $item)
		{

		$work2 = $item->work;
		$parts2 = $item->parts;
		$service2= $item->service;
		$total2 = $item->total;
		$bill_dt2 = $item->bill_dt;
		$customer_nm2 = $item->customer_nm;


		}


		if ($work2 =='engineering'){

			$myCustomerAcc2 = 'Workshop Customer';
		}
		if ($work2 =='intercompany'){

			$myCustomerAcc2 = 'Intercompany Customer';
		}
		if ($work2 =='automobile'){

			$myCustomerAcc2 = 'Automobile Customer';
		}

		$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' ");
		foreach($myRef as $item){$RefNo = $item->id;}
		$Ref = 'CuAdj-'.$RefNo;

		//dd($Ref);

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

		$check_ref->delete();

		}



		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc, $customer_nm, $due, '0', $customer_id, $job_no]);

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $dt, $myCustomerAcc2,$customer_nm2, '0', $due, $vcustomer_id, $job_no]);




		return redirect(route("pay"), 307);
	}














	public function pay01(Request $r)
	{
		$advance=$r->input('advance');//post input
		$received=$r->input('received');//post input
		$bonus=$r->input('bonus');//post input
		$vat_wav=$r->input('vat_wav');//post input
		$vat_pro=$r->input('vat_pro');//post input
		$ait=$r->input('ait');//post input
		$due01=$r->input('due');//post input
		$due=($received+$bonus+$vat_wav+$vat_pro+$ait);//post input
		$net_bill=$r->input('net_bill');//post input
		$bill=$r->input('bill_no');//post input
		$bill_dt=$r->input('bill_dt');//post input
		$job_no=$r->input('job_no');//post input
		$pay_type=$r->input('pay_type');//post input
		$customer_id=$r->input('customer_id');//post input
		$ref=$r->input('ref');//post input
		$note=$r->input('note');//post input
		$mer_bkash=$r->input('mer_bkash');//post input
		$trix=$r->input('trix');//post input
		$send=$r->input('send');//post input
		$bank=$r->input('bank');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$chequeDt=$r->input('chequeDt');//post input

		$card_bank=$r->input('card_bank');//post input
		$card_no=$r->input('card_no');//post input
		$card_type=$r->input('card_type');//post input
		$merchant_bank=$r->input('merchant');//post input
		$merchant_online=$r->input('merchant_online');//post input
		$merchant_checque=$r->input('merchant_checque');//post input

		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$bill_no = "";

if($advance!="")
{
			DB::table('pay')->where('bill','Advance')->where('customer_id',$customer_id)
				->update(['bill' => $bill, 'job_no' => $job_no, 'ref' => 'Advance']);
}

if($pay_type=="cash")
{
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,round($received,2),round($bonus,2)
	,round($vat_wav,2),round($vat_pro,2),round($ait,2), round(-$due,2),$dt,$user_id,$pay_type,$ref,$note]);
}
if($pay_type=="online")
{
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`, `merchant_bank`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,round($received,2),round($bonus,2)
	,round($vat_wav,2),round($vat_pro,2),round($ait,2), round(-$due,2),$dt,$user_id,$pay_type,$ref,$note,$merchant_online]);
}
if($pay_type=="due")
{
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,'0','0','0','0','0','0',$dt,$user_id,
$pay_type,$ref,$note]);
}
if($pay_type=="cheque")
{

		//HAPS Code

		$find_Ch_No = DB::select("SELECT `chequeNo` FROM `pay` WHERE `chequeNo`='$chequeNo'");

		if ( count($find_Ch_No) != 0){

			//return redirect ('/chequeApproval')->with('danger', 'Duplicate Cheque Number!');

		}
		// End Code
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `post_dt`, `user_id`,`pay_type`,`ref`,`note`,`bank`, `chequeNo`, `chequeDt`, `merchant_bank`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,'0',round($bonus,2)
		,round($vat_wav,2),round($vat_pro,2),round($ait,2), '0',$dt,$dt,$user_id,$pay_type,$ref,$note,
		$bank,$chequeNo,$chequeDt,$merchant_checque]);

		DB::insert('INSERT INTO `cheque_pending`(`bank`, `chequeNo`, `chequeDt`,`received`, `due`,
		`job_no`, `customer_id`, `flag`) VALUES (?,?,?,?,?,?,?,?)',[$bank, $chequeNo, $chequeDt,
		round($received,2), round(-$due,2), $job_no, $customer_id, '0']);
}

if($pay_type=="bkash")
{


if($mer_bkash=="330"){
	$charge=round($received-($received*0.988),2);
	$received = round($received*0.988,2);
}
else{
	$charge=round($received-($received*0.985),2);
	$received = round($received*0.985,2);
}

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`,`charge`,`mer_bkash`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,round($received,2),round($bonus,2)
	,round($vat_wav,2),round($vat_pro,2),round($ait,2), round(-$due,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$charge,$mer_bkash]);
}

if($pay_type=="card")
{
	if($merchant_bank=="CBL"){
		if($card_type=="CityVMQU"){
			$charge=round($received-($received*0.983),2);
			$received = round($received*0.983,2);
		}
		elseif($card_type=="Visa" || $card_type=="Master"){
			$charge=round($received-($received*0.987),2);
			$received = round($received*0.987,2);
		}
		else{
			$charge=round($received-($received*0.980),2);
			$received = round($received*0.980,2);
		}
	}
	else if($merchant_bank=="DBBL"){
		if($card_type=="Nexus"){
			$charge=round($received-($received*0.990),2);
			$received = round($received*0.990,2);
		}
        elseif($card_type=="DBBLVisaMaster"){
			$charge=round($received-($received*0.987),2);
			$received = round($received*0.987,2);
		}
	}
	else{
		$charge=round($received-($received*0.987),2);
		$received = round($received*0.987,2);
	}



		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`vat_pro`,`ait`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`, `card_bank`, `card_no`, `card_type`,
		`merchant_bank`,`charge`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill,$job_no,$customer_id,round($received,2),round($bonus,2)
	,round($vat_wav,2),round($vat_pro,2),round($ait,2), round(-$due,2),$dt,$user_id,$pay_type,$ref,$note,
	$card_bank,$card_no,$card_type,$merchant_bank,$charge]);
}

if($ait!='0')
{
		DB::insert('INSERT INTO `ait`(`bill_dt`, `dt`, `customer_id`,`job_no`, `ait`)
		VALUES (?,?,?,?,?)',[$bill_dt, $dt, $customer_id, $job_no,round($ait,2)]);
}
if($vat_pro!='0')
{
		DB::insert('INSERT INTO `vat_pro`(`job_no`) VALUES (?)',[$job_no]);
}





	/// HAPS Code   -- Collection from Customer--30-08-24

	$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
		foreach($my_Data as $item)
	{

		$work = $item->work;
		$parts = $item->parts;
		$service= $item->service;
		$total = $item->total;
		$bill_dt = $item->bill_dt;
		$customer_nm = $item->customer_nm;


	}



	if ($work =='engineering'){

		$myCustomerAcc = 'Workshop Customer';
	}
	if ($work =='intercompany'){

		$myCustomerAcc = 'Intercompany Customer';
	}
	if ($work =='automobile'){

		$myCustomerAcc = 'Automobile Customer';
	}

	//dd($myCustomerAcc);

	//******************* */

	if ($pay_type=="cash"){

		$PartReceived = $received ;
		$TotalReceive = $received + $bonus + $vat_wav + $ait + $vat_pro;

	}


	if ($pay_type=="online"){
		$bankacc = $r->input('BankAcc1');//post input

		$PartReceived = $received;
		$TotalReceive = $received + $bonus + $vat_wav + $ait + $vat_pro;


	}

	if ($pay_type=="bkash"){
		$bankacc = $r->input('BankAcc2');//post input
		$card_charges_acc = $r->input('BankAcc22');//post input

		$PartReceived = $received;
		$TotalReceive = $received + $bonus + $charge + $vat_wav + $ait + $vat_pro;


	}

	if ($pay_type=="card"){
		$bankacc = $r->input('BankAcc4');//post input
		$card_charges_acc = $r->input('BankAcc44');//post input

		$PartReceived = $received;
		$TotalReceive = $received + $bonus + $charge + $vat_wav + $ait + $vat_pro;


	}



	$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
	foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

	$myRef= DB::select("SELECT max(id) as id FROM `pay` WHERE `customer_id` = '$customer_id' AND `received` ='$received'");
	foreach($myRef as $item){$RefNo = $item->id;}
	$Ref = 'COL-'.$RefNo;

	//dd($Ref);

	$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}


		if ($pay_type == 'cash' or $pay_type=="online" ){

			if($pay_type == 'cash'){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Cash at Workshop' , $customer_nm, $PartReceived, '0', $customer_id, $job_no]);
			}

			if($pay_type == 'online'){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $bankacc , $customer_nm, $PartReceived, '0', $customer_id, $job_no]);
			}



			if ($bonus!=0){
			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Discount Allowed to Customer', $customer_nm, $bonus, '0', $customer_id, $job_no]);
			}
			if ($vat_wav!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C', $customer_nm, $vat_wav, '0', $customer_id, $job_no]);
				}
			if ($ait!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance Income Tax', $customer_nm, $ait, '0', $customer_id, $job_no]);
				}
			if ($vat_pro!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C', $customer_nm, $vat_pro, '0', $customer_id, $job_no]);
				}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc , $customer_nm, '0', $TotalReceive, $customer_id, $job_no]);


		}

		if ($pay_type=="bkash"  ){


			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $bankacc ,$customer_nm, $PartReceived, '0', $customer_id, $chequeNo, $chequeDt, $bank, $job_no]);

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $card_charges_acc  ,$customer_nm, $charge, '0', $customer_id, $chequeNo, $chequeDt, $bank, $job_no]);

			if ($bonus!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Discount Allowed to Customer',$customer_nm, $bonus, '0', $customer_id, $job_no]);
			}
			if ($vat_wav!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C',$customer_nm, $vat_wav, '0', $customer_id, $job_no]);
			}
			if ($ait!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance Income Tax', $customer_nm, $ait, '0', $customer_id, $job_no]);
				}
			if ($vat_pro!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C', $customer_nm, $vat_pro, '0', $customer_id, $job_no]);
				}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc ,$customer_nm, '0', $TotalReceive, $customer_id, $job_no]);


		}

		if ( $pay_type=="card"  ){



			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $bankacc ,$customer_nm, $PartReceived+$charge, '0', $customer_id, $chequeNo, $chequeDt, $bank, $job_no]);

			if ($bonus!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Discount Allowed to Customer',$customer_nm, $bonus, '0', $customer_id, $job_no]);
			}
			if ($vat_wav!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C',$customer_nm, $vat_wav, '0', $customer_id, $job_no]);
			}
			if ($ait!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance Income Tax', $customer_nm, $ait, '0', $customer_id, $job_no]);
				}
			if ($vat_pro!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C', $customer_nm, $vat_pro, '0', $customer_id, $job_no]);
				}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc ,$customer_nm, '0', $TotalReceive, $customer_id, $job_no]);


		}


		if ($pay_type == 'cheque'){

			$myRef= DB::select("SELECT max(id) as id FROM `pay`");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'COL-'.$RefNo;

			if ( $due01 < 0  ){

				//dd($due01);
				//$myDue = abs($due01);

				$TotalReceive = $bonus+$vat_wav+$ait+$vat_pro+$due01;
			}else{
				$TotalReceive = $bonus+$vat_wav+$ait+$vat_pro;
			}


			if ($bonus!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Discount Allowed to Customer',$customer_nm, $bonus, '0', $customer_id, $job_no]);
			}

			if ($vat_wav!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C',$customer_nm, $vat_wav, '0', $customer_id, $job_no]);
			}


			if ($ait!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance Income Tax', $customer_nm, $ait, '0', $customer_id, $job_no]);
			}


			if ($vat_pro!=0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'VAT Current A/C', $customer_nm, $vat_pro, '0', $customer_id, $job_no]);
			}

			if ($TotalReceive!=0){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc ,$customer_nm, '0', $TotalReceive, $customer_id, $job_no]);

			}





		}






		// if ( $due01 < 0  ){

		// 	DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		// 	VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc, $customer_nm, -$due01,'0', $customer_id, $job_no]);

		// 	DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
		// 	VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer' ,$customer_nm, '0', -$due01, $customer_id, $job_no]);


		// }


	//END HAPS Code---


		if($due01!='0')
			{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '2']);
				return view ('payPrint01',['bill' => $bill]);
			}

		if($due01=='0')
			{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '3']);
				return view ('payPrint',['bill' => $bill]);
			}

	}

	public function form06()
	{
		return view ('form06');
	}





	public function pay02(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		$received=$r->input('received');//post input
		$pay_type=$r->input('pay_type');//post input
		$customer_id=$r->input('customer_id');//post input
		$note=$r->input('note');//post input
		$ref= 'Advance';
		$mer_bkash=$r->input('mer_bkash');//post input
		$trix=$r->input('trix');//post input
		$send=$r->input('send');//post input
		$bank=$r->input('bank');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$chequeDt=$r->input('chequeDt');//post input
		$card_bank=$r->input('card_bank');//post input
		$card_no=$r->input('card_no');//post input
		$card_type=$r->input('card_type');//post input
		$merchant_bank=$r->input('merchant');//post input
		$merchant_online=$r->input('merchant_online');//post input
		$merchant_checque=$r->input('merchant_checque');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$bill_no = "";
		if($pay_type=="cash")
		{
				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `chequeNo`, `chequeDt`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$chequeNo,$chequeDt]);
		}
		if($pay_type=="online")
		{
				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `chequeNo`, `chequeDt`, `merchant_bank`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$chequeNo,$chequeDt, $merchant_online]);
		}
		if($pay_type=="cheque")
		{
			//HAPS Code

			$find_Ch_No = DB::select("SELECT `chequeNo` FROM `pay` WHERE `chequeNo`='$chequeNo'");

			if ( count($find_Ch_No) != 0){

				return redirect ('/chequeApproval')->with('danger', 'Duplicate Cheque Number!');

			}
			//** End */

				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `post_dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `bank`, `chequeNo`, `chequeDt`, `merchant_bank`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,'0',""
			,"", '0',$dt,$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$bank,$chequeNo,$chequeDt, $merchant_checque]);

				DB::insert('INSERT INTO `cheque_pending`(`bank`, `chequeNo`, `chequeDt`,`received`, `due`,
				`job_no`, `customer_id`, `flag`) VALUES (?,?,?,?,?,?,?,?)',[$bank, $chequeNo, $chequeDt,
				round($received,2), -round($received,2), $job_no, $customer_id, '0']);
		}
		if($pay_type=="bkash")
		{


		if($mer_bkash=="330"){
			$charge=round($received-($received*0.988),2);
			$received = round($received*0.988,2);
		}
		else{
			$charge=round($received-($received*0.985),2);
			$received = round($received*0.985,2);
		}

				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `chequeNo`, `chequeDt`
				,`charge`, `mer_bkash`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received+$charge,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$chequeNo,$chequeDt
			,$charge,$mer_bkash]);
		}
		if($pay_type=="card")
		{
			if($merchant_bank=="CBL"){
				if($card_type=="CityVMQU"){
					$charge=round($received-($received*0.983),2);
					$received = round($received*0.983,2);
				}
				elseif($card_type=="Visa" || $card_type=="Master"){
					$charge=round($received-($received*0.987),2);
					$received = round($received*0.987,2);
				}
				else{
					$charge=round($received-($received*0.980),2);
					$received = round($received*0.980,2);
				}
			}
			else if($merchant_bank=="DBBL"){
                if($card_type=="Nexus"){
                    $charge=round($received-($received*0.990),2);
                    $received = round($received*0.990,2);
                }
                elseif($card_type=="DBBLVisaMaster"){
                    $charge=round($received-($received*0.987),2);
                    $received = round($received*0.987,2);
                }
            }
			else{
				$charge=round($received-($received*0.987),2);
				$received = round($received*0.987,2);
			}

				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`,  `card_bank`, `card_no`, `card_type`,
				`merchant_bank`,`charge`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received+$charge,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$card_bank,$card_no,$card_type,
			$merchant_bank,$charge]);
		}








		//HAPS Code   --- Advance Received Pay02 --- by Job Number--30-08-24


		if ($pay_type=="online"){
			$bankacc = $r->input('BankAcc1');//post input
		}

		if ($pay_type=="bkash"){
			$bankacc = $r->input('BankAcc2');//post input
			$card_charges_acc = $r->input('BankAcc22');//post input
		}

		if ($pay_type=="card"){
			$bankacc = $r->input('BankAcc4');//post input
			$card_charges_acc = $r->input('BankAcc44');//post input
		}


		$myRef= DB::select("SELECT max(id) as id FROM `pay`");
		foreach($myRef as $item){$RefNo = $item->id;}
		$vRef = 'ADV-'.$RefNo;

		$myCustName = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
		foreach($myCustName as $item){$custName = $item->customer_nm;}

		$custInfo = $customer_id.' '.$custName;


		$check_ref = DB::table('tbl_acc_details')->where('ref', $vRef);

		if ( $check_ref !== null){

			$check_ref->delete();

		}


		if ($received > 0) {


			if ($pay_type == 'cash'  ){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Cash at Workshop',$custInfo, $received, '0', NULL, $job_no]);

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $received, NULL, $job_no]);

			}

			if ( $pay_type=="card" ){

				if ($charge > 0){

					$totalRec = $received+$charge;

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Receivable against Card',$custInfo, $totalRec,'0', NULL, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $totalRec, NULL, $job_no]);


				}

				if ($charge == 0){


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Receivable against Card',$custInfo, '0', $received, NULL, $job_no]);



				}


			}

			if($pay_type=="online")
			{
				$charge= 0;
			}


			if ($pay_type=="bkash" or $pay_type=="online" ){

				if ($charge > 0){

					$totalRec = $received+$charge;


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $card_charges_acc  ,$custInfo, $charge, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $totalRec, NULL, $job_no]);


				}

				if ($charge == 0){


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $received, NULL, $job_no]);



				}


			}




		}

		// End Code



		return redirect(route("payAdvance",['customer_id' => $customer_id]), 307);

		//return view ('payAdvance',['customer_id' => $customer_id]);
		//return redirect ('/cashIn')->with('alert', 'Recived Sucessfully!!!');
	}

	public function pay05(Request $r)
	{

	}

	public function pay04(Request $r)
	{
		$job_no='Advance';//post input
		$received=$r->input('received');//post input
		$pay_type=$r->input('pay_type');//post input
		$customer_id=$r->input('customer_id');//post input
		$note=$r->input('note');//post input
		$ref= 'Advance';
		$mer_bkash=$r->input('mer_bkash');//post input
		$trix=$r->input('trix');//post input
		$send=$r->input('send');//post input
		$bank=$r->input('bank');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$chequeDt=$r->input('chequeDt');//post input
		$card_bank=$r->input('card_bank');//post input
		$card_no=$r->input('card_no');//post input
		$card_type=$r->input('card_type');//post input
		$merchant_bank=$r->input('merchant');//post input
		$merchant_online=$r->input('merchant_online');//post input
		$merchant_checque=$r->input('merchant_checque');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$bill_no = "";
		$due=($received);//post input
		if($pay_type=="cash")
		{
				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `bank`, `chequeNo`, `chequeDt`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$bank,$chequeNo,$chequeDt]);
		}
		if($pay_type=="online")
		{
				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,`ait`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`merchant_bank`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"","", round($received,2),$dt,$user_id,$pay_type,$ref,$note,$merchant_online]);
		}
		if($pay_type=="cheque")//need to developer
		{

				//HAPS Code

				$find_Ch_No = DB::select("SELECT `chequeNo` FROM `pay` WHERE `chequeNo`='$chequeNo'");

				if ( count($find_Ch_No) != 0){

					//return redirect ('/chequeApproval')->with('danger', 'Duplicate Cheque Number!');

				}

		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
		`due`, `dt`, `post_dt`, `user_id`,`pay_type`,`ref`,`note`,`bank`, `chequeNo`, `chequeDt`,`merchant_bank`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,'0',""
		,"", '0',$dt,$dt,$user_id,$pay_type,$ref,$note,	$bank,$chequeNo,$chequeDt, $merchant_checque]);

		DB::insert('INSERT INTO `cheque_pending`(`bank`, `chequeNo`, `chequeDt`,`received`, `due`,
		`job_no`, `customer_id`, `flag`) VALUES (?,?,?,?,?,?,?,?)',[$bank, $chequeNo, $chequeDt,
		round($received,2), round(-$due,2), $job_no, $customer_id, '0']);





		}
		if($pay_type=="bkash")
		{


		if($mer_bkash=="330"){
			$charge=round($received-($received*0.988),2);
			$received = round($received*0.988,2);
		}
		else{
			$charge=round($received-($received*0.985),2);
			$received = round($received*0.985,2);
		}


				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `bank`, `chequeNo`, `chequeDt`
				,`charge`,`mer_bkash`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received+$charge,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$send,$bank,$chequeNo,$chequeDt
			,$charge,$mer_bkash]);
		}
		if($pay_type=="card")
		{
			if($merchant_bank=="CBL"){
				if($card_type=="CityVMQU"){
					$charge=round($received-($received*0.983),2);
					$received = round($received*0.983,2);
				}
				elseif($card_type=="Visa" || $card_type=="Master"){
					$charge=round($received-($received*0.987),2);
					$received = round($received*0.987,2);
				}
				else{
					$charge=round($received-($received*0.980),2);
					$received = round($received*0.980,2);
				}
			}
			else if($merchant_bank=="DBBL"){
				if($card_type=="Nexus"){
					$charge=round($received-($received*0.990),2);
					$received = round($received*0.990,2);
				}
				elseif($card_type=="DBBLVisaMaster"){
					$charge=round($received-($received*0.987),2);
					$received = round($received*0.987,2);
				}
			}
			else{
				$charge=round($received-($received*0.987),2);
				$received = round($received*0.987,2);
			}

				DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
				`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`,  `card_bank`, `card_no`, `card_type`,
				`merchant_bank`,`charge`)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',["Advance",$job_no,$customer_id,round($received,2),""
			,"", -round($received+$charge,2),$dt,$user_id,$pay_type,$ref,$note,$trix,$card_bank,$card_no,$card_type,
			$merchant_bank,$charge]);
		}




		//HAPS Code   --- Advance Received Pay04--For Registration & Chasis Number--30-08-24


		if ($pay_type=="online"){
			$bankacc = $r->input('BankAcc1');//post input
		}

		if ($pay_type=="bkash"){
			$bankacc = $r->input('BankAcc2');//post input
			$card_charges_acc = $r->input('BankAcc22');//post input
		}

		if ($pay_type=="card"){
			$bankacc = $r->input('BankAcc4');//post input
			$card_charges_acc = $r->input('BankAcc44');//post input
		}


		$myRef= DB::select("SELECT max(id) as id FROM `pay`");
		foreach($myRef as $item){$RefNo = $item->id;}
		$vRef = 'ADV-'.$RefNo;

		$myCustName = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
		foreach($myCustName as $item){$custName = $item->customer_nm;}

		$custInfo = $customer_id.' '.$custName;


		$check_ref = DB::table('tbl_acc_details')->where('ref', $vRef);

		if ( $check_ref !== null){

			$check_ref->delete();

		}


		if ($received > 0) {


			if ($pay_type == 'cash'  ){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Cash at Workshop',$custInfo, $received, '0', NULL, $job_no]);

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $received, NULL, $job_no]);

			}

			if ( $pay_type=="card" ){

				if ($charge > 0){

					$totalRec = $received+$charge;

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Receivable against Card',$custInfo, $totalRec,'0', NULL, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $totalRec, NULL, $job_no]);


					// DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					// VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $card_charges_acc  ,$custInfo, $charge, '0', $customer_id, $chequeNo, $chequeDt, $bankacc, $job_no]);

					// DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					// VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', $customer_id, $chequeNo, $chequeDt, $bankacc, $job_no]);

					// DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					// VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Receivable against Card',$custInfo, '0', $totalRec, $customer_id, $job_no]);


				}

				if ($charge == 0){


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Receivable against Card',$custInfo, '0', $received, NULL, $job_no]);



				}


			}

			if($pay_type=="online")
			{
				$charge= 0;
			}


			if ($pay_type=="bkash" or $pay_type=="online" ){

				if ($charge > 0){

					$totalRec = $received+$charge;


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $card_charges_acc  ,$custInfo, $charge, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $totalRec, NULL, $job_no]);


				}

				if ($charge == 0){


					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`ch_date`,`b_name`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, $bankacc ,$custInfo, $received, '0', NULL, $chequeNo, $chequeDt, $bankacc, $job_no]);

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`, `job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?)',['Advance Receipt','0',$vRef, $dt, 'Advance from Customer',$custInfo, '0', $received, NULL, $job_no]);



				}


			}




		}

		// End Code




		return redirect(route("payAdvance",['customer_id' => $customer_id]), 307);

		//return view ('payAdvance',['customer_id' => $customer_id]);
		//return redirect ('/cashIn')->with('alert', 'Recived Sucessfully!!!');
	}




	public function receipt(Request $r)
	{
		$bill=$r->input('bill_no');//post input
		return view ('payPrint03',['bill' => $bill]);
	}
	public function form07()
	{
		return view ('form07');
	}
	public function multiPay(Request $r)
	{
		 $job_no=$r->input('job_no');//post input
		 return view ('multiPay',['job_no' => $job_no]);
	}

	public function review01(Request $r)
	{
		$received_c=$r->input('received_c');//post input
		$received_k=$r->input('received_k');//post input
		$received_p=$r->input('received_p');//post input
		$received_b=$r->input('received_b');//post input
		$bonus=$r->input('bonus');//post input
		$vat_wav=$r->input('vat_wav');//post input
		$job_no=$r->input('job_no');//post input
		$bill=$r->input('bill');//post input
		$type=$r->input('type');//post input
		$net_bill=$r->input('net_bill');//post input
		$bill_dt=$r->input('bill_dt');//post input
		$pay_type=$r->input('pay_type');//post input
		$customer_id=$r->input('customer_id');//post input
		$total=$r->input('total');//post input
		$ref=$r->input('ref');//post input
		$note=$r->input('note');//post input
		$trix=$r->input('trix');//post input
		$send=$r->input('send');//post input
		$bank=$r->input('bank');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$chequeDt=$r->input('chequeDt');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");

		 return view ('review01',[
		 'received_c' => $received_c,'received_k' => $received_k,'received_b' => $received_b,
		 'received_p' => $received_p,
		 'bonus' => $bonus,'vat_wav' => $vat_wav,'job_no' => $job_no,
		 'bill' => $bill,'type' => $type,'net_bill' => $net_bill,
		 'bill_dt' => $bill_dt,'pay_type' => $pay_type,'customer_id' => $customer_id,
		 'total' => $total,'ref' => $ref,'note' => $note,
		 'trix' => $trix,'send' => $send,'bank' => $bank,
		 'chequeNo' => $chequeNo,'chequeDt' => $chequeDt
		 ]);

	}

	public function due()
	{
		return view ('due');
	}
	public function refWiseDue()
	{
		return view ('refWiseDue');
	}
	public function refWiseDue01(Request $r)
	{
		$ref=$r->input('ref');//post input
		return view ('refWiseDue01',['ref' => $ref]);
	}
	public function receive()
	{
		return view ('receive');
	}
	public function financialCharge()
	{
		return view ('financialCharge');
	}
	public function moneyReceipt()
	{
		return view ('moneyReceipt');
	}
	public function moneyReceipt01(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		return view ('moneyReceipt01',['job_no' => $job_no]);
	}
	public function moneyReceipt02(Request $r)
	{
		$id=$r->input('id');//post input
		$bill=$r->input('bill');//post input
		$job_no=$r->input('job_no');//post input
		return view ('moneyReceipt02',['id' => $id,'job_no' => $job_no,'bill' => $bill]);
	}
	public function moneyReceipt03(Request $r)
	{
		$id=$r->input('id');//post input
		$bill=$r->input('bill');//post input
		$job_no=$r->input('job_no');//post input
		return view ('moneyReceipt03',['id' => $id,'bill' => $bill,'job_no' => $job_no]);
	}
	public function moneyReceipt04(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('moneyReceipt04',['id' => $id]);
	}
	public function moneyReceipt05(Request $r)
	{

	}
	public function moneyReceipt06(Request $r)
	{
		$id=$r->input('id');//post input
		$bill=$r->input('bill');//post input
		$job_no=$r->input('job_no');//post input
		return view ('moneyReceipt06',['id' => $id,'job_no' => $job_no,'bill' => $bill]);
	}
	public function moneyReceipt07(Request $r)
	{
		$id=$r->input('id');//post input
		$bill=$r->input('bill');//post input
		$job_no=$r->input('job_no');//post input
		return view ('moneyReceipt07',['id' => $id,'job_no' => $job_no,'bill' => $bill]);
	}
	public function refWiseDueEdit(Request $r)
	{
		$ref = DB::table('pay')->distinct()->get('ref');
		$job_no=$r->input('job_no');//post input
		$ref01=$r->input('ref');//post input
		return view ('refWiseDueEdit',['job_no' => $job_no,'ref' => $ref,'ref01' => $ref01]);
	}
	public function refWiseDueEdit01(Request $r)
	{
		$ref=$r->input('ref');//post input
		$job_no=$r->input('job_no');//post input

		$result = DB::table('pay')->where('job_no', $job_no)->where('ref', '<>', 'SYS')
		->update(['ref' => $ref]);
		return redirect ('/refWiseDue')->with('alert', 'Recived Sucessfully!!!');
	}
	public function chequeApproval()
	{
		return view ('chequeApproval');
	}
	public function chequeConfirm()
	{
		return view ('chequeConfirm');
	}




	public function chequeApproval01(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		$id=$r->input('id');//post input
		$customer_id=$r->input('customer_id');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$received=$r->input('received');//post input
		$due=$r->input('due');//post input
		$dt = date("Y-m-d");


		if($job_no!='Advance')
		{
			///HAPS Code
			$my_bk_acc2 = $r->bank_02[0];
			if ($my_bk_acc2 == null or $my_bk_acc2 == '--Select Bank A/C--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}
			$my_adj_type = $r->adj1[0];
			if ($my_adj_type == null or $my_adj_type == '--Select Adjust Type--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}
			//End Code

			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('pay_type', 'cheque')
			//->where('due', '0')
			->update(['received' => $received,'due' => $due,'dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);



			/// HAPS Code -- Cheque Received from Customer--02

			$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
			foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

			$myRef= DB::select("SELECT id FROM `pay` WHERE `chequeNo` = '$chequeNo' AND `received` ='$received'");
			foreach($myRef as $item){$RefNo = $item->id;}

			//dd($RefNo );
			$Ref = 'COL-'.$RefNo;

			// $check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

			// if ( $check_ref !== null){

			// 	$check_ref->delete();

			// }


			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
			foreach($my_Data as $item)
			{
				$work = $item->work;

			}


			if ($work =='engineering'){

				$myCustomerAcc = 'Workshop Customer';
			}
			if ($work =='intercompany'){

				$myCustomerAcc = 'Intercompany Customer';
			}
			if ($work =='automobile'){

				$myCustomerAcc = 'Automobile Customer';
			}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $my_bk_acc2, $customer_nm, $received, '0', $customer_id, $chequeNo, $job_no]);

			if($my_adj_type == 'Advance'){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer', $customer_nm, '0', $received, $customer_id, $chequeNo, $job_no]);

			}else{

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc, $customer_nm, '0', $received, $customer_id, $chequeNo, $job_no]);

			}

			/// End Code



		}
		if($job_no=='Advance')
		{

			///HAPS Code
			$my_bk_acc4 = $r->bank_04[0];
			if ($my_bk_acc4 == null or $my_bk_acc4 == '--Select Bank A/C--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}

			$my_adj_type = $r->adj1[0];
			if ($my_adj_type == null or $my_adj_type == '--Select Adjust Type--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}

			//End Code


			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('customer_id', $customer_id)
			->where('pay_type', 'cheque')
			->where('received', '0')
			->update(['received' => $received,'due' => $due,'dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);


			/// HAPS Code -- Cheque Received from Customer -- 04

			$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
			foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

			$myRef= DB::select("SELECT id FROM `pay` WHERE `chequeNo` = '$chequeNo' AND `received` ='$received'");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'ADV-'.$RefNo;

			// $check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

			// if ( $check_ref !== null){

			// 	$check_ref->delete();

			// }

			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
			foreach($my_Data as $item)
			{
				$work = $item->work;

			}


			if ($work =='engineering'){

				$myCustomerAcc = 'Workshop Customer';
			}
			if ($work =='intercompany'){

				$myCustomerAcc = 'Intercompany Customer';
			}
			if ($work =='automobile'){

				$myCustomerAcc = 'Automobile Customer';
			}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $my_bk_acc4, $customer_nm, $received, '0', NULL, $chequeNo, $job_no]);

			if($my_adj_type == 'Advance'){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer', $customer_nm, '0', $received, NULL, $chequeNo, $job_no]);

			}else{

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc, $customer_nm, '0', $received, NULL, $chequeNo, $job_no]);

			}
			/// End Code
		}


		return redirect ('/chequeApproval')->with('alert', 'Cheque Approval Sucessfully!!!');
	}








	public function chequeApproval02(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		$id=$r->input('id');//post input
		$customer_id=$r->input('customer_id');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$received=$r->input('received');//post input
		$due=$r->input('due');//post input
		$dt = date("Y-m-d");


		if($job_no!='Advance')
		{
			///HAPS Code
			$my_bk_acc1 = $r->bank_01[0];
			if ($my_bk_acc1 == null or $my_bk_acc1 == '--Select Bank A/C--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}

			$my_adj_type = $r->adj1[0];
			if ($my_adj_type == null or $my_adj_type == '--Select Adjust Type--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}
			//End Code

			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('pay_type', 'cheque')
			//->where('due', '0')
			->update(['received' => $received,'due' => $due,'pay_type' => 'cash','dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);

				/// HAPS Code -- Cheque Received from Customer---01

				$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
				foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

				$myRef= DB::select("SELECT id FROM `pay` WHERE `chequeNo` = '$chequeNo' AND `received` ='$received'");
				foreach($myRef as $item){$RefNo = $item->id;}
				$Ref = 'COL-'.$RefNo;

				// $check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

				// if ( $check_ref !== null){

				// 	$check_ref->delete();

				// }


				$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
				foreach($my_Data as $item)
				{
					$work = $item->work;

				}


				if ($work =='engineering'){

					$myCustomerAcc = 'Workshop Customer';
				}
				if ($work =='intercompany'){

					$myCustomerAcc = 'Intercompany Customer';
				}
				if ($work =='automobile'){

					$myCustomerAcc = 'Automobile Customer';
				}

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
						VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $my_bk_acc1, $customer_nm, $received, '0', $customer_id, $chequeNo, $job_no]);

				if($my_adj_type == 'Advance'){

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
						VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer', $customer_nm, '0', $received, $customer_id, $chequeNo, $job_no]);

				}else{

					DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc, $customer_nm, '0', $received, $customer_id, $chequeNo, $job_no]);

				}
				/// End Code

		}


		if($job_no=='Advance')
		{
			///HAPS Code
			$my_bk_acc3 = $r->bank_03[0];
			if ($my_bk_acc3 == null or $my_bk_acc3 == '--Select Bank A/C--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}
			$my_adj_type = $r->adj1[0];
			if ($my_adj_type == null or $my_adj_type == '--Select Adjust Type--'){
				return redirect ('/chequeApproval')->with('alert', 'Please select a bank acc and adj type!');
			}
			//End Code

			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('customer_id', $customer_id)
			->where('pay_type', 'cheque')
			->where('received', '0')
			->update(['received' => $received,'due' => $due,'pay_type' => 'cash','dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);


			/// HAPS Code -- Cheque Received from Customer --03

			$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
			foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

			$myRef= DB::select("SELECT id FROM `pay` WHERE `chequeNo` = '$chequeNo' AND `received` ='$received'");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'ADV-'.$RefNo;

			// $check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

			// if ( $check_ref !== null){

			// 	$check_ref->delete();

			// }

			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
			foreach($my_Data as $item)
			{
				$work = $item->work;

			}


			if ($work =='engineering'){

				$myCustomerAcc = 'Workshop Customer';
			}
			if ($work =='intercompany'){

				$myCustomerAcc = 'Intercompany Customer';
			}
			if ($work =='automobile'){

				$myCustomerAcc = 'Automobile Customer';
			}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $my_bk_acc3, $customer_nm, $received, '0', NULL, $chequeNo, $job_no]);

			if($my_adj_type == 'Advance'){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer', $customer_nm, '0', $received, NULL, $chequeNo, $job_no]);

			}else{

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $myCustomerAcc, $customer_nm, '0', $received, NULL, $chequeNo, $job_no]);

			}
			/// End Code


		}

		return redirect ('/chequeApproval')->with('alert', 'Cheque Approval Sucessfully!!!');
	}




	public function chequeApproval03(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('chequeApproval03',['id' => $id]);
	}





	public function chequeApproval04(Request $r)
	{
		$id=$r->input('id');//post input
		$denyImage = $r->file('denyImage');
		$dt = date("Y-m-d");
		$this->validate($r, [
			'denyImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
		]);
        $imageName = $id.'.'.$denyImage->extension();
        $denyImage->move(public_path('/upload/deny/'), $imageName);

		$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
		->update(['flag' => '2','denyImage' => $imageName, 'denyDt' => $dt]);

		return redirect ('/chequeApproval')->with('alert', 'Deny Image Upload Sucessfully!!!');
	}
	public function chequeConfirm01(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		$id=$r->input('id');//post input
		$customer_id=$r->input('customer_id');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$received=$r->input('received');//post input
		$due=$r->input('due');//post input
		$dt = date("Y-m-d");
		$user_id = session('user_id');
		if($job_no!='Advance')
		{
			$result = DB::table('cheque_pending')->where('id', $id)->where('confirm', '0')
			->update(['confirm' => '1','confirmBy' => $user_id ]);
		}
		if($job_no=='Advance')
		{
			$result = DB::table('cheque_pending')->where('id', $id)->where('confirm', '0')
			->update(['confirm' => '1','confirmBy' => $user_id]);
		}
		return redirect ('/chequeConfirm')->with('alert', 'Cheque Approval Sucessfully!!!');
	}
	public function chequeConfirm02(Request $r)
	{
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input
		$chequeNo=$r->input('chequeNo');//post input
		return view ('chequeConfirm02',['id' => $id,'job_no' => $job_no,'chequeNo' => $chequeNo]);
	}



	public function chequeConfirm03(Request $r)
	{
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$denyImage = $r->file('denyImage');
		$this->validate($r, [
			'denyImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
		]);
        $imageName = $id.'.'.$denyImage->extension();
        $denyImage->move(public_path('/upload/deny/'), $imageName);

		$result = DB::table('cheque_pending')->where('id', $id)->where('confirm', '0')
		->update(['flag' => '0','confirm' => '','denyImage' => $imageName,'confirmBy' => $user_id]);

		$pay_row = DB::table('pay')->where('job_no', $job_no)->where('chequeNo', $chequeNo)
		->first();

		$result = DB::table('pay')->where('job_no', $job_no)->where('chequeNo', $chequeNo)
		->update(['received' => '0','due' =>  (float)$pay_row->received + (float)$pay_row->due ]);

		DB::insert('INSERT INTO `cheque_disorder`(`job_no`, `chequeNo`, `dt`, `user_id`) VALUES (?,?,?,?)',[$job_no,$chequeNo,$dt,$user_id]);


		/// HAPS Code -- Cheque Dishonoured Entry


		$myRef= DB::select("SELECT id FROM `pay` WHERE `chequeNo` = '$chequeNo' ");
		foreach($myRef as $item){$RefNo = $item->id;}
		$Ref = 'DIS-'.$RefNo;

		$dt = date("Y-m-d");

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}

		$dt_tran_credit = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ch_no`='$chequeNo' AND `credit` > '0' ");

		$dt_tran_debit = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ch_no`='$chequeNo' AND `debit` > '0' ");

		foreach($dt_tran_credit as $itemCr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $itemCr->ahead, $itemCr->narration, $itemCr->credit, 0, $itemCr->others_id, $chequeNo, $job_no]);

		}

		foreach($dt_tran_debit as $itemDr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $itemDr->ahead, $itemDr->narration, '0', $itemDr->debit, $itemDr->others_id, $chequeNo, $job_no]);

		}





		/// End Code


		return redirect ('/chequeConfirm')->with('alert', 'Deny Image Upload Sucessfully!!!');
	}





	public function advanceReceipt()
	{
		return view ('advanceReceipt');
	}
	public function ait()
	{
		return view ('ait');
	}
	public function vatProvision()
	{
		return view ('vatProvision');
	}
	public function aitReport()
	{
		return view ('aitReport');
	}
	public function vatReport()
	{
		return view ('vatReport');
	}
	public function aitCollect()
	{
		return view ('aitCollect');
	}
	public function vatCollect()
	{
		return view ('vatCollect');
	}
	public function vdsCollect()
	{
		return view ('vdsCollect');
	}
	public function collectedVat()
	{
		return view ('collectedVat');
	}
	public function collectedVat01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('collectedVat01',['from_dt' => $from_dt,'to_dt' => $to_dt]);
	}
	public function aitApproval(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('aitApproval',['id' => $id]);
	}
	public function vat_proApproval(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('vat_proApproval',['id' => $id]);
	}
	public function ait01(Request $r)
	{
		$id=$r->input('id');//post input
		$tr_no=$r->input('tr_no');//post input
		$tr_dt=$r->input('tr_dt');//post input
		$bin=$r->input('bin');//post input
		$user_id = session('user_id');

		$result = DB::table('ait')
		->where('id', $id)
		->update(['flag' => '1','user_id' => $user_id
		,'tr_no' => $tr_no,'tr_dt' => $tr_dt,'bin' => $bin]);
		return view ('ait');
	}
	public function vat_pro01 (Request $r)
	{
		 $bin=$r->input('bin');//post input
		 $chalan6no=$r->input('chalan6no');//post input
		 $chalan6dt=$r->input('chalan6dt');//post input
		 $taxdt=$r->input('taxdt');//post input
		 $chalan3no=$r->input('chalan3no');//post input
		 $chalan3dt=$r->input('chalan3dt');//post input
		 $job_no=$r->input('job_no');//post input
		 $vat_pro=$r->input('vat_pro');//post input
		 $dt = date("Y-m-d");
		 $user_id = session('user_id');

		$data = DB::select("SELECT `customer_nm`,`total` FROM `bill_mas` WHERE job_no='$job_no'");
		foreach($data as $item){ $customer_nm = $item->customer_nm ;$total = $item->total ;}

		$result = DB::table('vat_pro')
		->where('job_no', $job_no)
		->update(['bin' => $bin,'chalan6no' => $chalan6no,'chalan6dt' => $chalan6dt,'taxdt' => $taxdt,
		'chalan3no' => $chalan3no
		,'chalan3dt' => $chalan3dt,'vat_pro' => $vat_pro,'dt' => $dt,'user_id' => $user_id,
		'customer_nm' => $customer_nm
		,'total' => $total,'flag' => '1']);


		return redirect ('/vatProvision')->with('alert', 'Vat Collection Sucessfully!!!');
	}
    public function payAdvance(Request $r)
    {
		$customer_id=$r->input('customer_id');//post input
		return view ('payAdvance',['customer_id' => $customer_id]);
    }




	public function refund(Request $r)
	{

		///HAPS Code
		$my_bk_acc1 = $r->bank_01[0];
		if ($my_bk_acc1 == null or $my_bk_acc1 == '--Select Bank A/C--'){
			return redirect ('advanceReceipt')->with('alert', 'Please select a bank account!');
		}


		$id=$r->input('id');//post input

		$result = DB::select("
		SELECT `job_no`,a.`customer_id`,`dt`,`received`,`pay_type`, customer_nm
		FROM `pay` a, `customer_info` b
		WHERE a.`id` = '$id'
		and a.customer_id = b.customer_id
		");
		foreach($result as $item)
		{
			$job_no = $item->job_no;
			$customer_id = $item->customer_id;
			$customer_nm = $item->customer_nm;
			$dt = $item->dt;
			$received = $item->received;
			$pay_type = $item->pay_type;
			$user_id = session('user_id');
		}
		DB::insert('INSERT INTO `refund`(`job_no`, `customer_id`,`customer_nm`, `received`, `receipt_id`, `payment_type`,
		`received_dt`,`user_id`) VALUES (?,?,?,?,?,?,?,?)',[$job_no,$customer_id,$customer_nm,$received,$id,$pay_type,
		$dt,$user_id]);

		$result = DB::table('pay')->where('id', $id)->delete();



		/// HAPS Code for Refund


		$my_Data = DB::select("SELECT *  FROM `bill_mas` where `customer_id` = '$customer_id'");
		foreach($my_Data as $item)
		{

			$work = $item->work;
			$parts = $item->parts;
			$service= $item->service;
			$total = $item->total;
			$bill_dt = $item->bill_dt;
			$customer_nm = $item->customer_nm;


		}


		if ($work =='engineering'){

			$myCustomerAcc = 'Workshop Customer';
		}
		if ($work =='intercompany'){

			$myCustomerAcc = 'Intercompany Customer';
		}
		if ($work =='automobile'){

			$myCustomerAcc = 'Automobile Customer';
		}


		$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
		foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

		$dt_Ref_id = DB::select("SELECT * FROM `pay` WHERE `customer_id` ='$customer_id'");
		foreach($dt_Ref_id as $item){	$myRef_id= $item->id;}

		if ($job_no == 'Advance'){

			$Ref = 'ADR-'.$myRef_id;
		}else{
			$Ref = 'ADR-'.$job_no;
		}




		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}

		$dt = date("Y-m-d");



		// ****** Reverse Entry

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, 'Advance from Customer' , $customer_nm, $received, '0', NULL, $job_no]);

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $my_bk_acc1 , $customer_nm, '0', $received, NULL, $job_no]);



		//END HAPS Code---


		return view ('advanceReceipt');
	}








	public function advanceRefund()
	{
		return view ('advanceRefund');
	}

	public function declineBankPOS()
	{
		return view ('declineBankPOS');
	}



//multi receive
	public function pay03(Request $r)
	{
		$received_c=$r->input('received_c');//post input
		$received_k=$r->input('received_k');//post input
		$received_p=$r->input('received_p');//post input
		$received_b=$r->input('received_b');//post input
		$bonus=$r->input('bonus');//post input
		$vat_wav=$r->input('vat_wav');//post input
		$job_no=$r->input('job_no');//post input
		$bill=$r->input('bill');//post input
		$type=$r->input('type');//post input

		$net_bill=$r->input('net_bill');//post input
		$bill_dt=$r->input('bill_dt');//post input
		$pay_type=$r->input('pay_type');//post input
		$customer_id=$r->input('customer_id');//post input
		$total=$r->input('total');//post input
		$ref=$r->input('ref');//post input
		$note=$r->input('note');//post input
		$trix=$r->input('trix');//post input
		$send=$r->input('send');//post input
		$bank=$r->input('bank');//post input
		$chequeNo=$r->input('chequeNo');//post input
		$chequeDt=$r->input('chequeDt');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$bill_no = "";




		$number = count($job_no);
		if($number>1)
		{
			for($i=0; $i<$number; $i++)
			{
				if(trim($job_no[$i])!='')
				{
					 $bill1=$bill[$i];
					 $job_no1 = $job_no[$i];
					 $customer_id1 = $customer_id[$i];
					 $bonus1=$bonus[$i];
					 $vat_wav1=$vat_wav[$i];
					 $received_c1=$received_c[$i];
					 $received_k1=$received_k[$i];
					 $received_b1=$received_b[$i];
					 $ref1=$ref[$i];
					 $note1=$note[$i];
					 $trix1=$trix[$i];
					 $send1=$send[$i];
					 $bank1=$bank[$i];
					 $chequeNo1=$chequeNo[$i];
					 $chequeDt1=$chequeDt[$i];
					 $received1=($received_c1+$received_k1+$received_b1);
					 $due1=$total[$i]-($received1+$bonus1+$vat_wav1);

if($received1!='0')
{
$result01 = DB::select("
SELECT sum(`received`) advance FROM `pay`
WHERE `bill` = 'Advance'
and `customer_id` = '$customer_id1' and `job_no` = '$job_no1';
");
foreach($result01 as $item01)
		{
			$advance = $item01->advance;
		}


}
/*
		DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `received`,`bonus`,`vat_wav`,
		`due`, `dt`, `user_id`,`pay_type`,`ref`,`note`,`trix`, `send`, `bank`, `chequeNo`, `chequeDt`)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill1,$job_no1,$customer_id1,round($received1,2),
round($bonus1,2),round($vat_wav1,2), round(-$due1,2),$dt,$user_id,'Multi',$ref1,$note1,$trix1,$send1,
$bank1,$chequeNo1,$chequeDt1]);

		if($due01!='0')
			{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '2']);

				$data = DB::table('gatepass')->where('bill_no', $bill)->get();
				foreach($data as $item){ $bill_no = $item->bill_no ;}
				if($bill_no=="")
				{
				DB::insert('INSERT INTO `gatepass`(`bill_no`, `flag`, `user_id`)
							VALUES (?,?,?)',[$bill,'0',$user_id]);
				}

				//return view ('payPrint01',['bill' => $bill]);
			}

		if($due01=='0')
			{
				DB::table('bill_mas')->where('bill_no', $bill)
				->update(['flag' => '3']);

				$data = DB::table('gatepass')->where('bill_no', $bill)->get();
				foreach($data as $item){ $bill_no = $item->bill_no ;}
				if($bill_no=="")
				{
				DB::insert('INSERT INTO `gatepass`(`bill_no`, `flag`, `user_id`)
							VALUES (?,?,?)',[$bill,'1',$user_id]);
				}
				//return view ('payPrint',['bill' => $bill]);
			}
*/


				}
			}
		}
	}




	public function bankDeclineForm()
	{
		return view ('bankDeclineForm');
	}

	public function bankDeclinePayment(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		$card_no=$r->input('card_no');//post input
		return view ('bankDeclinePayment',['job_no' => $job_no, 'card_no' => $card_no]);
	}

	public function bankDeclinePayment01(Request $r)
	{
		$reg_no=$r->input('reg_no');//post input
		$chassis_no=$r->input('chassis_no');//post input
		$card_no=$r->input('card_no');//post input
		return view ('bankDeclinePayment01',['reg_no' => $reg_no, 'chassis_no' => $chassis_no, 'card_no' => $card_no]);
	}

	public function bankDeclinePaymentConfirm(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('bankDeclinePaymentConfirm',['id' => $id]);
	}



	public function bankDeclinePaymentSubmit(Request $r)
	{
		$id=$r->input('id');//post input

		$row_pay = DB::table('pay')->where('id', $id)->first();

		//echo "<pre>";print_r($row_pay);exit;

		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$denyImage = $r->file('denyImage');
		$this->validate($r, [
			'denyImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
		]);
        $imageName = $id.'.'.$denyImage->extension();
        $denyImage->move(public_path('/upload/deny/'), $imageName);

		DB::table('bank_decline_payments')->insert(
			[
				'job_no' => $row_pay->job_no,
				'bank' => $row_pay->card_bank,
				'card_no' => $row_pay->card_no,
				'received' => $row_pay->received,
				'bonus' => $row_pay->bonus,
				'vat_wav' => $row_pay->vat_wav,
				'vat_pro' => $row_pay->vat_pro,
				'ait' => $row_pay->ait,
				'due' => $row_pay->due,
				'charge' => $row_pay->charge,
				'dt' => $dt,
				'user_id' => $user_id,
				'image' => $imageName,
				'pay_id' => $id
			]
		);

		$result = DB::table('pay')->where('id', $id)
		->update(['received' => '0','bonus' => '0','vat_wav' => '0','vat_pro' => '0','ait' => '0','due' => '0','charge' => '0']);




		/// HAPS Code -- For reverse Entry POS


		$ref_col=$r->input('vch_no');//post input


		$Ref = $ref_col.'R';

		//dd($Ref);

		// ************** Entry-1 *****************

		$dt_tran_credit = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ref`='$ref_col' AND `credit` > '0' ");

		$dt_tran_debit = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ref`='$ref_col' AND `debit` > '0' ");

		foreach($dt_tran_credit as $itemCr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $itemCr->ahead, $itemCr->narration, $itemCr->credit, 0, $itemCr->others_id, $itemCr->ch_no, $itemCr->job_no]);

		}

		foreach($dt_tran_debit as $itemDr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $dt, $itemDr->ahead, $itemDr->narration, '0', $itemDr->debit, $itemDr->others_id, $itemCr->ch_no, $itemCr->job_no]);

		}

		// ************** Entry-2 *****************

		$ref_col2=$r->input('vch_no2');//post input


		$Ref2 = $ref_col2.'R';

		//dd($Ref);



		$dt_tran_credit2 = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ref`='$ref_col2' AND `credit` > '0' ");

		$dt_tran_debit2 = DB::select("SELECT * FROM `tbl_acc_details` WHERE `ref`='$ref_col2' AND `debit` > '0' ");

		foreach($dt_tran_credit2 as $itemCr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref2, $dt, $itemCr->ahead, $itemCr->narration, $itemCr->credit, 0, $itemCr->others_id, $itemCr->ch_no, $itemCr->job_no]);

		}

		foreach($dt_tran_debit2 as $itemDr){

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`ch_no`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref2, $dt, $itemDr->ahead, $itemDr->narration, '0', $itemDr->debit, $itemDr->others_id, $itemCr->ch_no, $itemCr->job_no]);

		}




		/// End Code








		return redirect ('/bankDeclineForm')->with('alert', 'Bank Decline (POS) Image Upload Sucessfully!!!');
	}





}
