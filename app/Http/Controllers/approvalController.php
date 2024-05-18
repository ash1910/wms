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
		$today = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::table('pay')->where('id', $id)
		->update(['pay_check' => '1','check_approval' => $user_id,'approval_dt' => $today]);
	
		return back();
	}
	public function cardCheck()
	{
		return view ('cardCheck');
	}
	public function cardCheck01(Request $r)
	{
		$id=$r->input('id');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::table('pay')->where('id', $id)
		->update(['pay_check' => '1','check_approval' => $user_id,'approval_dt' => $today]);
	
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
