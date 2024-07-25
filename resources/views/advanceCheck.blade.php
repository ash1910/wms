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
                    <li class="breadcrumb-item active" aria-current="page">Advance Money Received </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Advance Money Received Check</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Money RCV</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`id`, a.`pay_type`, a.`trix`, a.`send`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_chas,b.customer_vehicle, a.dt, b.customer_id, a.chequeNo, a.chequeDt
FROM `pay` a, customer_info b
WHERE a.customer_id = b.customer_id
AND a.job_no = 'Advance'
order by a.`id` desc;
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Chas.:</b> {{$item->customer_chas}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}
				
		<?php				
		$pay_type='';$job_no='';
		$stock02 = DB::select("SELECT `job_no` pay_type, `denyImage` 
		FROM `cheque_pending` WHERE `flag`='2' and `customer_id`='$item->customer_id'
		and chequeNo='$item->chequeNo' and chequeDt='$item->chequeDt'");
		foreach($stock02 as $item02)
		{
			$pay_type = $item02->pay_type;
			$denyImage = $item02->denyImage;
			$imageUrl = asset('upload/deny/'.$denyImage); ?>
			<a href="{{ $imageUrl }}" target="_blank">[Deny]</a>
	<?php 
		}
		?>
						
						</td>
						
						<td style="border: 1px solid black;text-align: center;">
							
		<form class="row g-3" action="payAdvance01" method='post' target="_blank">{{ csrf_field() }}
			<div class="col-12">
				<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
				<input type="hidden" name="id" value="{{$item->id}}">
				<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
						<i class="fadeIn animated bx bx-printer"></i> Print</button>
			</div>
		</form>		
		<form class="row g-3" action="payAdvance06?image=1" method='post' target="_blank">{{ csrf_field() }}
			<div class="col-12">
				<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
				<input type="hidden" name="id" value="{{$item->id}}">
				<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
						<i class="fadeIn animated bx bx-printer"></i> M.R-ESL</button>
			</div>
		</form>
		
		<form class="row g-3" action="payAdvance07?image=1" method='post' target="_blank">{{ csrf_field() }}
			<div class="col-12">
				<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
				<input type="hidden" name="id" value="{{$item->id}}">
				<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
						<i class="fadeIn animated bx bx-printer"></i> M.R-HAS</button>
			</div>
		</form>
						</td>							
						
						
						<td style="border: 1px solid black;text-align: center;">
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>					
					<form style="display: inline;" action="payAdvance02" method="post">{{ csrf_field() }}
					<input type="hidden" name="customer_id" value="{{$item->customer_id}}">
					<input type="hidden" name="customer_nm" value="{{$item->customer_nm}}">
					<input type="hidden" name="id" value="{{$item->id}}">
					<button class="btn btn-outline-success px-3" type="submit" name="" value="" 
					<?php if($item->received=='0'){echo 'disabled';} ?>
					>
					 Settlement</button>
					</form>	
<?php } else {?>	
					<form style="display: inline;" action="" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$item->id}}">
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
 @endsection