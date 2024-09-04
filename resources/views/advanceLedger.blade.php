<?php
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator"))
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
                    <li class="breadcrumb-item active" aria-current="page">Ledger </li>
                    <li class="breadcrumb-item active" aria-current="page">Advance Ledger </li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Advance Money Ledger</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>

            <div class="card-body">
              <div class="table-responsive">

				<table id="example2" class="table table-bordered mb-0" style="width: 60%;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
                            <th scope="col" style="border: 1px solid black;text-align: center;">Customer ID</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance</th>
						</tr>
					</thead>
					<tbody>
<?php
// Nishan
// $result = DB::select("
// SELECT b.customer_nm,b.customer_reg,b.customer_chas,b.customer_vehicle,b.customer_id, sum(-a.`due`) Credit
// FROM `pay` a, customer_info b
// WHERE a.customer_id = b.customer_id AND a.customer_id in (SELECT DISTINCT `customer_id` FROM `pay` WHERE `ref` = 'Advance') and a.job_no='Advance'
// group by b.customer_nm,b.customer_reg,b.customer_vehicle,b.customer_id,b.customer_chas
// order by Credit desc;
// ");

$result = DB::select("
SELECT b.customer_nm,b.customer_reg,b.customer_chas,b.customer_vehicle,b.customer_id
FROM `pay` a, customer_info b
WHERE a.customer_id = b.customer_id AND a.customer_id in (SELECT DISTINCT `customer_id` FROM `pay` WHERE `ref` = 'Advance')
group by b.customer_nm,b.customer_reg,b.customer_vehicle,b.customer_id,b.customer_chas;
");
	$sl = '1'; 	$amount='0'; $credit='0';
foreach($result as $item)
		{

$result01 = DB::select("
SELECT sum(-`due`) Credit
FROM `pay` WHERE (job_no='Advance' OR bill='Advance') AND customer_id='$item->customer_id';
");
foreach($result01 as $item01)
		{
			$credit = $item01->Credit;
		}
?>
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
                        <td style="border: 1px solid black;text-align: center;">{{$item->customer_id}}</td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Chas.:</b> {{$item->customer_chas}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href="/advanceLedger01?id={{$item->customer_id}}">
						    <?php
						    if($credit>0)
						    {
						    echo number_format(($credit), 2, '.', ',');
						    $credit=$credit;
						    }
						    else
						    {
						    echo '0';
						    $credit='0';
						    }
					        ?>
						    </a></td>


					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$credit;
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
