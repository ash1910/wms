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
				else{
					$charge=round($received-($received*0.980),2);
					$received = round($received*0.980,2);
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
				else{
					$charge=round($received-($received*0.980),2);
					$received = round($received*0.980,2);
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
			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('pay_type', 'cheque')
			//->where('due', '0')
			->update(['received' => $received,'due' => $due,'dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);
		}
		if($job_no=='Advance')
		{		
			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('customer_id', $customer_id)
			->where('pay_type', 'cheque')
			->where('received', '0')
			->update(['received' => $received,'due' => $due,'dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);
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
			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('pay_type', 'cheque')
			//->where('due', '0')
			->update(['received' => $received,'due' => $due,'pay_type' => 'cash','dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);
		}
		if($job_no=='Advance')
		{		
			$result = DB::table('pay')
			->where('job_no', $job_no)
			->where('chequeNo', $chequeNo)
			->where('customer_id', $customer_id)
			->where('pay_type', 'cheque')
			->where('received', '0')
			->update(['received' => $received,'due' => $due,'pay_type' => 'cash','dt' => $dt]);
			$result = DB::table('cheque_pending')->where('id', $id)->where('flag', '0')
			->update(['flag' => '1','confirm' => '0']);
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

		return redirect ('/bankDeclineForm')->with('alert', 'Bank Decline (POS) Image Upload Sucessfully!!!');
	}



	
	
}
