
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
                    <li class="breadcrumb-item active" aria-current="page">Date Wise </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Received Type: {{$pay_type}} [From Date: {{$from_dt}} To: {{$to_dt}}]</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Receive No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat Waiver</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">AIT</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Note</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">trix</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">send</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">chequeNo</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">chequeDt</th>
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Card Bank</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Merchant Bank</th>

							<th scope="col" style="border: 1px solid black;text-align: center;">Received Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Receive By</th>
						</tr>
					</thead>
					<tbody>				
<?php

	if( $pay_type == "has"){
		$where_pay_type = " and a.merchant_bank='CBL' AND a.pay_type IN ('card','cheque','online') ";
	}
	elseif( $pay_type == "esl"){
		$where_pay_type = " and a.merchant_bank='MTBL' AND a.pay_type IN ('card','cheque','online') ";
	}
	else{
		$where_pay_type = " and a.pay_type='$pay_type' ";
	}

	$result = DB::select("
	SELECT `bill` bill_no, a.`job_no`, b.customer_nm, a.`bill_dt`, a.`net_bill`, `received`, `bonus`, `due`,`pay_type`, `ref`, `dt`, a.`user_id` , trix,send,bank,chequeNo,chequeDt, b.bill_dt,
	a.id, c.user_name,charge,vat_wav,`card_bank`, `card_no`, `card_type`, `merchant_bank`, a.`ait`, a.note
	FROM `pay` a, bill_mas b, user c
	WHERE 
	a.bill = b.bill_no
	AND a.dt between '$from_dt' and '$to_dt'
	and a.user_id = c.user_id and a.pay_type<>'SYS' 
	$where_pay_type 
	order by bill, a.bill_dt desc
	;
	");
	$sl = '1'; 	$total02 = '0';		
	foreach($result as $item)
	{		$total01 = '0';$net_bill = $item->net_bill; $vat= (int)$net_bill*.1;
?>					<tr>
					<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
					<td style="border: 1px solid black;text-align: center;">{{$item->id}}</td>
					<td style="border: 1px solid black;text-align: center;">{{date('d-m-y', strtotime($item->bill_dt))}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</td>
					<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
					<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->received}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->bonus}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->vat_wav}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->ait}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->charge}}</td>
					<td style="border: 1px solid black;text-align: center;">{{-$item->due}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->ref}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->trix}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->send}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->bank}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->chequeNo}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->chequeDt}}</td>
					
					<td style="border: 1px solid black;text-align: center;">{{$item->card_bank}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->card_no}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->card_type}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->merchant_bank}}</td>
					
					<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->user_name}}</td>
				</tr>
	<?php
	$sl = $sl+1;
	$total01 = $item->received;
	$total02 = $total01+$total02;
	}  



////ADVANCE
	$result = DB::select("
	SELECT `bill` bill_no, a.`job_no`, a.`bill_dt`, a.`net_bill`, `received`, `bonus`, 
	`due`,`pay_type`, `ref`, `dt`, a.`user_id` , trix,send,bank,chequeNo,chequeDt, 
	a.id, c.user_name,charge,vat_wav,`card_bank`, `card_no`, `card_type`, `merchant_bank`, a.`ait`, a.note
	FROM `pay` a, user c
	WHERE 
	a.dt between '$from_dt' and '$to_dt'
	and a.user_id = c.user_id and a.pay_type<>'SYS'
	and bill = 'Advance' and a.pay_type = '$pay_type'
	order by bill, a.bill_dt desc;
	;
	");
			
	foreach($result as $item)
	{		$total01 = '0';$net_bill = $item->net_bill; $vat= (int)$net_bill*.1;
?>					<tr>
					<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
					<td style="border: 1px solid black;text-align: center;">{{$item->id}}</td>
					<td style="border: 1px solid black;text-align: center;">{{date('d-M-y', strtotime($item->bill_dt))}}</td> 
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: center;">{{$item->bill_no}}</a></td>
					<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->received}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->bonus}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->vat_wav}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->ait}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->charge}}</td>
					<td style="border: 1px solid black;text-align: center;">{{-$item->due}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->ref}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->trix}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->send}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->bank}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->chequeNo}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->chequeDt}}</td>
					
					<td style="border: 1px solid black;text-align: center;">{{$item->card_bank}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->card_no}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->card_type}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->merchant_bank}}</td>
					
					<td style="border: 1px solid black;text-align: center;">{{$item->dt}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->user_name}}</td>
				</tr>
	<?php
	$sl = $sl+1;
	$total01 = $item->received;
	$total02 = $total01+$total02;
	}  







?>






						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->
						
					</tbody>
				</table>
	


	
<strong>Total {{$pay_type}} Received Amount: Tk. {{number_format(($total02), 2, '.', ',')}}	</strong><br>
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