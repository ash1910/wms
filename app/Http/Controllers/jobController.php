<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class jobController extends Controller
{
    public function jobAccept(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$estimate = DB::table('estimate')
		->where('customer_id', $customer_id)
		->where('flag',1)->get();

		foreach($estimate as $item1)
		{$id = $item1->id;
		$estimate_id = date("His"); 
		
		$result = DB::table('estimate')
					  ->where('id', $id)
					  ->update([
					  'estimate_id' => $estimate_id
					  ]);		
		
		// Display the alert box 
		 echo '<script>alert("Estimate Create Sucessfully !!!")</script>';
		 echo "<script>window.close();</script>";
		}
		
		
	}
	
    public function jobModify(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$estimate_parts = DB::table('estimate')
		->where('customer_id', $customer_id)
		->where('type', '1')
		->where('flag',1)
		->orderBy('prod_id', 'asc')->get();
		$estimate_service = DB::table('estimate')
		->where('customer_id', $customer_id)
		->where('type', '2')
		->where('flag',1)
		->orderBy('prod_id', 'asc')->get();
		$estimate_sample = DB::table('estimate')
		->where('customer_id', $customer_id)
		->where('type', '3')
		->where('flag',1)
		->orderBy('prod_id', 'asc')->get();
		
		return view('jobModify',['customer_id'=>$customer_id
		,'estimate_parts'=>$estimate_parts
		,'estimate_service'=>$estimate_service
		,'estimate_sample'=>$estimate_sample]);			
		

	}
	
    public function jobModifyOne(Request $r)
	{
		$qty=$r->input('qty');//post input
		$id=$r->input('id');//post input
		$result = DB::table('estimate')
					  ->where('id', $id)
					  ->update([
					  'qty' => $qty
					  ]);
		return back();
	}

    public function jobModifyDel(Request $r)
	{
		$id=$r->input('id');//post input
		$result = DB::table('estimate')->delete($id);
		return back();
	}
	
    public function jobModifyOneBack(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input

		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->get();
		$parts_info = DB::table('parts_info')->get();
		$service_info = DB::table('service_info')->get();
		$estimate_parts = DB::table('estimate')
		->where('type', '1')->where('flag',1)
		->orderBy('prod_id', 'asc')->get();
		$estimate_service = DB::table('estimate')
		->where('type', '2')->where('flag',1)
		->orderBy('prod_id', 'asc')->get();
		$estimate_sample = DB::table('estimate')
		->where('type', '3')->where('flag',1)
		->orderBy('prod_id', 'asc')->get();

		return view('estimate', [
					'result' => $result,
					'parts_info' => $parts_info,
					'service_info' => $service_info,
					'estimate_parts' => $estimate_parts,
					'estimate_service' => $estimate_service,
					'estimate_sample' => $estimate_sample
					]);	
	}
	
	public function jobCancel(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)
		->get();
		$result01 = DB::table('estimate')->where('customer_id', $customer_id)->delete();
		
		return view('gatePass',['result' => $result]);
	}

	public function jobSample(Request $r)
	{
		$customer_id=$r->input('customer_id');//post input
		
		$estimate_sample = DB::table('estimate')
		->where('type', '3')->where('customer_id', $customer_id)->where('flag',1)
		->orderBy('prod_id', 'asc')->get();

		return view('jobSample',['customer_id'=>$customer_id,
		'estimate_sample'=>$estimate_sample]);
	}
	
	public function jobSampleOne(Request $r)
	{
		$sampleItem=$r->input('sampleItem');//post input
		$sampleQty=$r->input('sampleQty');//post input
		$samplePrice=$r->input('samplePrice');//post input
		$customer_id=$r->input('customer_id');//post input
		$today = date("Y-m-d");
		$user_id = session('user_id');
	
		
		
		/* Ae khaney kal k sql ta dektay hobey
		DB::insert('INSERT INTO `estimate`(`service_name`, `service_image`, `service_detail`) 
		VALUES (?,?,?)',[$service_name,$name1,$service_detail]);
		*/
		
		DB::insert('INSERT INTO `estimate`(`customer_id`, `prod_id`, `prod_name`, `qty`,unit_price, `dt`,
		 `user_id`, `flag`,`type`)
		VALUES (?,?,?,?,?,?,?,?,?)',[$customer_id,'xxxx',$sampleItem,$sampleQty,$samplePrice,$today,
		$user_id,'1','3']);

		return back();
		
	}

}
