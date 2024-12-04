
@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Reports</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Draft Bill</li>
                  </ol>
                </nav>
              </div>

            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Draft Bill Report [From Date: {{$from_dt}} To: {{$to_dt}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
                            <th scope="col" style="border: 1px solid black;text-align: center;">Customer ID</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Reg.No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Chas.No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vehicle</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Mobile</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Service</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Parts</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Work Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Engineer</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Group</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Company</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sister Companies</th>
						</tr>
					</thead>
					<tbody>
<?php

$result = DB::select("
SELECT `job_dt`,`bill_no`, a.work, a.customer_id, b.customer_nm, b.customer_mobile , b.customer_group , b.company , b.sister_companies, `job_no`,
`user_id`, `net_bill` ,customer_reg,customer_chas,customer_vehicle, total, parts, service, engineer
FROM `bill_mas` a, customer_info b
WHERE `job_dt` between '$from_dt' and '$to_dt'
and a.customer_id = b.customer_id
and a.flag='0'
;
");
	$sl = '1'; 	$total02 = '0';
foreach($result as $item)
		{		$total01 = '0';$net_bill = $item->net_bill; $vat= (int)$net_bill*.1;
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_dt}}</td>
                        <td style="border: 1px solid black;text-align: center;">{{$item->customer_id}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_reg}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_chas}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_vehicle}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_mobile}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->service}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->parts}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$vat}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{number_format(intval($item->total), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->work}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->engineer}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_group}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->company}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->sister_companies}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->total;
		$total02 = (float)$total01+(float)$total02;
		}
?>
						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->

					</tbody>
				</table>

<strong>Total Draft Amount: Tk. {{number_format(intval($total02), 2, '.', ',')}}	</strong>
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
