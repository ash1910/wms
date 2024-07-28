<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class customerController extends Controller
{
    public function customer()
	{
		$company = DB::table('customer_info')->distinct()->get('company');
		$sister_companies = DB::table('customer_info')->distinct()->get('sister_companies');
		$customer_info = DB::table('customer_info')->get();

		return view ('customer', [
						'customer_info' => $customer_info,
						'company' => $company,
						'sister_companies' => $sister_companies
						
						]);	
	}	
	
	public function customerCreate(Request $r)
	{
		$customer_nm =request('customer_nm');//post input
		$customer_mobile =request('customer_mobile');//post input
		$email =request('email');//post input
		$customer_vehicle =request('customer_vehicle');//post input
		$customer_reg =request('customer_reg');//post input
		$customer_chas =request('customer_chas');//post input
		$customer_address =request('customer_address');//post input
		$year =request('year');//post input

		$customer_eng =request('customer_eng');//post input
		$car_user =request('car_user');//post input
		$car_colour =request('car_colour');//post input

		$driver_mobile =request('driver_mobile');//post input
		$company =request('company');//post input
		$customer_group =request('customer_group');//post input
		$sister_companies =request('sister_companies');//post input

		$contact_person =request('contact_person');//post input
		$bin =request('bin');//post input

		$ac_name=request('ac_name');//post input
		$ac_no=request('ac_no');//post input
		$bank_name=request('bank_name');//post input
		$branch_name=request('branch_name');//post input
		$routing_no=request('routing_no');//post input
		$swift_code=request('swift_code');//post input
		$ac_name02=request('ac_name02');//post input
		$ac_no02=request('ac_no02');//post input
		$bank_name02=request('bank_name02');//post input
		$branch_name02=request('branch_name02');//post input
		$routing_no02=request('routing_no02');//post input
		$swift_code02=request('swift_code02');//post input

		$contact1_name=request('contact1_name');
		$contact1_mobile=request('contact1_mobile');
		$contact1_desig=request('contact1_desig');
		$contact1_purpose=request('contact1_purpose');

		$contact2_name=request('contact2_name');
		$contact2_mobile=request('contact2_mobile');
		$contact2_desig=request('contact2_desig');
		$contact2_purpose=request('contact2_purpose');

		$contact3_name=request('contact3_name');
		$contact3_mobile=request('contact3_mobile');
		$contact3_desig=request('contact3_desig');
		$contact3_purpose=request('contact3_purpose');

		$contact4_name=request('contact4_name');
		$contact4_mobile=request('contact4_mobile');
		$contact4_desig=request('contact4_desig');
		$contact4_purpose=request('contact4_purpose');

		DB::insert('INSERT INTO `customer_info`( `customer_reg`, `customer_nm`, `customer_mobile`,`email`, `customer_eng`, `car_user`, `car_colour`,  
		`customer_address`, `customer_vehicle`, `flag`, `customer_chas`,`year`,`driver_mobile`,`company`,`customer_group`,`sister_companies`,`contact_person`,`ac_name`,`ac_no`,`bank_name`,
		`branch_name`,`routing_no`,`swift_code`,`ac_name02`,`ac_no02`,`bank_name02`,
		`branch_name02`,`routing_no02`,`swift_code02`,`bin`,
		`contact1_name`,`contact1_mobile`,`contact1_desig`,`contact1_purpose`,
		`contact2_name`,`contact2_mobile`,`contact2_desig`,`contact2_purpose`,
		`contact3_name`,`contact3_mobile`,`contact3_desig`,`contact3_purpose`,
		`contact4_name`,`contact4_mobile`,`contact4_desig`,`contact4_purpose`
		) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$customer_reg,$customer_nm,$customer_mobile,$email,$customer_eng,$car_user, $car_colour 
		,$customer_address,$customer_vehicle,'1',$customer_chas,$year,$driver_mobile,$company,$customer_group,$sister_companies,$contact_person,$ac_name,$ac_no,$bank_name,$branch_name,
		$routing_no,$swift_code,$ac_name02,$ac_no02,$bank_name02,$branch_name02,
		$routing_no02,$swift_code02,$bin, $contact1_name, $contact1_mobile, $contact1_desig, $contact1_purpose,  $contact2_name, $contact2_mobile, $contact2_desig, $contact2_purpose, $contact3_name, $contact3_mobile, $contact3_desig, $contact3_purpose, $contact4_name, $contact4_mobile, $contact4_desig, $contact4_purpose]);

		return redirect ('/home')->with('success', 'Customer Create Sucessfully!!!');
	}

	public function customerEdit()
	{
		$data = DB::table('customer_info')
		//->where('post_type', 'Sale')
		->get();
		return view('customerEdit',['data'=>$data]);
	}
	public function customerEditOne(Request $r)
	{
		$company = DB::table('customer_info')->distinct()->get('company');
		$sister_companies = DB::table('customer_info')->distinct()->get('sister_companies');

		$id =request('id');//post input

		$search=$r->input('search');//post input
		$register=$r->input('register');//post input
		$chas=$r->input('chas');//post input

		if( $id == "" ){
			if($register=='register'){
				$id = DB::table('customer_info')->where('customer_reg', $search)
				->where('flag', '1')->first()->customer_id;
			}
			if($chas=='chas'){
				$id = DB::table('customer_info')->where('customer_chas', $search)
				->where('flag', '1')->first()->customer_id;
			}
		}

		$data = DB::table('customer_info')
		->where('customer_id', $id)
		->get();
		return view('customerEditOne',['data'=>$data,'company' => $company,
						'sister_companies' => $sister_companies]);
	}	
	public function getCustomerDataById(Request $r)
	{
		$id = request('id');
		return DB::table('customer_info')
		->where('customer_id', $id)
		->first();
	}
	public function customerEditTwo(Request $r)
	{
		$customer_id =request('id');//post input
		$customer_nm =request('customer_nm');//post input
		$customer_mobile =request('customer_mobile');//post input
		$email =request('email');//post input
		$driver_mobile =request('driver_mobile');//post input
		$customer_vehicle =request('customer_vehicle');//post input
		$customer_reg =request('customer_reg');//post input
		$customer_chas =request('customer_chas');//post input
		$customer_address =request('customer_address');//post input
		$customer_group =request('customer_group');//post input
		$company =request('company');//post input
		$sister_companies =request('sister_companies');//post input

		$year =request('year');//post input

		$customer_eng =request('customer_eng');//post input
		$car_user =request('car_user');//post input
		$car_colour =request('car_colour');//post input

		$contact_person =request('contact_person');//post input
		$bin =request('bin');//post input

		$ac_name=request('ac_name');//post input
		$ac_no=request('ac_no');//post input
		$bank_name=request('bank_name');//post input
		$branch_name=request('branch_name');//post input
		$routing_no=request('routing_no');//post input
		$swift_code=request('swift_code');//post input
		$ac_name02=request('ac_name02');//post input
		$ac_no02=request('ac_no02');//post input
		$bank_name02=request('bank_name02');//post input
		$branch_name02=request('branch_name02');//post input
		$routing_no02=request('routing_no02');//post input
		$swift_code02=request('swift_code02');//post input

		$contact1_name=request('contact1_name');
		$contact1_mobile=request('contact1_mobile');
		$contact1_desig=request('contact1_desig');
		$contact1_purpose=request('contact1_purpose');

		$contact2_name=request('contact2_name');
		$contact2_mobile=request('contact2_mobile');
		$contact2_desig=request('contact2_desig');
		$contact2_purpose=request('contact2_purpose');

		$contact3_name=request('contact3_name');
		$contact3_mobile=request('contact3_mobile');
		$contact3_desig=request('contact3_desig');
		$contact3_purpose=request('contact3_purpose');

		$contact4_name=request('contact4_name');
		$contact4_mobile=request('contact4_mobile');
		$contact4_desig=request('contact4_desig');
		$contact4_purpose=request('contact4_purpose');

		$data = DB::table('customer_info')
		->where('customer_id', $customer_id)
	  ->update([
	  'customer_nm' => $customer_nm,
	  'customer_eng' => $customer_eng,
	  'car_user' => $car_user,
	  'car_colour' => $car_colour,
	  'customer_mobile' => $customer_mobile,
	  'email' => $email,
	  'driver_mobile' => $driver_mobile,
	  'customer_vehicle' => $customer_vehicle,
	  'customer_reg' => $customer_reg,
	  'customer_chas' => $customer_chas,
	  'year' => $year,
	  'customer_address' => $customer_address,
	  'customer_group' => $customer_group,
	  'company' => $company,
	  'sister_companies' => $sister_companies,
	  'contact_person' => $contact_person,
	  'bin' => $bin,
	  'ac_name' => $ac_name,
	  'ac_no' => $ac_no,
	  'bank_name' => $bank_name,
	  'branch_name' => $branch_name,
	  'routing_no' => $routing_no,
	  'swift_code' => $swift_code,
	  'ac_name02' => $ac_name02,
	  'ac_no02' => $ac_no02,
	  'bank_name02' => $bank_name02,
	  'branch_name02' => $branch_name02,
	  'routing_no02' => $routing_no02,
	  'swift_code02' => $swift_code02,
	  'contact1_name' => $contact1_name,
	  'contact1_mobile' => $contact1_mobile,
	  'contact1_desig' => $contact1_desig,
	  'contact1_purpose' => $contact1_purpose,
	  'contact2_name' => $contact2_name,
	  'contact2_mobile' => $contact2_mobile,
	  'contact2_desig' => $contact2_desig,
	  'contact2_purpose' => $contact2_purpose,
	  'contact3_name' => $contact3_name,
	  'contact3_mobile' => $contact3_mobile,
	  'contact3_desig' => $contact3_desig,
	  'contact3_purpose' => $contact3_purpose,
	  'contact4_name' => $contact4_name,
	  'contact4_mobile' => $contact4_mobile,
	  'contact4_desig' => $contact4_desig,
	  'contact4_purpose' => $contact4_purpose
	  ]);
	  //return redirect ('/customerEdit');
	  return redirect ('/home')->with('success', 'Customer has been Updated Sucessfully.');
	}
	public function customerDel(Request $r)
	{
		$customer_id =request('id');//post input
		$result = DB::table('customer_info')
		->where('customer_id', $customer_id)->delete();
		return redirect ('/customerEdit');

	}
	public function changePassword()
	{
		return view ('/changePassword');
	}
	public function changePassword01(Request $r)
	{
		$password =request('password');//post input
		$user_id=session('user_id');

		$data = DB::table('user')
		->where('user_id', $user_id)
		->update(['password' => md5($password)]);
		return redirect ('changePassword')->with('sucess', 'Thanks For Subscribe!');
	
		
	}
	
	
	
	
}
