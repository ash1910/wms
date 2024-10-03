<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Models\tbl_acc_master;

use App\Models\tbl_test;

use App\Models\tbl_acc_detail;
use App\Models\tbl_rep_trial_bal;


class AccountsController extends Controller
{
    


   public function store_acc_group(Request $request)
    {


        $id = $request->input('group_id');

        if ( $id === null) {
                $acc_group = new tbl_acc_master;

                $MyGroup = $request->input('under_group');
                $result = explode('|', $MyGroup);
                $group_id =  trim($result[0]);
                $child_group =  trim($result[1]);
                    
                $acc_group->grp_status = 'GR';
                $acc_group->acc_name  = $request->input('group_name');
                $acc_group->grp_under = $group_id;
                $acc_group->type_id = $request->input('acc_type');
                $acc_group->child_name = $child_group;

                $acc_group->acc_lock = 0;

                // Checking Group Level
                $dt_group_level = DB::select("SELECT `id`,`acc_name`,  @myid_01:=grp_under FROM tbl_acc_masters WHERE `id` = '$group_id'
                            UNION
                            SELECT `id`,`acc_name`, @myid_01:=grp_under FROM tbl_acc_masters WHERE `id`=  @myid_01
                            UNION
                            SELECT `id`,`acc_name`,@myid_01:=grp_under FROM tbl_acc_masters WHERE `id`=  @myid_01
                            UNION
                            SELECT `id`,`acc_name`,@myid_01:=grp_under FROM tbl_acc_masters WHERE `id`=  @myid_01
                            UNION
                            SELECT `id`,`acc_name`,@myid_01:=grp_under FROM tbl_acc_masters WHERE `id`=  @myid_01
                            UNION
                            SELECT `id`,`acc_name`,@myid_01:=grp_under FROM tbl_acc_masters WHERE `id`=  @myid_01");


                        
                $number =  count( $dt_group_level );

                //dd($number);
            
                if ($number > 5) {

                    return redirect()->back()->with('warning', 'Maximum 6 (six) level is allowed !');


                }




                // Checking duplicate group before saving data
                $Ck_group = $request->input('group_name');

                $group_Exists = tbl_acc_master::where('acc_name', '=', $Ck_group)->first();
                if ( $group_Exists === null) {
                
                    $acc_group->save();
                    return redirect()->back()->with('success', 'Accounts Group created sucessfully !');

                } else{

                    return redirect()->back()->with('success', 'Duplicate group cannot save!');

                }

            }else{


                $acc_group = tbl_acc_master::find($id);
                //echo $id;

                $my_acc_grp = DB::table('tbl_acc_masters')->select('acc_name')->where('id', '=', $id)->first(); /// For update child_name column
        
                $MyGroup = $request->input('under_group');

                
                $result = explode('|', $MyGroup);
                $group_id =  trim($result[0]);
                $child_group =  trim($result[1]);
                    
                $acc_group->grp_status = 'GR';
                $acc_group->acc_name  = $request->input('group_name');
                $acc_group->grp_under = $group_id;
                $acc_group->type_id = $request->input('acc_type');
                $acc_group->child_name = $child_group;
        
                $acc_group->acc_lock = 0;
        
                $acc_group->update();

                /// Updating others column
                
                $my_type_id = DB::table('tbl_acc_masters')->select('type_id')->where('id', '=', $id)->first(); /// For update type_id column
        
                $group = $request->input('group_name');

                DB::table('tbl_acc_masters')->where('child_name', $my_acc_grp->acc_name)->update(['child_name' => $group, 'type_id' =>  $my_type_id->type_id ]);

        
                return redirect('acc_group_add')->with('success', 'Accounts Group updated sucessfully !');


            }
            
    }






   public function edit_acc_group( Request $request )
   {  
    
    $id = $request->id;
    $edit_data = tbl_acc_master::where('id','=',$id)->first();
    //echo $id;

    //$group_type = DB::select("SELECT tbl_acc_masters.id, tbl_acc_types.type_head  FROM tbl_acc_masters INNER JOIN  tbl_acc_types ON tbl_acc_masters.type_id = tbl_acc_types.id WHERE tbl_acc_masters.id = '.$id.'");
    //$group_type = DB::select("SELECT * FROM `tbl_acc_types` WHERE id =2;");
  

    // $group_type  = DB::table('tbl_acc_masters')
    // ->join('tbl_acc_types', 'tbl_acc_masters.type_id', '=', 'tbl_acc_types.id')
    // ->where('tbl_acc_masters.id', $id)
    // >get();


    return view('acc_group_add',compact('edit_data','id'));   


   }

    
   public function delete_acc_group(Request $request)
   {

    $id = $request->id;

    $GR_Under_Data_CK = DB::select("SELECT `grp_under` FROM `tbl_acc_masters` WHERE `grp_under` = '$id'");
    $number =  count($GR_Under_Data_CK);

    $id = $request->id;
     
    if ( ($id !== null) && (session('role')=="Super Administrator")) 
    {

        if ($number !== 0)
        {
            return redirect('acc_group_list')-> with ('warning','Data found under group can not delete!');

        }else{

            tbl_acc_master::where('id','=',$id)->delete();

            return redirect('acc_group_list')-> with ('danger','Group deleted successfully!');

            }
       
    } else {

        return view('acc_group_list'); 
    }

    
   }




   public function store_voucher_entry(Request $request)
   {
        $ref=  $request->input('voucherRef');
        
        $delete_ref = DB::table('tbl_acc_details')->where('ref', $ref);

        $check_ref= DB::select("SELECT `ref` FROM `tbl_acc_details` WHERE `ref` = '$ref'");
        $number =  count($check_ref);

        if ($number !== 0){

                $delete_ref->delete();

                foreach($request->accHead as $key=>$accHead) {

                    $MyVType = $request->input('vType');

                    $result = explode('|', $MyVType);
                    $vType =  trim($result[0]);
                

                    $data = new tbl_acc_detail();
                    $data->vr_type  = $vType;
                    $data->ref  = $request->input('voucherRef');
                    $data->tdate  = $request->input('trnDate');
                    $data->ahead= $accHead;
                    $data->debit = $request->accDebit[$key];
                    $data->credit = $request->accCredit[$key];
                    $data->narration = $request->accRemarks[$key];
                    $data->ch_no = $request->accChNo[$key];
                    $data->ch_date = $request->accChDate[$key];
                    $data->b_name = $request->accBank[$key];
                    $data->others_id = $request->accCID[$key];
                    $data-> Save();

                }

                return redirect('/acc_voucher_entry')->with('warning', 'Data updated Successfully !');
       
    
        }else{

            foreach($request->accHead as $key=>$accHead) {

                $MyVType = $request->input('vType');

                $result = explode('|', $MyVType);
                $vType =  trim($result[0]);
            

                $data = new tbl_acc_detail();
                $data->vr_type  = $vType;
                $data->ref  = $request->input('voucherRef');
                $data->tdate  = $request->input('trnDate');
                $data->ahead= $accHead;
                $data->debit = $request->accDebit[$key];
                $data->credit = $request->accCredit[$key];
                $data->narration = $request->accRemarks[$key];
                $data->ch_no = $request->accChNo[$key];
                $data->ch_date = $request->accChDate[$key];
                $data->b_name = $request->accBank[$key];
                $data->others_id = $request->accCID[$key];
                $data-> Save();

            }

            return redirect('/acc_voucher_entry')->with('success', 'Data saved Successfully !');

        }
       

        


   }



   

   public function edit_voucher_entry( Request $request )
   {  
    
    $ref= $request->ref;

    $editAccVoucher1 = tbl_acc_detail::where('ref','=',$ref)->first();

    //dd( $editAccVoucher1);

    //This DB::table() is used for Json Format
    $editAccVoucher2 = DB::table('tbl_acc_details')->where('ref', $ref)->get();
    //return $editAccVoucher2;
    


    return view('/acc_voucher_entry',compact('editAccVoucher1','editAccVoucher2','ref'));   


   }

   







   public function store_test_data(Request $request)
   {
        $ref=  $request->input('voucherRef');
        
        $check_ref = DB::table('tbl_tests')->where('ref', $ref);

        if ( $check_ref !== null){

            $check_ref->delete();
    
        }
       

        foreach($request->accHead as $key=>$accHead) {

            $data = new tbl_test();
            $data->ref  = $request->input('voucherRef');
            $data->ahead= $accHead;
            $data->amount = $request->accDebit[$key];
            $data-> Save();

        }
       


       return redirect('/acc_voucher_entry')->with('success', 'Data saved Successfully !');
   }


   

   public function edit_acc_Voucher( Request $request )
   {  
    
    $ref= $request->ref;

    

    $editAccVoucher = DB::table('tbl_tests')->where('ref', $ref)->get();
    $editAccVoucher->transform(function($i) {
        return (array)$i;
    });
    $array = $editAccVoucher->toArray();


    $editAccVoucher2 = tbl_test::where('ref','=',$ref)->first();
   

    return view('/acc_voucher_entry',compact('editAccVoucher','editAccVoucher2','ref'));   


   }


   public function delete_acc_voucher(Request $request)
   {

    $ref = $request->ref;
    
    if ( ($ref !== null) && (session('role')=="Super Administrator"))
    
    {

      
        tbl_acc_detail::where('ref','=',$ref)->delete();
    
    
        return redirect('acc_voucher_list')-> with ('danger','Voucher deleted successfully!');
    } else {

        return view('acc_voucher_list');  
    }
  
   }

   
   public function store_acc_head(Request $request)
    {


        $id = $request->input('acc_id');

        if ( $id === null) {

               $acc_name = new tbl_acc_master;

                $MyGroup = $request->input('under_group');
                $MyAccConfig = $request->input('acc_config');

                //echo ( $MyGroup);

                $result = explode('|', $MyGroup);
                $group_id =  trim($result[0]);
                $child_group =  trim($result[1]);
                    
             
                $my_type_id = DB::table('tbl_acc_masters')->select('type_id')->where('acc_name', '=', $child_group)->first();
          
                $acc_name->grp_status = 'AH';
                $acc_name->acc_name  = $request->input('a_name');
                $acc_name->grp_under = $group_id;
                $acc_name->type_id =  $my_type_id->type_id;
                $acc_name->child_name = $child_group;
                $acc_name->acc_config  = $MyAccConfig;

                $acc_name->acc_lock = 0;


                // Checking duplicate group before saving data
                $Ck_acc = $request->input('a_name');

                $acc_Exists = tbl_acc_master::where('acc_name', '=', $Ck_acc)->first();
                if ( $acc_Exists === null) {
                
                    $acc_name->save();
                    return redirect()->back()->with('success', 'Accounts Head Created sucessfully !');

                } else{

                    return redirect()->back()->with('success', 'Duplicate accounts cannot save!');

                }

            }else{


                 $acc_name = tbl_acc_master::find($id);
                //echo $id;
        
                $MyGroup = $request->input('under_group');
                $MyAccConfig = $request->input('acc_config');
                //dd( $MyGroup);

                $result = explode('|', $MyGroup);
                $group_id =  trim($result[0]);
                $child_group =  trim($result[1]);

                //dd($child_group);
                
                $my_type_id = DB::table('tbl_acc_masters')->select('type_id')->where('acc_name', '=', $child_group)->first();

                $my_acc_name = DB::table('tbl_acc_masters')->select('acc_name')->where('id', '=', $id)->first(); /// For details table

                //dd( $my_type_id);

                $acc_name->grp_status = 'AH';
                $acc_name->acc_name  = $request->input('a_name');
                $acc_name->grp_under = $group_id;
                $acc_name->type_id =  $my_type_id->type_id;
                $acc_name->child_name = $child_group;
                $acc_name->acc_config  = $MyAccConfig;
                
                $acc_name->acc_lock = 0;
        
                $acc_name->update();


                ///******** Updating Details Table */
            
                $ahead = $request->input('a_name');
                
                DB::table('tbl_acc_details')->where('ahead', $my_acc_name->acc_name)->update(['ahead' => $ahead]);


        
                return redirect('acc_head_add')->with('success', 'Accounts Head updated sucessfully !');


            }
            
    }


    public function delete_acc_head(Request $request)
    {
 
     $id = $request->id;

     $AH_Under_Data_CK = DB::select("SELECT tbl_acc_details.ahead, tbl_acc_masters.id FROM tbl_acc_masters INNER JOIN tbl_acc_details 
                                    ON tbl_acc_masters.acc_name = tbl_acc_details.ahead
                                    WHERE tbl_acc_masters.id = '$id' LIMIT 1;");

     $number =  count($AH_Under_Data_CK);


     
     $my_acc_grp = DB::table('tbl_acc_masters')->select('acc_lock')->where('id', '=', $id)->first(); 
        

      
     if ( ($id !== null) && (session('role')=="Super Administrator"))
     {
        if (  $my_acc_grp->acc_lock == 1){

            return redirect('acc_head_list')-> with ('warning','Accounts head is locked can not delete!');

        }

         if ($number !== 0)
         {
             return redirect('acc_head_list')-> with ('warning','Transactions found can not delete!');
 
         }

         if ($number == 0)
            {
 
            tbl_acc_master::where('id','=',$id)->delete();
 
             return redirect('acc_head_list')-> with ('danger','Accounts head deleted successfully!');
 
             }
        
     } else {
 
         return view('acc_head_list'); 
     }
   
   
        
        
    }


    public function ck_acc_lock(Request $request){
        
        $id = $request->id;

        if ( ($id !== null) && (session('role')=="Super Administrator")){

            $acc_lock = DB::table('tbl_acc_masters')->where('id', $id)->first()->acc_lock;  

            if ( $acc_lock == 1){

                return redirect('acc_head_list')-> with ('warning', 'This account is locked can not edit !');
            }

            if ( $acc_lock == 0){

                return view('acc_head_add'); 
            }

        }else{

            return view('acc_head_add'); 

        }

        


    }

    
   public function store_opening_balance(Request $request)
   {
        $ref=  $request->input('voucherRef');
        
        $check_ref = DB::table('tbl_acc_details')->where('ref', $ref);

        if ( $check_ref !== null){

            $check_ref->delete();
    
        }
       

        foreach($request->accHead as $key=>$accHead) {


            // $MyVType = $request->input('vType');

            // $result = explode('|', $MyVType);
            // $vType =  trim($result[0]);
          

            $data = new tbl_acc_detail();
            $data->vr_type  = $request->input('vType');
            $data->ref  = $request->input('voucherRef');
            $data->tdate  = $request->input('trnDate');
            $data->ahead= $accHead;
            $data->debit = $request->accDebit[$key];
            $data->credit = $request->accCredit[$key];
            $data->narration = $request->accRemarks[$key];
            $data->ch_no = null;
            $data->ch_date = null;
            $data->b_name = null;
            $data-> Save();

        }
       


       return redirect('/acc_opening_bal')->with('success', 'Data saved Successfully !');
   }

   
   public function delete_opening_bal(Request $request)
   {

    $ref = $request->ref;
    
    if ( ($ref !== null) && (session('role')=="Super Administrator")){

      
        tbl_acc_detail::where('ref','=',$ref)->delete();
    
    
        return redirect('acc_opening_bal_list')-> with ('danger','Data deleted successfully!');
    } else {

        return view('acc_opening_bal_list');  
    }
  
   }


   
   public function delete_auto_voucher(Request $request)
   {

    $ref = $request->ref;
    
    if ( $ref !== null){

      
        tbl_acc_detail::where('ref','=',$ref)->delete();
    
    
        return redirect('acc_auto_journal_list')-> with ('success','Data deleted successfully!');

        //return redirect('acc_auto_journal_list')-> with ('warning','You have no right to delete!');

    } else {

        return view('acc_auto_journal_list');  
    }
  
   }



   public function LoadTreeview(){

    $categories = tbl_acc_master::where('grp_under', '=', 0)->where('acc_name', '!=', 'Primary')->get();
    //dd( $categories);
    $allCategories = tbl_acc_master::pluck('acc_name','id')->all();
    return view('acc_report_trial_bal',compact('categories','allCategories'));

    }

    
   public function LoadTreeview_pl(){

    $categories = tbl_acc_master::where('grp_under', '=', 0)->where('acc_name', '!=', 'Primary')->where('acc_name', '!=', 'Assets')->where('acc_name', '!=', 'Liabilities')->get();
    //dd( $categories);
    $allCategories = tbl_acc_master::pluck('acc_name','id')->all();
    return view('acc_report_pl',compact('categories','allCategories'));

    }

    
   public function LoadTreeview_bs(){

    $categories = tbl_acc_master::where('grp_under', '=', 0)->where('acc_name', '!=', 'Primary')->where('acc_name', '!=', 'Income')->where('acc_name', '!=', 'Expenses')->get();
    //dd( $categories);
    $allCategories = tbl_acc_master::pluck('acc_name','id')->all();
    return view('acc_report_bs',compact('categories','allCategories'));

    }


    public function load_control_voucher(Request $r)
	{
		$id_from=$r->input('id_from');//post input
		$id_to=$r->input('id_to');//post input
		
		return redirect('/acc_control_acc_entry?id_from='.$id_from.'&id_to='.$id_to.'');
	}
	



}
