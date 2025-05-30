<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")
	||(session('role')=="Store")||(session('role')=="Administrator"))
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
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Purchase Report without Supplier [From Date: {{date('d-M-Y', strtotime($from_dt))}} to {{date('d-M-Y', strtotime($to_dt))}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Product ID</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Product Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Qty</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Rate</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT b.`prod_id`, b.`prod_name`,sum(b.`qty`) qty, sum(b.`amount`) amount, (sum(b.`amount`)/sum(b.`qty`)) rate
FROM `purchase_mas` a, `purchase_det` b 
WHERE a.`purchase_dt` BETWEEN '$from_dt' AND '$to_dt' 
AND a.purchase_id = b.purchase_id
group by b.`prod_id`, b.`prod_name`
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->prod_id}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->prod_name}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->qty}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format((round($item->rate,2)), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						
					</tr>
		<?php
		$sl = $sl+1;
 		$amount = $amount+$item->amount;
       
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
				
<strong>Total Purchase Amount: Tk. {{number_format(($amount), 2, '.', ',')}}	</strong>
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