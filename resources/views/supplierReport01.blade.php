
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
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Supplier Report [From: {{date('d-M-Y', strtotime($dt01))}} To: {{date('d-M-Y', strtotime($dt02))}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0" style="width: 50%;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount(summary)</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount(details)</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT  sum(a.`amount`) buytp, a.`supplier_id`, b.supplier_name
FROM `purchase_mas` a, suppliers b 
WHERE a.`purchase_dt` between '$dt01' and '$dt02'
and a.supplier_id = b.supplier_id 
group by a.`supplier_id`, b.supplier_name
order by b.supplier_name
;
");
	$sl = '1'; 			
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{$item->supplier_name}}</td>
						<td style="border: 1px solid black;text-align: right;">
						<a href="/supplierReport03?supplier_id={{$item->supplier_id}}&&dt01={{$dt01}}&&dt02={{$dt02}}">
						{{number_format(($item->buytp), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;">
						<a href="/supplierReport02?supplier_id={{$item->supplier_id}}&&dt01={{$dt01}}&&dt02={{$dt02}}">
						{{number_format(($item->buytp), 2, '.', ',')}}</a></td>
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