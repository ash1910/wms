
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

$result = DB::select("
SELECT `date`,`pch`,`particulars`, `debit`,`credit`, @Balance := @Balance + `t`.`credit` - `t`.`debit` AS `balance`
FROM
(
SELECT  p.purchase_dt AS`date`, p.purchase_id AS `pch`, CONCAT(CONCAT('PCH-', p.purchase_id),CONCAT(', Bill-', p.`supplier_ref`)) AS `particulars`, p.`amount` AS `credit`, '0.00' AS `debit`
FROM `purchase_mas` p
WHERE supplier_id='$supplier_id'
UNION
SELECT s.created_date AS`date`, 0 AS `pch`, 
CASE 
WHEN `mode_of_payment`='Cash' THEN CONCAT(CONCAT('Payment through Cash (', s.`bill_numbers`),')') 
WHEN `mode_of_payment`='Cheque' THEN CONCAT(CONCAT(CONCAT('Payment through Bank (', s.`bill_numbers`),')'),'-',s.`bank_name`,'-',s.`cheque_number`,'-',s.`cheque_date`) 
WHEN `mode_of_payment`='Service' THEN CONCAT(CONCAT('Adjustment With Job No. ',s.`note`,' (Ref Voucher:	', s.`bill_numbers`),')') 
ELSE 'Discount'
END AS `particulars`, '0.00' AS `credit`, s.`paid_amount` AS `debit` 
FROM `suppliers_payment` s WHERE supplier_id='$supplier_id'
UNION
SELECT s.created_date AS`date`, 0 AS `pch`, 
'Discount' AS `particulars`, '0.00' AS `credit`, IFNULL(s.`discount`,0) AS `debit` 
FROM `suppliers_payment` s WHERE supplier_id='$supplier_id'
) t, (SELECT @Balance := 0) AS variableInit
ORDER BY `date`;
;
");
	$sl = '1'; 	$total02 = '0';	$total04 = '0';		
foreach($result as $item)
		{		$total01 = '0';$total03 = '0';
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->date))}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="purchase02?id={{$item->pch}}">{{$item->particulars}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->debit), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->credit), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->balance), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->debit;
		$total02 = $total01+$total02;
		$total03 = $item->credit;
		$total04 = $total03+$total04;
		}  
?>
						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->
						
					</tbody>
				</table>
				
<strong>Total Debit Amount: Tk. {{number_format(($total02), 2, '.', ',')}}	</strong><br>
<strong>Total Credit Amount: Tk. {{number_format(($total04), 2, '.', ',')}}	</strong><br>
<strong>Current Balance Amount: Tk. {{number_format(($total04-$total02), 2, '.', ',')}}	</strong>
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