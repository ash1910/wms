<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class cashOutController extends Controller
{
    public function cashOut()
	{
		return view ('cashOut');	
	}
    public function suppliersPayment()
	{
		return view ('suppliersPayment');	
	}
    public function suppliersPayment01(Request $r)
	{
		$supplier=$r->input('supplier');//post input
		$pieces = explode(" - ", $supplier);
		$supplier_id = $pieces[0];
		$mon=$r->input('mon');//post input
		$year=$r->input('year');//post input
		$dt = $year.'-'.$mon;
		
		$data = DB::select("
		SELECT GROUP_CONCAT(supplier_ref) AS supplier_ref,SUM(`amount`)amount
		FROM `purchase_mas` WHERE `purchase_dt` like '$dt%' and supplier_id = '$supplier_id' order by supplier_ref;
		");
		foreach($data as $item){ 
		$supplier_ref = $item->supplier_ref;  
		$amount = $item->amount;
		}	
		$data01=DB::select("
		SELECT (`due`-(`discount`+`paid_amount`))amount FROM `suppliers_payment` WHERE `supplier_id` = '$supplier_id'
		AND `bill_numbers` = '$supplier_ref';
		");
		foreach($data01 as $item01){ 
		$amount = $item01->amount;
		}	
		return view('suppliersPayment02', [
			'supplier_ref' => $supplier_ref,'amount' => $amount,'supplier' => $supplier,
			'dt' => $dt,'supplier_id' => $supplier_id
			]);			
	}
    public function suppliersPayment03(Request $r)
	{
		 $supplier=$r->input('supplier');//post input
		 $pieces = explode(" - ", $supplier);
		 $supplier_id = $pieces[0];
		 $dt=$r->input('dt');//post input
		 $ref=$r->input('ref');//post input
		 $ref = rtrim($ref, ',');
		$find = '0,';
		if (strpos($ref, $find) !== false) 
		{
		$ref = trim($ref, "0,");
		}
		$pAmount=$r->input('pAmount');//post input
		 $discount=$r->input('discount');//post input
		 $pDt=$r->input('pDt');//post input
		 $bank=$r->input('bank');//post input
		 $chequeNo=$r->input('chequeNo');//post input
		 $chequeDt=$r->input('chequeDt');//post input
		 $note=$r->input('note');//post input
		 $pay_type=$r->input('pay_type');//post input
		 $tamount=$r->input('tamount');//post input
		

		DB::insert('INSERT INTO `suppliers_payment`(`supplier_id`, `bill_numbers`, `due`, 
			`discount`, `paid_amount`, `created_date`, `note`, `mode_of_payment`,
			`bank_name`, `cheque_number`,`cheque_date`) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?)',
			[$supplier_id,$ref,$tamount,
			$discount,$pAmount,$pDt,$note,$pay_type,
			$bank, $chequeNo,$chequeDt]);
			
		if($tamount==($pAmount+$discount))
		{	

		$ids = explode(',',$ref);
				$result = DB::table('purchase_mas')
				->where('supplier_id', $supplier_id)
				->whereIn('supplier_ref', $ids)
				->update(['paid' => '1']);
		}
		if($tamount!=($pAmount+$discount))
		{	
		$ids = explode(',',$ref);
				$result = DB::table('purchase_mas')
				->where('supplier_id', $supplier_id)
				->whereIn('supplier_ref', $ids)
				->update(['paid' => '2']);
		}
		return redirect ('suppliersPayment')->with('alert', 'Suppliers Payment Successfully!');

	}
	
	public function payments()
	{
		return view ('payments');	
	}
    public function payments01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		
	
		return view('payments01', [
			'from_dt' => $from_dt,'to_dt' => $to_dt
			]);			
	}
	public function accounting()
	{
		return view ('accounting');	
	}
	public function creditor()
	{
		return view ('creditor');	
	}
    public function creditor01(Request $r)
	{
		$year=$r->input('year');//post input
		return view('creditor01', [
			'year' => $year
			]);			
	}
	public function creditor02()
	{
		return view ('creditor02');	
	}




/*
	public function update()
	{
	

	$data = DB::select("SELECT `id`,`prod_id`,`qty`
	FROM `issue` WHERE `dt` BETWEEN '2023-01-01' AND '2023-01-09' AND `amount`='0'");
	foreach($data as $item)
		{ 
		echo $id = $item->id ;
		echo '&nbsp;&nbsp;';
		echo $prod_id = $item->prod_id ;
		echo '&nbsp;&nbsp;';
		echo $qty = $item->qty ;
		$rate = '0';
		$data01 = DB::select("SELECT `avg_price` FROM `bom_prod` WHERE `parts_id` = '$prod_id'");
		foreach($data01 as $item01)
			{ 
			echo $rate = round($item01->avg_price,2) ;
			echo '&nbsp;&nbsp;';
			}		
		echo $amount = round($qty*$rate,2);
		
		$result = DB::table('issue')
		->where('id', $id)
		->update(['avg_price' => $rate,'amount' => $amount]);


		echo '<br>';
		}
	}
*/

	
}
