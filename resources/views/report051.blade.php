
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
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Receivable Reports [Company: {{$company}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example2" class="table table-bordered mb-0" style="width: 70%;" >
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sister Company</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
						</tr>
					</thead>
					<tbody>				
<?php

if($company!="")
{
    $result = DB::select("
		SELECT   sum(due)due, company, sister_companies
		from
		(
		SELECT b.customer_id customer_id ,b.customer_nm customer_nm, c.customer_reg customer_reg, 
		c.customer_chas customer_chas, c.company,c.sister_companies,
		sum(a.`due`) due
		FROM `pay` a, bill_mas b, customer_info c
		WHERE 
		a.bill = b.bill_no
		and b.customer_id = c.customer_id 
		and c.company = '$company' 
		GROUP by customer_id, customer_nm,customer_reg,customer_chas, c.company, c.sister_companies
		) A
		where due > 0
		group by company, sister_companies
    ;
    ");
}
if($company=="")
{
    $result = DB::select("
    SELECT sister_companies, due
    from
    (
    SELECT c.sister_companies sister_companies, sum(a.`due`) due
    FROM `pay` a, bill_mas b, customer_info c
    WHERE 
    a.bill = b.bill_no
    and b.customer_id = c.customer_id 
    and c.company is null
    GROUP by c.sister_companies
    ) A
    where due > 0
    order by sister_companies
    ;
    ");
}




	$sl = '1'; 	$total02 = '0';		
foreach($result as $item)
		{		$total01 = '0';
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;"><a href="report052?company={{urlencode($company)}}&&sister_companies={{urlencode($item->sister_companies)}}">{{$item->sister_companies}}</a></td>
						<td style="border: 1px solid black;text-align: center;"><a href="report052?company={{urlencode($company)}}&&sister_companies={{urlencode($item->sister_companies)}}">{{number_format(intval($item->due), 2, '.', ',')}}</a></td>
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