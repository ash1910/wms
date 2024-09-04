<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class stockController extends Controller
{
    public function in()
	{
		$parts_info = DB::table('parts_info')->get();
		$suppliers = DB::table('suppliers')->get();

		if(Session::get('ref')!='')
			{
			$today = date("Y-m-d");
			$ref=Session::get('ref');
			$sup=Session::get('sup');
			$stock = DB::table('stock')
			->join('parts_info', 'parts_info.parts_id', '=', 'stock.prod_id')
			->where('ref', $ref)->where('dt', $today)->where('supplier_id', $sup)
			->orderBy('prod_id', 'asc')->get();
			return view ('in', [
						'parts_info' => $parts_info,'suppliers' => $suppliers,'ref' => '',
						'stock' => $stock
						]);
			}
		if(Session::get('ref')=='')
			{
				return view ('in', [
							'parts_info' => $parts_info,'suppliers' => $suppliers,'ref' => ''
							]);
			}
	}
/*
	public function inOne(Request $r)
	{
		$ref=$r->input('ref');//post input
		$supplier=$r->input('supplier');//post input
		$pieces01 = explode(" - ", $supplier);
		$supplier_id = $pieces01[0];
		$prod=$r->input('prod');//post input
		$pieces = explode(" - ", $prod);
		$prod_id = $pieces[0];
		$qty=$r->input('qty');//post input
		$buypp=$r->input('buypp');//post input
		$salepp=$r->input('salepp');//post input
		$user_id = session('user_id');
		$today = date("Y-m-d");
		$avgtqty = '';

		/*
		$data = DB::select("
		SELECT `prod_id`, round(SUM(`buytp`)/sum(`qty`),2) avg, round(SUM(`buytp`),2) avgbuytp, round(sum(`qty`)) avgtqty
		FROM `stock`
		where `prod_id` = $prod_id group by prod_id
		");
		*/
/*
		$data = DB::select("
		SELECT `parts_id`, `parts_name`, `avg_price`, `stock_qty`, `type` FROM `parts_info` WHERE `parts_id` = $prod_id
		");

		//foreach($data as $item){ $avg = $item->avg; $avgbuytp = $item->avgbuytp; $avgtqty = $item->avgtqty; }
		foreach($data as $item){ $avg = $item->avg_price;  $avgtqty = $item->stock_qty; }

		if($avgtqty=='')
		{
		DB::insert('INSERT INTO `stock`(`prod_id`, `qty`, `buypp`,`buytp`, `ref`, `user_id`, `dt`, `flag`,supplier_id)
		VALUES (?,?,?,?,?,?,?,?,?)',[$prod_id,$qty,$buypp,$qty*$buypp,$ref,$user_id,$today,'IN',$supplier_id]);

		DB::table('parts_info')->where('parts_id', $prod_id)
		->update(['avg_price' => $buypp, 'stock_qty' => $qty]);

		}
		if($avgtqty!='')
		{
		DB::insert('INSERT INTO `stock`(`prod_id`, `qty`, `buypp`,`buytp`, `ref`, `user_id`, `dt`, `flag`,supplier_id)
		VALUES (?,?,?,?,?,?,?,?,?)',[$prod_id,$qty,$buypp,$qty*$buypp,$ref,$user_id,$today,'IN',$supplier_id]);

		$newbuypp = round(((($avg*$avgtqty)+($qty*$buypp))/($avgtqty+$qty)),2);
		$newqty = $qty+$avgtqty;

		DB::table('parts_info')->where('parts_id', $prod_id)
		->update(['avg_price' => $newbuypp, 'stock_qty' => $newqty]);

		}
		$r->session()->flash('ref', $ref);
		$r->session()->flash('sup', $supplier);
		return back();
	}
*/
	public function inHistory()
	{
		return view ('inHistory');
	}
	public function inHistoryOne(Request $r)
	{
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('inHistoryTwo',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02
		]);
	}
	public function purchaseWithSupplier()
	{
		return view ('purchaseWithSupplier');
	}
	public function purchaseWithSupplier01(Request $r)
	{
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('purchaseWithSupplier01',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02
		]);
	}
	public function printPurchase(Request $r)
	{
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		/*
		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->where('flag', '0')->orderBy('purchase_id', 'asc')
			->get(['purchase_id','supplier_id','supplier_ref','purchase_dt']);
		*/
		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('printPurchase',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02
		]);
	}
	public function printPurchase02(Request $r)
	{
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		/*
		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->where('flag', '0')->orderBy('purchase_id', 'asc')
			->get(['purchase_id','supplier_id','supplier_ref','purchase_dt']);
		*/
		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('printPurchase02',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02
		]);
	}
	public function stock()
	{

		return view('stock');
	}
	public function dateStock()
	{
		return view ('dateStock');
	}
	public function dateStock01(Request $r)
	{
		$dt=$r->input('dt');//post input

		return view ('dateStock01',['dt'=>$dt]);

	}

	public function stock_wip()
	{

		return view('stock_wip');
	}



}
