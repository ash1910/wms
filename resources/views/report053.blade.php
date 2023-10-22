<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
                    <li class="breadcrumb-item active" aria-current="page">Receivable</li>
                    <li class="breadcrumb-item active" aria-current="page">All Due</li>
                    <li class="breadcrumb-item active" aria-current="page">Company</li>
                    <li class="breadcrumb-item active" aria-current="page">Sister Company</li>
                    <li class="breadcrumb-item active" aria-current="page">Customer</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Single Receivable Reports </h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
<?php
$result = DB::select("
SELECT  `customer_nm`, `customer_mobile`, `customer_reg`,`customer_vehicle` FROM `customer_info` 
WHERE `customer_id` = '$id' 
;
");	
foreach($result as $item)
		{
		$customer_nm = $nm;	
		$customer_mobile = $item->customer_mobile;	
		$customer_reg = $item->customer_reg;	
		$customer_vehicle = $item->customer_vehicle;	
		}
?>	
            <div class="card-body"><b>Customer Name:</b> {{$customer_nm}}
			<br><b>Reg:</b> {{$customer_reg}}, &nbsp;&nbsp;&nbsp;&nbsp;<b>Vehicle:</b> {{$customer_vehicle}}
			<br><b>Mobile:</b> {{$customer_mobile}}
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat Waiver</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Receive</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
select bill_no,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt
from
(
SELECT `bill` bill_no, a.`job_no`, b.customer_nm, b.bill_dt,
sum(a.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav
FROM `pay` a, bill_mas b 
WHERE 
a.bill = b.bill_no
and b.customer_id = '$id' and b.customer_nm = '$nm'
GROUP by bill,job_no,customer_nm,b.bill_dt
)A
where due > 1

;
");
	$sl = '1'; 	$total02 = '0';		
foreach($result as $item)
		{		$total01 = '0';$net_bill = $item->net_bill; $vat= (int)$net_bill*.1;
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{$item->bill_dt}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->received}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->bonus}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->vat_wav}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->due}}</td>
					<td style="border: 1px solid black;text-align: center;">	
<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>					
					<form style="display: inline;" action="pay" method="post" target="_blank">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$item->bill_no}}">
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Receive</button>
					</form>
<?php } else {?>						
					<form style="display: inline;" action="pay" method="post" target="_blank">
					<input type="hidden" name="bill_no" value="{{$item->bill_no}}">
					<button class="btn btn-secondary px-3" type="submit" name="" value="" disabled>
					 Receive</button>
					</form>
<?php } ?>						
					
					</td>
					
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->due;
		$total02 = $total01+$total02;
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