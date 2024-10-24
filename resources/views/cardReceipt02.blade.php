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
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Card [Settlement Date: {{date('d-M-Y', strtotime($s_dt))}}] <br><b>Debit A/C: @if($merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($merchant_bank == 'CBL') HAS-MTBL-7814 @elseif($merchant_bank == 'DBBL') HAS-DBBL-1152 @endif</b>

					 <form  target="_blank" style="display: inline;" action="cardReceiptPrint" method="post">{{ csrf_field() }}
					<input type="hidden" name="s_dt" value="{{$s_dt}}">
					<input type="hidden" name="merchant_bank" value="{{$merchant_bank}}">
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Card No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bank Charged</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card's Bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement By</th>
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
SELECT a.`id`, a.`card_type`, a.`card_bank`, a.`card_no`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_chas,b.customer_vehicle, c.bill_no, a.dt, a.approval_dt, a.check_approval, d.user_name, charge
FROM `pay` a, customer_info b, bill_mas c, user d
WHERE a.customer_id = b.customer_id
and b.customer_id= c.customer_id
and c.job_no = a.job_no
AND a.`pay_check`='1' and a.`pay_type` = 'card'
and a.approval_dt = '$s_dt' AND $where_merchant_bank
and a.check_approval = d.user_id
order by a.`id`;
");
	$sl = '1'; 	$amount='0';	$charge='0';	$amount1='0';
foreach($result as $item)
		{
?>
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->approval_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">****{{$item->card_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received+$item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_bank}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Chas.:</b> {{$item->customer_chas}}
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




$result = DB::select("
SELECT a.`id`, a.`card_type`, a.`card_bank`, a.`card_no`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_chas,b.customer_vehicle, a.dt, a.approval_dt, a.check_approval, d.user_name, charge
FROM `pay` a, customer_info b, user d
WHERE a.customer_id = b.customer_id
AND a.`pay_check`='1' and a.`pay_type` = 'card'
and a.approval_dt = '$s_dt' AND $where_merchant_bank
and a.check_approval = d.user_id and a.job_no='Advance'
order by a.`id`;
");

foreach($result as $item)
		{
?>
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->approval_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">****{{$item->card_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received+$item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->charge), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_bank}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Chas.:</b> {{$item->customer_chas}}
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
