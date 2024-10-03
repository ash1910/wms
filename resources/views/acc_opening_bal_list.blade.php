
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>

@extends("layouts.master")

@section("content")





<?php 


$dt_Voucher = DB::select("SELECT ref, max(tdate) as TanDate, max(ahead) as ahead, sum(debit) as amount FROM `tbl_acc_details`  where `vr_type` = 'Opening Balance'  GROUP BY ref");


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
		<a class="btn btn-primary active" href="/acc_opening_bal"><i class="fadeIn animated bx bx-add-to-queue"></i> Back to Opening Balance </a>


	


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
				<tbody>
				@if(isset( $dt_Voucher ))
				@foreach($dt_Voucher as $item)
					<tr>
					<tr>
						<td style="text-align: center;"><a href = "acc_opening_bal?ref={{$item->ref}}"><i class="lni lni-pencil-alt"></i></a></td>

						<td style="text-align: center;"><a href = "acc_opening_bal_list?ref={{$item->ref}}"onclick="return confirm('Are you sure want to delete?')" style="color:red;"> X </a></td>
						
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




  </script>
  
 
 

 @endsection
 