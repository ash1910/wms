<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
//echo session('role');
}
else {
?>
  <script>
    window.location = "/logout";
  </script>
<?php  
}
?>

<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message----> 
@if(session()->has('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
	
<script type="text/javascript">
$(document).ready(function () {
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
 });
</script>	
@endif	
<!---Alert message---->  

 <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Payments </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Payments Report [From Date: {{date('d-M-Y', strtotime($from_dt))}} To: {{date('d-M-Y', strtotime($to_dt))}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Method of Payment</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bank Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque Number</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Credit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Paid</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Remaining</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Note</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT
DATE_FORMAT(p.created_date, '%d-%m-%Y') as `Payment_Date`,
p.supplier_id as `supplier_id`,
s.supplier_name as `Suppler_Name`,
p.bill_numbers as `Suppliers_Ref`,
p.mode_of_payment as `Method`,
p.bank_name as `Bank_Name`,	
p.cheque_number as `Cheque_Number`,	
p.cheque_date as `Cheque_Date`,	
p.due as`Credit`,	
p.discount as `Discount`,	
p.paid_amount as `Paid`,	
(p.due-(p.discount+p.paid_amount)) as `Remaining`,
p.note
FROM `suppliers_payment` p 
INNER JOIN `suppliers` s ON p.supplier_id=s.supplier_id
WHERE STR_TO_DATE(created_date, '%Y-%m-%d')
BETWEEN STR_TO_DATE('$from_dt', '%Y-%m-%d')
AND STR_TO_DATE('$to_dt', '%Y-%m-%d');
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->Payment_Date}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Suppler_Name}}</td>
						<td style="border: 1px solid black;text-align: center;">
<?php						
$result01 = DB::select("
SELECT (DATE_FORMAT(purchase_dt, '%d-%m-%Y')) bill_dt FROM purchase_mas 
WHERE supplier_id='$item->supplier_id' AND supplier_ref IN('$item->Suppliers_Ref');

");
foreach($result01 as $item01)
		{		
echo $item01->bill_dt.',';
		}			
?>					
						
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Suppliers_Ref}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Method}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Bank_Name}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Cheque_Number}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Cheque_Date}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Credit}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Discount}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Paid}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->Remaining}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
						
						
						
						
						
					</tr>
		<?php
		$sl = $sl+1;
		$amount=$amount+$item->Paid;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>

<strong>Total Payment Amount TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
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