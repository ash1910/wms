<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />



@extends("layouts.master")

@section("content")




<?php 

$myID = request()->get('id');

//echo ($myID);
$dt_Acc_Head = DB::select("SELECT * FROM `tbl_acc_masters` WHERE `grp_status` = 'AH' ORDER BY acc_name");

$dt_Cash_Book = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE `grp_status` ='AH' and `type_id`='6'");

$dt_Bank_Book = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE `grp_status` ='AH' and `type_id`='7'");

$dt_Customer_info = DB::select("SELECT DISTINCT `others_id`, customer_info.customer_nm FROM `tbl_acc_details` 
INNER JOIN customer_info on tbl_acc_details.others_id = customer_info.customer_id ;");

$dt_Supplier_info = DB::select("SELECT DISTINCT `others_id`, suppliers.supplier_name FROM `tbl_acc_details` 
INNER JOIN suppliers on tbl_acc_details.others_id = suppliers.supplier_id order by suppliers.supplier_id;");

if(isset($myID)){

  $dt_AccHead_Edit = DB::table('tbl_acc_masters')->select('id','acc_name')->where('id', '=', $myID)->first();

  $dt_AccGroup_Edit = DB::table('tbl_acc_masters')->select('id','child_name')->where('id', '=', $myID)->first();

}


$dt_AccGroup = DB::select("SELECT * FROM `tbl_acc_masters` WHERE id > 5 AND grp_status ='GR'ORDER BY acc_name;");

$data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();


?>







<main class="page-content">



@if (\Session::has('success'))

    <div class="alert alert-success fade-message">
         <p>{{ \Session::get('success') }}</p>
    </div><br />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(function(){
        setTimeout(function() {
            $('.fade-message').slideUp();
        }, 1500);
    });
    </script>
@endif 

			
  
 		
                        
                    <div class="col-12 col-lg-5">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <h6 style="text-align:center; font-weight:bold;" class="mb-0 text-uppercase"><u>WORKSHOP MANAGEMENT REPORT</u> </h6>
                                <br>
                                <div class="col-12">
                                    <label class="form-label">Select Report</label>
                                    <select autofocus name="report_type" id="report_type" class="form-select" onchange="showHideDiv(this)">
                                        <option >--Select--</option>
                                        <option value="1">Journal</option>
                                        <option value="2">Ledger</option>
                                        <option value="3">Cash Book</option>
                                        <option value="4">Bank Book</option>
                                        <option value="5">Receipt & Payment</option>
                                        <option value="6">Trial Balance</option>
                                        <option value="7">Profit & Loss A/C</option>
                                        <option value="8">Balance Sheet</option>
                                        <option value="9">Customer Ledger</option>
                                        <option value="10">Supplier Ledger</option>
                                        <option value="11">Customer Position</option>
                                    </select>
                                </div>
                                <br>
                                <div class="col-12">
                                    <label class="form-label">Date Range</label>
                                    <select autofocus name="date_range" id="date_range" class="form-select">
                                        <option value="Customs">Customs</option>
                                        <option value="Yearly">Yearly</option>
                                        <option value="Current Month">Current Month</option>
                                        <option value="Previous Month">Previous Month</option>
                                    </select>
                                </div>
                                <br>
                                <div class="col-12">
                                        <td>Form: </td>
                                        <td><input type ="date" value="<?= date('Y-m-d') ?>" class="form-control"  name="f_date"  id="f_date" required></td>
                                </div>
                                <br>
                                <div class="col-12">
                                        <td>To: </td>
                                        <td><input type ="date" value="<?= date('Y-m-d') ?>" class="form-control"  name="t_date"  id="t_date" required></td>
                                </div>
                                <br>
                                <div style='display:none;' id="journal" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="myJournal" id="myJournal" class="form-select">
                                        <option value="All Journal">All Journal</option>
                                        <option value="Cash Receipt">Cash Receipt</option>
                                        <option value="Bank Receipt">Bank Receipt</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                        <option value="Bank Payment">Bank Payment</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cash Deposit">Cash Deposit</option>
                                        <option value="Cash Withdrawn">Cash Withdrawn</option>
                                        <option value="Journal Voucher">Journal Voucher</option>
                                    </select>						
						
                                </div>
                              
                                <div  style='display:none;' id="ledger" class="col-12">
                                    <label class="form-label">Accounts</label>
                                    
                                    <select name="myLedger" id="myLedger" class="form-select">
                                        @if(isset( $dt_Acc_Head ))
                                            @foreach ( $dt_Acc_Head as $item)
                                            <option  value="{{$item->acc_name}}" >{{$item->acc_name}} </option>
                                            @endforeach
                                        @endif
                                    </select>						
						
                                </div>

                                
                                <div  style='display:none;' id="CashBook" class="col-12">
                                    <label class="form-label">Accounts</label>
                                    
                                    <select name="myCashBook" id="myCashBook" class="form-select">
                                        @if(isset( $dt_Cash_Book ))
                                            @foreach ( $dt_Cash_Book as $item)
                                            <option  value="{{$item->acc_name}}" >{{$item->acc_name}} </option>
                                            @endforeach
                                        @endif
                                    </select>						
						
                                </div>

                                <div  style='display:none;' id="BankBook" class="col-12">
                                    <label class="form-label">Accounts</label>
                                    
                                    <select name="myBankBook" id="myBankBook" class="form-select">
                                        @if(isset( $dt_Bank_Book ))
                                            @foreach ( $dt_Bank_Book as $item)
                                            <option  value="{{$item->acc_name}}" >{{$item->acc_name}} </option>
                                            @endforeach
                                        @endif
                                    </select>						
						
                                </div>

                                <div style='display:none;' id="Rec_Pay" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="myRecPay" id="myRecPay" class="form-select">
                                        <option value="Accountswise">Accountswise</option>
                                    </select>						
						
                                </div>
                               <br>

                                <div style='display:none;' id="t_bal" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="myTB" id="myTB" class="form-select">
                                        <option value="Accountswise">Accountswise</option>
                                        <option value="Groupwise">Groupwise</option>
                                    </select>						
						
                                </div>
                                <div style='display:none;' id="PL" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="myPL" id="myPL" class="form-select">
                                        <option value="Accountswise">Accountswise</option>
                                        <option value="Groupwise">Groupwise</option>
                                    </select>						
						
                                </div>
                                <div style='display:none;' id="BS" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="myBS" id="myBS" class="form-select">
                                        <option value="Accountswise">Accountswise</option>
                                        <option value="Groupwise">Groupwise</option>
                                    </select>						
						
                                </div>
                                <div style='display:none;' id="Customer" class="col-12">
                                    <label class="form-label">Control A/C ID</label>
                                    
                                    <!-- <select name="myCustomer" id="myCustomer" class="form-select">
                                        @if(isset( $dt_Customer_info ))
                                            @foreach ( $dt_Customer_info as $item)
                                            <option  value="{{$item->others_id}}" >{{$item->others_id}} - {{$item->customer_nm}} </option>
                                            @endforeach
                                        @endif
                                    </select>						 -->

                                    <input  type="text"  name="myCustomer" id="myCustomer" class="form-control form-control-sm" >
						
                                </div>
                                <div style='display:none;' id="Supplier" class="col-12">
                                    <label class="form-label">Options</label>
                                    
                                    <select name="mySupplier" id="mySupplier" class="form-select">
                                        @if(isset( $dt_Supplier_info ))
                                            @foreach ( $dt_Supplier_info  as $item)
                                            <option  value="{{$item->others_id}}" >{{$item->others_id}} - {{$item->supplier_name}} </option>
                                            @endforeach
                                        @endif
                                    </select>						
						
                                </div>

                                <div style='display:none;' id="CustomerPosition" class="col-12">
                                    <label class="form-label">Options</label>

                                    <select name="myCustomerPosition" id="myCustomerPosition" class="form-select">
                                            <option value="Workshop Customer">Workshop Customer</option>
                                            <option value="Intercompany Customer">Intercompany Customer</option>
                                            <option value="Automobile Customer">Automobile Customer</option>
                                    </select>						
						
                                </div>

                               <br>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button href="" onclick=openPage() type="submit" class="btn btn-primary">Preview</button>
                                    </div>
                                </div>

                             

                              
                            </div>
                        </div>
        


	
			
			
			
			
			
        
    @if(isset($data_ComInfo))

        

    <div> <input hidden type="text"  id="op_date" name="op_date" value ="{{$data_ComInfo[0]->fy_opening}}"></div>
    <div> <input hidden type="text"  id="cl_date" name="cl_date" value ="{{$data_ComInfo[0]->fy_closing}}"></div>

    <div> <input hidden type="text"  id="op_date_m" name="op_date_m" value =<?php $query_date = date('Y-m-d'); echo date('Y-m-01', strtotime($query_date)); ?>></div>
    <div> <input hidden type="text"  id="cl_date_m" name="cl_date_m" value =<?php $query_date = date('Y-m-d'); echo date('Y-m-t', strtotime($query_date)); ?>></div>

    <div> <input hidden type="text"  id="op_date_pm" name="op_date_pm" value = <?php $first_date = date('Y-m-d', strtotime('first day of previous month')); echo $first_date; ?>></div>
    <div> <input hidden type="text"  id="cl_date_pm" name="cl_date_pm" value =<?php $last_date  = date('Y-m-d', strtotime('last day of previous month')); echo $last_date; ?>></div>





    <script>

        document.getElementById('date_range').addEventListener('change', function() {
        
        //alert(this.value);

        if (this.value == "Yearly"){
        document.getElementById("f_date").value =  document.getElementById("op_date").value;
        document.getElementById("t_date").value =  document.getElementById("cl_date").value;
            
        }

        if (this.value == "Current Month"){

            document.getElementById("f_date").value =  document.getElementById("op_date_m").value;
            document.getElementById("t_date").value =  document.getElementById("cl_date_m").value;
            
        }

        if (this.value == "Previous Month"){

            document.getElementById("f_date").value =  document.getElementById("op_date_pm").value;
            document.getElementById("t_date").value =  document.getElementById("cl_date_pm").value;
            
        }



        });

        

        

    </script>

    @endif



    
			



			
</main>
@endsection		 





@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>


  <script type="text/javascript">
    function showHideDiv(select){

    if(select.value== '1'){
        //alert(1);
        document.getElementById('journal').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    }

    if(select.value== '2'){
        //alert(2);
        document.getElementById('ledger').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '3'){
        //alert(2);
        document.getElementById('CashBook').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    
    if(select.value== '4'){
        //alert(2);
        document.getElementById('BankBook').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '5'){
        //alert(2);
        document.getElementById('Rec_Pay').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('BankBook').style.display = "None";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '6'){
        //alert(2);
        document.getElementById('t_bal').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '7'){
        //alert(2);
        document.getElementById('PL').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '8'){
        //alert(2);
        document.getElementById('BS').style.display = "block";
        document.getElementById('PL').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '9'){
        //alert(2);
        document.getElementById('Customer').style.display = "block";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '10'){
        //alert(2);
        document.getElementById('Supplier').style.display = "block";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('CustomerPosition').style.display = "none";
    } 

    if(select.value== '11'){
        //alert(2);
        document.getElementById('CustomerPosition').style.display = "block";
        document.getElementById('Supplier').style.display = "none";
        document.getElementById('Customer').style.display = "none";
        document.getElementById('BS').style.display = "none";
        document.getElementById('PL').style.display = "none";
        document.getElementById('t_bal').style.display = "none";
        document.getElementById('Rec_Pay').style.display = "none";
        document.getElementById('BankBook').style.display = "none";
        document.getElementById('CashBook').style.display = "none";
        document.getElementById('ledger').style.display = "none";
        document.getElementById('journal').style.display = "none";
    } 


    } 


</script>


<script>
    function openPage(){

        var myValue =  document.getElementById('report_type').value

    if(myValue== '1'){

        //alert(1);
        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myOption =  document.getElementById('myJournal').value

        var page = 'acc_report_journal?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& option='+ myOption;
		var myWindow = window.open(page, "_self");

       
    }

    if(myValue== '2'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('myLedger').value

        var page = 'acc_report_ledger?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '3'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('myCashBook').value

        var page = 'acc_report_cashbk?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '4'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('myBankBook').value

        var page = 'acc_report_bankbk?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '5'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('myRecPay').value

        var page = 'acc_report_receipt_pay?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		var myWindow = window.open(page, "_self");
        
    } 


    if(myValue== '6'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myOption =  document.getElementById('myTB').value

        var page = 'acc_report_trial_bal?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& option='+ myOption;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '7'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myOption =  document.getElementById('myPL').value

        var page = 'acc_report_pl?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& option='+ myOption;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '8'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myOption =  document.getElementById('myBS').value

        var page = 'acc_report_bs?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& option='+ myOption;
		var myWindow = window.open(page, "_self");
        
    } 

    if(myValue== '9'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('myCustomer').value

        var page = 'acc_report_cust_ledger?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		
        var myWindow = window.open(page, "_self");

        
    } 

    if(myValue== '10'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myAccount =  document.getElementById('mySupplier').value

        var page = 'acc_report_sup_ledger?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& acc='+ myAccount;
		
        var myWindow = window.open(page, "_self");

        
    } 

    if(myValue== '11'){
        //alert(2);

        var myFr_Date =  document.getElementById('f_date').value
        var myTo_Date =  document.getElementById('t_date').value
        var myOption =  document.getElementById('myCustomerPosition').value

        var page = 'acc_rep_cust_position?f_date='+ myFr_Date +'& t_date='+ myTo_Date +'& option='+ myOption;
		
        var myWindow = window.open(page, "_self");

        
    } 


    } 


</script>


 
 @endsection
