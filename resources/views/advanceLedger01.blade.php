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

$result02 = DB::select("
SELECT `customer_reg`,`customer_nm`,`customer_vehicle` 
FROM `customer_info` WHERE `customer_id` = '$id'
");
foreach($result02 as $item02)
		{
			$customer_reg=$item02->customer_reg;
			$customer_nm=$item02->customer_nm;
			$customer_vehicle=$item02->customer_vehicle;
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
                <b>C/N: {{$customer_nm}}</b><br>
                <b>Car Reg.:</b> {{$customer_reg}}<br>
                <b>Car Name:</b> {{$customer_vehicle}}
				<table id="example3" class="table table-bordered mb-0" style="width: 100%;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;"></th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received Detail</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Adjustment Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Use Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Debit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Credit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Balance</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Source Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT a.`dt`, a.`job_no`, a.`bill`,-a.`due` Credit , note, bank,chequeNo,chequeDt,pay_type,trix,send,received_org,id,card_bank,card_no,card_type  
FROM `pay` a
WHERE a.`customer_id` = '$id' 
AND a.`ref`='Advance' AND a.distributed_from_pay_id IS NULL;
");
//AND a.`ref`='Advance' AND a.pay_type<>'A/C Refund';
	$sl = '1'; 	$balance='0';	$done='';	
foreach($result as $item)
		{
			if( (float)$item->received_org > 0 ){
				$credit = $item->received_org;
			}
			else{
				$credit = $item->Credit;
			}

			$balance=$balance+$credit;
			$job_no=$item->job_no;
			$bill=$item->bill;
?>				
			<tr>
				<td style="border: 1px solid black;text-align: center;"></td>
				<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
				<td style="border: 1px solid black;text-align: left;">
				    
<?php if($item->pay_type=='cheque'){ ?> <b>Payment Type:</b> {{$item->pay_type}}<br><b>Bank:</b>{{$item->bank}}<br><b>Cheque No:</b>{{$item->chequeNo}}<br><b>Cheque Date:</b>{{$item->chequeDt}}<br> <?php } ?>	    
<?php if($item->pay_type=='bkash'){ ?> <b>Payment Type:</b> {{$item->pay_type}}<br><b>Trix:</b>{{$item->trix}}<br><b>Send:</b>{{$item->send}}<br> <?php } ?>	    
<?php if($item->pay_type=='card'){ ?> <b>Payment Type:</b> {{$item->pay_type}}<br><b>Card Bank:</b>{{@$item->card_bank}}<br><b>Card No:</b>{{@$item->card_no}}<br><b>Card Type:</b>{{@$item->card_type}}<br> <?php } ?>	    
<?php if($item->pay_type=='cash'){ ?> <b>Payment Type:</b> {{$item->pay_type}}<br> <?php } ?>	  
                </td>			
				<td style="border: 1px solid black;text-align: center;"></td>
				<td style="border: 1px solid black;text-align: center;"></td>
				<td style="border: 1px solid black;text-align: center;"></td>
				<td style="border: 1px solid black;text-align: center;">{{number_format(($credit), 2, '.', ',');}}</td>
				<td style="border: 1px solid black;text-align: center;">{{number_format(($balance), 2, '.', ',');}}</td>
				<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
			</tr>

			@if($job_no != 'Advance' && $bill != 'Advance')  <?php $balance=$balance-$credit; ?>
				<tr>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: left;"></td>			
					<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
					<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$job_no}}">{{$job_no}}</a></td>
					
					<td style="border: 1px solid black;text-align: center;">{{number_format(($credit), 2, '.', ',');}}</td>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: center;">{{number_format(($balance), 2, '.', ',');}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item->note}}</td>
				</tr>

			@endif

			<?php if( (float)$item->received_org > 0 ){  

				$result01 = DB::select("
				SELECT `dt`, -`due` Credit, `job_no`, `note` FROM `pay` 
				WHERE `distributed_from_pay_id` = '$item->id'
				");
				foreach($result01 as $item01){

				$credit = $item01->Credit;
				$balance=$balance-$credit; 
				$job_no=$item01->job_no;
			?>
				<tr>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: left;"></td>			
					<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item01->dt))}}</td>
					<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$job_no}}">{{$job_no}}</a></td>
					
					<td style="border: 1px solid black;text-align: center;">{{number_format(($credit), 2, '.', ',');}}</td>
					<td style="border: 1px solid black;text-align: center;"></td>
					<td style="border: 1px solid black;text-align: center;">{{number_format(($balance), 2, '.', ',');}}</td>
					<td style="border: 1px solid black;text-align: center;">{{$item01->note}}</td>
				</tr>

			<?php } }?>
		<?php





		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total Amount	TK. {{number_format(($balance), 2, '.', ',')}}</strong>				
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