<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>

@extends("layouts.master")

@section("content")





<?php 


if (isset($_GET["submit"])) 
{ 

 $From_Date = $_GET["f_date"]; 

 $To_Date = $_GET["t_date"]; 


 DB::table('tbl_voucher_list')->delete();

 $dt_Voucher = DB::select("SELECT vr_type, job_no, ref, MAX(others_id) as others_id, max(tdate) as TanDate, max(ahead) as ahead, sum(debit) as amount FROM `tbl_acc_details`  
 where (`vr_type` = 'Sales Revenue' or `vr_type` = 'Issue Invoice' or `vr_type` = 'Purchases Invoice' 
 or `vr_type` = 'Purchases Return' or `vr_type` = 'COGS Invoice' or `vr_type` = 'Supplier Payment' 
 or `vr_type` = 'Advance Receipt'or `vr_type` = 'Collection' or `vr_type` = 'Advance Adjustment')  
 AND (`tdate` between '$From_Date' and '$To_Date') GROUP BY vr_type, job_no, ref HAVING `ahead` <> 'Primary'");

foreach($dt_Voucher as $data){DB::table('tbl_voucher_list')->insert(['vr_type'=>$data->vr_type,'cust_id'=>$data->others_id, 'job_no'=>$data->job_no, 'ref'=>$data->ref, 
																	'tdate'=>$data->TanDate,'ahead'=>$data->ahead,'amount'=>$data->amount]);}
//// Customer Update
DB::select("update tbl_voucher_list as t1
    		inner join (SELECT customer_info.customer_id, customer_info.customer_nm, customer_info.customer_reg, 					    		
			customer_info.customer_chas   FROM `customer_info` 
            	INNER JOIN tbl_voucher_list
            	ON customer_info.customer_id = tbl_voucher_list.cust_id
            	) as t2
			set t1.reg_no = t2.customer_reg,  t1.cust_name = t2.customer_nm, t1.chasis_no = t2.customer_chas
			where (t1.cust_id = t2.customer_id) 
			AND (t1.vr_type = 'Collection' OR t1.vr_type = 'Sales Revenue' OR t1.vr_type = 'Advance Adjustment'
			OR t1.vr_type = 'Advance Receipt' OR t1.vr_type = 'Issue Invoice')");



//// Supplier Update
DB::select("update tbl_voucher_list as t1
    		inner join (SELECT  suppliers.supplier_id, suppliers.supplier_name FROM `suppliers`
				INNER JOIN tbl_voucher_list
				ON suppliers.supplier_id = tbl_voucher_list.cust_id) as t2
			set t1.cust_name = t2.supplier_name
			where t1.cust_id = t2.supplier_id;");





} else{

	$L_From_Date = date('Y-m-d'); 

	$L_To_Date = date('Y-m-d');



	DB::table('tbl_voucher_list')->delete();

	$dt_Voucher = DB::select("SELECT vr_type,  job_no, ref, MAX(others_id) as others_id, max(tdate) as TanDate, max(ahead) as ahead, sum(debit) as amount FROM `tbl_acc_details`  
	where (`vr_type` = 'Sales Revenue' or `vr_type` = 'Issue Invoice' or `vr_type` = 'Purchases Invoice' 
	or `vr_type` = 'Purchases Return' or `vr_type` = 'COGS Invoice' or `vr_type` = 'Supplier Payment' 
	or `vr_type` = 'Advance Receipt'or `vr_type` = 'Collection' or `vr_type` = 'Advance Adjustment')  
	AND (`tdate` between '$L_From_Date' and '$L_To_Date') GROUP BY vr_type, job_no, ref HAVING `ahead` <> 'Primary'");
   
   foreach($dt_Voucher as $data){DB::table('tbl_voucher_list')->insert(['vr_type'=>$data->vr_type,'cust_id'=>$data->others_id, 'job_no'=>$data->job_no, 'ref'=>$data->ref, 
																	   'tdate'=>$data->TanDate,'ahead'=>$data->ahead,'amount'=>$data->amount]);}
   //// Customer Update
   DB::select("update tbl_voucher_list as t1
			   inner join (SELECT customer_info.customer_id, customer_info.customer_nm, customer_info.customer_reg, 					    		
			   customer_info.customer_chas   FROM `customer_info` 
				   INNER JOIN tbl_voucher_list
				   ON customer_info.customer_id = tbl_voucher_list.cust_id
				   ) as t2
			   set t1.reg_no = t2.customer_reg,  t1.cust_name = t2.customer_nm, t1.chasis_no = t2.customer_chas
			   where (t1.cust_id = t2.customer_id) 
			   AND (t1.vr_type = 'Collection' OR t1.vr_type = 'Sales Revenue' OR t1.vr_type = 'Advance Adjustment'
			   OR t1.vr_type = 'Advance Receipt' OR t1.vr_type = 'Issue Invoice')");



	//// Supplier Update
	DB::select("update tbl_voucher_list as t1
	inner join (SELECT  suppliers.supplier_id, suppliers.supplier_name FROM `suppliers`
		INNER JOIN tbl_voucher_list
		ON suppliers.supplier_id = tbl_voucher_list.cust_id) as t2
	set t1.cust_name = t2.supplier_name
	where t1.cust_id = t2.supplier_id;");
   
}


$data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();

$dt_Voucher_list = DB::select("SELECT vr_type, cust_id, cust_name, ref, tdate, job_no, reg_no, chasis_no, ahead, amount FROM `tbl_voucher_list` ");



?>

<main class="page-content">


{{-- Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('success')}}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('warning')}}
    </div>
@endif
		



<div class="card" >
		<a class="btn btn-info" href=""> List of Auto Voucher Entry </a>


	<form   href="/acc_auto_journal_list"  >

			<div class="table-responsive">
				<table id ="myTable_01"  class="table table-success table-striped" >
					
					<tbody>

						<tr >
							<td>Date Range:</td>
							<td>
								<div class="select">
									<select autofocus name="date_range" id="date_range" class="form-select">
										<option value="Customs">Customs</option>
										<option value="Yearly">Yearly</option>
										<option value="Current Month">Current Month</option>
										<option value="Previous Month">Previous Month</option>
									</select>
								</div>
							</td>

							<td>Form: </td>
							<td><input type ="date" value="<?= date('Y-m-d') ?>" class="form-control"  name="f_date"  id="f_date" required></td>

							<td>To: </td>
							<td><input type ="date" value="<?= date('Y-m-d') ?>" class="form-control"  name="t_date"  id="t_date" required></td>

							<td><button class="btn btn-success" type="submit" name="submit" id="submit" > Find</button></td>

							<td width="25%">
								<div class="input-group rounded">
									<input onkeyup='searchSname()' id="mySearch" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
								</div>
							</td>


							

						</tr>

					</tbody>
				</table>
			</div>
			

	</form>


<div class="card-body">
	
		<div class="table-responsive">
			<table id="Table1" class="table table-striped table-bordered" style='font-size:100%'>
				<thead>
					<tr>
						<th type="hidden">Delete</th>
						<th>View</th>
						<th>Ref.</th>
						<th>Date</th>
						<th>Name</th>
						<th>Job No</th>
						<th>Registration</th>
						<th>Chassis No</th>
						<th>Accounts Head</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody  id="myBody">
				@if(isset( $dt_Voucher_list ))
				@foreach($dt_Voucher_list as $item)
					<tr>
					<tr>

						<td style="text-align: center;"><a href = "acc_auto_journal_list?ref={{$item->ref}}"onclick="return confirm('Are you sure want to delete?')" style="color:red;"> X </a></td>
						
						<td style="text-align: center;"> <a href="" onclick=openPage() ><i class="bi bi-search"></i></a> </td>

						<td>{{$item->ref}}</td>
						<td>{{date('d-m-Y', strtotime($item->tdate))}}</td>
						<td>{{$item->cust_id}}-{{$item->cust_name}}</td>
						<td>{{$item->job_no}}</td>
						<td>{{$item->reg_no}}</td>
						<td>{{$item->chasis_no}}</td>
						<td>{{$item->ahead}}</td>
						<td>{{$item->amount}}</td>
						
						
					</tr>
				@endforeach 
				@endif
				
				</tbody>
			</table>
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
  
  
  
  <script>



	function openPage(){


		var rows = document.getElementById("Table1").rows;

		for(var i = 0, ceiling = rows.length; i < ceiling; i++) {
			rows[i].onclick = function() {

				var my_ref  = this.cells[2].innerHTML;

				var final_ref = my_ref.split(['-']); 

				//alert(final_ref[0]);

				if(final_ref[0] == 'PIN'){

					var page = 'acc_report_voucher_pin/'+my_ref;

				}else if(final_ref[0] == 'PRN'){

					var page = 'acc_report_voucher_pir/'+my_ref;

				}else if(final_ref[0] == 'ISU'){

					var page = 'acc_report_voucher_isu/'+my_ref;

				}else{

					var page = 'acc_report_voucher/'+my_ref;

				}
				
			
				
				var myWindow = window.open(page);
				myWindow.focus();

			}
		}

	}


	function searchSname() {
		var input, filter, found, table, tr, td, i, j;
		input = document.getElementById("mySearch");
		filter = input.value.toUpperCase();
		table = document.getElementById("myBody");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td");
			for (j = 0; j < td.length; j++) {
				if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
					found = true;
				}
			}
			if (found) {
				tr[i].style.display = "";
				found = false;
			} else {
				tr[i].style.display = "none";
			}
		}
	}


  </script>
  
 
 

 @endsection
 