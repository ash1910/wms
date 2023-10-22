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
                    <li class="breadcrumb-item active" aria-current="page">Main Bill</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Sales Segment: {{$segment}} [From Date: {{date('d-M-Y',strtotime($from_dt))}} To: {{date('d-M-Y',strtotime($to_dt))}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example3" class="table table-bordered mb-0"style="width: 700px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Service</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Parts</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sale Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php

if($segment=='Engineering'){$segment='engineering';}
if($segment=='Inter-Company'){$segment='intercompany';}
if($segment=='Automobiles'){$segment='automobile';}

$result = DB::select("
SELECT 
bill_dt,
(`service`) service, (`parts`) parts, (`net_bill`) sale_amount,(`job_no`) job_no, bill_no
FROM `bill_mas` 
WHERE `bill_dt` BETWEEN '$from_dt' and '$to_dt'
and work='$segment'

");
	$sl = '1';$service = '0';$parts = '0';$sale_amount = '0';		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y',strtotime($item->bill_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->service), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->parts), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->sale_amount), 2, '.', ',');}}</td>
					</tr>
		<?php
		
		$sl = $sl+1;
		$service = $item->service+$service;
		$parts = $item->parts+$parts;
		$sale_amount = $item->sale_amount+$sale_amount;
		}  
?>
					</tbody>
				</table>
				
				
<strong>Total service: {{number_format(($service), 2, '.', ',')}}<br></strong>				
<strong>Total parts: {{number_format(($parts), 2, '.', ',')}}<br></strong>				
<strong>Total Sale Amount: {{number_format(($sale_amount), 2, '.', ',')}}<br></strong>				
				
			
<br><br><br>				
				
				
				
				
				
				
				
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