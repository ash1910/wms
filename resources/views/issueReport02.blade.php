
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
                    <li class="breadcrumb-item active" aria-current="page">With Date </li>
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
				
				  <h5 class="mb-0">Issue Report With Date [From Date: {{date('d-M-Y', strtotime($from_dt))}} to {{date('d-M-Y', strtotime($to_dt))}}]</h5>
				
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
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Date</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Code</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Product</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" style="text-align: center;" scope="col">GIN</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" style="text-align: center;" scope="col">RTN</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Job No.</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Req. No.</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Qty</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">R Qty</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Buy (Per Unit)</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Total</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Note</th>
					</tr>
				</thead>
				<tbody>
<!-------------> 
<?php               
		$inHistory01 = DB::table('issue')
			->whereBetween('dt', [$from_dt, $to_dt])
			->orderBy('dt', 'asc')->orderBy('prod_name', 'asc')
			->get(['prod_id','prod_name','gin','qty','req','avg_price','amount','job_no','note','dt']);
$sl = '1';$amount='0';
foreach($inHistory01 as $item)
		{	
?>					
			<tr>
				<th style="text-align: center;border: 1px solid black;" scope="row">{{$sl}}</th>
				<td style="text-align: center;border: 1px solid black;">{{$item->dt}}</td>
				<td style="text-align: center;border: 1px solid black;">{{$item->prod_id}}</td>
				<td style="text-align: left;width: 300px;border: 1px solid black;">{{$item->prod_name}}</td>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;">{{$item->gin}}</td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;"></td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;">{{$item->gin}}</td>
<?php } ?>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;"></td>
<?php } ?>
				<td style="text-align: center;border: 1px solid black;">{{$item->job_no}}</td>
				<td style="text-align: center;border: 1px solid black;">{{$item->req}}</td>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;"></td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;">{{-$item->qty}}</td>
<?php } ?>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;"></td>
<?php } ?>
				<td style="text-align: center;border: 1px solid black;">{{$item->avg_price}}</td>
				<td style="text-align: right;border: 1px solid black;">{{$item->amount}}</td>
				<td style="text-align: right;border: 1px solid black;width: 150px;">{{$item->note}}</td>
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