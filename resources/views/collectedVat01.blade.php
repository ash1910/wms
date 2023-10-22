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
                    <li class="breadcrumb-item active" aria-current="page">VAT </li>
                    <li class="breadcrumb-item active" aria-current="page">Collected VAT  </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Collected VAT [From: {{date('d-M-Y', strtotime($from_dt))}} To: {{date('d-M-Y', strtotime($to_dt))}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example3" class="table table-bordered mb-0" style="width: 50%;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Basic Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Receive Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Collected VAT</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.job_no, round(a.basic,2) basic, round(a.receive,2) receive, round(a.collected_vat,2) collected_vat
FROM
(
SELECT job_no,SUM(`received`+IFNULL(`charge`, 0)) receive,SUM(`net_bill`/110*100) basic,(SUM(`received`+IFNULL(`charge`, 0))-SUM(`net_bill`/110*100)) collected_vat FROM `pay` 
WHERE `job_no`in(SELECT `job_no` FROM `pay` WHERE `dt` BETWEEN '$from_dt' AND '$to_dt' AND `pay_type`<>'SYS') GROUP by job_no
) a
WHERE a.collected_vat >0
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$item->job_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->basic}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->receive}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->collected_vat}}</td>

					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->collected_vat;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
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