  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
                    <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Inventory Report </h5>
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
							<th scope="col">#</th>
							<th scope="col">Code</th>
							<th scope="col">Product</th>
							<th scope="col">Quantity</th>
							<th scope="col">Avg Rate</th>
							<th scope="col">Amount</th>
						</tr>
					</thead>
					<tbody>
<?php
/*
$stock01 = DB::select('
SELECT a.prod_id, a.prod_name, a.purchase_qty - IFNULL(b.issue_qty, 0) stock
FROM
(
SELECT DISTINCT prod_id, prod_name, SUM(`qty`) purchase_qty  FROM `purchase_det`
GROUP by  prod_id,prod_name
) a LEFT JOIN
(
SELECT DISTINCT `prod_id` prod_id, sum(`qty`) issue_qty FROM `issue` GROUP by prod_id
)b
on
a.prod_id = b.prod_id;
');
*/

$stock01 = DB::select('
SELECT `parts_id`, `parts_name`, `avg_price`, `stock_qty`, `amount` FROM `bom_prod`;	
');
	$sl = '1'; 	$total02 = '0';	
	foreach($stock01 as $item)
		{ 				
?>					<tr>
						<th scope="row">{{$sl}}</th>
						<td><a href="productLedger02?id={{$item->parts_id}} - {{$item->parts_name}}">{{$item->parts_id}}</a></td>
						<td>{{$item->parts_name}}</td>
						<td>{{$item->stock_qty}}</td>
						<td>{{$item->avg_price}}</td>
						<td>{{$item->amount}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->amount;
		$total02 = $total01+$total02;

		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>

<br>				
<strong>Total Stock Amount: Tk. {{number_format($total02, 2, '.', ',')}}	</strong>
				
			
				
				
				
				
				
				
				
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