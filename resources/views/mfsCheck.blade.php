


<!-- HAPS Code -->
<?php 

$dt_BankAcc = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE `type_id`='7' and `child_name`='Cash at Bank'");
$dt_MFSAcc = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE `type_id`='7' and `child_name`='Cash at MFS'");


?>
<!-- End Code -->


<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
//echo session('role');
}
else {
?>
  <script>
    window.location = "/logout";
  </script>
<?php  
}
?>


@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message----> 
@if(session()->has('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
	
<script type="text/javascript">
$(document).ready(function () {
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
 });
</script>	
@endif	
<!---Alert message---->  

 <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Check</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Mobile Financial Services </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Mobile Financial Services Check</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>

				  <!-- HAPS Code -->
				  <div style="width: 100%;">
					<select  onchange="myFunction1()" id="BankAcc1" name="BankAcc1" style="width: 100%;" class="form-select" >
							<option >--Select Bank A/C--</option>
							@if(isset( $dt_BankAcc  ))
								@foreach ( $dt_BankAcc as $acc)
								<option  value="{{$acc->acc_name}}">{{$acc->acc_name}}</option>
								@endforeach
							@endif
					</select>
				</div>
				  <div style="width: 100%;">
					<select onchange="myFunction2()" id="BankAcc2" name="BankAcc2" style="width: 100%;" class="form-select">
						<option >--Select MFS A/C--</option>
						@if(isset( $dt_MFSAcc  ))
							@foreach ( $dt_MFSAcc as $item)
							<option  value="{{$item->acc_name}}">{{$item->acc_name}}</option>
							@endforeach
						@endif
					</select>
				</div>
				<!-- End Code -->
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">MFS Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">TRIX</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sender</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Debit A/C</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`id`, a.`pay_type`, a.`trix`, a.`send`, `received`, `due`, a.`job_no`, b.customer_nm, b.customer_id ,charge, `mer_bkash`,
b.customer_reg,b.customer_vehicle, a.bill, a.dt, a.charge
FROM `pay` a, customer_info b
WHERE a.customer_id = b.customer_id
AND a.`pay_check`='0' and a.`pay_type` = 'bkash'
order by a.`id` desc;
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="@if($item->bill != 'Advance')report02?bill={{$item->bill}}@endif">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->trix}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->send}}</td>
						<td style="border: 1px solid black;text-align: center;"> 01777781{{$item->mer_bkash}} </td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received+$item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>					
					<form style="display: inline;" action="mfsCheck01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="date" class="form-control" name='approval_dt'>
					<!-- HAPS Code -->
					<input hidden type="text"  name="customer_id" value="{{$item->customer_id}}">
					<input hidden  type="text"   name="job_no" value="{{$item->job_no}}">
					<input hidden  type="text"   name="received" value="{{$item->received}}">
					<input hidden  type="text" id="bank_01" name="bank_01[]" value="">
					<input hidden  type="text" id="bank_02" name="bank_02[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Settlement</button>
					</form>	
<?php } else {?>	
					<form style="display: inline;" action="mfsCheck01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<!-- HAPS Code -->
					<input hidden type="text"  name="customer_id" value="{{$item->customer_id}}">
					<input hidden  type="text"   name="job_no" value="{{$item->job_no}}">
					<input hidden  type="text"   name="received" value="{{$item->received}}">
					<input hidden  type="text" id="bank_01" name="bank_01[]" value="">
					<input hidden  type="text" id="bank_02" name="bank_02[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-secondary px-3" type="submit" name="" value="" disabled>
					 Settlement</button>
					</form>	
<?php } ?>						
					</td>	
						
					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->received;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
<br>				
			
				
				
				
				
				
				
				
             </div>

             <!--end row-->

             <hr>
           <!-- begin invoice-note -->
           <div class="my-3">
            
           </div>
         <!-- end invoice-note -->
            </div>
			
			

          
           </div>


			
			
</main>



		  
@endsection		 





@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>


  
<script>

	
function myFunction1() {
	
	var x = document.getElementById("BankAcc1").value;

	var bk_nm_1 =  document.getElementsByName("bank_01[]");

	for (let index = 0; index < bk_nm_1.length; index++ ){

		bk_nm_1[index].value = x;

	}
}


function myFunction2() {
	
	var x = document.getElementById("BankAcc2").value;

	var bk_nm_2 =  document.getElementsByName("bank_02[]");

	for (let index = 0; index < bk_nm_2.length; index++ ){

		bk_nm_2[index].value = x;

	}
}




</script>

 @endsection