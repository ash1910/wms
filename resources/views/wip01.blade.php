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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">WIP </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->



<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Work In Process </h5>
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
							<th scope="col" style="text-align: center;">#</th>
							<th scope="col" style="text-align: center;">Job Date</th>
							<th scope="col" style="text-align: center;">Job No</th>
							<th scope="col" style="text-align: center;">Bill Amount</th>
							<th scope="col" style="text-align: center;">BOM Amount</th>
							<th scope="col" style="text-align: center;">Gross Profit</th>
							<th scope="col" style="text-align: center;">COGS Ratio</th>
							<th scope="col" style="text-align: center;">GP Ratio</th>
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



SELECT `bill_dt`,a.`job_no`,`net_bill` bill, sum(b.amount) purchase, `net_bill`-sum(b.amount) profit
FROM `bill_mas` a, `issue` b
WHERE `bill_dt` BETWEEN '$from_dt' AND '$to_dt'
AND a.job_no=b.job_no
group by `bill_dt`,a.`job_no`,`net_bill`


*/

$stock01 = DB::select("
SELECT bill_no,
bill_mas.bill_dt bill_dt,
bill_mas.job_no job_no,
bill_mas.job_dt job_dt, 
(bill_mas.net_bill) bill, 
sum(issue.amount) purchase,
((bill_mas.net_bill)-IFNULL(sum(issue.amount), 0)) profit,
(sum(issue.amount)/(bill_mas.net_bill))*100 COGS,
(((bill_mas.net_bill)-IFNULL(sum(issue.amount), 0))/(bill_mas.net_bill))*100 Gp
FROM bill_mas
LEFT JOIN issue
ON bill_mas.job_no = issue.job_no
WHERE bill_mas.flag='0'
group by bill_mas.bill_dt,bill_mas.job_dt,bill_mas.job_no,bill_mas.net_bill,bill_no
");
	$sl = '1'; $bill = '0'; $purchase = '0';$profit = '0';
	foreach($stock01 as $item)
		{ 				
?>					
		<tr>
			<th scope="row" style="text-align: center;">{{$sl}}</th>
			<td style="text-align: center;">{{date('d-M-Y', strtotime($item->job_dt))}}</td>
			<td style="text-align: center;"><a href="/report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
			<td style="text-align: right;">{{number_format((floatval($item->bill)), 2, '.', ',')}}</td>
			<td style="text-align: right;">{{number_format(($item->purchase), 2, '.', ',')}}</td>
			<td style="text-align: right;">{{number_format(($item->profit), 2, '.', ',')}}</td>
			<td style="text-align: center;">{{number_format(($item->COGS), 2, '.', ',')}}%</td>
			<td style="text-align: center;">{{number_format(($item->Gp), 2, '.', ',')}}%</td>
		</tr>
		<?php
		$sl = $sl+1;
		$bill = floatval($item->bill)+$bill;
		$purchase = $item->purchase+$purchase;
		$profit = $item->profit+$profit;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<br>				
		<strong>Total Bill Amount :TK {{number_format(intval($bill), 2, '.', ',');}}<br>
		Total Purchase Ammount :TK {{number_format(($purchase), 2, '.', ',');}}<br>
		Gross Profit :TK {{number_format(($profit), 2, '.', ',');}}</strong>
		
			
				
				
				
				
				
				
				
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







