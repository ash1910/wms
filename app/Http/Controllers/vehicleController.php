<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class vehicleController extends Controller
{
    function searchby(Request $r)
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
		
		if($register=='register')
		{
			$result = DB::table('customer_info')->where('customer_reg', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;}
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();
			
			$estimate_parts = DB::table('estimate')
			->where('type', '1')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			
			$estimate_service = DB::table('estimate')
			->where('type', '2')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			
			$estimate_sample = DB::table('estimate')
			->where('type', '3')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			
			$estimate = DB::table('estimate')
			->where('customer_id', $customer_id)->where('flag',1)->get();
			
			foreach($estimate as $item2)
			{$estimate_id = $item2->estimate_id;}
		if($estimate_id!="")
			{
			return redirect ('search')->with('alert', 'Thanks For Subscribe!');
			}
			
		if($result=="[]")
			{
			return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
			}


return view('estimate', [
			'result' => $result,
			'parts_info' => $parts_info,
			'service_info' => $service_info,
			'estimate_parts' => $estimate_parts,
			'estimate_service' => $estimate_service,
			'estimate_sample' => $estimate_sample
			]);			
		}
		if($chas=='chas')
		{
			$result = DB::table('customer_info')->where('customer_chas', $search)
			->where('flag', '1')->get();
			foreach($result as $item1)
			{$customer_id = $item1->customer_id;}
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();
			$estimate_parts = DB::table('estimate')
			->where('type', '1')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			$estimate_service = DB::table('estimate')
			->where('type', '2')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			$estimate_sample = DB::table('estimate')
			->where('type', '3')->where('customer_id', $customer_id)->where('flag',1)
			->orderBy('prod_id', 'asc')->get();
			
			$estimate = DB::table('estimate')
			->where('customer_id', $customer_id)->where('flag',1)->get();
			foreach($estimate as $item2)
			{$estimate_id = $item2->estimate_id;}
		if($estimate_id!="")
			{
			return redirect ('search')->with('alert', 'Thanks For Subscribe!');
			}
			
		if($result=="[]")
			{
			return redirect ('customer')->with('alert', 'Thanks For Subscribe!');
			}
			
return view('estimate', [
			'result' => $result,
			'parts_info' => $parts_info,
			'service_info' => $service_info,
			'estimate_parts' => $estimate_parts,
			'estimate_service' => $estimate_service,
			'estimate_sample' => $estimate_sample
			]);			
		}

	


	
		
		

	
	
	}
}
