<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class billController extends Controller
{
    public function bill()
	{
		return view ('bill');	
	}
	
	public function searchClient(Request $r)
	{
		$search=$r->input('search');//post input
		$register=$r->input('register');//post input
		$chas=$r->input('chas');//post input
		
	    $customer_id = '';
	    $customer_nm = '';
	    $customer_reg = '';
	    $customer_mobile = '';
	    $customer_address = '';
	    $customer_vehicle = '';
	    $customer_chas = '';
		$estimate_id = '';
		$customer_group = '';
		$company = '';
		$sister_companies = '';
		
		if($register=='register')
		{
			$result = DB::table('customer_info')->where('customer_reg', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{
				$customer_id = $item1->customer_id;
				$customer_group = $item1->customer_group;
				$company = $item1->company;
				$sister_companies = $item1->sister_companies;
			}
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();
			
			
			if($result=="[]")
				{
				return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
				}


			return view('billform', [
			'result' => $result,
			'parts_info' => $parts_info,
			'service_info' => $service_info,
			'customer_group' => $customer_group,
			'company' => $company,
			'sister_companies' => $sister_companies
			]);			
		}
		if($chas=='chas')
		{
			$result = DB::table('customer_info')->where('customer_chas', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{
				$customer_id = $item1->customer_id;
				$customer_group = $item1->customer_group;
				$company = $item1->company;
				$sister_companies = $item1->sister_companies;
			}
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();
			
			if($result=="[]")
				{
				return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
				}
			
			return view('billform', [
			'result' => $result,
			'parts_info' => $parts_info,
			'service_info' => $service_info,
			'customer_group' => $customer_group,
			'company' => $company,
			'sister_companies' => $sister_companies
			]);			
		}
		
		if($register=='register01')
		{
			$result = DB::table('bill_mas')->where('job_no', $search)
			->where('flag', '0')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;
			$job_no = $item1->job_no;}
			
			if($result=="[]")
				{
				return redirect ('billAdvance')->with('alert01', 'Thanks For Subscribe!');
				}
			return view('advanceForm', [
			'customer_id' => $customer_id,'job_no' => $job_no
			]);			
		}		
		if($register=='register02')
		{
			$search=$r->input('search');//post input
			$result = DB::table('customer_info')->where('customer_reg', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;}

			if($result=="[]")
				{
				return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
				}

			return view('advanceClient01', [
			'result' => $result,'customer_id' => $customer_id
			]);			
		}		
		if($chas=='register03')
		{
			$search=$r->input('search');//post input
			$result = DB::table('customer_info')->where('customer_chas', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;}

			if($result=="[]")
				{
				return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
				}

			return view('advanceClient01', [
			'result' => $result,'customer_id' => $customer_id
			]);			
		}		
		
		
		
		
	}
	public function billAdvance()
	{
		return view ('billAdvance');	
	}

	public function	billcard(Request $r)
	{
		$register=$r->input('register');//post input
		$engineer=$r->input('engineer');//post input
		$technician=$r->input('technician');//post input
		$km=$r->input('km');//post input
		$job_no=$r->input('job');//post input
		$work=$r->input('work');//post input
		$job_dt = date("Y-m-d");
		$bill_no = date("ymdHis");
		$customer_id=$r->input('customer_id');//post input
		$customer_nm=$r->input('customer_nm');//post input
		$user_id = session('user_id');


if($register=="register01")
	{		
		DB::insert('INSERT INTO `bill_mas`(`bill_no`, `customer_id`, `engineer`, `technician`, `job_no`, 
		`job_dt`, `user_id`,`net_bill`,`work`,`km`, `customer_nm`) VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$bill_no,$customer_id,$engineer,$technician,$job_no,$job_dt,
		$user_id,'',$work, $km,$customer_nm]);
	if($work=='intercompany')
		{
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->update(['company' => 'Inter-Company','sister_companies' => '']);
		}
	if($work=='automobile')
		{
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->update(['company' => 'HNS Automobiles','sister_companies' => 'HNS Automobiles']);
		}
		
		return redirect('/billMemo?bill='.$bill_no.'');
	}
	
if($register=="register02")
	{		
		DB::insert('INSERT INTO `bill_mas`(`bill_no`, `customer_id`, `engineer`, `technician`, `job_no`, 
		`job_dt`, `user_id`,`net_bill`,`work`,`km`, `customer_nm`) VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$bill_no,$customer_id,$engineer,$technician,$job_no,$job_dt,
		$user_id,'',$work, $km,$customer_nm]);
	if($work=='intercompany')
		{
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->update(['company' => 'Inter-Company','sister_companies' => '']);
		}
	if($work=='automobile')
		{
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->update(['company' => 'HNS Automobiles','sister_companies' => 'HNS Automobiles']);
		}
		return redirect('/home');
	}



	}
	
	
	
	
	public function billModi(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemo?bill='.$bill_no.'');
	}
	
	
	public function billMemoEdit(Request $r)
	{
		$id=$r->input('id');//post input
		$bill_no=$r->input('bill_no');//post input
		return view('billMemoEdit', [
			'id' => $id,
			'bill_no' => $bill_no
			]);	
	}
	public function billMemoEditOne(Request $r)
	{
		$id=$r->input('id');//post input
		$bill_no=$r->input('bill_no');//post input
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		$amount = $qty*$unit_rate;

		$result = DB::table('bill_det')
		->where('id', $id)
		->update(['qty' => $qty,'unit_rate' => $unit_rate,'amount' => $amount]);
		
		$data = DB::select("
		SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
		from
		(SELECT sum(`amount`) parts FROM `bill_det` WHERE `bill_no` = $bill_no AND `type` = '1')A,
		(SELECT sum(`amount`) service FROM `bill_det` WHERE `bill_no` = $bill_no AND `type` = '2')b;
		");
		foreach($data as $item){ 
		$parts = $item->parts;  
		$service = $item->service;
		$net_bill = $item->net_bill;  
		$total = $item->total;
		}
		$result = DB::table('bill_mas')
		->where('bill_no', $bill_no)
		->update(['parts' => $parts,'service' => $service,'net_bill' => $net_bill,'total' => $total]);
		return view('billMemoEdit', [
			'id' => $id,
			'bill_no' => $bill_no
			]);			

	}
	
	
	
	
	public function billMemoOne(Request $r)
	{
		$product=$r->input('prod');//post input
		$pieces = explode(" - ", $product);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		//$bill_no=session('bill_no');
		$bill_no=$r->input('bill_no');//post input
		$amount = $qty*$unit_rate;
		$dt = date("Y-m-d");
		$user_id = session('user_id');
		$check = '';
		// Check
		$data02 = DB::select("
		SELECT bill_no from bill_det where bill_no = '$bill_no' and type = '1' 
		and prod_id = '$prod_id' and qty = '$qty' and unit_rate = '$unit_rate' and 
		user_id = '$user_id'
		");
		foreach($data02 as $item02)
		{ 
		$check = $item02->bill_no;  
		}
if($check == '') 
	{
		//insert 
		DB::insert('INSERT INTO `bill_det`(`bill_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,
		`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$bill_no,'1',$prod_id,$prod_name,$qty,$unit_rate,
		$amount, $dt, $user_id]);	
	
		// netbill
		$data = DB::select("
		SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
		from
		(SELECT nvl(sum(`amount`),0) parts FROM `bill_det` WHERE `bill_no` = '$bill_no' AND `type` = '1')A,
		(SELECT nvl(sum(`amount`),0) service FROM `bill_det` WHERE `bill_no` = '$bill_no' AND `type` = '2')b;
		");
		foreach($data as $item)
		{ 
			$parts = $item->parts;  
			$service = $item->service;
			$net_bill = $item->net_bill;  
			$total_bill = $item->total;

			$data01 = DB::select("
			SELECT `work` FROM `bill_mas` WHERE `bill_no` = '$bill_no'
			");
			foreach($data01 as $item01)
			{$work = $item01->work;}
			if($work=='intercompany')
			{
				$total_bill = $net_bill;
			}
			if($work=='automobile')
			{
				$total_bill = $net_bill;
			}
		}		
		
		//update netbill
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['net_bill' => $net_bill,'parts' => $parts,'service' => $service,
		'total' => round($total_bill,2), 'user_id' => session('user_id')]);
	}
	return back();		
	}
	
	public function billMemoTwo(Request $r)
	{
		$product=$r->input('prod');//post input
		$pieces = explode(" - ", $product);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		//$bill_no=session('bill_no');
		$bill_no=$r->input('bill_no');//post input
		$amount = $qty*$unit_rate;
		$dt = date("Y-m-d");
		$user_id = session('user_id');
		$check = '';
		// Check
		$data02 = DB::select("
		SELECT bill_no from bill_det where bill_no = '$bill_no' and type = '2' 
		and prod_id = '$prod_id' and qty = '$qty' and unit_rate = '$unit_rate' and 
		user_id = '$user_id'
		");
		foreach($data02 as $item02)
		{ 
		$check = $item02->bill_no;  
		}
if($check == '') 
	{
		//insert
		DB::insert('INSERT INTO `bill_det`(`bill_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,
		`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$bill_no,'2',$prod_id,$prod_name,$qty,$unit_rate,
		$amount, $dt, $user_id]);	
		//net_bill
	
		$data = DB::select("
		SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
		from
		(SELECT nvl(sum(`amount`),0) parts FROM `bill_det` WHERE `bill_no` = $bill_no AND `type` = '1')A,
		(SELECT nvl(sum(`amount`),0) service FROM `bill_det` WHERE `bill_no` = $bill_no AND `type` = '2')b;
		");
		foreach($data as $item)
		{ 
			$parts = $item->parts;  
			$service = $item->service;
			$net_bill = $item->net_bill;  
			$total_bill = $item->total;

			$data01 = DB::select("
			SELECT `work` FROM `bill_mas` WHERE `bill_no` = '$bill_no'
			");
			foreach($data01 as $item01)
			{$work = $item01->work;}
			if($work=='intercompany')
			{
				$total_bill = $net_bill;
			}
			if($work=='automobile')
			{
				$total_bill = $net_bill;
			}
		}
		
		//update net_bill
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['net_bill' => $net_bill,'parts' => $parts, 'service' => $service, 
		'total' => round($total_bill,2), 'user_id' => session('user_id')]);
	}
	return back();		
	}	
	
	public function billMemoThree(Request $r)
	{
		$id=$r->input('id');//post input
		//delQty,delAmount
		$data = DB::select("SELECT `id`,`bill_no`, `qty`,`type`, `amount` FROM `bill_det` WHERE `id` = $id;");
		foreach($data as $item){ $delQty = $item->qty; $delAmount = $item->amount; $bill_no = $item->bill_no;
		$type = $item->type; }
		//net_bill
		$data = DB::select("SELECT SUM(`net_bill`) net_bill, sum(`parts`) parts, sum(service) service FROM `bill_mas` WHERE `bill_no`=$bill_no;");
		foreach($data as $item){ $net_bill01 = $item->net_bill;$parts01 = $item->parts;$service01 = $item->service; }
		$net_bill = $net_bill01-$delAmount;
		$parts = $parts01-$delAmount;
		$service = $service01-$delAmount;
		$total_bill = $net_bill+($net_bill*.1);
		//update net_bill
		if($type=='1')
		{
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['net_bill' => $net_bill,'parts' => $parts, 'total' => $total_bill, 
		'user_id' => session('user_id')]);
		}
		if($type=='2')
		{
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['net_bill' => $net_bill,'service' => $service, 'total' => $total_bill, 
		'user_id' => session('user_id')]);
		}		
		//del
		$result = DB::table('bill_det')->delete($id);
		return back();	
		
	}
	
	public function form01()
	{
		return view ('form01');	
	}
	
	public function report01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report01',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}

	public function form_estimate()
	{
		return view ('form_estimate');	
	}

	public function report_estimate(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report_estimate',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}
	
	public function report02(Request $r)
	{
		$bill=$r->input('bill');//post input
		$job_no=$r->input('job_no');//post input
		if($job_no!='')
		{
		$data = DB::select("SELECT bill_no FROM `bill_mas` WHERE `job_no`='$job_no';");
		foreach($data as $item){ $bill = $item->bill_no; }		
			if($bill=='')
			{
				return redirect ('/jobLedger')->with('alert', 'Please Provide Correct Job No!!!');
			}

		}
		return view ('report02',['bill'=>$bill]);
	}

	public function billPrint(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$data = DB::select("SELECT flag FROM `bill_mas` WHERE `bill_no`=$bill_no;");
		foreach($data as $item){ $flag = $item->flag; }		
		
		if($flag=='0')
		{
			return view ('billPrintDraft',['bill_no'=>$bill_no]);
		}		
		if($flag=='1')
		{
			return view ('billPrint03',['bill_no'=>$bill_no]);
		}
		if($flag=='2')
		{
			return view ('billPrint03',['bill_no'=>$bill_no]);
		}
		if($flag=='3')
		{
			return view ('billPrint03',['bill_no'=>$bill_no]);
		}
		
	}

	public function billPrint_as(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$data = DB::select("SELECT flag FROM `bill_mas` WHERE `bill_no`=$bill_no;");
		foreach($data as $item){ $flag = $item->flag; }		
		
		if($flag=='0')
		{
			return view ('billPrintDraft_as',['bill_no'=>$bill_no]);
		}		
		if($flag=='1')
		{
			return view ('billPrint03_as',['bill_no'=>$bill_no]);
		}
		if($flag=='2')
		{
			return view ('billPrint03_as',['bill_no'=>$bill_no]);
		}
		if($flag=='3')
		{
			return view ('billPrint03_as',['bill_no'=>$bill_no]);
		}
		
	}

	public function billPrintView(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$data = DB::select("SELECT flag FROM `bill_mas` WHERE `bill_no`=$bill_no;");
		foreach($data as $item){ $flag = $item->flag; }		
		
		if($flag=='0')
		{
			return view ('billPrintDraft',['bill_no'=>$bill_no]);
		}		
		if($flag=='1')
		{
			return view ('billPrintView',['bill_no'=>$bill_no]);
		}
		if($flag=='2')
		{
			return view ('billPrintView',['bill_no'=>$bill_no]);
		}
		if($flag=='3')
		{
			return view ('billPrintView',['bill_no'=>$bill_no]);
		}
		
	}
	
	public function billPrintRef(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		return view ('billPrintRef',['bill_no'=>$bill_no]);
	}
	
	public function supplierReport()
	{
		return view ('supplierReport');
	}
	
	public function supplierReport01(Request $r)
	{
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input
		return view ('supplierReport01',[
		'dt01'=>$dt01,
		'dt02'=>$dt02
		]);	
	}
	public function supplierReport02(Request $r)
	{
		$supplier_id=$r->input('supplier_id');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input
		return view ('supplierReport02',[
		'dt01'=>$dt01,
		'dt02'=>$dt02,
		'supplier_id'=>$supplier_id
		]);	
	}
	public function supplierReport03(Request $r)
	{
		$supplier_id=$r->input('supplier_id');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input
		return view ('supplierReport03',[
		'dt01'=>$dt01,
		'dt02'=>$dt02,
		'supplier_id'=>$supplier_id
		]);	
	}	
	public function changeCustomer(Request $r)
	{
		$bill=$r->input('bill_no');//post input
		$job_no=$r->input('job_no');//post input
		$engineer=$r->input('engineer');//post input
		$technician=$r->input('technician');//post input
		$km=$r->input('km');//post input
		$cartridge=$r->input('cartridge');//post input
		return view ('changeCustomer',[
		'bill'=>$bill,
		'job_no'=>$job_no,
		'engineer'=>$engineer,
		'technician'=>$technician,
		'km'=>$km,
		'cartridge'=>$cartridge
		]);
	}
	public function changeCustomer01(Request $r)
	{
		$customer_reg=$r->input('customer_reg');//post input
		$bill_no=$r->input('bill_no');//post input
		$register=$r->input('register');//post input

if($register=='register')
{
		$result = DB::table('customer_info')->where('customer_reg', $customer_reg)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;$customer_nm = $item1->customer_nm;}
}
if($register=='register01')
{
		$result = DB::table('customer_info')->where('customer_chas', $customer_reg)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;$customer_nm = $item1->customer_nm;}
}

		
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['customer_id' => $customer_id,'customer_nm' => $customer_nm]);
		return redirect('/billMemo?bill='.$bill_no.'');
		
			

		
	}
	public function changeCustomer02(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$change_dt=$r->input('change_dt');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['job_dt' => $change_dt]);
		
		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemo?bill='.$bill_no.'');
	}
	public function changeCustomer03(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$job_no=$r->input('job_no');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['job_no' => $job_no]);
		
		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemo?bill='.$bill_no.'');
	}
	public function changeCustomer04(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$km=$r->input('km');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['km' => $km]);
		
		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemo?bill='.$bill_no.'');
		
	}	
	public function changeCustomer05(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$engineer=$r->input('engineer');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['engineer' => $engineer]);
		
		return redirect('/billMemo?bill='.$bill_no.'');
		
	}	
	public function changeCustomer06(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$technician=$r->input('technician');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['technician' => $technician]);
		
		return redirect('/billMemo?bill='.$bill_no.'');
		
	}	
	public function changeCustomer07(Request $r)
	{
		$bill_no=$r->input('bill_no');//post input
		$cartridge=$r->input('cartridge');//post input
		DB::table('bill_mas')->where('bill_no', $bill_no)
		->update(['cartridge' => $cartridge]);
		
		return redirect('/billMemo?bill='.$bill_no.'');
		
	}	
	public function reports()
	{
		return view ('reports');	
	}
	public function form03()
	{
		return view ('form03');	
	}
	public function report03(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$billtype=$r->input('billtype');//post input
		return view ('report03',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt,
		'billtype'=>$billtype
		]);	
	}
	public function report031(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$segment=$r->input('segment');//post input
		return view ('report031',[
		'from_dt'=>$from_dt,'to_dt'=>$to_dt,'segment'=>$segment
		]);	
	}
	public function report032(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$segment=$r->input('segment');//post input
		$adjust=$r->input('adjust');//post input
		return view ('report032',[
		'from_dt'=>$from_dt,'to_dt'=>$to_dt,'segment'=>$segment,'adjust'=>$adjust
		]);	
	}	
	public function form04()
	{
		return view ('form04');	
	}
	public function form08()
	{
		return view ('form08');	
	}
	public function form09()
	{
		return view ('form09');	
	}
	public function form10()
	{
		return view ('form10');	
	}
	public function report04(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report04',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}
	public function report041(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$pay_type=$r->input('pay_type');//post input
		return view ('report041',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt,
		'pay_type'=>$pay_type
		]);	
	}
	public function report08(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		$work=$r->input('work');//post input
		return view ('report08',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt,
		'work'=>$work
		]);	
	}
	public function report09(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report09',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}
	public function report10(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report10',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}
	public function form05()
	{
		return view ('form05');	
	}
	public function report05(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('report05',[
		'from_dt'=>$from_dt,
		'to_dt'=>$to_dt
		]);	
	}	
	public function report051(Request $r)
	{
		$company=$r->input('company');//post input
		return view ('report051',[
		'company'=>$company
		]);	
	}	
	public function report052(Request $r)
	{
		$company=$r->input('company');//post input
		$sister_companies=$r->input('sister_companies');//post input
		return view ('report052',[
		'company'=>$company,
		'sister_companies'=>$sister_companies
		]);	
	}	
	public function report053(Request $r)
	{
		$id=$r->input('id');//post input
		$nm=$r->input('nm');//post input
		return view ('report053',[
		'id'=>$id,
		'nm'=>$nm
		]);	
	}
	public	function saleSummary()
	{
		return view ('saleSummary');	
	}
	public	function saleSummary01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		return view ('saleSummary01',[
		'from_dt'=>$from_dt
		]);	
	}
	public function ModifyAcceptBill()
	{
		return view ('ModifyAcceptBill');
	}
	public function ModifyAcceptBill01(Request $r)
	{
		$job=$r->input('job');//post input
		return view ('ModifyAcceptBill02',[
		'job'=>$job
		]);	
	}
	public function ModifyAcceptBill03(Request $r)
	{
		$job_no=$r->input('job_no');//post input
	
		DB::table('bill_mas')->where('job_no', $job_no)
		->update(['flag' => '0']);	
		$result = DB::table('pay')->where('job_no', $job_no)->where('pay_type', 'SYS')->delete();
		return view ('home');
	}
	public function report054(Request $r)
	{
		return view ('report054');	
	}	
	public function report055(Request $r)
	{
		return view ('report055');	
	}	
	public function report056(Request $r)
	{
		return view ('report056');	
	}	
	public function report057(Request $r)
	{
		return view ('report057');	
	}	
	public function ModifyBillDt()
	{
		return view ('ModifyBillDt');
	}
	public function ModifyBillDt01(Request $r)
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

		if($job_no=='X')
		{
				return redirect ('/approval')->with('alert', 'This job Already Approved Before!!!');
		}
    		$result = DB::table('bill_mas')->where('bill_no', $bill_no)
    		->update(['flag' => '1', 'bill_dt' => $job_dt]);

			DB::insert('INSERT INTO `pay`(`bill`, `job_no`, `customer_id`, `bill_dt`, `net_bill`, `received`, `bonus`, `due`, `dt`, `user_id`,`pay_type`,`ref`) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$bill_no,$job_no,$customer_id,$bill_dt,$net_bill,"0","0",$net_bill,$job_dt,$user_id,"SYS","SYS"]);

			DB::insert('INSERT INTO `gatepass`(`bill_no`, `flag`, `user_id`,`job_no`)
						VALUES (?,?,?,?)',[$bill_no,'1',$user_id,$job_no]);					
		return back();	

	}
	public function dueRef()
	{
		return view ('dueRef');
	}
	public function dueRef01(Request $r)
	{
		$ref=$r->input('ref');//post input
		$ref01=$r->input('ref01');//post input
		return view ('dueRef01',['ref'=>$ref,'ref01'=>$ref01]);	
	}
	public function dueRef02(Request $r)
	{
		$ref=$r->input('ref');//post input
		$year=$r->input('year');//post input
		$total=$r->input('total');//post input
		$before=$r->input('before');//post input
		return view ('dueRef02',['ref'=>$ref,'year'=>$year,'total'=>$total,'before'=>$before]);	
	}
	public function dueRef03(Request $r)
	{
		$ref=$r->input('ref');//post input
		$year=$r->input('year');//post input
		$mon=$r->input('mon');//post input
		return view ('dueRef03',['ref'=>$ref,'year'=>$year,'mon'=>$mon]);	
	}	
	public function dueRef04(Request $r)
	{
		$ref=$r->input('ref');//post input
		$year=$r->input('year');//post input
		$mon=$r->input('mon');//post input
		return view ('dueRef04',['ref'=>$ref,'year'=>$year,'mon'=>$mon]);	
	}	
	public function advance()
	{
		return view ('advance');
	}
	public function advanceClient()
	{
		return view ('advanceClient');
	}
	public function allDueReport()
	{
		return view ('allDueReport');
	}
	public function allDueReport01(Request $r)
	{
		$supplier_id=$r->input('supplier');//post input
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view ('allDueReport01',['from_dt'=>$from_dt,'to_dt'=>$to_dt
		,'supplier_id'=>$supplier_id]);	
	}
	
	
}
