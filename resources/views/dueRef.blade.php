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
                      <h5 class="mb-0">Due Reference Reports</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0" style="width: 70%;" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
						</tr>
					</thead>
					<tbody>				
<?php
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query
$sl = '1';$total02 = '0';	$total01 = '0';

$result = DB::select("
SELECT SUM(temp.due) due,`ref` FROM 
(
SELECT SUM(p.due) due, 
CASE
    WHEN base.`ref` LIKE '%nizam%' THEN 'DGM Nizam Sir & Others'
    WHEN base.`ref` LIKE '%mostafa%' THEN 'Engr. Mostafa & Others'
    WHEN base.`ref` LIKE '%bayezid%' THEN 'Engr. A.A Bayezid'
    WHEN base.`ref` LIKE '%solaiman%' AND base.`ref` NOT LIKE '%mostafa%' THEN 'Engr. Solaiman & Others'
    WHEN base.`ref` LIKE '%rafiq%' AND base.`ref` NOT LIKE '%mostafa%' THEN 'Engr. Rafiq & Others'
    WHEN base.`ref` LIKE '%fakrul%' AND base.`ref` NOT LIKE '%mostafa%' THEN 'Fakrul Bhai & Others'
    WHEN base.`ref` LIKE 'inter%com%' THEN 'Inter Company'
    ELSE 'Others'
END AS `ref` FROM 
 (        
    SELECT `job_no`,`ref` FROM `pay` WHERE `ref` IS NOT NULL AND `ref`<>'SYS' GROUP BY `job_no`
     ) base
 INNER JOIN
 `pay` p 
 ON base.`job_no`=p.`job_no`
 Group by base.`ref` 
 ) temp
 GROUP BY temp.`ref`

");
	 		
foreach($result as $item)
		{		
		$ref = '';
		$ref01 = '';
		$ref = $item->ref;
		if($ref =="DGM Nizam Sir & Others") {$ref01='nizam';}
		if($ref =="Engr. Mostafa & Others") {$ref01='mostafa';}
		if($ref =="Engr. A.A Bayezid") {$ref01='bayezid';}
		if($ref =="Engr. Solaiman & Others") {$ref01='solaiman';}
		if($ref =="Engr. Rafiq & Others") {$ref01='rafiq';}
		if($ref =="Fakrul Bhai & Others") {$ref01='fakrul';}
		if($ref =="Inter Company") {$ref01='Inter%com';}
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><a href="dueRef01?ref={{urlencode($ref)}}&&ref01={{urlencode($ref01)}}">{{$item->ref}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="dueRef01?ref={{urlencode($ref)}}&&ref01={{urlencode($ref01)}}">{{number_format(($item->due), 2, '.', ',')}}</a></td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->due;
		$total02 = $total01+$total02;
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