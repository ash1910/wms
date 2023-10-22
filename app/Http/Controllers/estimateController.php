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
}
