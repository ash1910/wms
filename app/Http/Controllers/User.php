<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    
	function check(Request $r){
		
		$user=$r->input('user');//post input
		$password=$r->input('password');//post input
		$user_name = "";
		
		$result = DB::select("select user_id,user_name,password,role,flag,`full_name`, `image` from user 
	where user_name='$user' and flag='1'");
	foreach($result as $post)
		{
			$user_id = $post->user_id;
			$user_name = $post->user_name;
			$db_password = $post->password;
			$role = $post->role;
			$full_name = $post->full_name;
			$image = $post->image;
		}
	if($user_name!="")
	{	
		if($user==$user_name && md5($password)==$db_password)
		{
			$r->session()->put('user_id',$user_id);
			$r->session()->put('user',$user);
			$r->session()->put('role',$role);
			$r->session()->put('full_name',$full_name);
			$r->session()->put('image',$image);
			return redirect ('home');
		}
		else
		{ 
		 $r->session()->flash('error','Please enter valid Password !!!');
		 return redirect ('/');
		}
	}

	if($user_name=="")
	{
		 $r->session()->flash('error','Please enter valid User Name !!!');
		 return redirect ('/');
	}
}
	
	
	
	
	
}
