
@extends("layouts.master")

@section("content")

<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Accounts"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
echo session('role');
}
else {
?>
  <script>
    window.location = "/home";
  </script>
<?php  
}
?>


<main class="page-content">
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
@endif	
 

 <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Approval</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Gate Pass</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Gate Pass Approval</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bonus</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Approval</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT `bill_no`, a.customer_id, a.customer_nm, a.job_no,  sum(b.`net_bill`) total, sum(b.received) received, 
sum(b.bonus) bonus, sum(b.due) due
FROM `bill_mas` a, pay b
WHERE  a.flag = '2'
and a.bill_no = b.bill
group by `bill_no`, a.customer_id, a.customer_nm, a.job_no
;
");
	$sl = '1'; 			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</a></td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{number_format(intval($item->total), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(intval($item->received), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(intval($item->bonus), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(intval($item->due), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: center;">
						
						
					<form style="display: inline;" action="gatePassApproval01" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$item->bill_no}}">
					<button class="btn btn-outline-success px-3" type="submit" name="" value="">
					 Gate Pass</button>
					</form>						
						
						
					</tr>
		<?php
		$sl = $sl+1;

		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
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