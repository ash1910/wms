
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
                      <h5 class="mb-0">Due Reference Reports [{{$ref}}-{{$year}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">bill_no</th>
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
		SELECT `job_no`,`bill`,`ref` FROM `pay` WHERE `ref`='$ref' GROUP BY `job_no`
		 ) base
	 INNER JOIN
	 `pay` p 
	 ON base.`job_no`=p.`job_no`
	  INNER JOIN
	 `bill_mas` bm 
	 ON bm.`bill_no`=base.`bill` AND year(date(bm.`bill_dt`))='$year'
INNER JOIN `customer_info` c ON c.`customer_id` = bm.`customer_id` 
  AND p.`customer_id` = c.`customer_id` 
GROUP BY 
  base.`ref`, 
  base.bill, 
  base.job_no, 
  customer_nm, 
  bm.bill_dt 
ORDER BY 
  `base`.`ref`, bm.bill_dt ASC;
	");


	 		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
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