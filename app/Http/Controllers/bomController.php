<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class bomController extends Controller
{
	public function purchase()
	{
		return view ('purchase');
	}
	public function purchase01(Request $r)
	{
		$dt=$r->input('dt');//post input
		$supplier=$r->input('supplier');//post input
		$pieces = explode(" - ", $supplier);
		$supplier_id = $pieces[0];
		$supplier_ref =$r->input('ref');//post input
		$purchase_id = DB::table('purchase_mas')->max('purchase_id');
		$purchase_id = $purchase_id+1;
		$amount='0';
		$duplicate = '';
		$user_id = session('user_id');
		$purchase_dt = date('Y-m-d', strtotime($dt));

		$data = DB::select("
		SELECT `purchase_id` duplicate FROM `purchase_mas` WHERE `supplier_id` = '$supplier_id'
		and `supplier_ref` = '$supplier_ref';
		");
		foreach($data as $item){ $duplicate = $item->duplicate; }

		if($duplicate!='')
		{
		return back()->with('alert', 'Duplicate Supplier Bill No.');
		}

		DB::insert('INSERT INTO `purchase_mas`(`purchase_id`, `supplier_id`, `supplier_ref`, `amount`,
		`purchase_dt`, `user_id`,`flag`) VALUES (?,?,?,?,?,?,?)',[$purchase_id,$supplier_id,$supplier_ref,
		$amount, $purchase_dt, $user_id, '0']);

		return redirect('/purchase02?id='.$purchase_id.'');
	}

	public function purchase02(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('purchase02',['id'=>$id]);
	}

	public function purchase03(Request $r)
	{
		$purchase_id=$r->input('purchase_id');//post input
		$prod=$r->input('prod');//post input
		$pieces = explode(" - ", $prod);
		$prod_id = $pieces[0];
		$prod_name = $pieces[1];
		$qty=$r->input('qty');//post input
		$req=$r->input('req');//post input
		$rate=$r->input('rate');//post input
		$amount= $qty*$rate;//post input
		$job_no=$r->input('job_no');//post input
		$note=$r->input('note');//post input
		$user_id=session('user_id');
		$dt=date("Y-m-d");//post input
		$grn = '0';
		$data01 = DB::select("
		SELECT COUNT(*) grn FROM `purchase_det` WHERE `flag` is null;
		");
		foreach($data01 as $item){$grn = $item->grn;}
		$grn=$grn+1;

		DB::insert('INSERT INTO `purchase_det`(`purchase_id`, `prod_id`, `prod_name`, `qty`,`req`,
		`rate`,`amount`,`job_no`,`note`,`user_id`,`dt`,`grn`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$purchase_id,$prod_id,
		$prod_name,$qty, $req, round($rate,2), round($amount,2), $job_no, $note, $user_id, $dt, 'GRN-'.$grn]);

		$data = DB::select("
		SELECT sum(`amount`) amount FROM `purchase_det` WHERE `purchase_id` = $purchase_id;
		");
		foreach($data as $item){ $amount01 = $item->amount; }
		$amount02 = $amount01;
		//update amount
		DB::table('purchase_mas')->where('purchase_id', $purchase_id)
		->update(['amount' => $amount02, 'user_id' => session('user_id')]);

		return back();
	}
	public function purchase04(Request $r)
	{
		$id=$r->input('id');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$data = DB::select("
		SELECT `supplier_ref`,  `purchase_dt` FROM `purchase_mas` WHERE `purchase_id` = $id
		");
		foreach($data as $item){ $supplier_ref = $item->supplier_ref; $purchase_dt = $item->purchase_dt; }
		return view ('purchase04',['id'=>$id,'supplier_ref'=>$supplier_ref,'purchase_dt'=>$purchase_dt
		,'dt01'=>$dt01,'dt02'=>$dt02]);
	}
	public function purchase041(Request $r)
	{
		$id=$r->input('id');//post input
		$supplier_ref=$r->input('supplier_ref');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$result = DB::table('purchase_mas')->where('purchase_id', $id)
		->update(['supplier_ref' => $supplier_ref]);

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('inHistoryTwo',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02]);


	}
	public function purchase042(Request $r)
	{
		$id=$r->input('id');//post input
		$purchase_dt=$r->input('purchase_dt');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$result = DB::table('purchase_mas')->where('purchase_id', $id)
		->update(['purchase_dt' => $purchase_dt]);

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('inHistoryTwo',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02]);


	}



	public function purchaseDel(Request $r)
	{
		$id=$r->input('id');//post input
		$amount = 0;
		//find purchase ID
		$data = DB::select("SELECT `purchase_id`FROM `purchase_det` WHERE `id`='$id'");
		foreach($data as $item){ $purchase_id = $item->purchase_id;}
		//del
		$result = DB::table('purchase_det')->delete($id);
		//amount
		$data = DB::select("SELECT sum(`amount`) amount from purchase_det
		WHERE purchase_id = '$purchase_id'");
		foreach($data as $item){$amount = $item->amount > 0 ?  $item->amount : 0;}
		//update
		DB::table('purchase_mas')->where('purchase_id', $purchase_id)
		->update(['amount' => $amount]);
	    return back();
	}

	public function issue()
	{
		return view ('issue',['job_no'=>'']);
	}
	public function issue01(Request $r)
	{
		$prod=$r->input('prod');//post input
		$pieces = explode(" - ", $prod);
		$prod_id = $pieces[0];
		$prod_name01 = $pieces[1];
		$pieces = explode(" -[", $prod_name01);
		$prod_name = $pieces[0];
		$prod_name02 = $pieces[1];
		$job_no=$r->input('job_no');//post input
		$note=$r->input('note');//post input
		$qty=$r->input('qty');//post input
		$req=$r->input('req');//post input
	    $dt01=$r->input('dt');//post input
	    $dt=date('Y-m-d', strtotime($dt01));
		$user_id=session('user_id');
		//$dt=date("Y-m-d");//post input
		$mess = '';
		$gin = '0';
		$data01 = DB::select("
		SELECT `gin` FROM `issue` WHERE `id` = (SELECT max(`id`) FROM `issue` WHERE `flag` is null);
		");
		foreach($data01 as $item){$gin = $item->gin;}
		$pieces = explode("GIN-", $gin);
		$gin = $pieces[1];
		$gin=$gin+1;


		$data = DB::select("SELECT `avg_price`,`stock_qty` FROM `bom_prod` WHERE `parts_id`='$prod_id'");
		foreach($data as $item){ $avg_price = $item->avg_price;$stock_qty = $item->stock_qty;}

		if($stock_qty<$qty){$mess='Not Enough Quantity!!! ['.$prod_id.']-'.$prod_name;}
		else
		{
			DB::insert('INSERT INTO `issue`(`prod_id`, `prod_name`, `qty`, `job_no`, `note`, `user_id`,
			`dt`,`amount`,`avg_price`,`req`,`gin`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$prod_id,$prod_name,$qty,$job_no,$note, $user_id, $dt,
			$avg_price*$qty, $avg_price, $req, 'GIN-'.$gin]);
		}
		return back()->with('job_no', $job_no)->with('dt', $dt01)->with('req', $req)->with('mess', $mess);
	}
	public function issueDel(Request $r)
	{
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input
		$result = DB::table('issue')->delete($id);
		return back()->with('job_no', $job_no);
	}
	public function purchaseReturn()
	{
		return view ('purchaseReturn');
	}
	public function purchaseReturn01(Request $r)
	{
		$supplier=$r->input('supplier');//post input
		$pieces = explode(" - ", $supplier);
		$supplier_id = $pieces[0];
		$supplier_ref =$r->input('ref');//post input

		return view ('purchaseReturn02',['supplier_id'=>$supplier_id,'supplier_ref'=>$supplier_ref]);
	}
	public function purchaseReturn03(Request $r)
	{
		$supplier_id =$r->input('supplier_id');//post input
		$id =$r->input('id');//post input
		$supplier_ref =$r->input('supplier_ref');//post input

		return view ('purchaseReturn03',['supplier_id'=>$supplier_id,'supplier_ref'=>$supplier_ref,
		'id'=>$id]);
	}
	public function purchaseReturn04(Request $r)
	{
		$purchase_id=$r->input('purchase_id');//post input
		$prod_id=$r->input('prod_id');//post input
		$prod_name=$r->input('prod_name');//post input
		$qty=$r->input('qty');//post input
		$req=$r->input('req');//post input
		$rate=$r->input('rate');//post input
		$amount= $qty*$rate;//post input
		$job_no=$r->input('job_no');//post input
		$user_id=session('user_id');
		$dt=date("Y-m-d");//post input
		$supplier_id=$r->input('supplier_id');//post input
		$supplier_ref=$r->input('supplier_ref');//post input
		$id=$r->input('id');//post input
		$grn = '0';
		$data01 = DB::select("
		SELECT COUNT(*) grn FROM `purchase_det` WHERE `flag` = 'R';
		");
		foreach($data01 as $item){$grn = $item->grn;}
		$grn=$grn+1;

		DB::insert('INSERT INTO `purchase_det`(`purchase_id`, `prod_id`, `prod_name`, `qty`,`req`,
		`rate`,`amount`,`job_no`,`user_id`,`dt`,`flag`,`grn`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',[$purchase_id,$prod_id,
		$prod_name,-$qty, $req, $rate, -$amount, $job_no, $user_id, $dt, 'R', 'RTN-'.$grn]);

		$data = DB::select("
		SELECT sum(`amount`) amount FROM `purchase_det` WHERE `purchase_id` = $purchase_id;
		");
		foreach($data as $item){
		$amount01 = $item->amount;
		}
		$amount02 = $amount01;
		//update amount
		DB::table('purchase_mas')->where('purchase_id', $purchase_id)
		->update(['amount' => $amount02, 'user_id' => session('user_id')]);

		//return back();
		//return view ('purchaseReturn02',['supplier_id'=>$supplier_id,'supplier_ref'=>$supplier_ref]);

		return redirect('purchaseReturn')->with('alert', 'Purchase Return Done!!')
		->with('supplier_id',$supplier_id)->with('supplier_ref',$supplier_ref);
	}
	public function grossProfit()
	{
		return view ('grossProfit');
	}
	public function grossProfit01(Request $r)
	{
		$from_dt =$r->input('from_dt');//post input
		$to_dt =$r->input('to_dt');//post input
		return view ('grossProfit01',['from_dt'=>$from_dt,'to_dt'=>$to_dt]);

	}

	public function issueReport ()
	{
		return view ('issueReport');
	}
	public function issueWithDate ()
	{
		return view ('issueWithDate');
	}
	public function issueWithoutDate ()
	{
		return view ('issueWithoutDate');
	}
	public function issueReport01(Request $r)
	{
		$from_dt =$r->input('from_dt');//post input
		$to_dt =$r->input('to_dt');//post input
		return view ('issueReport02',['from_dt'=>$from_dt,'to_dt'=>$to_dt]);
	}
	public function issueReport03(Request $r)
	{
		$from_dt =$r->input('from_dt');//post input
		$to_dt =$r->input('to_dt');//post input
		return view ('issueReport03',['from_dt'=>$from_dt,'to_dt'=>$to_dt]);
	}
	public function printIssue(Request $r)
	{
		$from_dt =$r->input('from_dt');//post input
		$to_dt =$r->input('to_dt');//post input
		return view ('printIssue',['from_dt'=>$from_dt,'to_dt'=>$to_dt]);
	}
	public function issueReturn()
	{
		return view ('issueReturn');
	}
	public function issueReturn01(Request $r)
	{
		$job_no =$r->input('job_no');//post input
		return view ('issueReturn01',['job_no'=>$job_no]);

	}
	public function issueReturn02(Request $r)
	{
		$id =$r->input('id');//post input
		$job_no =$r->input('job_no');//post input
		return view ('issueReturn02',['job_no'=>$job_no,'id'=>$id]);

	}
	public function issueReturn03(Request $r)
	{
		$id =$r->input('id');//post input
		$job_no =$r->input('job_no');//post input
		$note =$r->input('note');//post input
		$prod_id =$r->input('prod_id');//post input
		$prod_name =$r->input('prod_name');//post input
		$qty =$r->input('qty');//post input
		$user_id=session('user_id');
		$dt=$r->input('dt');//post input
        $avg_price =$r->input('avg_price');//post input
        $amount= $qty*$avg_price;//post input
		$grn = '0';
		$data01 = DB::select("
		SELECT COUNT(*) grn FROM `issue` WHERE `flag` = 'R';
		");
		foreach($data01 as $item){$grn = $item->grn;}
		$grn=$grn+1;


		DB::insert('INSERT INTO `issue`(`prod_id`, `prod_name`, `qty`, `job_no`, `note`,
		`user_id`, `dt`,`gin`,`flag`,`avg_price`,`amount`) VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$prod_id, $prod_name,-$qty, $job_no, $note,
		$user_id, $dt,'RTN-'.$grn,'R',$avg_price,-$amount]);
		//return view ('issueReturn01',['job_no'=>$job_no]);
		//return redirect()->route('issueReturn01', ['job_no' => $job_no]);
		//return redirect(route(('issueReturn01')));
		return redirect('issueReturn')->with('alert', 'Issure Return Done!!')
		->with('job',$job_no);;
	}
	public function issueModi(Request $r)
	{
		return view ('issueModi');
	}
	public function issueModi01(Request $r)
	{
		$job_no=$r->input('job_no');//post input

			return redirect('issue')->with('job_no', $job_no);
	}
	public function purchase05(Request $r)
	{
		$id=$r->input('id');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input
		$data = DB::select("
		SELECT `req`,`job_no` FROM `purchase_det` WHERE `id` = '$id'
		");
		foreach($data as $item){ $req = $item->req;$job_no = $item->job_no; }
		return view ('purchase05',['id'=>$id,'req'=>$req,'job_no'=>$job_no,'dt01'=>$dt01,'dt02'=>$dt02]);

	}
	public function purchase051(Request $r)
	{
		$id=$r->input('id');//post input
		$req=$r->input('req');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$result = DB::table('purchase_det')
		->where('id', $id)
		->update(['req' => $req]);

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('inHistoryTwo',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02]);

	}
	public function purchase052(Request $r)
	{
		$id=$r->input('id');//post input
		$job_no=$r->input('job_no');//post input
		$dt01=$r->input('dt01');//post input
		$dt02=$r->input('dt02');//post input

		$result = DB::table('purchase_det')
		->where('id', $id)
		->update(['job_no' => $job_no]);

		$inHistory = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->orderBy('purchase_id', 'asc')
			->get(['supplier_id']);

		return view('inHistoryTwo',['inHistory'=>$inHistory,
		'dt01'=>$dt01,'dt02'=>$dt02]);
	}
	public function purchaseReport()
	{
		return view ('purchaseReport');
	}
	public function purchaseWithoutSupplier()
	{
		return view ('purchaseWithoutSupplier');
	}
	public function purchaseWithoutSupplier01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input


		return view ('purchaseWithoutSupplier01',['from_dt'=>$from_dt,'to_dt'=>$to_dt]);
	}
	public function productLedger()
	{
		return view ('productLedger');
	}
	public function productLedger01(Request $r)
	{
		$product=$r->input('product');//post input
		$pieces = explode(" - ", $product);
		$product_id = $pieces[0];

		return view ('productLedger01',['product_id'=>$product_id,'product'=>$product]);
	}
	public function productLedger02(Request $r)
	{
		$product=$r->input('id');//post input
		$pieces = explode(" - ", $product);
		$product_id = $pieces[0];

		return view ('productLedger02',['product_id'=>$product_id,'product'=>$product]);
	}


	public function ledger()
	{
		return view ('ledger');
	}
	public function supplierLedger()
	{
		return view ('supplierLedger');
	}
	public function supplierLedger01(Request $r)
	{
		$supplier=$r->input('supplier');//post input
		$pieces = explode(" - ", $supplier);
		$supplier_id = $pieces[0];

		return view ('supplierLedger01',['supplier_id'=>$supplier_id,'supplier'=>$supplier]);
	}
	public function vehicleLedger()
	{
		return view ('vehicleLedger');
	}
	public function vehicleLedger01(Request $r)
	{
		$reg=$r->input('reg');//post input
		return view ('vehicleLedger01',['reg'=>$reg]);
	}
	public function vehicleLedger02(Request $r)
	{
		$reg=$r->input('reg');//post input
		return view ('vehicleLedger02',['reg'=>$reg]);
	}
	public function jobLedger()
	{
		return view ('jobLedger');
	}
	public function advanceLedger()
	{
		return view ('advanceLedger');
	}
	public function advanceLedger01(Request $r)
	{
		$id=$r->input('id');//post input
		return view ('advanceLedger01',['id'=>$id]);
	}


}
