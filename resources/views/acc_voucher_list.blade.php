


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>


@extends("layouts.master")

@section("content")





<?php 


if (isset($_GET["submit"])) 
{ 

 $From_Date = $_GET["f_date"]; 

 $To_Date = $_GET["t_date"]; 


	$dt_Voucher = DB::select("SELECT ref, max(tdate) as TanDate, max(ahead) as ahead, sum(debit) as amount FROM `tbl_acc_details`  
    where (`vr_type` = 'Bank Payment' or `vr_type` = 'Bank Receipt' or `vr_type` = 'Cash Receipt'or `vr_type` = 'Cash Payment'
    or `vr_type` = 'Bank Transfer'or `vr_type` = 'Cash Deposit'or `vr_type` = 'Cash Withdrawn'or `vr_type` = 'Journal Voucher')  
    AND (`tdate` between '$From_Date' and '$To_Date') GROUP BY ref HAVING `ahead` <> 'Primary'");




} else{

	$L_From_Date = date('Y-m-d'); 

	$L_To_Date = date('Y-m-d');

	$dt_Voucher = DB::select("SELECT ref, max(tdate) as TanDate, max(ahead) as ahead, sum(debit) as amount FROM `tbl_acc_details`  
    where (`vr_type` = 'Bank Payment' or `vr_type` = 'Bank Receipt' or `vr_type` = 'Cash Receipt'or `vr_type` = 'Cash Payment'
    or `vr_type` = 'Bank Transfer'or `vr_type` = 'Cash Deposit'or `vr_type` = 'Cash Withdrawn'or `vr_type` = 'Journal Voucher')  
    AND (`tdate` between '$L_From_Date' and '$L_To_Date') GROUP BY ref HAVING `ahead` <> 'Primary'");

}


$data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();




?>

<main class="page-content">


{{-- Message --}}


@if(session('danger'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('danger')}}
    </div>
@endif



<div class="card" >
		<a class="btn btn-success" href="/acc_voucher_entry"><i class="fadeIn animated bx bx-add-to-queue"></i> Back to Voucher Entry </a>


	<form   href="/acc_voucher_entry"  >
	
	
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
			<table id="Table1" class="table table-striped table-bordered" >
				<thead>
					<tr>
						<th>Edit</th>
						<th>Delete</th>
						<th>Preview</th>
						<th>Referance</th>
						<th>Date</th>
						<th>Accounts Head</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody id="myBody">
				@if(isset( $dt_Voucher ))
				@foreach($dt_Voucher as $item)
					<tr>
					<tr>
						<td style="text-align: center;"><a href = "acc_voucher_entry?ref={{$item->ref}}"><i class="lni lni-pencil-alt"></i></a></td>

						<td style="text-align: center;"><a href = "acc_voucher_list?ref={{$item->ref}}"onclick="return confirm('Are you sure want to delete?')" style="color:red;"> X </a></td>
						
						<td> <a href="" onclick=openPage() >Preview</a> </td>

						<td>{{$item->ref}}</td>
						<td>{{$item->TanDate}}</td>
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

				var my_ref  = this.cells[3].innerHTML;
				//alert(get_tin);

				var page = 'acc_report_voucher/'+my_ref;
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
 