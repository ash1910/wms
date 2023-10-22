<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ledgerController extends Controller
{
    public function led_master()
	{
		$led_master = DB::table('led_master')->get();
		return view('led_master',['led_master'=>$led_master]);
	}
    public function led_master01(Request $r)
	{
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `led_master`(`name`) VALUES (?)',[$name]);
		return redirect ('/led_master')->with('alert', 'New Ledger Master Add Sucessfully!!!');
	}
    public function payment01(Request $r)
	{
		$ledge=$r->input('ledge');//post input
		$payment_type=$r->input('payment_type');//post input
		$amount=$r->input('amount');//post input
		$note=$r->input('note');//post input
		$user_id = session('user_id');
		$dt = date("Y-m-d");
		$data = DB::select("SELECT `id` FROM `coa` WHERE `name` = '$ledge'");
		foreach($data as $item){ $ledge01=$item->id ;}
		
		DB::insert('INSERT INTO `transactions01`(`ledge`,`payment_type`,`amount`,`note`,`type`,`date`,`user_id`) VALUES (?,?,?,?,?,?,?)',[$ledge01,$payment_type,-$amount,$note,'C',$dt,$user_id]);
		return redirect ('/payment')->with('alert', 'New Payment Add Sucessfully!!!');
	}
    public function led_group()
	{
		return view('led_group');
	}
    public function led_group01(Request $r)
	{
		$master_id=$r->input('master_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$master_id,$name]);
		return redirect ('/led_group')->with('alert', 'New Ledger Group Add Sucessfully!!!');
	}
 
	public function led_subGroup01()
	{
		return view('led_subGroup01');
	}
    public function led_sub01(Request $r)
	{
		$parent_id=$r->input('parent_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$parent_id,$name]);
		return redirect ('/led_subGroup01')->with('alert', 'New Ledger Sub Group Add Sucessfully!!!');
	} 
	public function led_subGroup02()
	{
		return view('led_subGroup02');
	}
    public function led_sub02(Request $r)
	{
		$parent_id=$r->input('parent_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$parent_id,$name]);
		return redirect ('/led_subGroup02')->with('alert', 'New Ledger Sub Group Add Sucessfully!!!');
	} 
	public function led_subGroup03()
	{
		return view('led_subGroup03');
	}
    public function led_sub03(Request $r)
	{
		$parent_id=$r->input('parent_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$parent_id,$name]);
		return redirect ('/led_subGroup03')->with('alert', 'New Ledger Sub Group Add Sucessfully!!!');
	} 
	public function led_subGroup04()
	{
		return view('led_subGroup04');
	}
    public function led_sub04(Request $r)
	{
		$parent_id=$r->input('parent_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$parent_id,$name]);
		return redirect ('/led_subGroup04')->with('alert', 'New Ledger Sub Group Add Sucessfully!!!');
	} 
	public function led_subGroup05()
	{
		return view('led_subGroup05');
	}
    public function led_sub05(Request $r)
	{
		$parent_id=$r->input('parent_id');//post input
		$name=$r->input('name');//post input
		DB::insert('INSERT INTO `coa`(`parent_id`,`name`) VALUES (?,?)',[$parent_id,$name]);
		return redirect ('/led_subGroup05')->with('alert', 'New Ledger Sub Group Add Sucessfully!!!');
	} 
///////////////////////Select option change sub select//////////////////////////////
    public function masTogroup($id){
        echo json_encode(DB::table('coa')->where('parent_id', $id)->get());
    }
    public function masTogroup01($id){
        echo json_encode(DB::table('coa')->where('parent_id', $id)->get());
    }
    public function masTogroup02($id){
        echo json_encode(DB::table('coa')->where('parent_id', $id)->get());
    }
    public function masTogroup03($id){
        echo json_encode(DB::table('coa')->where('parent_id', $id)->get());
    }
    public function masTogroup04($id){
        echo json_encode(DB::table('coa')->where('parent_id', $id)->get());
    }



	
    public function led_tree()
	{
		return view('led_tree');
	}
    public function chartOfAccount()
	{
		return view('chartOfAccount');
	}
    public function chartOfAccount01()
	{
		return view('chartOfAccount01');
	}
    public function chartOfAccount02(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view('chartOfAccount02', ['from_dt' => $from_dt,'to_dt' => $to_dt]);	
	}
	
	
	
	
	
	
	
	
	public function accounts()
	{
		return view('accounts');
	}
	public function groupAccount()
	{
		return view('groupAccount');
	}
	public function groupAccount01(Request $r)
	{
		$group=$r->input('group');//post input
		$parent_id=$r->input('parent_id');//post input
		
		DB::insert('INSERT INTO `groups`(`name`, `parent_id`) VALUES (?,?)',[$group,$parent_id]);
		return redirect ('/groupAccount')->with('alert', 'Add Sucessfully!!!');
	}
	public function groupAccountView()
	{
		return view('groupAccountView');
	}
	public function ledgerAccount()
	{
		return view('ledgerAccount');
	}
	public function ledgerAccount01(Request $r)
	{
		$groups=$r->input('groups_id');//post input
		$pieces = explode(" - ", $groups);
		$groups_id = $pieces[0];

		$name=$r->input('name');//post input
		$amount=$r->input('amount');//post input
		$txtype=$r->input('txtype');//post input
		$txdate= date("Y-m-d");//post input
		
		DB::insert('INSERT INTO `accounts`(`groups_id`, `name`) VALUES (?,?)',[$groups_id,$name]);
		$data = DB::select("SELECT `id` FROM `accounts` WHERE `groups_id`='$groups_id' and `name`='$name' ");
		foreach($data as $item){ $accounts_id = $item->id ;}
		DB::insert('INSERT INTO `transactions`(`accounts_id`, `amount`, `txtype`, `txdate`)
		VALUES (?,?,?,?)',[$accounts_id,$amount,$txtype,$txdate]);
		return redirect ('/ledgerAccount')->with('alert', 'Add Sucessfully!!!');

	}
	public function journal()
	{
		return view('journal');
	}

	public function setLedge(Request $r)
	{
		$payment=$r->input('payment');//post input
		$id=$r->input('id');//post input
	if($payment=='on')
	{		
		DB::table('coa')->where('id', $id)->update(['ledge' => '1']);
		return redirect ('/chartOfAccount01')->with('alert', 'Ledger Update Sucessfully!!!');
	}	
	if($payment=='')
	{		
		DB::table('coa')->where('id', $id)->update(['ledge' => '0']);
		return redirect ('/chartOfAccount01')->with('alert', 'Ledger Update Sucessfully!!!');
	}	
		return redirect ('/chartOfAccount01');

	}

	public function setLedge01(Request $r)
	{
		$move=$r->input('move');//post input
		$id=$r->input('id');//post input
		
		$data = DB::select("SELECT `id` FROM `coa` WHERE `name`='$move' ");
		foreach($data as $item){ $move_id = $item->id ;}
		DB::table('coa')->where('id', $id)->update(['parent_id' => $move_id]);
		return redirect ('/chartOfAccount01')->with('alert', 'Ledger Update Sucessfully!!!');
	}
	public function paymentDel(Request $r)
	{
		$id=$r->input('id');//post input
		$result = DB::table('transactions01')->where('id', $id)->delete();
		return redirect ('/payment')->with('alertDel', 'Ledger Update Sucessfully!!!');
	}
    public function paymentReport01(Request $r)
	{
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view('paymentReport01', ['from_dt' => $from_dt,'to_dt' => $to_dt]);	
	}
    public function paymentReport02(Request $r)
	{
		$id=$r->input('id');//post input
		$from_dt=$r->input('from_dt');//post input
		$to_dt=$r->input('to_dt');//post input
		return view('paymentReport02', ['from_dt' => $from_dt,'to_dt' => $to_dt,'id' => $id]);	
	}








}
