<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
<?php
$result = DB::select("
SELECT `supplier_name` FROM `suppliers` WHERE `supplier_id` = '$supplier_id'
");
	
foreach($result as $item)
		{		
		$supplier_name=$item->supplier_name;
		}
?>

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Supplier:  
					  {{$supplier_name}} [From: {{date('d-M-Y', strtotime($dt01))}} To: {{date('d-M-Y', strtotime($dt02))}}]</h5>
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
							<th scope="col" style="text-align: center;border: 1px solid black;">#</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Date</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Ref</th>
							<th scope="col" style="text-align: center;border: 1px solid black;">Total Buy</th>
						</tr>
					</thead>
					<tbody>	
<?php
$result = DB::select("

SELECT  distinct purchase_dt,supplier_ref, a.`supplier_id`, b.supplier_name, sum(a.amount) buypp
FROM `purchase_mas` a, suppliers b
WHERE a.`purchase_dt` between '$dt01' and '$dt02'
and a.`supplier_id` = '$supplier_id'
and a.supplier_id = b.supplier_id 
group BY  purchase_dt,supplier_ref, a.`supplier_id`, b.supplier_name
order by purchase_dt
");
	$sl = '1'; $tbuy = '';
	$buy = '';	
foreach($result as $item)
		{		

		 
?>		
				



				<tr>
						<th scope="row" style="border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{date('d-M-Y', strtotime($item->purchase_dt))}}</td>
						<td style="border: 1px solid black;">{{$item->supplier_ref}}</td>
						<td style="border: 1px solid black;">{{number_format(intval(($item->buypp)), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$buy = ($item->buypp);
		$tbuy = ((int)$buy + (int)$tbuy);
		}  
?>

					</tbody>
				</table>
			<h4><strong>Total	Tk. {{number_format(intval($tbuy), 2, '.', ',')}}</strong></h4>
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