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
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Due Reference Reports [{{$ref}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Before 2022</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">2022</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">2023</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">2024</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">2025</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">2026</th>
						</tr>
					</thead>
					<tbody>				
<?php
$sl = '1';$total02 = '0';	$total01 = '0';
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query

if($ref!='Others')
{
	$result = DB::select("
	SELECT `ref`,
	ROUND(SUM(CASE WHEN year < '2022' then `due` ELSE 0 END),2) AS `b2022`, 
	ROUND(SUM(CASE WHEN year = '2022' then `due` ELSE 0 END),2) AS `y2022`,
	ROUND(SUM(CASE WHEN year = '2023' then `due` ELSE 0 END),2) AS `y2023`,
	ROUND(SUM(CASE WHEN year = '2024' then `due` ELSE 0 END),2) AS `y2024`,
	ROUND(SUM(CASE WHEN year = '2025' then `due` ELSE 0 END),2) AS `y2025`,
	ROUND(SUM(CASE WHEN year = '2026' then `due` ELSE 0 END),2) AS `y2026`,
	ROUND(SUM(`due`),2) AS `total`
	FROM
	(
	SELECT base.`ref`, year(date(b.`bill_dt`)) year,SUM(p.due) due FROM 
	 (        
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref` LIKE '%$ref01%' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` b 
	 ON b.`bill_no`=base.`bill`
	Group by base.`ref`, year(date(b.`bill_dt`))  
	ORDER BY `base`.`ref` ASC
	) t
	WHERE `due`>0
	Group by t.`ref`;

	");
}	
if($ref=='Others')
{
	$result = DB::select("

	SELECT `ref`,
	ROUND(SUM(CASE WHEN year < '2022' then `due` ELSE 0 END),2) AS `b2022`, 
	ROUND(SUM(CASE WHEN year = '2022' then `due` ELSE 0 END),2) AS `y2022`,
	ROUND(SUM(CASE WHEN year = '2023' then `due` ELSE 0 END),2) AS `y2023`,
	ROUND(SUM(CASE WHEN year = '2024' then `due` ELSE 0 END),2) AS `y2024`,
	ROUND(SUM(CASE WHEN year = '2025' then `due` ELSE 0 END),2) AS `y2025`,
	ROUND(SUM(CASE WHEN year = '2026' then `due` ELSE 0 END),2) AS `y2026`,
ROUND(SUM(`due`),2) AS `total`
FROM
(
SELECT base.`ref`, year(date(b.`bill_dt`)) year,SUM(p.due) due FROM 
 (        
    SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref` NOT LIKE '%nizam%' AND `ref` NOT LIKE '%bayezid%' AND 
    `ref` NOT LIKE '%mostafa%'  AND `ref` NOT LIKE '%rafiq%'  AND `ref` NOT LIKE '%solaiman%'  
	AND `ref` NOT LIKE '%fakrul%' AND `ref` NOT LIKE 'inter%com%' AND `ref`<>'sys'
    AND `ref`<> 'Advance' AND `ref` IS NOT NULL
    GROUP BY `job_no`
     ) base
 INNER JOIN
 `pay` p 
 ON base.`job_no`=p.`job_no`
  INNER JOIN
 `bill_mas` b 
 ON b.`bill_no`=base.`bill`
Group by base.`ref`, year(date(b.`bill_dt`))  
ORDER BY `base`.`ref` ASC
) t
WHERE `due`>0
Group by t.`ref`

	");
}	
if($ref=='Engr. Rafiq & Others')
{
	$result = DB::select("

	SELECT `ref`,
	ROUND(SUM(CASE WHEN year < '2022' then `due` ELSE 0 END),2) AS `b2022`,
	ROUND(SUM(CASE WHEN year = '2022' then `due` ELSE 0 END),2) AS `y2022`,
	ROUND(SUM(CASE WHEN year = '2023' then `due` ELSE 0 END),2) AS `y2023`,
	ROUND(SUM(CASE WHEN year = '2024' then `due` ELSE 0 END),2) AS `y2024`,
	ROUND(SUM(CASE WHEN year = '2025' then `due` ELSE 0 END),2) AS `y2025`,
	ROUND(SUM(CASE WHEN year = '2026' then `due` ELSE 0 END),2) AS `y2026`,
	ROUND(SUM(`due`),2) AS `total`
	FROM
	(
	SELECT base.`ref`, year(date(b.`bill_dt`)) year,SUM(p.due) due FROM 
	 (        
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref` LIKE '%rafiq%' AND `ref` NOT LIKE '%mostafa%' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` b 
	 ON b.`bill_no`=base.`bill`
	Group by base.`ref`, year(date(b.`bill_dt`))  
	ORDER BY `base`.`ref` ASC
	) t
	WHERE `due`>0
	Group by t.`ref`			

	");
}	
if($ref=='Engr. Solaiman & Others')
{
	$result = DB::select("

	SELECT `ref`,
	ROUND(SUM(CASE WHEN year < '2022' then `due` ELSE 0 END),2) AS `b2022`,
	ROUND(SUM(CASE WHEN year = '2022' then `due` ELSE 0 END),2) AS `y2022`,
	ROUND(SUM(CASE WHEN year = '2023' then `due` ELSE 0 END),2) AS `y2023`,
	ROUND(SUM(CASE WHEN year = '2024' then `due` ELSE 0 END),2) AS `y2024`,
	ROUND(SUM(CASE WHEN year = '2025' then `due` ELSE 0 END),2) AS `y2025`,
	ROUND(SUM(CASE WHEN year = '2026' then `due` ELSE 0 END),2) AS `y2026`,
	ROUND(SUM(`due`),2) AS `total`
	FROM
	(
	SELECT base.`ref`, year(date(b.`bill_dt`)) year,SUM(p.due) due FROM 
	 (        
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref` LIKE '%solaiman%' AND `ref` NOT LIKE '%mostafa%' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` b 
	 ON b.`bill_no`=base.`bill`
	Group by base.`ref`, year(date(b.`bill_dt`))  
	ORDER BY `base`.`ref` ASC
	) t
	WHERE `due`>0
	Group by t.`ref`			

	");
}	
if($ref=='Fakrul Bhai & Others')
{
	$result = DB::select("

	SELECT `ref`,
	ROUND(SUM(CASE WHEN year < '2022' then `due` ELSE 0 END),2) AS `b2022`,
	ROUND(SUM(CASE WHEN year = '2022' then `due` ELSE 0 END),2) AS `y2022`,
	ROUND(SUM(CASE WHEN year = '2023' then `due` ELSE 0 END),2) AS `y2023`,
	ROUND(SUM(CASE WHEN year = '2024' then `due` ELSE 0 END),2) AS `y2024`,
	ROUND(SUM(CASE WHEN year = '2025' then `due` ELSE 0 END),2) AS `y2025`,
	ROUND(SUM(CASE WHEN year = '2026' then `due` ELSE 0 END),2) AS `y2026`,
	ROUND(SUM(`due`),2) AS `total`
	FROM
	(
	SELECT base.`ref`, year(date(b.`bill_dt`)) year,SUM(p.due) due FROM 
	 (        
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref` LIKE '%fakrul%' AND `ref` NOT LIKE '%mostafa%' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` b 
	 ON b.`bill_no`=base.`bill`
	Group by base.`ref`, year(date(b.`bill_dt`))  
	ORDER BY `base`.`ref` ASC
	) t
	WHERE `due`>0
	Group by t.`ref`			

	");
}	


	
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;">{{$item->ref}}</td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&total=Total">{{number_format(($item->total), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&before=Before 2022">{{number_format(($item->b2022), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&year=2022">{{number_format(($item->y2022), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&year=2023">{{number_format(($item->y2023), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&year=2024">{{number_format(($item->y2024), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&year=2025">{{number_format(($item->y2025), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef02?ref={{urlencode($item->ref)}}&&year=2026">{{number_format(($item->y2026), 2, '.', ',')}}</a></td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->total;
		$total02 = $total01+$total02;
		}  
	
?>
						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->
						
					</tbody>
				</table>






<strong>Total Receivable Amount: Tk. {{number_format(($total02), 2, '.', ',')}}	</strong>
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