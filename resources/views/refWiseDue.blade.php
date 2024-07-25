
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
                    <li class="breadcrumb-item active" aria-current="page">Ref Wise Due </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Ref Wise Due Reports</h5>
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
$sl = '1';$total02 = '0';	$total01 = '0';
$result01 = DB::select("SELECT `ref` FROM `pay` a WHERE `ref` <> 'SYS' GROUP by `ref`");
foreach($result01 as $item01)
		{
		$ref_nm = $item01->ref;
		

$result = DB::select("
SELECT due, nm ref
from
(
SELECT sum(a.`due`) due, '$ref_nm' nm
FROM `pay` a, bill_mas b, customer_info c
WHERE 
a.bill = b.bill_no
and b.customer_id = c.customer_id 
and a.job_no in (SELECT job_no FROM `pay` a WHERE ref='$ref_nm' GROUP by job_no)
) A
where due > 0
");
	 		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: left;"><a href="refWiseDue01?ref={{urlencode($item->ref)}}">{{$item->ref}}</a></td>
						<td style="border: 1px solid black;text-align: right;"><a href="refWiseDue01?ref={{urlencode($item->ref)}}">{{number_format(intval($item->due), 2, '.', ',')}}</a></td>
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