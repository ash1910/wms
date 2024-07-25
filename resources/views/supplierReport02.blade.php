
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
                      <h5 class="mb-0">Supplier Report [From: {{$dt01}} To: {{$dt02}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
<?php
$result = DB::select("
SELECT  distinct purchase_dt,supplier_ref, a.`supplier_id`, b.supplier_name, purchase_id
FROM `purchase_mas` a, suppliers b 
WHERE a.`purchase_dt` between '$dt01' and '$dt02'
and a.`supplier_id` = '$supplier_id'
and a.supplier_id = b.supplier_id
order by purchase_dt
");
$t_amount = '0';
foreach($result as $item)
		{		
		 $supplier_name = $item->supplier_name;
		 $dt =  $item->purchase_dt;
		 $dt1 = strtotime($dt);
		 $dt2 =date('d-M-Y', $dt1);
		 $ref =  $item->supplier_ref;
		 $purchase_id =  $item->purchase_id;
		 
?><h5>{{$supplier_name}}</h5>
Date: {{$dt2}}, &nbsp;&nbsp;&nbsp;&nbsp;
Ref: {{$ref}}, &nbsp;&nbsp;&nbsp;&nbsp;
Purchase Entry No: PCH-{{$purchase_id}}		
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th style="text-align: center;background-color: darkgray;" scope="col">#</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Code</th>
							<th style="text-align: center;width: 350px;background-color: darkgray;" scope="col">Product</th>
							<th style="text-align: center;background-color: darkgray;" style="text-align: center;" scope="col">GRN</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Job No.</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Req. No.</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Qty</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Buy (Per Unit)</th>
							<th style="text-align: center;background-color: darkgray;" scope="col">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$stock = DB::table('purchase_det')->where('purchase_id', $purchase_id)->get(); 
	$sl = '1';$amount='0';
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th style="text-align: center;" scope="row">{{$sl}}</th>
						<td style="text-align: center;">{{$item->prod_id}}</td>
						<td style="text-align: left;">{{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->grn}}</td>
						<td style="text-align: center;">{{$item->job_no}}</td>
						<td style="text-align: center;">{{$item->req}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: center;">{{$item->rate}}</td>
						<td style="text-align: right;">{{number_format(intval($item->amount), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$amount = $amount+$item->amount;
		}  
?>
	
						
						<tr><td style="background-color: darkgray;"></td>
							<td  style="background-color: darkgray;"colspan="7"><strong>Total Purchase from {{$supplier_name}}	</strong></td>
							<td style="text-align: right;background-color: darkgray;"><strong>{{number_format(intval($amount), 2, '.', ',')}}</strong></td>
						</tr>
					</tbody>
				</table>
	<br>			
<?php 
		$t_amount = $amount+$t_amount;
	} 
		
?>				

<center>				
	<h3>Total Purchase Amount: Tk.	{{number_format(intval($t_amount), 2, '.', ',')}}</h3>
</center>			
				
				
				
				
				
				
				
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