<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
                    <li class="breadcrumb-item active" aria-current="page">Main Bill</li>
                    <li class="breadcrumb-item active" aria-current="page">Sales Segment</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$segment}}</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
<?php
if($adjust=='return'){$adjust01='Sale Return';}
if($adjust=='discount'){$adjust01='Sale Discount';}
if($adjust=='rework'){$adjust01='Re-work';}
if($adjust=='damage'){$adjust01='Damage to Work';}
if($adjust=='comple'){$adjust01='Complementary';}
if($adjust=='refund'){$adjust01='Advance Refund';}
?>
	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Sales Adjustment: {{$adjust01}} [From Date: {{date('d-M-Y',strtotime($from_dt))}} To: {{date('d-M-Y',strtotime($to_dt))}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example3" class="table table-bordered mb-0"style="width: 700px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>

<?php if($adjust01=='Re-work'){?><th scope="col" style="border: 1px solid black;text-align: center;">Ref Job</th><?php } ?>						
							
							<th scope="col" style="border: 1px solid black;text-align: center;">{{$adjust01}} Amount</th>
						</tr>
					</thead>
					<tbody>				
<?php
if($segment=='Engineering'){$segment='engineering';}
if($segment=='Inter-Company'){$segment='intercompany';}
if($segment=='Automobiles'){$segment='automobile';}

if($adjust=='return')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(sales_return)adjust
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.sales_return<>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work;
");
}
if($adjust=='discount')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(bonus)adjust
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.bonus<>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work;
");
}
if($adjust=='rework')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(rework)adjust, a.rework_ref
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.rework<>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work, a.rework_ref;
");
}
if($adjust=='damage')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(damage_work)adjust
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.damage_work<>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work;
");
}
if($adjust=='comple')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(complementary_work)adjust
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.complementary_work<>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work;
");
}
if($adjust=='refund')
{
$result = DB::select("
SELECT DISTINCT bill,b.bill_dt, a.job_no, b.work, sum(advance_refund)adjust
from pay a, bill_mas b
where a.dt BETWEEN '$from_dt' and '$to_dt'
AND b.work = '$segment'
AND a.advance_refund <>'0'
AND a.bill = b.bill_no
GROUP by bill,b.bill_dt, a.job_no, b.work;
");
}



	$sl = '1';$service = '0';$parts = '0';$sale_amount = '0';		
foreach($result as $item)
		{		
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y',strtotime($item->bill_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill}}">{{$item->job_no}}</a></td>
<?php if($adjust01=='Re-work'){?><th scope="col" style="border: 1px solid black;text-align: center;">{{$item->rework_ref}}</th><?php } ?>						
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->adjust), 2, '.', ',');}}</td>
					</tr>
		<?php
		
		$sl = $sl+1;
		$sale_amount = $item->adjust+$sale_amount;
		}  
?>
					</tbody>
				</table>
				
				
<strong>Total Adjustment Amount: {{number_format(($sale_amount), 2, '.', ',')}}<br></strong>				
				
			
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