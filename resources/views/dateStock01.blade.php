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
                    <li class="breadcrumb-item active" aria-current="page">Stock</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Stock Report {{$dt}}</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				
		
	
				<table id="example2" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th scope="col" rowspan="2">#</th>
							<th scope="col" rowspan="2">Code</th>
							<th scope="col" rowspan="2">Product</th>
							<th scope="col" >Opening</th>
							<th scope="col" >Opening</th>
							<th scope="col" >Opening</th>
							<th scope="col" >Purchase</th>
							<th scope="col" >Purchase</th>
							<th scope="col" >Purchase</th>
						</tr>
						<tr>
						<th scope="col">Qty</th>
						<th scope="col">Avg. Rate</th>
						<th scope="col">Amount</th>
						<th scope="col">Qty</th>
						<th scope="col">Avg. Rate</th>
						<th scope="col">Amount</th>
						</tr>
					</thead>
					<tbody>
<?php


$stock01 = DB::select('SELECT `parts_id`, `parts_name`FROM parts_info');
	
	$sl = '1'; 
	foreach($stock01 as $item)
		{ 	
$parts_id = $item->parts_id;
$parts_name = $item->parts_name;
		$o_avg='0';
		$o_qty='0';
		$o_amount='0';
		$p_qty='0';
		$p_avg='0';
		$p_amount='0';
		$stock02 = DB::select("SELECT `avg_price` o_avg, `stock_qty` o_qty, `type`, `dt` FROM `dayend_inv` 
		WHERE `parts_id` = '$parts_id' and `dt` ='$dt'");
		foreach($stock02 as $item02)
				{ 
				$o_avg = $item02->o_avg;
				$o_qty = $item02->o_qty;
				$o_amount = 	(int)$o_avg*(int)$o_qty;
				}
		$stock03 = DB::select("SELECT sum(`qty`) qty, (sum(`buytp`)/sum(`qty`)) rate FROM `stock` 
WHERE `prod_id` = '$parts_id' AND flag = 'IN' AND `dt` between '$dt' and '2022-12-31'");
		foreach($stock03 as $item03)
				{ 
				$p_qty = $item03->qty;
				$p_avg = $item03->rate;
				$p_amount = (int)$p_avg*(int)$p_qty;
				}

		
?>				<tr>
					<th scope="row">{{$sl}}</th>
					<td>{{$parts_id}}</td>
					<td>{{$parts_name}}</td>
					<td>{{$o_qty}}</td>
					<td>{{$o_avg}}</td>
					<td>{{$o_amount}}</td>
					<td>{{$p_qty}}</td>
					<td>{{$p_avg}}</td>
					<td>{{$p_amount}}</td>
				</tr>
		<?php
		$sl = $sl+1;
		//$buy = (int)($item->avg_price)*(int)($item->stock_qty);
		//$tbuy = ((int)$buy + (int)$tbuy);
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
					<tfoot>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Code</th>
							<th scope="col">Product</th>
							<th scope="col">Quantity</th>
							<th scope="col">Buy (AVG)</th>
							<th scope="col">Total Buy</th>
						</tr>
					</tfoot>
				</table>
<strong>Total Stock Value </strong><strong>Tk. {{}}</strong>				

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