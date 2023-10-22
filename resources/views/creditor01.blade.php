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
                      <h5 class="mb-0">Creditor Aging Report [Year: {{$year}}]</h5>
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
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Purchase-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Purchase_return-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Discount-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Payment-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total Balance-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Jan-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Jan-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Jan-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Jan-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Jan-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Feb-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Feb-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Feb-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Feb-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Feb-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Mar-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Mar-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Mar-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Mar-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Mar-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Apr-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Apr-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Apr-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Apr-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Apr-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-May-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-May-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-May-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-May-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-May-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Jun-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Jun-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Jun-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Jun-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Jun-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Jul-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Jul-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Jul-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Jul-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Jul-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Aug-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Aug-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Aug-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Aug-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Aug-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Sep-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Sep-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Sep-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Sep-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Sep-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Oct-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Oct-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Oct-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Oct-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Oct-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Nov-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Nov-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Nov-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Nov-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Nov-{{$year}}</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Purchase-Dec-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">purchase_return-Dec-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount-Dec-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment-Dec-{{$year}}</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance-Dec-{{$year}}</th>


						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("

SELECT `supplier_name`,
ROUND(SUM(CASE WHEN month = '1' then `purchase` ELSE 0 END),2) AS `purchase_Jan_2023`,
ROUND(SUM(CASE WHEN month = '1' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Jan_2023`,
ROUND(SUM(CASE WHEN month = '1' then `discount` ELSE 0 END),2) AS `discount_Jan_2023`,
ROUND(SUM(CASE WHEN month = '1' then `payment` ELSE 0 END),2) AS `payment_Jan_2023`,
ROUND(SUM(CASE WHEN month = '1' then `balance` ELSE 0 END),2) AS `balance_Jan_2023`,

ROUND(SUM(CASE WHEN month = '2' then `purchase` ELSE 0 END),2) AS `purchase_Feb_2023`,
ROUND(SUM(CASE WHEN month = '2' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Feb_2023`,
ROUND(SUM(CASE WHEN month = '2' then `discount` ELSE 0 END),2) AS `discount_Feb_2023`,
ROUND(SUM(CASE WHEN month = '2' then `payment` ELSE 0 END),2) AS `payment_Feb_2023`,
ROUND(SUM(CASE WHEN month = '2' then `balance` ELSE 0 END),2) AS `balance_Feb_2023`,

ROUND(SUM(CASE WHEN month = '3' then `purchase` ELSE 0 END),2) AS `purchase_Mar_2023`,
ROUND(SUM(CASE WHEN month = '3' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Mar_2023`,
ROUND(SUM(CASE WHEN month = '3' then `discount` ELSE 0 END),2) AS `discount_Mar_2023`,
ROUND(SUM(CASE WHEN month = '3' then `payment` ELSE 0 END),2) AS `payment_Mar_2023`,
ROUND(SUM(CASE WHEN month = '3' then `balance` ELSE 0 END),2) AS `balance_Mar_2023`,

ROUND(SUM(CASE WHEN month = '4' then `purchase` ELSE 0 END),2) AS `purchase_Apr_2023`,
ROUND(SUM(CASE WHEN month = '4' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Apr_2023`,
ROUND(SUM(CASE WHEN month = '4' then `discount` ELSE 0 END),2) AS `discount_Apr_2023`,
ROUND(SUM(CASE WHEN month = '4' then `payment` ELSE 0 END),2) AS `payment_Apr_2023`,
ROUND(SUM(CASE WHEN month = '4' then `balance` ELSE 0 END),2) AS `balance_Apr_2023`,

ROUND(SUM(CASE WHEN month = '5' then `purchase` ELSE 0 END),2) AS `purchase_May_2023`,
ROUND(SUM(CASE WHEN month = '5' then `purchase_return` ELSE 0 END),2) AS `purchase_return_May_2023`,
ROUND(SUM(CASE WHEN month = '5' then `discount` ELSE 0 END),2) AS `discount_May_2023`,
ROUND(SUM(CASE WHEN month = '5' then `payment` ELSE 0 END),2) AS `payment_May_2023`,
ROUND(SUM(CASE WHEN month = '5' then `balance` ELSE 0 END),2) AS `balance_May_2023`,

ROUND(SUM(CASE WHEN month = '6' then `purchase` ELSE 0 END),2) AS `purchase_Jun_2023`,
ROUND(SUM(CASE WHEN month = '6' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Jun_2023`,
ROUND(SUM(CASE WHEN month = '6' then `discount` ELSE 0 END),2) AS `discount_Jun_2023`,
ROUND(SUM(CASE WHEN month = '6' then `payment` ELSE 0 END),2) AS `payment_Jun_2023`,
ROUND(SUM(CASE WHEN month = '6' then `balance` ELSE 0 END),2) AS `balance_Jun_2023`,

ROUND(SUM(CASE WHEN month = '7' then `purchase` ELSE 0 END),2) AS `purchase_Jul_2023`,
ROUND(SUM(CASE WHEN month = '7' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Jul_2023`,
ROUND(SUM(CASE WHEN month = '7' then `discount` ELSE 0 END),2) AS `discount_Jul_2023`,
ROUND(SUM(CASE WHEN month = '7' then `payment` ELSE 0 END),2) AS `payment_Jul_2023`,
ROUND(SUM(CASE WHEN month = '7' then `balance` ELSE 0 END),2) AS `balance_Jul_2023`,


ROUND(SUM(CASE WHEN month = '8' then `purchase` ELSE 0 END),2) AS `purchase_Aug_2023`,
ROUND(SUM(CASE WHEN month = '8' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Aug_2023`,
ROUND(SUM(CASE WHEN month = '8' then `discount` ELSE 0 END),2) AS `discount_Aug_2023`,
ROUND(SUM(CASE WHEN month = '8' then `payment` ELSE 0 END),2) AS `payment_Aug_2023`,
ROUND(SUM(CASE WHEN month = '8' then `balance` ELSE 0 END),2) AS `balance_Aug_2023`,

ROUND(SUM(CASE WHEN month = '9' then `purchase` ELSE 0 END),2) AS `purchase_Sep_2023`,
ROUND(SUM(CASE WHEN month = '9' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Sep_2023`,
ROUND(SUM(CASE WHEN month = '9' then `discount` ELSE 0 END),2) AS `discount_Sep_2023`,
ROUND(SUM(CASE WHEN month = '9' then `payment` ELSE 0 END),2) AS `payment_Sep_2023`,
ROUND(SUM(CASE WHEN month = '9' then `balance` ELSE 0 END),2) AS `balance_Sep_2023`,

ROUND(SUM(CASE WHEN month = '10' then `purchase` ELSE 0 END),2) AS `purchase_Oct_2023`,
ROUND(SUM(CASE WHEN month = '10' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Oct_2023`,
ROUND(SUM(CASE WHEN month = '10' then `discount` ELSE 0 END),2) AS `discount_Oct_2023`,
ROUND(SUM(CASE WHEN month = '10' then `payment` ELSE 0 END),2) AS `payment_Oct_2023`,
ROUND(SUM(CASE WHEN month = '10' then `balance` ELSE 0 END),2) AS `balance_Oct_2023`,

ROUND(SUM(CASE WHEN month = '11' then `purchase` ELSE 0 END),2) AS `purchase_Nov_2023`,
ROUND(SUM(CASE WHEN month = '11' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Nov_2023`,
ROUND(SUM(CASE WHEN month = '11' then `discount` ELSE 0 END),2) AS `discount_Nov_2023`,
ROUND(SUM(CASE WHEN month = '11' then `payment` ELSE 0 END),2) AS `payment_Nov_2023`,
ROUND(SUM(CASE WHEN month = '11' then `balance` ELSE 0 END),2) AS `balance_Nov_2023`,

ROUND(SUM(CASE WHEN month = '12' then `purchase` ELSE 0 END),2) AS `purchase_Dec_2023`,
ROUND(SUM(CASE WHEN month = '12' then `purchase_return` ELSE 0 END),2) AS `purchase_return_Dec_2023`,
ROUND(SUM(CASE WHEN month = '12' then `discount` ELSE 0 END),2) AS `discount_Dec_2023`,
ROUND(SUM(CASE WHEN month = '12' then `payment` ELSE 0 END),2) AS `payment_Dec_2023`,
ROUND(SUM(CASE WHEN month = '12' then `balance` ELSE 0 END),2) AS `balance_Dec_2023`,

ROUND(SUM(`purchase`),2) AS `totalpurchase_2023`,
ROUND(SUM(`purchase_return`),2) AS `totalpurchase_return_2023`,
ROUND(SUM(`discount`),2) AS `totaldiscount_2023`,
ROUND(SUM(`payment`),2) AS `totalpayment_2023`,
ROUND(SUM(`balance`),2) AS `totalbalance_2023`
FROM
(
SELECT 
s.supplier_name,
month(date(pm.`purchase_dt`)) month, 
SUM(pm.`amount`) AS `purchase`,
SUM(pd.`amount`) AS `purchase_return`,
SUM(sp.`discount`) AS `discount`,
SUM(sp.`paid_amount`) AS `payment`,
((SUM(IFNULL(pm.`amount`, 0 ))+SUM(IFNULL(pd.`amount`, 0 )))-(SUM(IFNULL(sp.`discount`, 0 ))+SUM(IFNULL(sp.`paid_amount`, 0 )))) AS `balance`
FROM `suppliers` s 
LEFT OUTER JOIN 
`purchase_mas` pm
ON pm.supplier_id=s.supplier_id AND year(date(pm.purchase_dt))='$year'
LEFT OUTER JOIN 
`purchase_det` pd
ON pm.purchase_id=pd.purchase_id AND `qty`<0
LEFT OUTER JOIN `suppliers_payment` sp
ON sp.supplier_id=s.supplier_id
GROUP BY s.supplier_name, month(date(pm.`purchase_dt`))
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
	
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpurchase_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpurchase_return_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totaldiscount_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalpayment_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->totalbalance_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Jan_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Jan_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Jan_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Jan_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Jan_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Feb_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Feb_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Feb_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Feb_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Feb_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Mar_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Mar_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Mar_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Mar_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Mar_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Apr_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Apr_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Apr_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Apr_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Apr_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_May_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_May_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_May_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_May_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_May_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Jun_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Jun_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Jun_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Jun_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Jun_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Jul_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Jul_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Jul_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Jul_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Jul_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Aug_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Aug_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Aug_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Aug_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Aug_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Sep_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Sep_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Sep_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Sep_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Sep_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Oct_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Oct_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Oct_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Oct_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Oct_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Nov_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Nov_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Nov_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Nov_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Nov_2023}}</td>
						
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_Dec_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->purchase_return_Dec_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->discount_Dec_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->payment_Dec_2023}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->balance_Dec_2023}}</td>
						
						
						
						
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