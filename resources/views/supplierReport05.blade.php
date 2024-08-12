
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
                    <li class="breadcrumb-item active" aria-current="page"> Supplier Payable Report</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Supplier Payable Report </h5>
                    </div>
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0" style="width: 50%;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
              <th scope="col" style="border: 1px solid black;text-align: center;">Code</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Debit</th>
              <th scope="col" style="border: 1px solid black;text-align: center;">Credit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payable Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php

$suppliers_list = []; $supplier_payments_list = []; $supplier_purchases_list = []; $supplier_final_list = [];

$suppliers = DB::select("SELECT supplier_id, supplier_name FROM suppliers;");

$supplier_payments = DB::select("SELECT SUM(paid_amount+discount) AS debit, supplier_id FROM `suppliers_payment` GROUP BY supplier_id;");

$supplier_purchases = DB::select("SELECT SUM(amount) AS credit, supplier_id FROM `purchase_mas` GROUP BY supplier_id;");

foreach($supplier_payments as $supplier_payment){	$supplier_payments_list[$supplier_payment->supplier_id] = $supplier_payment->debit; }

foreach($supplier_purchases as $supplier_purchase){	$supplier_purchases_list[$supplier_purchase->supplier_id] = $supplier_purchase->credit; }

foreach($suppliers as $supplier){	
  $debit = !empty($supplier_payments_list[$supplier->supplier_id]) ? $supplier_payments_list[$supplier->supplier_id] : 0;
  $credit = !empty($supplier_purchases_list[$supplier->supplier_id]) ? $supplier_purchases_list[$supplier->supplier_id] : 0;
  $suppliers_list[] = array(
    'supplier_id' => $supplier->supplier_id,
    'supplier_name' => $supplier->supplier_name,
    'debit' => $debit,
    'credit' => $credit,
    'balance' => $credit - $debit
  );
}

//echo "<pre>";print_r($suppliers_list);exit;

$sl = '1'; $total = 0;
foreach($suppliers_list as $item)
		{		
      if($item['balance'] <= 0) continue;
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
            <td style="border: 1px solid black;">{{$item['supplier_id']}}</td>
            <td style="border: 1px solid black;">{{$item['supplier_name']}}</td>
            <td style="border: 1px solid black;">{{number_format(($item['debit']), 2, '.', ',')}}</td>
            <td style="border: 1px solid black;">{{number_format(($item['credit']), 2, '.', ',')}}</td>
            <td style="border: 1px solid black;">{{number_format(($item['balance']), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
    $total += $item['balance'];
		}  
?>
						<tr>
							<td colspan="5" style="border: 1px solid black;text-align: center;"><strong>Total Payable to Spare Parts Suppliers</strong></td>
              <td style="border: 1px solid black;">{{number_format(($total), 2, '.', ',')}}</td>
						</tr>
					</tbody>
				</table>	
		
				
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