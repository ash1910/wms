
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
                    <li class="breadcrumb-item active" aria-current="page">Money Receipt Print</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Job No: {{$job_no}}</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
                
					
<?php

$result = DB::select("
SELECT `bill` bill_no, a.`job_no`, b.customer_nm, a.`bill_dt`, a.`net_bill`, `received`, `bonus`, `due`,
`pay_type`, `ref`, `dt`, a.`user_id` , trix,send,bank,chequeNo,chequeDt, b.bill_dt,a.id, c.user_name,
a.`bonus`, a.`vat_wav`, a.`ait`
FROM `pay` a, bill_mas b, user c
WHERE 
a.job_no = b.job_no
AND a.`job_no` = '$job_no'
and a.user_id = c.user_id and a.pay_type<>'SYS'
order by id,bill, a.bill_dt desc
;
");
	$sl = '1'; 	$total02 = '0';		
foreach($result as $item)
		{		;
?>					
              <div class="col">
<?php 
		$deny='0';
		$result02 = DB::select("SELECT * FROM `cheque_pending` WHERE `job_no` = '$item->job_no' AND `chequeNo` = '$item->chequeNo' AND `bank`='$item->bank' AND `chequeDt`='$item->chequeDt' and `confirm` = '2'");
		foreach($result02 as $item02)
			{		
				$deny = '1';
			}
if($deny=='0')
{
	echo '<div class="card border shadow-none bg-light radius-10">';
}
if($deny=='1')
{
	echo '<div class="card border shadow-none bg-Warning radius-10">';
}
?>			  
                
				
                  <div class="card-body text-left">
                    
                     <p class="mb-0"><b>Customer: {{$item->customer_nm}}</b></p>
                     <p class="mb-0"><b><a href="report02?bill={{$item->bill_no}}">Bill No: {{$item->bill_no}}</b></a></p>
                     <p class="mb-0"><b>Receive No:</b> {{$item->id}}</p>
                     <p class="mb-0"><b>Bill Date:</b> {{$item->bill_dt}}</p>
                     <p class="mb-0"><b>Received Date:</b> {{$item->dt}}</p>
                     <p class="mb-0"><b>Type:</b> {{$item->pay_type}}</p>
                     <p class="mb-0"><b>Received:</b> {{$item->received}}</p>
                     <p class="mb-0"><b>Discount:</b> {{$item->bonus}}</p>
                     <p class="mb-0"><b>Vat Waiver:</b> {{$item->vat_wav}}</p>
                     <p class="mb-0"><b>AIT Deduction:</b> {{$item->ait}}</p>
                     <p class="mb-0"><b>Receive By:</b> {{$item->user_name}}</p>
		
<div class="row row-cols-1 row-cols-3">		
	<form class="row g-3" action="moneyReceipt02" method='post' target="_blank">{{ csrf_field() }}
		<div class="col">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$item->bill_no}}">
		<input type="hidden" name="job_no" value="{{$item->job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
		</div>
	</form>		

  <form class="row g-3" action="moneyReceipt06" method='post' target="_blank">{{ csrf_field() }}
		<div class="col">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$item->bill_no}}">
		<input type="hidden" name="job_no" value="{{$item->job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> PDF</button>
		</div>
	</form>

  <form class="row g-3" action="moneyReceipt06?image=1" method='post' target="_blank">{{ csrf_field() }}
		<div class="col">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$item->bill_no}}">
		<input type="hidden" name="job_no" value="{{$item->job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Image</button>
		</div>
	</form>

</div>

		
				  </div>
                </div>
              </div>
		
		
<?php } ?>

						
				
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