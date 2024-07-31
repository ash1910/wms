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
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
@endif	
 

 <!--breadcrumb-->
             <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">AIT </li>
                    <li class="breadcrumb-item active" aria-current="page">AIT Collection</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">AIT Collection List</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Posting date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">TR Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">AIT</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`dt`,a.`customer_id`,a.`job_no`,a.`ait`,a.`tr_no`, a.`tr_dt`, a.`bin`,
b.customer_nm,b.customer_reg, b.customer_chas,b.customer_vehicle,
c.bill_dt, c.parts, c.service,c.net_bill,c.total, c.bill_no
FROM `ait`a, customer_info b, bill_mas c 
WHERE a.`flag`='1'
and a.`customer_id` = b.customer_id
and a.`job_no` = c.job_no
AND b.customer_id = c.customer_id;
");
	$sl = '1';$amount='0'; 			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
	
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;">
						<b>Parts :</b> Tk. {{number_format(($item->parts), 2, '.', ',');}}
						<br><b>Service:</b> Tk. {{number_format(($item->service), 2, '.', ',');}}
						<br><b>Total:</b> Tk. {{number_format(($item->net_bill), 2, '.', ',');}}
						</td>
						<td style="border: 1px solid black;text-align: left;">
						<b>TR No :</b> {{$item->tr_no}}
						<br><b>TR Date:</b> {{$item->tr_dt}}
						<br><b>Bin:</b> {{$item->bin}}
						</td>
						<td style="border: 1px solid black;text-align: center;">Tk. {{number_format(($item->ait), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">Tk. {{number_format(($item->total), 2, '.', ',');}}</td>
											
						
						
					</tr>
		<?php
		$sl = $sl+1;
		$amount=$amount+$item->ait;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total AIT Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
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