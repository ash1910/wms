
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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Suppliers Ledger</li>
                  </ol>
                </nav>
              </div>

            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Suppliers [{{$supplier}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Particulars</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Debit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Credit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance</th>
						</tr>
					</thead>
					<tbody>
<?php

$supp_list = []; $balance = 0;
$supplier_payments = DB::select("SELECT (IFNULL(paid_amount, 0)+IFNULL(discount, 0)) AS debit, CONCAT(note, '(', bill_numbers, ')') AS detail, created_date AS date FROM `suppliers_payment` WHERE supplier_id =  $supplier_id;");

$supplier_purchases = DB::select("SELECT amount AS credit, supplier_ref AS detail, purchase_dt AS date FROM `purchase_mas` WHERE supplier_id =  $supplier_id;");

$supplier_leadgers = array_merge($supplier_purchases,$supplier_payments);
usort($supplier_leadgers, fn($a, $b) => $a->date <=> $b->date);

foreach($supplier_leadgers as $item){
  $debit = !empty($item->debit) ? $item->debit : 0;
  $credit = !empty($item->credit) ? $item->credit : 0;
  $balance += $credit - $debit;

  $supp_list[] = array(
    'date' => $item->date,
    'detail' => $item->detail,
    'debit' => $debit,
    'credit' => $credit,
    'balance' => $balance
  );
}

//echo "<pre>";print_r($supplier_payments);echo "<pre>";print_r($supplier_purchases);echo "<pre>";print_r((array)$supp_list);exit;

	$sl = '1'; 	$totaDebit = 0;	$totaCredit = 0;
foreach($supp_list as $item)
		{
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item['date']))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item['detail']}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item['debit']), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item['credit']), 2, '.', ',')}}</td>
            <td style="border: 1px solid black;text-align: center;">{{number_format(($item['balance']), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$totaDebit += $item['debit'];
    $totaCredit += $item['credit'];
		}
?>

					</tbody>
				</table>

<strong>Total Debit Amount: Tk. {{number_format(($totaDebit), 2, '.', ',')}}	</strong><br>
<strong>Total Credit Amount: Tk. {{number_format(($totaCredit), 2, '.', ',')}}	</strong><br>
<strong>Current Balance Amount: Tk. {{number_format((-$totaDebit+$totaCredit), 2, '.', ',')}}	</strong>
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
