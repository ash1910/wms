<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")

<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Accounts")||(session('role')=="PRO"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
echo session('role');
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
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
@endif	
 

 <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Approval</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Estimate</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Estimate Approval</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Estimate Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Estimate No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Approval</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT `est_no`, a.customer_id, b.customer_nm, b.customer_mobile, b.customer_reg, b.customer_chas,
`est_no`, `user_id`, `total` total ,bill_dt, est_dt, b.customer_vehicle
FROM `est_mas` a, customer_info b
WHERE a.customer_id = b.customer_id
and a.flag = '0'
order by est_dt desc
;
");
	$sl = '1'; 			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="billMemoEst?est_no={{$item->est_no}}">{{date('d-M-Y', strtotime($item->est_dt))}}</a></td>
						<td style="border: 1px solid black;text-align: center;"><a href="billMemoEst?est_no={{$item->est_no}}">{{$item->est_no}}</a></td>
						
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Chasis.:</b> {{$item->customer_chas}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>

						
						<td style="border: 1px solid black;text-align: center;"><a href="billMemoEst?est_no={{$item->est_no}}">{{number_format(intval($item->total), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">
						
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="PRO"))
{
?>					
					<form style="display: inline;" action="approval01Est" method="post">{{ csrf_field() }}
						<input type="hidden" name="est_no" value="{{$item->est_no}}">
						<input type="hidden" name="est_dt" value="{{$item->est_dt}}">
						
            <table style="display: inline;">
              <tr><td>
                <b>Job No:</b> <input type="text" name="job_no" maxlength="7" minlength="7" required style="width: 80px;">
              </td></tr>
              
              <tr>
                <td>
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="engineering">
                    <label class="form-check-label" for="flexRadioDefault1">Engineering&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="intercompany">
                    <label class="form-check-label" for="flexRadioDefault1">Intercompany</label>
                  </div>
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="automobile">
                    <label class="form-check-label" for="flexRadioDefault1">Automobile</label>
                  </div>
                </td>
              </tr>

                  <tr><td>
                    
                  </td></tr>
              </table>
              <button class="btn btn-outline-success px-3" type="submit" name="" value="">
						Approval to<br> Draft Bill</button>
						
					</form>						
<?php } else {?>						
					
<?php } ?>			
					</td>
					</tr>
		<?php
		$sl = $sl+1;

		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
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