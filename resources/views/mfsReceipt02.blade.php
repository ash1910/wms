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
                    <li class="breadcrumb-item active" aria-current="page">Receive </li>
                    <li class="breadcrumb-item active" aria-current="page">Mobile Financial Services </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Mobile Financial Services [Settlement Date: {{date('d-M-Y', strtotime($to_dt))}}]
					  
					<form  target="_blank" style="display: inline;" action="mfsReceiptPrint" method="post">{{ csrf_field() }}
					<input type="hidden" name="to_dt" value="{{$to_dt}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form>
					
					</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">TRIX</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sender</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">MFS Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement Amount</th>
							
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement By</th>
						</tr>
					</thead>
					<tbody>				
<?php
$where_mer_bkash = "";
if( $mer_bkash == "330"){
	$where_mer_bkash = "a.mer_bkash = 330";
}
else{
  $where_mer_bkash = "( a.mer_bkash <> 330 OR a.mer_bkash IS NULL )";
}

$result = DB::select("
SELECT a.`id`, a.`pay_type`, a.`trix`, a.`send`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_vehicle, c.bill_no, a.dt, a.approval_dt, a.check_approval, d.user_name, charge
FROM `pay` a, customer_info b, bill_mas c, user d
WHERE a.customer_id = b.customer_id
and b.customer_id= c.customer_id
and c.job_no = a.job_no
AND a.`pay_check`='1' and a.`pay_type` = 'bkash' and a.approval_dt = '$to_dt' AND $where_mer_bkash 
and a.check_approval = d.user_id
order by a.`id`;
");
	$sl = '1'; 	$amount='0';		$charge='0';	$amount1='0';
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->approval_dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->trix}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->send}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received+$item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						
						
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->user_name}}</td>
					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->received;
        $charge=$charge+$item->charge;
        $amount1=$amount1+($item->received+$item->charge);
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
<br>				
<br>				

Total Transaction Amount:	<b>TK. {{number_format(($amount1), 2, '.', ',')}}</b>&nbsp;&nbsp;&nbsp;&nbsp;
Total Charge Amount:	<b>TK. {{number_format(($charge), 2, '.', ',')}}</b>&nbsp;&nbsp;&nbsp;&nbsp;
Total Settlement Amount:	<b>TK. {{number_format(($amount), 2, '.', ',')}}</b>
				
				
				
				
				
				
				
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