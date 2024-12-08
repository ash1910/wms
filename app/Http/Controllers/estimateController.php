<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class estimateController extends Controller
{
    // public function estimateAdd(Request $r)
	// {
	// 	$product =request('product');//post input
	// 	$pieces = explode(" - ", $product);
	// 	$prod_id = $pieces[0];
	// 	$prod_name = $pieces[1];
	// 	$customer_id =request('customer_id');//post input
	// 	$type =request('type');//post input
	// 	$qty =request('qty');//post input
	// 	$today = date("Y-m-d");
	// 	$user_id = session('user_id');
	// 	$data = DB::table('parts_info')
	// 			->where('parts_id', $prod_id)->where('type', $type)
	// 			->get();
	// 	foreach($data as $item)
	// 	{
	// 	$unit_price = $item->unit_price;
	// 	}
	// 	$data = DB::table('service_info')
	// 			->where('service_id', $prod_id)->where('type', $type)
	// 			->get();
	// 	foreach($data as $item)
	// 	{
	// 	$unit_price = $item->unit_price;
	// 	}

	// 	DB::insert('INSERT INTO `estimate`(`customer_id`, `prod_id`, `prod_name`, `qty`,unit_price, `dt`,
	// 	`user_id`, `flag`,`type`)
	// 	VALUES (?,?,?,?,?,?,?,?,?)',[$customer_id,$prod_id,$prod_name,$qty,$unit_price,$today,
	// 	$user_id,'1',$type]);

	// 	return back();
	// }


	public function est()
	{
		return view ('est');
	}

	public function searchClientEst(Request $r)
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


			return view('billformEst', [
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

			return view('billformEst', [
			'result' => $result,
			'parts_info' => $parts_info,
			'service_info' => $service_info,
			'customer_group' => $customer_group,
			'company' => $company,
			'sister_companies' => $sister_companies
			]);
		}

	}

	public function	billcardEst(Request $r)
	{
		$register=$r->input('register');//post input
		$engineer=$r->input('engineer');//post input
		$technician=$r->input('technician');//post input
		$km=$r->input('km');//post input
		$days=$r->input('days');//post input
        $validity=$r->input('validity');//post input
        $note=$r->input('note');//post input
		$work=$r->input('work');//post input
		$est_dt = date("Y-m-d");
		//$est_no = date("ymdHis");
		$customer_id=$r->input('customer_id');//post input
		$customer_nm=$r->input('customer_nm');//post input
		$user_id = session('user_id');


		if($register=="register01")
		{
			DB::insert('INSERT INTO `est_mas`(`customer_id`, `engineer`, `technician`, `days`, `validity`, `note`,
			`est_dt`, `user_id`,`net_bill`,`work`,`km`, `customer_nm`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$customer_id,$engineer,$technician,$days,$validity,$note,$est_dt,
			$user_id,'',$work, $km,$customer_nm]);
			$est_no = DB::getPdo()->lastInsertId();
			$est_no = str_pad($est_no, 5, '0', STR_PAD_LEFT);

			return redirect('/billMemoEst?est_no='.$est_no.'');
		}


	}

	public function billPrint_asEst(Request $r)
	{
		$est_no=$r->input('est_no');//post input
        $detail=$r->input('detail');//post input

		if($detail== 1)
		{
			return view ('billPrint_asEst',['est_no'=>$est_no]);
		}

        return view ('billPrintDraft_asEst',['est_no'=>$est_no]);

	}

	public function billMemoOneEst(Request $r)
	{
		$product=$r->input('prod');//post input
		$pieces = explode(" - ", $product);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		//$est_no=session('est_no');
		$est_no=$r->input('est_no');//post input
		$amount = $qty*$unit_rate;
		$dt = date("Y-m-d");
		$user_id = session('user_id');
		$check = '';
		// Check
		$data02 = DB::select("
		SELECT est_no from est_det where est_no = '$est_no' and type = '1'
		and prod_id = '$prod_id' and qty = '$qty' and unit_rate = '$unit_rate' and
		user_id = '$user_id'
		");
		foreach($data02 as $item02)
		{
		$check = $item02->est_no;
		}
		if($check == '')
			{
				//insert
				DB::insert('INSERT INTO `est_det`(`est_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,
				`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$est_no,'1',$prod_id,$prod_name,$qty,$unit_rate,
				$amount, $dt, $user_id]);

				// netbill
				$data = DB::select("
				SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
				from
				(SELECT nvl(sum(`amount`),0) parts FROM `est_det` WHERE `est_no` = '$est_no' AND `type` = '1')A,
				(SELECT nvl(sum(`amount`),0) service FROM `est_det` WHERE `est_no` = '$est_no' AND `type` = '2')b;
				");
				foreach($data as $item)
				{
					$parts = $item->parts;
					$service = $item->service;
					$net_bill = $item->net_bill;
					$total_bill = number_format((float)$item->total, 2, '.', '');

					$data01 = DB::select("
					SELECT `work` FROM `est_mas` WHERE `est_no` = '$est_no'
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
				DB::table('est_mas')->where('est_no', $est_no)
				->update(['net_bill' => $net_bill,'parts' => $parts,'service' => $service,
				'total' => round($total_bill,2), 'user_id' => session('user_id')]);
			}
			return back();
	}

	public function billMemoTwoEst(Request $r)
	{
		$product=$r->input('prod');//post input
		$pieces = explode(" - ", $product);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		//$est_no=session('est_no');
		$est_no=$r->input('est_no');//post input
		$amount = $qty*$unit_rate;
		$dt = date("Y-m-d");
		$user_id = session('user_id');
		$check = '';
		// Check
		$data02 = DB::select("
		SELECT est_no from est_det where est_no = '$est_no' and type = '2'
		and prod_id = '$prod_id' and qty = '$qty' and unit_rate = '$unit_rate' and
		user_id = '$user_id'
		");
		foreach($data02 as $item02)
		{
		$check = $item02->est_no;
		}
		if($check == '')
			{
				//insert
				DB::insert('INSERT INTO `est_det`(`est_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,
				`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$est_no,'2',$prod_id,$prod_name,$qty,$unit_rate,
				$amount, $dt, $user_id]);
				//net_bill

				$data = DB::select("
				SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
				from
				(SELECT nvl(sum(`amount`),0) parts FROM `est_det` WHERE `est_no` = $est_no AND `type` = '1')A,
				(SELECT nvl(sum(`amount`),0) service FROM `est_det` WHERE `est_no` = $est_no AND `type` = '2')b;
				");
				foreach($data as $item)
				{
					$parts = $item->parts;
					$service = $item->service;
					$net_bill = $item->net_bill;
					$total_bill = number_format((float)$item->total, 2, '.', '');

					$data01 = DB::select("
					SELECT `work` FROM `est_mas` WHERE `est_no` = '$est_no'
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
				DB::table('est_mas')->where('est_no', $est_no)
				->update(['net_bill' => $net_bill,'parts' => $parts, 'service' => $service,
				'total' => round($total_bill,2), 'user_id' => session('user_id')]);
			}
			return back();
	}

	public function billMemoEditEst(Request $r)
	{
		$id=$r->input('id');//post input
		$est_no=$r->input('est_no');//post input
		return view('billMemoEditEst', [
			'id' => $id,
			'est_no' => $est_no
			]);
	}
	public function billMemoEditOneEst(Request $r)
	{
		$id=$r->input('id');//post input
		$est_no=$r->input('est_no');//post input
		$qty=$r->input('qty');//post input
		$unit_rate=$r->input('salepp');//post input
		$amount = $qty*$unit_rate;

		$result = DB::table('est_det')
		->where('id', $id)
		->update(['qty' => $qty,'unit_rate' => $unit_rate,'amount' => $amount]);

		$data = DB::select("
		SELECT parts,service, (parts+service) net_bill, (parts+service)+((parts+service)*.10) total
		from
		(SELECT COALESCE(SUM(amount),0) parts FROM `est_det` WHERE `est_no` = $est_no AND `type` = '1')A,
		(SELECT COALESCE(SUM(amount),0) service FROM `est_det` WHERE `est_no` = $est_no AND `type` = '2')b;
		");

		//echo "<pre>";print_r($data );exit;

		foreach($data as $item){
		$parts = $item->parts;
		$service = $item->service;
		$net_bill = $item->net_bill;
		$total_bill =  number_format((float)$item->total, 2, '.', '');
		}

		$data01 = DB::select("
		SELECT `work` FROM `est_mas` WHERE `est_no` = '$est_no'
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


		$result = DB::table('est_mas')
		->where('est_no', $est_no)
		->update(['parts' => $parts,'service' => $service,'net_bill' => $net_bill,'total' => $total_bill]);
		return redirect('/billMemoEst?est_no='.$est_no.'');

	}

	public function billMemoThreeEst(Request $r)
	{
		$id=$r->input('id');//post input
		//delQty,delAmount
		$data = DB::select("SELECT `id`,`est_no`, `qty`,`type`, `amount` FROM `est_det` WHERE `id` = $id;");
		foreach($data as $item){ $delQty = $item->qty; $delAmount = $item->amount; $est_no = $item->est_no;
		$type = $item->type; }
		//net_bill
		$data = DB::select("SELECT SUM(`net_bill`) net_bill, sum(`parts`) parts, sum(service) service FROM `est_mas` WHERE `est_no`=$est_no;");
		foreach($data as $item){ $net_bill01 = $item->net_bill;$parts01 = $item->parts;$service01 = $item->service; }
		$net_bill = $net_bill01-$delAmount;
		$parts = $parts01-$delAmount;
		$service = $service01-$delAmount;
		$total_bill = $net_bill+($net_bill*.1);
		//update net_bill
		$data01 = DB::select("
		SELECT `work` FROM `est_mas` WHERE `est_no` = '$est_no'
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

		if($type=='1')
		{
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['net_bill' => $net_bill,'parts' => $parts, 'total' => $total_bill,
		'user_id' => session('user_id')]);
		}
		if($type=='2')
		{
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['net_bill' => $net_bill,'service' => $service, 'total' => $total_bill,
		'user_id' => session('user_id')]);
		}
		//del
		$result = DB::table('est_det')->delete($id);
		return back();

	}

    public function cloneEst(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$today = date("Y-m-d");
		$est_dt = date("Y-m-d");
		$user_id = session('user_id');

		$result = DB::select("SELECT * FROM `est_mas` WHERE est_no= '$est_no'");
		foreach($result as $item)
		{
			$customer_id = $item->customer_id;
			$customer_nm = $item->customer_nm;
			$engineer = $item->engineer;
			$technician = $item->technician;
			$km = $item->km;
			$days = $item->days;
			$parts = $item->parts;
			$service = $item->service;
			$net_bill = $item->net_bill;
			$total = $item->total;
		}

		DB::insert('INSERT INTO `est_mas`( `customer_id`, `customer_nm`, `engineer`, `technician`, `days`,`km`,
		`est_dt`, `user_id`,`parts`,`service`,`total`,`net_bill`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$customer_id,$customer_nm,$engineer,$technician,$days,$km, $est_dt,
		$user_id,$parts,$service, $total, $net_bill]);

        $est_no_clone = DB::getPdo()->lastInsertId();
		$est_no_clone = str_pad($est_no_clone, 5, '0', STR_PAD_LEFT);

		$result = DB::select("SELECT * FROM `est_det` WHERE est_no= '$est_no'");
		foreach($result as $item)
		{
			$type = $item->type;
			$prod_id = $item->prod_id;
			$prod_name = $item->prod_name;
			$qty = $item->qty;
			$unit_rate = $item->unit_rate;
			$amount = $item->amount;

			DB::insert('INSERT INTO `est_det`(`est_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$est_no_clone,$type,$prod_id,$prod_name,$qty,$unit_rate,$amount, $today, $user_id]);
		}



		return redirect('/billMemoEst?est_no='.$est_no_clone.'');
    }

	public function approvalEst()
	{
		return view ('approvalEst');
	}
	public function approval01Est(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$job_no=$r->input('job_no');//post input
		$work=$r->input('work');//post input
		$bill_no = date("ymdHis");
		$today = date("Y-m-d");
		$job_dt = date("Y-m-d");

		$user_id = session('user_id');
		$result = DB::select("SELECT * FROM `est_mas` WHERE est_no= '$est_no' and `flag` = '0'");
		foreach($result as $item)
		{
			$est_no = $item->est_no;
			$customer_id = $item->customer_id;
			$customer_nm = $item->customer_nm;
			$engineer = $item->engineer;
			$technician = $item->technician;
			$km = $item->km;
			//$work = $item->work;
			$parts = $item->parts;
			$service = $item->service;
			$net_bill = $item->net_bill;
			$total = $item->total;
		}
		if($work=='intercompany')
		{
			$total = $net_bill;
		}
		if($work=='automobile')
		{
			$total = $net_bill;
		}

		DB::insert('INSERT INTO `bill_mas`(`bill_no`, `customer_id`, `customer_nm`, `engineer`, `technician`, `job_no`,`km`, `work`, `est_no`,
		`job_dt`, `user_id`,`parts`,`service`,`total`,`net_bill`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$bill_no,$customer_id,$customer_nm,$engineer,$technician,$job_no,$km, $work, $est_no, $job_dt,
		$user_id,$parts,$service, $total, $net_bill]);

		$result = DB::select("SELECT * FROM `est_det` WHERE est_no= '$est_no'");
		foreach($result as $item)
		{
			$type = $item->type;
			$prod_id = $item->prod_id;
			$prod_name = $item->prod_name;
			$qty = $item->qty;
			$unit_rate = $item->unit_rate;
			$amount = $item->amount;

			DB::insert('INSERT INTO `bill_det`(`bill_no`, `type`, `prod_id`, `prod_name`, `qty`, `unit_rate`,`amount`, `dt`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?)',[$bill_no,$type,$prod_id,$prod_name,$qty,$unit_rate,$amount, $today, $user_id]);
		}


		$result = DB::table('est_mas')->where('est_no', $est_no)->update(['flag' => '1', 'bill_dt' => $today]);


		return back();
	}

	public function changeCustomerEst(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$days=$r->input('days');//post input
        $validity=$r->input('validity');//post input
        $note=$r->input('note');//post input
		$engineer=$r->input('engineer');//post input
		$technician=$r->input('technician');//post input
		$km=$r->input('km');//post input
		return view ('changeCustomerEst',[
		'est_no'=>$est_no,
		'days'=>$days,
        'validity'=>$validity,
        'note'=>$note,
		'engineer'=>$engineer,
		'technician'=>$technician,
		'km'=>$km
		]);
	}
	public function changeCustomerEst01(Request $r)
	{
		$customer_reg=$r->input('customer_reg');//post input
		$est_no=$r->input('est_no');//post input
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

		DB::table('est_mas')->where('est_no', $est_no)
		->update(['customer_id' => $customer_id,'customer_nm' => $customer_nm]);
		return redirect('/billMemoEst?est_no='.$est_no.'');

	}
	public function changeCustomerEst02(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$change_dt=$r->input('change_dt');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['est_dt' => $change_dt]);

		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemoEst?est_no='.$est_no.'');
	}
	public function changeCustomerEst03(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$days=$r->input('days');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['days' => $days]);

		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemoEst?est_no='.$est_no.'');
	}
	public function changeCustomerEst04(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$km=$r->input('km');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['km' => $km]);

		//$r->session()->put('bill_no',$bill_no);
		//return redirect('billMemo');
		return redirect('/billMemoEst?est_no='.$est_no.'');

	}
	public function changeCustomerEst05(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$engineer=$r->input('engineer');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['engineer' => $engineer]);

		return redirect('/billMemoEst?est_no='.$est_no.'');

	}
	public function changeCustomerEst06(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$technician=$r->input('technician');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['technician' => $technician]);

		return redirect('/billMemoEst?est_no='.$est_no.'');
	}
    public function changeCustomerEst07(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$validity=$r->input('validity');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['validity' => $validity]);

		return redirect('/billMemoEst?est_no='.$est_no.'');
	}
    public function changeCustomerEst08(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$note=$r->input('note');//post input
		DB::table('est_mas')->where('est_no', $est_no)
		->update(['note' => $note]);

		return redirect('/billMemoEst?est_no='.$est_no.'');
	}

}
