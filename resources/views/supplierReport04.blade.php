
@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Reports</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Date Wise Supplier</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->


	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Supplier:  
					  Partial Payment [From: {{date('d-M-Y', strtotime($dt01))}} To: {{date('d-M-Y', strtotime($dt02))}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
			  
				<table id="example2" class="table table-bordered mb-0" style="width: 70%;">
					<thead>
						<tr>
							<th scope="col" style="text-align: center;border: 1px solid black;">#</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Date</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Ref</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Total Buy</th>
              <th scope="col" style="text-align: center;border: 1px solid black;">Payment Status</th>
						</tr>
					</thead>
					<tbody>	
<?php

$result = DB::select("
SELECT  distinct purchase_dt,supplier_ref, a.`supplier_id`, b.supplier_name, sum(a.amount) buypp, Min(a.paid) paid 
FROM `purchase_mas` a, suppliers b
WHERE a.`purchase_dt` between '$dt01' and '$dt02'
and a.`paid` = '$paid' 
and a.supplier_id = b.supplier_id 
group BY purchase_dt,supplier_ref, a.`supplier_id`, b.supplier_name
order by purchase_dt
");
	$sl = '1'; $tbuy = ''; $t_paid = ''; $t_partial = ''; $t_due = '';
	$buy = '';	$payment_status = "Due";
foreach($result as $item)
		{		
      $buy = ($item->buypp);
      $tbuy = ((float)$buy + (float)$tbuy);

     if( $item->paid == '1' ){
      $payment_status = "Paid";
      $t_paid = ((float)$buy + (float)$t_paid);
     }
     elseif( $item->paid == '2' ){
      $payment_status = "Partial";
      $t_partial = ((float)$buy + (float)$t_partial);
     }
     else{
      $payment_status = "Due";
      $t_due = ((float)$buy + (float)$t_due);
     }
?>		
				<tr>
						<th scope="row" style="border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{date('d-M-Y', strtotime($item->purchase_dt))}}</td>
						<td style="border: 1px solid black;">{{$item->supplier_ref}}</td>
						<td style="border: 1px solid black;">{{number_format(floatval(($item->buypp)), 2, '.', ',')}}</td>
            <td style="border: 1px solid black; text-align: center;">{{$payment_status}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		}  
?>

					</tbody>
				</table>
      <br><br><br>
			<p><strong>Total Purchase Amount Tk. {{number_format(floatval($tbuy), 2, '.', ',')}}</strong></p>
      <p><strong>Total Payment Amount Tk. {{number_format(floatval($t_paid), 2, '.', ',')}}</strong></p>
      <p><strong>Total Partial Amount Tk. {{number_format(floatval($t_partial), 2, '.', ',')}}</strong></p>
      <p><strong>Total Due Amount Tk. {{number_format(floatval($t_due), 2, '.', ',')}}</strong></p>
	<br>			
				
			
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