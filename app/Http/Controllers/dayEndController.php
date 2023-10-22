<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dayEndController extends Controller
{
    public function dayEnd()
	{
		return view('dayEnd');
	}
	public function dayEnd01(Request $r)
	{
		$dt=$r->input('dt');//post input
		return view ('dayEnd01',['dt' => $dt]);	
	}
	public function dayEnd02(Request $r)
	{
		$open_balance=$r->input('open_balance');//post input
		$close_balance=$r->input('closing_balance');//post input
		$cash=$r->input('cash');//post input
		$bank=$r->input('bank');//post input
		$mfs=$r->input('mfs');//post input
		$card=$r->input('card');//post input
		$online=$r->input('online');//post input
		$date=$r->input('date');//post input
		$user_id = session('user_id');
		DB::table('day_end')->insert(['date' => $date,'open_balance' => $open_balance,'close_balance' => $close_balance,'cash' => $cash,'bank' => $bank,'mfs' => $mfs,'card' => $card,'online' => $online,'user_id' => $user_id]);
		return view ('dayEnd',['dt' => $date]);	
	}
}
