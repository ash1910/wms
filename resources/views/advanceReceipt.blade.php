<!-- HAPS Code -->
<?php 

$dt_CashBankAcc = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE (`type_id`='6' or `type_id`='7') and `grp_status`<>'GR';");


?>
<!-- End Code -->


@extends("layouts.master")

@section("content")

<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Accounts"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
session('role');
}
else {
?>
  <script>
    window.location = "/home";
  </script>
<?php  
}
?>



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
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Receive </li>
                    <li class="breadcrumb-item active" aria-current="page">Advance Money Receipt </li>
                  </ol>
                </nav>
              </div>
              
            </div>

            <!--end breadcrumb-->

			<!-- HAPS Code -->
			<div class="d-flex align-items-center mb-3" style="width: 100%;">
              
                <div style="width: 100%;">
                  <select onchange="myFunction1()" id="CashankAcc" name="CashankAcc" style="width: 100%;"  class="form-select form-select-sm">
				  <option >--Select Bank A/C--</option>
                  @if(isset( $dt_CashBankAcc  ))
                    @foreach ( $dt_CashBankAcc as $item)
                    <option  value="{{$item->acc_name}}">{{$item->acc_name}}</option>
                    @endforeach
                  @endif
                </select>
                </div>
              </div>
			<!-- End -->
	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Advance Money Receipt</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0">
					<thead>
						<tr>
						
						 
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer ID</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Money receipt</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Refund</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`id`, a.`dt`, a.`job_no`, a.`customer_id`, a.`received`, a.`pay_type`, a.`charge`, a.`ref`,
b.customer_nm , b.customer_reg,b.customer_vehicle
FROM `pay` a, customer_info b 
WHERE `bill` ='Advance' and a.customer_id = b.customer_id; 
;
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
<td style="border: 1px solid black;text-align: center;">{{$item->customer_id}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>

						<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$item->job_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->id}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
					
						<td style="border: 1px solid black;text-align: center;">
<?php if ((session('role')=="Super Administrator")||(session('role')=="Accounts")) { ?>					
					<form style="display: inline;" action="refund" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<!-- HAPS Code -->
					<input hidden type="text" id="bank_01" name="bank_01[]" value="">
					<!-- End Code -->
					<button class="btn btn-danger px-3" type="submit" name="" value="">
					 Refund</button>
					</form>	
<?php } else {?>	
					<form style="display: inline;" action="" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<!-- HAPS Code -->
					<input hidden type="text" id="bank_01" name="bank_01[]" value="">
					<!-- End Code -->
					<button class="btn btn-secondary px-3" type="submit" name="" value="" disabled>
					 Refund</button>
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
	
	var x = document.getElementById("CashankAcc").value;

	var bk_nm_1 =  document.getElementsByName("bank_01[]");

	for (let index = 0; index < bk_nm_1.length; index++ ){

		bk_nm_1[index].value = x;

	}
	}

  </script>
 @endsection