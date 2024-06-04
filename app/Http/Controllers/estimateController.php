<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class estimateController extends Controller
{
    public function estimateAdd(Request $r)
	{
		$product =request('product');//post input
		$pieces = explode(" - ", $product);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$customer_id =request('customer_id');//post input
		$type =request('type');//post input
		$qty =request('qty');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');
		$data = DB::table('parts_info')
				->where('parts_id', $prod_id)->where('type', $type)
				->get();
		foreach($data as $item)
		{
		$unit_price = $item->unit_price;
		}
		$data = DB::table('service_info')
				->where('service_id', $prod_id)->where('type', $type)
				->get();
		foreach($data as $item)
		{
		$unit_price = $item->unit_price;
		}

DB::insert('INSERT INTO `estimate`(`customer_id`, `prod_id`, `prod_name`, `qty`,unit_price, `dt`,
 `user_id`, `flag`,`type`)
VALUES (?,?,?,?,?,?,?,?,?)',[$customer_id,$prod_id,$prod_name,$qty,$unit_price,$today,
$user_id,'1',$type]);

/*
$result = DB::select("select customer_nm,customer_id, customer_reg, customer_mobile, customer_address,
			customer_vehicle, customer_chas
			from customer_info 
			where customer_id='$customer_id' and flag='1'");
			
			foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
			}
			$parts_info = DB::table('parts_info')->get();
			$estimate = DB::table('estimate')->get();
return view('estimate', [
			'customer_id' => $customer_id, 
			'customer_nm' => $customer_nm, 
			'customer_reg' => $customer_reg,
			'customer_mobile' => $customer_mobile,
			'customer_address' => $customer_address,
			'customer_vehicle' => $customer_vehicle,
			'customer_chas' => $customer_chas,
			'parts_info' => $parts_info,
			'estimate' => $estimate
			]);				
*/
return back();
	}


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
		$work=$r->input('work');//post input
		$est_dt = date("Y-m-d");
		$est_no = date("ymdHis");
		$customer_id=$r->input('customer_id');//post input
		$customer_nm=$r->input('customer_nm');//post input
		$user_id = session('user_id');


		if($register=="register01")
		{		
			DB::insert('INSERT INTO `est_mas`(`est_no`, `customer_id`, `engineer`, `technician`, `days`, 
			`est_dt`, `user_id`,`net_bill`,`work`,`km`, `customer_nm`) VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$est_no,$customer_id,$engineer,$technician,$days,$est_dt,
			$user_id,'',$work, $km,$customer_nm]);
			
			return redirect('/billMemoEst?est_no='.$est_no.'');
		}


	}

	public function billPrint_asEst(Request $r)
	{
		$est_no=$r->input('est_no');//post input
		$data = DB::select("SELECT flag FROM `est_mas` WHERE `est_no`=$est_no;");
		foreach($data as $item){ $flag = $item->flag; }		
		
		if($flag=='0')
		{
			return view ('billPrintDraft_asEst',['est_no'=>$est_no]);
		}		
		if($flag=='1')
		{
			return view ('billPrint03_asEst',['est_no'=>$est_no]);
		}
		if($flag=='2')
		{
			return view ('billPrint03_asEst',['est_no'=>$est_no]);
		}
		if($flag=='3')
		{
			return view ('billPrint03_asEst',['est_no'=>$est_no]);
		}
		
	}



}
