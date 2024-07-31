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
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
@endif	
 

 <!--breadcrumb-->
             <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">VAT </li>
                    <li class="breadcrumb-item active" aria-current="page">VDS</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Vat Deducted at Source List</h5>
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
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bin</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Buyer Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Value</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Deducted VAT</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Challen No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Challen Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">VDS No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">VDS Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Tax Deposit Date</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT `bin`, `chalan6no`, `chalan6dt`, `taxdt`, `chalan3no`, `chalan3dt`, `job_no`,
 `vat_pro`, `customer_nm`, `total`, `dt`, `user_id`, `flag` FROM `vat_pro` WHERE dt is not null;
");
	$sl = '1';$amount='0'; 			
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$item->job_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->bin}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->total}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->vat_pro}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chalan3no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chalan3dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chalan6no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->chalan6dt}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->taxdt}}</td>
											
						
						
					</tr>
		<?php
		$sl = $sl+1;
		$amount=$amount+$item->vat_pro;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total VAT Provision Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
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