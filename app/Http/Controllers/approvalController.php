<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class approvalController extends Controller
{
    public function approval()
	{
		return view ('approval');
	}


	public function approval01(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$today = date("Y-m-d");
		$job_no = 'X';

		$user_id = session('user_id');
		$result = DB::select("
		SELECT `bill_no`, a.customer_id, b.customer_nm, b.customer_mobile, `job_no`, `user_id`, `total` net_bill ,bill_dt,`job_dt`
		FROM `bill_mas` a, customer_info b
		WHERE a.customer_id = b.customer_id and bill_no= '$bill_no' and a.`flag` = '0'
		");
		foreach($result as $item)
			{
				$bill_dt = $item->bill_dt;
				$job_no = $item->job_no;
				$customer_id = $item->customer_id;
				$customer_nm = $item->customer_nm;
				$customer_mobile = $item->customer_mobile;
				$net_bill = $item->net_bill;
				$job_dt = $item->job_dt;
			}
			//job Already Approved
			if($job_no=='X')
			{
					return redirect ('/approval')->with('alert', 'This job Already Approved Before!!!');
			}

    		$result = DB::table('bill_mas')->where('bill_no', $bill_no)
    		->update(['flag' => '1', 'bill_dt' => $today]);

			DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `bill_dt`, `net_bill`, `received`, `bonus`, `due`, `dt`, `user_id`,`pay_type`,`ref`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$bill_no,$job_no,$customer_id,$bill_dt,$net_bill,"0","0",$net_bill,$today,$user_id,"SYS","SYS"]);

			DB::insert('INSERT INTO `gatepass`(`bill_no`, `flag`, `user_id`,`job_no`)
			VALUES (?,?,?,?)',[$bill_no,'1',$user_id,$job_no]);

			$id = '';
			$data = DB::select("SELECT `id` FROM `pay` WHERE `job_no` = '$job_no' AND `bill` = 'Advance';");
			foreach($data as $item){ $id = $item->id ;}
			if($id!='')
			{$result = DB::table('pay')->where('id', $id)->update(['bill' => $bill_no]);}


			/// HAPS Code  ---For Sales Recognition--30-08-24


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

			$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' ");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'SRE-'.$RefNo;

			$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

			if ( $check_ref !== null){

				$check_ref->delete();

			}


			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $bill_dt, $myCustomerAcc, $customer_nm, $total, '0', $customer_id,  $job_no]);

			if ($vat!==0){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $bill_dt, 'VAT Current A/C',$customer_nm, '0', $vat, $customer_id,  $job_no]);
			}

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $bill_dt, 'Parts Revenue',$customer_nm, '0', $parts, $customer_id,  $job_no]);

			if ($service!=='0'){
				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $bill_dt, 'Service Revenue',$customer_nm, '0', $service, $customer_id,  $job_no]);
			}


			/// HAPS_Code ---For COGS Recognition

			$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' ");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'COG-'.$RefNo;


			$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

			if ( $check_ref !== null){

				$check_ref->delete();

			}

			$myAmount = DB::select("SELECT sum(`amount`) as amount FROM `issue` WHERE `job_no`='$job_no';");
			foreach($myAmount as $item){$amount = $item->amount;}

			if ($amount > 0 ){

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['COGS Invoice','0',$Ref, $bill_dt, 'Cost of Goods Sold',$job_no, $amount, '0', $customer_id, $job_no]);

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['COGS Invoice','0',$Ref, $bill_dt, 'Inventory-WIP-Spare Parts',$job_no, '0', $amount, $customer_id, $job_no]);


			}

			/// HAPS Code  ---For Advance Adjustment

			$today = date("Y-m-d");

			$my_balance = DB::select("SELECT SUM(debit-credit) as Balance FROM `tbl_acc_details` WHERE `others_id` = '$customer_id' AND `ahead` ='Advance from Customer';");

			foreach($my_balance as $item)
			{
				$adv_balance = $item->Balance;
			}

			if( $adv_balance < 0){

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


				$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
				foreach($my_Data as $item)
				{
					$customer_nm = $item->customer_nm;

				}


				$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' and `job_no` ='$job_no';");
				foreach($myRef as $item){$RefNo = $item->id;}
				$Ref = 'AAJ-'.$RefNo;

				$myNarration = $customer_id.'-'.$customer_nm;

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, 'Advance from Customer', $myNarration, -$adv_balance, '0', $customer_id, $job_no]);

				DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, $myCustomerAcc, $myNarration, '0', -$adv_balance, $customer_id, $job_no]);



			}


			//// End HAPS Code ---


		return back();
	}




    public function gatePassApproval()
	{
		return view ('gatePassApproval');
	}
	public function gatePassApproval01(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$result = DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['flag' => '3']);
		$result = DB::table('gatepass')->where('bill_no', $bill_no)
		->update(['flag' => '1']);
		return back();

	}
	public function gatePassPrint()
	{
		return view ('gatePassPrint');
	}
	public function gatePassPrint01(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input

		$result = DB::table('gatepass')->where('bill_no', $bill_no)
		->update(['flag' => '2']);

		return view ('payPrint02',['bill' => $bill_no]);

	}
	public function gatepassList()
	{
		return view ('gatepassList');
	}
	public function gatepassList01(Request $r)
	{
		$job_no=$r->input('job_no');//post input
		return view ('gatepassList01',['job_no' => $job_no]);
	}
	public function mfsCheck()
	{
		return view ('mfsCheck');
	}


	public function mfsCheck01(Request $r)
	{
		$id=$r->input('id');//post input
		$approval_dt=$r->input('approval_dt');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');


		///HAPS Code
		$my_bk_acc1 = $r->bank_01[0];
		if ($my_bk_acc1 == null or $my_bk_acc1 == '--Select Bank A/C--'){
			return redirect ('/mfsCheck')->with('alert', 'Please select a bank account!');
		}

		$my_bk_acc2 = $r->bank_02[0];
		if ($my_bk_acc2 == null or $my_bk_acc2 == '--Select MFS A/C--'){
			return redirect ('/mfsCheck')->with('alert', 'Please select a MFS account!');
		}
		//End Code



		/// HAPS Code  ---For MFS Amount confirmation

		$job_no=$r->input('job_no');//post input
		$customer_id=$r->input('customer_id');//post input
		$received=$r->input('received');//post input


		$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
		foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

		$myRef= DB::select("SELECT id FROM `pay` WHERE `customer_id` = '$customer_id' AND `received` ='$received' AND `pay_type` = 'bkash'");
		foreach($myRef as $item){$RefNo = $item->id;}

		//dd($RefNo );
		$Ref = 'MFS-'.$RefNo;

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}


		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $approval_dt ? $approval_dt : $today, $my_bk_acc1, $customer_nm, $received, '0', $customer_id, $job_no]);

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $approval_dt ? $approval_dt : $today, $my_bk_acc2, $customer_nm, '0', $received, $customer_id, $job_no]);

		/// End Code




		$result = DB::table('pay')->where('id', $id)
		->update(['pay_check' => '1','check_approval' => $user_id,'approval_dt' => $approval_dt ? $approval_dt : $today]);

		return back();
	}


	public function cardCheck()
	{
		return view ('cardCheck');
	}


	public function cardCheck01(Request $r)
	{

		$job_no=$r->input('job_no');//post input
		$customer_id=$r->input('customer_id');//post input
		$received=$r->input('received');//post input

		///HAPS Code
		$my_bk_acc2 = $r->bank_02[0];
		if ($my_bk_acc2 == null or $my_bk_acc2 == '--Select Bank A/C--'){
			return redirect ('/cardCheck')->with('alert', 'Please select a bank account!');
		}
		$my_ChargeAcc1 = $r->ChargeAcc1[0];
		if ($my_ChargeAcc1 == null or $my_ChargeAcc1 == '--Select Charge A/C--'){
			return redirect ('/cardCheck')->with('alert', 'Please select a card charges account!');
		}
		$my_ChargeAmt1 = $r->ChargeAmt1[0];
		$my_total_RecAmt = $received + $my_ChargeAmt1;
		//End Code


		$id=$r->input('id');//post input
		$approval_dt=$r->input('approval_dt');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::table('pay')->where('id', $id)
		->update(['pay_check' => '1','check_approval' => $user_id,'approval_dt' => $approval_dt ? $approval_dt : $today]);



		/// HAPS Code  ---For Card Amount confirmation


		$dt_custInfo = DB::select("SELECT `customer_nm` FROM `customer_info` WHERE `customer_id` ='$customer_id'");
		foreach($dt_custInfo as $item){	$customer_nm = $item->customer_nm;}

		$myRef= DB::select("SELECT id FROM `pay` WHERE `customer_id` = '$customer_id' AND `received` ='$received' AND `pay_type` = 'card'");
		foreach($myRef as $item){$RefNo = $item->id;}

		//dd($RefNo );
		$Ref = 'CNF-'.$RefNo;

		$check_ref = DB::table('tbl_acc_details')->where('ref', $Ref);

		if ( $check_ref !== null){

			$check_ref->delete();

		}

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $approval_dt ? $approval_dt : $today, $my_ChargeAcc1, $customer_nm, $my_ChargeAmt1, '0', $customer_id, $job_no]);

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $approval_dt ? $approval_dt : $today, $my_bk_acc2, $customer_nm, $received, '0', $customer_id, $job_no]);

		DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
				VALUES (?,?,?,?,?,?,?,?,?,?)',['Collection','0',$Ref, $approval_dt ? $approval_dt : $today, 'Receivable against Card', $customer_nm, '0', $my_total_RecAmt, $customer_id, $job_no]);

		/// End Code




		return back();
	}






	public function mfsReceipt()
	{
		return view ('mfsReceipt');
	}
	public function mfsReceipt01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$mer_bkash=$r->input('mer_bkash');//post input
		return view ('mfsReceipt01',['from_dt' => $from_dt,'to_dt' => $to_dt,'mer_bkash' => $mer_bkash]);
	}
	public function mfsReceipt02(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$mer_bkash=$r->input('mer_bkash');//post input
		return view ('mfsReceipt02',['from_dt' => $from_dt,'to_dt' => $to_dt, 'mer_bkash' => $mer_bkash]);
	}
	public function mfsReceiptPrint(Request $r)
	{
		$to_dt=$r->input('to_dt');//post input
		$mer_bkash=$r->input('mer_bkash');//post input
		return view ('mfsReceiptPrint',['to_dt' => $to_dt, 'mer_bkash' => $mer_bkash]);
	}
	public function cardReceiptPrint(Request $r)
	{
		$s_dt=$r->input('s_dt');//post input
		$merchant_bank=$r->input('merchant_bank');//post input
		return view ('cardReceiptPrint',['s_dt' => $s_dt,'merchant_bank' => $merchant_bank]);
	}

	public function cardReceipt()
	{
		return view ('cardReceipt');
	}
	public function cardReceipt01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$merchant_bank=$r->input('merchant_bank');//post input
		return view ('cardReceipt01',['from_dt' => $from_dt,'to_dt' => $to_dt,'merchant_bank' => $merchant_bank]);
	}
	public function cardReceipt02(Request $r)
	{
		$m_dt=$r->input('m_dt');//post input
		$s_dt=$r->input('s_dt');//post input
		$merchant_bank=$r->input('merchant_bank');//post input
		return view ('cardReceipt02',['m_dt' => $m_dt,'s_dt' => $s_dt,'merchant_bank' => $merchant_bank]);
	}
	public function advanceCheck()
	{
		return view ('advanceCheck');
	}
	public function advanceCheck01(Request $r)
	{
		$id=$r->input('id');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::table('pay')->where('id', $id)
		->update(['pay_check' => '1','check_approval' => $user_id,'approval_dt' => $today]);

		return back();
	}

	public function payAdvance01(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$id=$r->input('id');//post input
		return view ('payAdvance01',['customer_id' => $customer_id,'id' => $id]);
	}
	public function payAdvance02(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$customer_nm=$r->input('customer_nm');//post input
		$id=$r->input('id');//post input
		return view ('payAdvance02',['customer_id' => $customer_id,
		'customer_nm' => $customer_nm,'id' => $id]);
	}
	public function payAdvance03(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input

	$result = DB::select("
	SELECT `bill_no` FROM `bill_mas` WHERE `job_no` = '$job_no' and `customer_id` = $customer_id
	");
	foreach($result as $item)
		{
			 $bill_no = $item->bill_no;
		}

		$result = DB::table('pay')->where('id', $id)
		->update(['job_no' => $job_no,'bill' => $bill_no,'adjustment_dt' => date('Y-m-d')]);

	$result01 = DB::select("
	SELECT `bank`,`chequeNo`,`chequeDt` FROM `pay` WHERE `id` = '$id'");
	foreach($result01 as $item01)
		{
			$bank = $item01->bank;
			$chequeNo = $item01->chequeNo;
			$chequeDt = $item01->chequeDt;
		}

		$result = DB::table('cheque_pending')->where('bank', $bank)->where('chequeNo', $chequeNo)->where('chequeDt', $chequeDt)
		->update(['job_no' => $job_no]);


		/// HAPS Code  ---For Advance Adjustment

		$today = date("Y-m-d");

		$my_balance = DB::select("SELECT SUM(debit-credit) as Balance FROM `tbl_acc_details` WHERE `others_id` = '$customer_id' AND `ahead` ='Advance from Customer';");

		foreach($my_balance as $item)
		{
			$adv_balance = $item->Balance;
		}

		if( $adv_balance < 0){

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


			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
			foreach($my_Data as $item)
			{
				$customer_nm = $item->customer_nm;

			}


			$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' and `job_no` ='$job_no';");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'AAJ-'.$RefNo;

			$myNarration = $customer_id.'-'.$customer_nm;

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, 'Advance from Customer', $myNarration, -$adv_balance, '0', $customer_id, $job_no]);

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, $myCustomerAcc, $myNarration, '0', -$adv_balance, $customer_id, $job_no]);



		}


		//// End HAPS Code ---






	return redirect('/advanceCheck');

	}






	public function payAdvance04(Request $r)
	{
		$change_customer=$r->input('change_customer');//post input
		$id=$r->input('id');//post input
		$result = DB::table('pay')->where('id', $id)
		->update(['customer_id' => $change_customer]);

		return redirect('/advanceCheck');
	}

	public function payAdvance05(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input
		$amount=$r->input('amount');//post input

		$today = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::select("
		SELECT `bill_no` FROM `bill_mas` WHERE `job_no` = '$job_no' and `customer_id` = $customer_id
		");
		foreach($result as $item)
		{
			 $bill_no = $item->bill_no;
		}

		$pay_row = DB::table('pay')->where('id', $id)->first();

		$total_current_due = DB::table('pay')->where('job_no', $job_no)->where('customer_id', $customer_id)->sum('due');

		//echo "<pre>";print_r($total_current_due);exit;

		// check distribute amount
		if( $amount > $pay_row->received ){
			return redirect('/advanceCheck');
		}
		// check total current due
		if( $amount > $total_current_due ){
			return redirect('/advanceCheck');
		}

		$pay_row_dis = array(
			"bill" => $bill_no,
			"job_no" => $job_no,
			"customer_id" => $customer_id,
			"received" => $amount,
			"due" => -$amount,
			"pay_type" => $pay_row->pay_type,
			"ref" => "Advance",
			"note" => "distribute from pay id ".$id,
			"distributed_from_pay_id" => $id,
			"dt" => $today,
			"user_id" => $user_id,
			"adjustment_dt" => $today
		);

		DB::table('pay')->insert($pay_row_dis);

		//echo "<pre>";print_r($pay_row);echo "<pre>";print_r($pay_row_dis);exit;

		if( empty($pay_row->received_org) ){
			$result = DB::table('pay')->where('id', $id)->update(['received' => $pay_row->received - $amount,'due' => $pay_row->due + $amount,'received_org' => $pay_row->received]);
			$result = DB::table('cheque_pending')->where('bank', $pay_row->bank)->where('chequeNo', $pay_row->chequeNo)->where('chequeDt', $pay_row->chequeDt)->update(['job_no' => $job_no]);
		}
		else{
			$result = DB::table('pay')->where('id', $id)->update(['received' => $pay_row->received - $amount,'due' => $pay_row->due + $amount]);
		}



		/// HAPS Code  ---For Advance Adjustment

		$today = date("Y-m-d");

		$my_balance = DB::select("SELECT SUM(debit-credit) as Balance FROM `tbl_acc_details` WHERE `others_id` = '$customer_id' AND `ahead` ='Advance from Customer';");

		foreach($my_balance as $item)
		{
			$adv_balance = $item->Balance;
		}

		if( $adv_balance < 0){

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


			$my_Data = DB::select("SELECT *  FROM `bill_mas` where `job_no` = '$job_no'");
			foreach($my_Data as $item)
			{
				$customer_nm = $item->customer_nm;

			}


			$myRef= DB::select("SELECT max(id) as id FROM `pay` Where customer_id ='$customer_id' and `job_no` ='$job_no';");
			foreach($myRef as $item){$RefNo = $item->id;}
			$Ref = 'AAJ-'.$RefNo;

			$myNarration = $customer_id.'-'.$customer_nm;

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, 'Advance from Customer', $myNarration, -$adv_balance, '0', $customer_id, $job_no]);

			DB::insert('INSERT INTO `tbl_acc_details`( `vr_type`,`vr_sl`,`ref`,`tdate`,`ahead`,`narration`,`debit`,`credit`,`others_id`,`job_no`)
			VALUES (?,?,?,?,?,?,?,?,?,?)',['Sales Revenue','0',$Ref, $today, $myCustomerAcc, $myNarration, '0', -$adv_balance, $customer_id, $job_no]);



		}


		//// End HAPS Code ---












		return redirect('/advanceCheck');

	}









	public function payAdvance06(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$id=$r->input('id');//post input
		return view ('payAdvance06',['customer_id' => $customer_id,'id' => $id]);
	}

	public function payAdvance07(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$id=$r->input('id');//post input
		return view ('payAdvance07',['customer_id' => $customer_id,'id' => $id]);
	}


}
