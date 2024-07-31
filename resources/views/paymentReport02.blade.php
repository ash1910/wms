<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
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
                    <li class="breadcrumb-item active" aria-current="page">Transactions </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Transactions Reports [From Date: {{date('d-M-Y', strtotime($from_dt))}} To: {{date('d-M-Y', strtotime($to_dt))}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ledge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Note</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Entry By</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT b.name, a.payment_type,a.amount,a.note, a.date, c.user_name,a.ledge
FROM `transactions01` a, coa b, user c
WHERE a.`date` BETWEEN '$from_dt' AND '$to_dt'
AND a.`type` = 'C' and a.ledge = '$id'
AND a.ledge=b.id
AND a.user_id = c.user_id;
");
	$sl = '1'; 	$total='0';
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->date}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->name}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_type}}</td>
						<td style="border: 1px solid black;text-align: right;">{{number_format((abs($item->amount)), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->user_name}}</td>

					</tr>
		<?php
		$sl = $sl+1; $total=$item->amount+$total;
		}  
?>





					
						
					</tbody>
				</table>
	
	<strong>Total Amount: Tk.</strong>{{number_format((abs($total)), 2, '.', ',');}}
			
				
			
				
				
				
				
				
				
				
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