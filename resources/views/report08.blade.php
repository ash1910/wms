
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
                    <li class="breadcrumb-item active" aria-current="page">Receive </li>
                    <li class="breadcrumb-item active" aria-current="page">VAT Waive </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Receive Reports [From Date: {{$from_dt}} To: {{$to_dt}}] , Work Type: {{$work}}</h5>
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
              <th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
              <th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat Waiver</th>
						</tr>
					</thead>
					<tbody>				
<?php
$workCond = $work == 'all' ? "" : "AND b.work = '$work'";

$result = DB::select("
SELECT `bill` bill_no, a.`job_no`, b.customer_nm, a.`bill_dt`, a.`net_bill`, `received`, `bonus`, `due`,`pay_type`, `ref`, `dt`, a.`user_id` , trix,send,bank,chequeNo,chequeDt, b.bill_dt,
a.id, c.user_name,charge,vat_wav,`card_bank`, `card_no`, `card_type`, `merchant_bank`, a.`ait`, a.note, 
a.advance_refund,a.post_dt
FROM `pay` a, bill_mas b, user c
WHERE 
a.bill = b.bill_no
AND a.dt between '$from_dt' and '$to_dt'
AND a.vat_wav > 0 
$workCond 
and a.user_id = c.user_id and a.pay_type<>'SYS'
order by bill, a.bill_dt desc
;
");
	$sl = '1'; 	$total03 = 0;		
foreach($result as $item)
		{
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
            <td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
            <td style="border: 1px solid black;text-align: center;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->vat_wav}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total03 += $item->vat_wav;
		}  
?>
					</tbody>
				</table>
	
<strong>Total VAT Waived Amount: Tk. {{number_format(($total03), 2, '.', ',')}}	</strong><br>

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