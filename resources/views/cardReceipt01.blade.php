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


@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message---->
@if(session()->has('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
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
                    <li class="breadcrumb-item active" aria-current="page">Card </li>
                  </ol>
                </nav>
              </div>

            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Card [From: {{date('d-M-Y', strtotime($from_dt))}} To: {{date('d-M-Y', strtotime($to_dt))}}] <br><b>Debit A/C: @if($merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($merchant_bank == 'CBL') HAS-MTBL-7814 @elseif($merchant_bank == 'DBBL') HAS-DBBL-1152 @endif</b></h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Merchant Payment Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
						</tr>
					</thead>
					<tbody>
<?php

$where_merchant_bank = "";
if( $merchant_bank == "CBL"){
	$where_merchant_bank = "a.merchant_bank = 'CBL'";
}
else if( $merchant_bank == "DBBL"){
	$where_merchant_bank = "a.merchant_bank = 'DBBL'";
}
else{
  $where_merchant_bank = "( a.merchant_bank <> 'CBL' OR a.merchant_bank IS NULL )";
}

$result = DB::select("
SELECT a.settlement_date approval_dt,
       SUM(a.received) AS received,
       GROUP_CONCAT(DISTINCT a.merchant_payment_date ORDER BY a.merchant_payment_date ASC SEPARATOR ', ') AS dt

from
(	SELECT round(sum(`received`),2) received, a.dt merchant_payment_date, a.approval_dt settlement_date
	FROM `pay` a, customer_info b, bill_mas c, user d
	WHERE a.customer_id = b.customer_id
	and b.customer_id= c.customer_id
	and c.job_no = a.job_no
	AND a.`pay_check`='1' and a.`pay_type` = 'card' and a.approval_dt between '$from_dt' and '$to_dt' AND $where_merchant_bank
	and a.check_approval = d.user_id
	GROUP by a.dt, a.approval_dt
	order by a.`id`
)a
GROUP BY a.settlement_date
ORDER BY a.settlement_date ASC;




");
	$sl = '1'; 	$amount='0';
foreach($result as $item)
		{
?>
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->approval_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href="cardReceipt02?m_dt={{$item->dt}}&s_dt={{$item->approval_dt}}&merchant_bank={{$merchant_bank}}">{{number_format(($item->received), 2, '.', ',')}}</a></td>
					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->received;
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
