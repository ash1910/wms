<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class setupController extends Controller
{
    public function service()
	{
		$data = DB::table('service_info')
		->get();
		return view('service',['data'=>$data]);
	}
	public function serviceAdd()
	{
		$service_info = DB::table('service_info')->get();
		return view('serviceAdd',['service_info'=>$service_info]);
	}
	public function serviceAddOne(Request $r)
	{
		$service_name=$r->input('service_name');//post input
		$section=$r->input('section');//post input
		DB::insert('INSERT INTO `service_info`(`service_name`, `type`, `section`) VALUES (?,?,?)',[$service_name,'2',$section]);
		return redirect ('/service')->with('success', 'New Service Add Sucessfully!!!');
	}
	public function serviceEdit(Request $r)
	{
		$id=$r->input('id');//post input
		return view('serviceEdit',['id'=>$id]);
	}
	public function serviceEditOne(Request $r)
	{
		$id=$r->input('id');//post input
		$section=$r->input('section');//post input
		$result = DB::table('service_info')->where('service_id', $id)
		->update([ 'section' => $section]);
		return redirect('/service');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function user()
	{
		$data = DB::table('user')->where('role', '<>', 'Super Administrator')
		->get();
		return view('user',['data'=>$data]);
	}	
	public function userAdd()
	{
		$user_info = DB::table('user')->get();
		return view('userAdd',['user_info'=>$user_info]);
	}
	public function userAddOne(Request $r)
	{
		$user_name=$r->input('user_name');//post input
		$full_name=$r->input('full_name');//post input
		$role=$r->input('role');//post input
		$password=$r->input('password');//post input
		DB::insert('INSERT INTO `user`(`user_name`,`password`,`role`,`flag`,`full_name`) VALUES (?,?,?,?,?)',
		[$user_name,md5($password),$role,'1',$full_name]);
		return redirect ('/user')->with('success', 'New User Add Sucessfully!!!');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function parts()
	{
		$data = DB::table('parts_info')
		->get();
		return view('parts',['data'=>$data]);
	}	
	public function partsAdd()
	{
		$company = DB::table('parts_info')->distinct()->get('cat');
		$sister_companies = DB::table('parts_info')->distinct()->get('sub_cat');
		$parts_info = DB::table('parts_info')->get();
		return view('partsAdd',['parts_info'=>$parts_info,
						'company' => $company,
						'sister_companies' => $sister_companies]);
	}
	public function partsEdit(Request $r)
	{
		$company = DB::table('parts_info')->distinct()->get('cat');
		$sister_companies = DB::table('parts_info')->distinct()->get('sub_cat');
		$id=$r->input('id');//post input
		return view('partsEdit',['id'=>$id,
						'company' => $company,
						'sister_companies' => $sister_companies]);
	}
	public function partsEditOne(Request $r)
	{
		$id=$r->input('id');//post input
		$cat=$r->input('cat');//post input
		$sub_cat=$r->input('sub_cat');//post input
		$section=$r->input('section');//post input
		$result = DB::table('parts_info')->where('parts_id', $id)
		->update(['cat' => $cat,'sub_cat' => $sub_cat, 'section' => $section]);
		return redirect('/parts');
	}
	public function partsAddOne(Request $r)
	{
		$parts_name=$r->input('parts_name');//post input
		$cat=$r->input('cat');//post input
		$sub_cat=$r->input('sub_cat');//post input
		$section=$r->input('section');//post input
		DB::insert('INSERT INTO `parts_info`(`parts_name`, `type`, cat, sub_cat, section) VALUES (?,?,?,?,?)',[$parts_name,'1',$cat,$sub_cat,$section]);
		return redirect ('/parts')->with('success', 'New Parts Add Sucessfully!!!');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function supplier()
	{
		$data = DB::table('suppliers')
		->get();
		return view('supplier',['data'=>$data]);
	}	
	public function supplierAdd()
	{
		$parts_info = DB::table('suppliers')->get();
		return view('supplierAdd',['parts_info'=>$parts_info]);
	}
	public function supplierAddOne(Request $r)
	{
		$supplier_name=$r->input('supplier_name');//post input
		$address=$r->input('address');//post input
		$contact=$r->input('contact');//post input
		$email=$r->input('email');//post input
		$ac_name=$r->input('ac_name');//post input
		$ac_no=$r->input('ac_no');//post input
		$bank_name=$r->input('bank_name');//post input
		$branch_name=$r->input('branch_name');//post input
		$routing_no=$r->input('routing_no');//post input
		$swift_code=$r->input('swift_code');//post input
		$ac_name02=$r->input('ac_name02');//post input
		$ac_no02=$r->input('ac_no02');//post input
		$bank_name02=$r->input('bank_name02');//post input
		$branch_name02=$r->input('branch_name02');//post input
		$routing_no02=$r->input('routing_no02');//post input
		$swift_code02=$r->input('swift_code02');//post input
		DB::insert('INSERT INTO `suppliers`(`supplier_name`
		,`address`,`contact`,`ac_name`,`ac_no`,`bank_name`,
		`branch_name`,`routing_no`,`swift_code`,`ac_name02`,`ac_no02`,`bank_name02`,
		`branch_name02`,`routing_no02`,`swift_code02`,`email`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$supplier_name
		,$address,$contact,$ac_name,$ac_no,$bank_name,$branch_name,
		$routing_no,$swift_code,$ac_name02,$ac_no02,$bank_name02,$branch_name02,
		$routing_no02,$swift_code02,$email]);
		return redirect ('/supplier')->with('success', 'New Supplier Add Sucessfully!!!');
	}
	
	
	public function supplierEdit(Request $r)
	{
		$parts_info = DB::table('suppliers')->get();
		$id=$r->input('id');//post input
		return view('supplierEdit',['id'=>$id,'parts_info'=>$parts_info]);
	}
	public function supplierEditOne(Request $r)
	{

		$id=$r->input('id');//post input
		//$supplier_name=$r->input('supplier_name');//post input
		$address=$r->input('address');//post input
		$contact=$r->input('contact');//post input
		$ac_name=$r->input('ac_name');//post input
		$ac_no=$r->input('ac_no');//post input
		$email=$r->input('email');//post input
		$bank_name=$r->input('bank_name');//post input
		$branch_name=$r->input('branch_name');//post input
		$routing_no=$r->input('routing_no');//post input
		$swift_code=$r->input('swift_code');//post input
		$ac_name02=$r->input('ac_name02');//post input
		$ac_no02=$r->input('ac_no02');//post input
		$bank_name02=$r->input('bank_name02');//post input
		$branch_name02=$r->input('branch_name02');//post input
		$routing_no02=$r->input('routing_no02');//post input
		$swift_code02=$r->input('swift_code02');//post input

		$result = DB::table('suppliers')->where('supplier_id', $id)
		->update(['address' => $address,'contact' => $contact,'email' => $email
		
		,'ac_name' => $ac_name,'ac_no' => $ac_no,'bank_name' => $bank_name
		,'branch_name' => $branch_name,'routing_no' => $routing_no,'swift_code' => $swift_code
		,'ac_name02' => $ac_name02,'ac_no02' => $ac_no02,'bank_name02' => $bank_name02
		,'branch_name02' => $branch_name02,'routing_no02' => $routing_no02,'swift_code02' => $swift_code02
		
		
		]);




		return redirect ('/supplier')->with('success', 'Supplier Information Update Sucessfully!!!');
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function bomParts()
	{
		$data = DB::table('bom_prod')
		->get();
		return view('bomParts',['data'=>$data]);
	}	
	public function bomPartsAdd()
	{
		$company = DB::table('bom_prod')->distinct()->get('cat');
		$sister_companies = DB::table('bom_prod')->distinct()->get('sub_cat');
		$parts_info = DB::table('bom_prod')->get();
		return view('bomPartsAdd',['parts_info'=>$parts_info,
						'company' => $company,
						'sister_companies' => $sister_companies]);
	}
	public function bomPartsEdit(Request $r)
	{
		$company = DB::table('bom_prod')->distinct()->get('cat');
		$sister_companies = DB::table('bom_prod')->distinct()->get('sub_cat');
		$id=$r->input('id');//post input
		return view('bomPartsEdit',['id'=>$id,
						'company' => $company,
						'sister_companies' => $sister_companies]);
	}
	public function bomPartsEditOne(Request $r)
	{
		$id=$r->input('id');//post input
		$cat=$r->input('cat');//post input
		$sub_cat=$r->input('sub_cat');//post input
		$result = DB::table('bom_prod')->where('parts_id', $id)
		->update(['cat' => $cat,'sub_cat' => $sub_cat]);
		return redirect('/bomParts');
	}
	public function bomPartsAddOne(Request $r)
	{
		$parts_name=$r->input('parts_name');//post input
		$company=$r->input('company');//post input
		$sister_companies=$r->input('sister_companies');//post input
		$user = session('user');
		DB::insert('INSERT INTO `bom_prod`(`parts_name`, `cat`, `sub_cat`,`user_id`) VALUES (?,?,?,?)',
		[$parts_name,$company,$sister_companies,$user]);
		return redirect ('/bomParts')->with('success', 'New BOM Parts Add Sucessfully!!!');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////







}
