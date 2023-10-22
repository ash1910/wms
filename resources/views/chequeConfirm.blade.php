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

<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message----> 
@if(session()->has('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
              <div class="breadcrumb-title pe-3">Confirm</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Cheque Confirm</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Cheque Confirm</h5>
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
AND a.confirm='0'
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
					
	
					<form style="display: inline;" action="chequeConfirm01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Confirm</button>
					</form>	
					<form style="display: inline;" action="chequeConfirm02" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-danger px-3" type="submit" name="" value="">
					 Dishonor</button>
					</form>	
<?php } else {?>						
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-outline-secondary px-3" type="submit" name="" value="" disabled>
					 Confirm</button>
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
AND a.confirm='0'
AND d.job_no = a.job_no AND d.bank = a.bank AND a.chequeNo = d.chequeNo;
");

// replaced AND a.flag='0' by AND a.confirm='0' 
			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name2:</b> {{$item->customer_vehicle}}
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
					
	
					<form style="display: inline;" action="chequeConfirm01" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Confirm</button>
					</form>	
					<form style="display: inline;" action="chequeConfirm02" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-danger px-3" type="submit" name="" value="">
					 Dishonor</button>
					</form>	
<?php } else {?>						
					<form style="display: inline;" action="chequeApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="job_no" value="{{$item->job_no}}">
					<input type="hidden" name="chequeNo" value="{{$item->chequeNo}}">
					<input type="hidden" name="received" value="{{$item->received}}">
					<input type="hidden" name="due" value="{{$item->due}}">
					<button class="btn btn-outline-secondary px-3" type="submit" name="" value="" disabled>
					 Confirm</button>
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
 @endsection