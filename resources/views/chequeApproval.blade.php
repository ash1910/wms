
<!-- HAPS Code -->
<?php 

$dt_BankAcc = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE `child_name`='Cash in Hand' or `child_name`='Cash at Bank'");

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
              <div class="breadcrumb-title pe-3">Approval</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Cheque Approval</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <!-- <h5 class="mb-0">Cheque Approval</h5> -->
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
				  <!-- HAPS Code -->
					
						<select  onchange="myFunction()" id="BankAcc1" name="BankAcc1[]" style="width: 100%;" class="form-select" >
							<option >--Select Bank A/C--</option>
							@if(isset( $dt_BankAcc  ))
								@foreach ( $dt_BankAcc as $acc)
								<option  value="{{$acc->acc_name}}">{{$acc->acc_name}}</option>
								@endforeach
							@endif
						</select>
						
						<select  onchange="myFunction2()" id="Adj_01" name="Adj_01[]" style="width: 100%;" class="form-select" >
							<option >--Select Adjust Type--</option>
							<option value="Advance">Adjust with Advance</option>
							<option value="Customer">Adjust with Customer</option>
						</select>
						
				
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Posting Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Money RCV</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Approval</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`id`, a.`bank`, a.`chequeNo`, a.`chequeDt`, a.`received`, a.`due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_vehicle, c.bill_no, d.dt, d.id pay_id,a.customer_id
FROM `cheque_pending` a, customer_info b, bill_mas c, pay d
WHERE a.customer_id = b.customer_id
and b.customer_id= c.customer_id
and c.job_no = a.job_no
AND a.flag='0'
AND d.job_no = a.job_no AND d.bank = a.bank AND a.chequeNo = d.chequeNo;

;
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->bank}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chequeNo}}</td>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chequeDt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						
						
						<td style="border: 1px solid black;text-align: center;">
						
	<form class="row g-3" action="moneyReceipt03" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="job_no" value="{{$item->job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
		</div>
	</form>						
					</td>	
						
						
						
						
						
						<td style="border: 1px solid black;text-align: center;">
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>					
					
					<form style="display: inline;" action="chequeApproval02" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<!-- HAPS Code -->
					<input type="hidden"  id="bank_01" name="bank_01[]" value="">
					<input type="hidden"  id="adj1" name="adj1[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Cash Cheque</button>
					</form>	
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<!-- HAPS Code -->
					<input type="hidden"  id="bank_02" name="bank_02[]" value="">
					<input type="hidden"  id="adj1" name="adj1[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 A/C Payee</button>
					</form>	
					<form style="display: inline;" action="chequeApproval03" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-danger px-3" type="submit" name="" value="">
					 Deny</button>
					</form>	
<?php } else {?>						
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-outline-secondary px-3" type="submit" name="" value="" disabled>
					 Approval</button>
					</form>	
<?php } ?>						
					
					</td>	
						
					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->received;
		}  



		
		
$result = DB::select("
SELECT a.`id`, a.`bank`, a.`chequeNo`, a.`chequeDt`, a.`received`, a.`due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_vehicle,a.customer_id, d.dt, d.id pay_id
FROM `cheque_pending` a, customer_info b, pay d
WHERE a.customer_id = b.customer_id
and a.job_no = 'Advance'
AND a.flag='0'
AND d.job_no = a.job_no AND d.bank = a.bank AND a.chequeNo = d.chequeNo;
");
			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->bank}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chequeNo}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chequeDt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						
						
						<td style="border: 1px solid black;text-align: center;">
						
	<form class="row g-3" action="payAdvance" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
		</div>
	</form>						
					</td>	
						
						
						
						
						
						<td style="border: 1px solid black;text-align: center;">
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>					
					
					<form style="display: inline;" action="chequeApproval02" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<!-- HAPS Code -->
					<input type="hidden"  id="bank_03" name="bank_03[]" value="">
					<input type="hidden"  id="adj1" name="adj1[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Cash Cheque</button>
					</form>	
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<!-- HAPS Code -->
					<input type="hidden"  id="bank_04" name="bank_04[]" value="">
					<input type="hidden"  id="adj1" name="adj1[]" value="">
					<!-- End Code -->
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 A/C Payee</button>
					</form>	
					<form style="display: inline;" action="chequeApproval03" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-danger px-3" type="submit" name="" value="">
					 Deny</button>
					</form>

<?php } else {?>						
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-outline-secondary px-3" type="submit" name="" value="" disabled>
					 Approval</button>
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

function myFunction() {
	
	var x = document.getElementById("BankAcc1").value;
	//document.getElementById("bank_01").value = x;

	var bk_nm_1 =  document.getElementsByName("bank_01[]");

	for (let index = 0; index < bk_nm_1.length; index++ ){

		bk_nm_1[index].value = x;

	}


	var bk_nm_2 =  document.getElementsByName("bank_02[]");

	for (let index = 0; index < bk_nm_2.length; index++ ){

		bk_nm_2[index].value = x;

	}

	
	var bk_nm_3 =  document.getElementsByName("bank_03[]");

	for (let index = 0; index < bk_nm_3.length; index++ ){

		bk_nm_3[index].value = x;

	}

	
	var bk_nm_4 =  document.getElementsByName("bank_04[]");

	for (let index = 0; index < bk_nm_4.length; index++ ){

		bk_nm_4[index].value = x;

	}


}


function myFunction2() {
	
	var x = document.getElementById("Adj_01").value;
	//document.getElementById("bank_01").value = x;

	var ck_nm_1 =  document.getElementsByName("adj1[]");

	for (let index = 0; index < ck_nm_1.length; index++ ){

		ck_nm_1[index].value = x;

	}



}



</script>


 @endsection