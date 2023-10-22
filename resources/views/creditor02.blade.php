<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator"))
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
                    <li class="breadcrumb-item active" aria-current="page">Accounting </li>
                    <li class="breadcrumb-item active" aria-current="page">Creditor Aging </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Creditor Aging Report</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier Name</th>
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Purchase</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Purchase Return</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Payment</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Balance</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase 2022</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase Return 2022</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount 2022</th>
							<th scope="col" style="border: 1px solid black;textalign: center;">Payment 2022</th>
							<th scope="col" style="border: 1px solid black;textalign: center;">Balance 2022</th>

							<th scope="col" style="border: 1px solid black;textalign: center;">Purchase 2023</th>
							<th scope="col" style="border: 1px solid black;text align: center;">purchase Return 2023</th>
							<th scope="col" style="border: 1px solid black;text align: center;">Discount 2023</th>
							<th scope="col" style="border: 1px solid black;text align: center;">Payment 2023</th>
							<th scope="col" style="border: 1px solid black;text align: center;">Balance 2023</th>

							<!--th scope="col" style="border: 1px solid black;text-align: center;">Purchase-2024</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-2024</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-2024</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-2024</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-2024</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-2025</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-2025</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-2025</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-2025</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-2025</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-2026</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-2026</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-2026</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-2026</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-2026</th-->



						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("

SELECT `supplier_name`,
ROUND(SUM(CASE WHEN year = '2022' then `purchase` ELSE 0 END),2) AS `purchase_2022`,
ROUND(SUM(CASE WHEN year = '2022' then `purchase_return` ELSE 0 END),2) AS `purchase_return_2022`,
ROUND(SUM(CASE WHEN year = '2022' then `discount` ELSE 0 END),2) AS `discount_2022`,
ROUND(SUM(CASE WHEN year = '2022' then `payment` ELSE 0 END),2) AS `payment_2022`,
ROUND(SUM(CASE WHEN year = '2022' then `balance` ELSE 0 END),2) AS `balance_2022`,

ROUND(SUM(CASE WHEN year = '2023' then `purchase` ELSE 0 END),2) AS `purchase_2023`,
ROUND(SUM(CASE WHEN year = '2023' then `purchase_return` ELSE 0 END),2) AS `purchase_return_2023`,
ROUND(SUM(CASE WHEN year = '2023' then `discount` ELSE 0 END),2) AS `discount_2023`,
ROUND(SUM(CASE WHEN year = '2023' then `payment` ELSE 0 END),2) AS `payment_2023`,
ROUND(SUM(CASE WHEN year = '2023' then `balance` ELSE 0 END),2) AS `balance_2023`,

ROUND(SUM(CASE WHEN year = '2024' then `purchase` ELSE 0 END),2) AS `purchase_2024`,
ROUND(SUM(CASE WHEN year = '2024' then `purchase_return` ELSE 0 END),2) AS `purchase_return_2024`,
ROUND(SUM(CASE WHEN year = '2024' then `discount` ELSE 0 END),2) AS `discount_2024`,
ROUND(SUM(CASE WHEN year = '2024' then `payment` ELSE 0 END),2) AS `payment_2024`,
ROUND(SUM(CASE WHEN year = '2024' then `balance` ELSE 0 END),2) AS `balance_2024`,

ROUND(SUM(CASE WHEN year = '2025' then `purchase` ELSE 0 END),2) AS `purchase_2025`,
ROUND(SUM(CASE WHEN year = '2025' then `purchase_return` ELSE 0 END),2) AS `purchase_return_2025`,
ROUND(SUM(CASE WHEN year = '2025' then `discount` ELSE 0 END),2) AS `discount_2025`,
ROUND(SUM(CASE WHEN year = '2025' then `payment` ELSE 0 END),2) AS `payment_2025`,
ROUND(SUM(CASE WHEN year = '2025' then `balance` ELSE 0 END),2) AS `balance_2025`,

ROUND(SUM(CASE WHEN year = '2026' then `purchase` ELSE 0 END),2) AS `purchase_2026`,
ROUND(SUM(CASE WHEN year = '2026' then `purchase_return` ELSE 0 END),2) AS `purchase_return_2026`,
ROUND(SUM(CASE WHEN year = '2026' then `discount` ELSE 0 END),2) AS `discount_2026`,
ROUND(SUM(CASE WHEN year = '2026' then `payment` ELSE 0 END),2) AS `payment_2026`,
ROUND(SUM(CASE WHEN year = '2026' then `balance` ELSE 0 END),2) AS `balance_2026`,

ROUND(SUM(`purchase`),2) AS `totalpurchase`,
ROUND(SUM(`purchase_return`),2) AS `totalpurchase_return`,
ROUND(SUM(`discount`),2) AS `totaldiscount`,
ROUND(SUM(`payment`),2) AS `totalpayment`,
ROUND(SUM(`balance`),2) AS `totalbalance`
FROM
(
SELECT 
s.supplier_name,
year(date(pm.`purchase_dt`)) year, 
SUM(pm.`amount`) AS `purchase`,
SUM(pd.`amount`) AS `purchase_return`,
SUM(sp.`discount`) AS `discount`,
SUM(sp.`paid_amount`) AS `payment`,
((SUM(IFNULL(pm.`amount`, 0 ))+SUM(IFNULL(pd.`amount`, 0 )))-(SUM(IFNULL(sp.`discount`, 0 ))+SUM(IFNULL(sp.`paid_amount`, 0 )))) AS `balance`
FROM `suppliers` s 
LEFT OUTER JOIN 
`purchase_mas` pm
ON pm.supplier_id=s.supplier_id
LEFT OUTER JOIN 
`purchase_det` pd
ON pm.purchase_id=pd.purchase_id AND `qty`<0
LEFT OUTER JOIN `suppliers_payment` sp
ON sp.supplier_id=s.supplier_id
GROUP BY s.supplier_name, year(date(pm.`purchase_dt`))
) t
GROUP BY t.supplier_name;

");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->supplier_name}}</td>
	
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpurchase}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpurchase_return}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totaldiscount}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpayment}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalbalance}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_2022}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_2022}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_2022}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_2022}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_2022}}</td>

						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_2023}}</td>

						<!--td style="border: 1px solid black;text-align: center;">{{$item->purchase_2024}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_2024}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_2024}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_2024}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_2024}}</td>

						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_2025}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_2025}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_2025}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_2025}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_2025}}</td>

						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_2026}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_2026}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_2026}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_2026}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_2026}}</td-->

						
						
						
						
					</tr>
		<?php
		$sl = $sl+1;

		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>

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