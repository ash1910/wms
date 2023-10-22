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
                    <li class="breadcrumb-item active" aria-current="page">Due </li>
                    <li class="breadcrumb-item active" aria-current="page">Due Reference </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Due Reference Reports [{{$ref}}-{{$year}}{{$total}}{{$before}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
			
<?php
$sl = '1';$total02 = '0';	$total01 = '0';
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query

if($year!='')
{
?>
				<table id="example2" class="table table-bordered mb-0" style="width: 50%;" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Jan</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Feb</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Mar</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Apr</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">May</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Jun</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Jul</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Aug</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sep</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Oct</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Nov</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Dec</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
						</tr>
					</thead>
					<tbody>		
<?php	
	
	$result = DB::select("
	SELECT `ref`,
	ROUND(SUM(CASE WHEN month = '1' then `due` ELSE 0 END),2) AS `Jan`,
	ROUND(SUM(CASE WHEN month = '2' then `due` ELSE 0 END),2) AS `Feb`,
	ROUND(SUM(CASE WHEN month = '3' then `due` ELSE 0 END),2) AS `Mar`,
	ROUND(SUM(CASE WHEN month = '4' then `due` ELSE 0 END),2) AS `Apr`,
	ROUND(SUM(CASE WHEN month = '5' then `due` ELSE 0 END),2) AS `May`,
	ROUND(SUM(CASE WHEN month = '6' then `due` ELSE 0 END),2) AS `Jun`,
	ROUND(SUM(CASE WHEN month = '7' then `due` ELSE 0 END),2) AS `Jul`,
	ROUND(SUM(CASE WHEN month = '8' then `due` ELSE 0 END),2) AS `Aug`,
	ROUND(SUM(CASE WHEN month = '9' then `due` ELSE 0 END),2) AS `Sep`,
	ROUND(SUM(CASE WHEN month = '10' then `due` ELSE 0 END),2) AS `Oct`,
	ROUND(SUM(CASE WHEN month = '11' then `due` ELSE 0 END),2) AS `Nov`,
	ROUND(SUM(CASE WHEN month = '12' then `due` ELSE 0 END),2) AS `Dec`,
	ROUND(SUM(`due`),2) AS `total`
	FROM
	(
	SELECT base.`ref`, month(date(b.`bill_dt`)) month,SUM(p.due) due FROM 
	 (        
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref`='$ref' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` b 
	 ON b.`bill_no`=base.`bill` AND year(date(b.`bill_dt`))='$year'
	Group by base.`ref`, month(date(b.`bill_dt`))  
	ORDER BY `base`.`ref` ASC
	) t
	WHERE `due`>0
	Group by t.`ref`
	");


	 		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=JAN">{{$item->Jan}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=FEB">{{$item->Feb}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=MAR">{{$item->Mar}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=APR">{{$item->Apr}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=MAY">{{$item->May}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=JUN">{{$item->Jun}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=JUL">{{$item->Jul}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=AUG">{{$item->Aug}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=SEP">{{$item->Sep}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=OCT">{{$item->Oct}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=NOV">{{$item->Nov}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef03?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=DEC">{{$item->Dec}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef04?ref={{urlencode($item->ref)}}&&year={{$year}}&&mon=total">{{number_format(($item->total), 2, '.', ',')}}</a></td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->total;
		$total02 = $total01+$total02;
		}  
}

if($total!='')
{
?>
				<table id="example2" class="table table-bordered mb-0" style="width: 50%;" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bill_no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">job_no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_nm</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">net_bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bonus</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">vat_wav</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bill_dt</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_reg</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_vehicle</th>
						</tr>
					</thead>
					<tbody>		
<?php	
	
	$result = DB::select("

SELECT 
  base.`bill` bill_no, 
  `base`.ref, 
  `base`.`job_no`, 
  bm.customer_nm, 
  bm.bill_dt, 
  customer_reg, 
  customer_vehicle, 
  Sum(p.`net_bill`) net_bill, 
  Sum(`received`) received, 
  Sum(`bonus`) bonus, 
  Sum(`due`) due, 
  Sum(`vat_wav`) vat_wav, 
  Sum(charge) charge 
FROM 
  (
    SELECT 
      `job_no`, 
      `bill`, 
      `ref` 
    FROM 
      `pay` 
    WHERE 
      `ref` LIKE '$ref' 
    GROUP BY 
      `job_no`
  ) base 
  INNER JOIN `pay` p ON base.`job_no` = p.`job_no` 
  INNER JOIN `bill_mas` bm ON bm.`bill_no` = base.`bill` 
  INNER JOIN `customer_info` c ON c.`customer_id` = bm.`customer_id` 
  AND p.`customer_id` = c.`customer_id` 
GROUP BY 
  base.`ref`, 
  base.bill, 
  base.job_no, 
  customer_nm, 
  bm.bill_dt 
ORDER BY 
  `base`.`ref`, 
  bm.bill_dt ASC;
	");


	 		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;">{{$item->ref}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->received}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->bonus}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->due}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->vat_wav}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->charge}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_reg}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_vehicle}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->due;
		$total02 = $total01+$total02;
		}  
}

if($before!='')
{
?>
				<table id="example2" class="table table-bordered mb-0" style="width: 50%;" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bill_no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">job_no</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_nm</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">net_bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bonus</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">vat_wav</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bill_dt</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_reg</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">customer_vehicle</th>
						</tr>
					</thead>
					<tbody>		
<?php	
	
	$result = DB::select("
select bill_no,ref,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt,charge,customer_reg,customer_vehicle
from
(
SELECT `bill` bill_no, p.ref,p.`job_no`, bm.customer_nm, bm.bill_dt,customer_reg,customer_vehicle,
sum(p.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav, sum(charge) charge
FROM `pay` p
INNER JOIN
`bill_mas` bm 
ON p.`bill` = bm.`bill_no` and bm.`flag`<>'0' 
INNER JOIN
`customer_info` c
ON
c.`customer_id`=bm.`customer_id` and p.`customer_id`=c.`customer_id`
GROUP by bill,job_no,customer_nm,bm.bill_dt,customer_reg,customer_vehicle
)A
where due > 1 AND (date(A.bill_dt) BETWEEN '1900-01-01' AND '2021-12-31') AND A.`ref`='$ref'
order by bill_dt,customer_nm;
	");


	 		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;">{{$item->bill_no}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->ref}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->received}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->bonus}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->due}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->vat_wav}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->charge}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_reg}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item->customer_vehicle}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->due;
		$total02 = $total01+$total02;
		}  
}
	
?>
						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->
						
					</tbody>
				</table>






<strong>Total Receivable Amount: Tk. {{number_format(intval($total02), 2, '.', ',')}}	</strong>
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