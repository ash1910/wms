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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Multi Job No</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
			
			

		<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Multi Receivable</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
			<form method="post" action="review01">{{ csrf_field() }}
				<table id="example2" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Cash</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Bkask</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received POS</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat Waiver</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Note</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Trix</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Send</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Cheque Date</th>
							
							<th></th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
select customer_id,bill_no,job_no,customer_nm,net_bill,received,bonus,due total,vat_wav,bill_dt
from
(
SELECT b.customer_id,`bill` bill_no, a.`job_no`, b.customer_nm, b.bill_dt,
sum(a.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav
FROM `pay` a, bill_mas b 
WHERE 
a.bill = b.bill_no
and b.job_no in ($job_no) and b.flag in ('1','2')
GROUP by bill,job_no,customer_nm,b.bill_dt,b.customer_id
)A
where due > 1
");
	$sl = '1'; 			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{number_format(intval($item->total), 2, '.', ',')}}</a></td>

						<td style="border: 1px solid black;text-align: center;"><input name="received_c[]" type="text" style="width: 100px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="received_k[]" type="text" style="width: 100px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="received_p[]" type="text" style="width: 100px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="received_b[]" type="text" style="width: 100px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="bonus[]" type="text" style="width: 70px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="vat_wav[]" type="text" style="width: 70px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="ref[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="note[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="trix[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="send[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="bank[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="chequeNo[]" type="text" style="width: 110px;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;"><input name="chequeDt[]" type="text" style="width: 110px;text-align: center;"></td>
						
						
						<input type="hidden" name="job_no[]" value="{{$item->job_no}}">
						<input type="hidden" name="bill[]" value="{{$item->bill_no}}">
						<input type="hidden" name="customer_id[]" value="{{$item->customer_id}}">
						<input type="hidden" name="total[]" value="{{$item->total}}">
						
					</tr>
		<?php
		$sl = $sl+1;

		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table><br>
            <input type="submit" name="submit" value="Submit" class="btn btn-outline-success px-3">
			</form>
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