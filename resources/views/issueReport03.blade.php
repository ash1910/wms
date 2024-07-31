
@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Issue </li>
                    <li class="breadcrumb-item active" aria-current="page">Without Date </li>
                    <li class="breadcrumb-item active" aria-current="page">
					<form  target="_blank" style="display: inline;" action="printIssue" method="post">{{ csrf_field() }}
					<input type="hidden" name="from_dt" value="{{$from_dt}}">
					<input type="hidden" name="to_dt" value="{{$to_dt}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form></li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
		<div class="card-header py-3">
			  <div class="row align-items-center g-3">
				<div class="col-12 col-lg-12">
				
				  <h5 class="mb-0">Issue Report Without Date [From Date: {{date('d-M-Y', strtotime($from_dt))}} to {{date('d-M-Y', strtotime($to_dt))}}]</h5>
				
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
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">#</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Code</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Product</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Qty</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Buy (Per Unit)</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
<!-------------> 
<?php               
		
			
$inHistory01 = DB::select("
SELECT `prod_id`,`prod_name`,sum(`qty`) qty, (sum(`amount`)/sum(`qty`)) avg_price ,sum(`amount`) amount
FROM `issue` WHERE `dt` BETWEEN '$from_dt' AND '$to_dt'
group by `prod_id`,`prod_name`
");			
			
			
			
$sl = '1';$amount='0';
foreach($inHistory01 as $item)
		{	
?>					
			<tr>
				<th style="text-align: center;border: 1px solid black;" scope="row">{{$sl}}</th>
				<td style="text-align: center;border: 1px solid black;">{{$item->prod_id}}</td>
				<td style="text-align: left;border: 1px solid black;">{{$item->prod_name}}</td>
				<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
				<td style="text-align: right;border: 1px solid black;">{{number_format(($item->avg_price), 2, '.', ',')}}</td>
				<td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
			</tr>
<?php
			$sl = $sl+1;
			$amount = $amount+$item->amount;
		}  
?>
					

				</tbody>
			</table>
				
<strong>Total Issue Amount:	TK. {{number_format(intval($amount), 2, '.', ',')}}</strong>			
				
			</div>
		</div>
	</div>


			
			
</main>



		  
@endsection		 






@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection