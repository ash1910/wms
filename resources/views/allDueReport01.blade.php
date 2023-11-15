<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")||(session('role')=="Executive"))
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
                    <li class="breadcrumb-item active" aria-current="page">All Due Report </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">All Due Report [{{$supplier_id}}]
					  From: {{date('d-M-Y', strtotime($from_dt))}} To: {{date('d-M-Y', strtotime($to_dt))}}
					  </h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example3" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Register</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bil No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bonus</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vehicle</th>
						</tr>
					</thead>
					<tbody>				
<?php
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query

if(($supplier_id!="")&&(($from_dt=="")&&($to_dt=="")))
{
    $result = DB::select("
    select bill_no,ref,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt,charge,customer_reg,
    customer_vehicle
    from
    (
    SELECT `bill` bill_no, p.ref,p.`job_no`, bm.customer_nm, bm.bill_dt,customer_reg,customer_vehicle,
    sum(p.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav, sum(charge) charge
    FROM `pay` p
    INNER JOIN
    `bill_mas` bm 
    ON p.`bill` = bm.`bill_no` and bm.`flag`<>'0' 
    INNER JOIN
    `customer_info` c
    ON
    c.`customer_id`=bm.`customer_id` and p.`customer_id`=c.`customer_id`
    GROUP by bill,job_no,customer_nm,bm.bill_dt,customer_reg,customer_vehicle
    )A
    where due > 1 AND A.`ref`<>'SYS' 
    AND A.customer_nm='$supplier_id'
    order by bill_dt,customer_nm
    ");
}
if(($supplier_id=="")&&(($from_dt=="")&&($to_dt=="")))
{
    $result = DB::select("
    select bill_no,ref,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt,charge,customer_reg,
    customer_vehicle
    from
    (
    SELECT `bill` bill_no, p.ref,p.`job_no`, bm.customer_nm, bm.bill_dt,customer_reg,customer_vehicle,
    sum(p.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav, sum(charge) charge
    FROM `pay` p
    INNER JOIN
    `bill_mas` bm 
    ON p.`bill` = bm.`bill_no` and bm.`flag`<>'0' 
    INNER JOIN
    `customer_info` c
    ON
    c.`customer_id`=bm.`customer_id` and p.`customer_id`=c.`customer_id`
    GROUP by bill,job_no,customer_nm,bm.bill_dt,customer_reg,customer_vehicle
    )A
    where due > 1  AND A.`ref`<>'SYS' 
    
    order by bill_dt,customer_nm
    ");
}
if(($supplier_id!="")&&(($from_dt!="")&&($to_dt!="")))
{
    $result = DB::select("
    select bill_no,ref,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt,charge,customer_reg,
    customer_vehicle
    from
    (
    SELECT `bill` bill_no, p.ref,p.`job_no`, bm.customer_nm, bm.bill_dt,customer_reg,customer_vehicle,
    sum(p.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav, sum(charge) charge
    FROM `pay` p
    INNER JOIN
    `bill_mas` bm 
    ON p.`bill` = bm.`bill_no` and bm.`flag`<>'0' 
    INNER JOIN
    `customer_info` c
    ON
    c.`customer_id`=bm.`customer_id` and p.`customer_id`=c.`customer_id`
    GROUP by bill,job_no,customer_nm,bm.bill_dt,customer_reg,customer_vehicle
    )A
    where due > 1 AND (date(A.bill_dt) BETWEEN '$from_dt' AND '$to_dt') AND A.`ref`<>'SYS' 
    AND A.customer_nm='$supplier_id'
    order by bill_dt,customer_nm
    ");
}
if(($supplier_id=="")&&(($from_dt!="")&&($to_dt!="")))
{
    $result = DB::select("
    select bill_no,ref,job_no,customer_nm,net_bill,received,bonus,due,vat_wav,bill_dt,charge,customer_reg,
    customer_vehicle
    from
    (
    SELECT `bill` bill_no, p.ref,p.`job_no`, bm.customer_nm, bm.bill_dt,customer_reg,customer_vehicle,
    sum(p.`net_bill`) net_bill, sum(`received`) received, sum(`bonus`) bonus, sum(`due`) due, sum(`vat_wav`) vat_wav, sum(charge) charge
    FROM `pay` p
    INNER JOIN
    `bill_mas` bm 
    ON p.`bill` = bm.`bill_no` and bm.`flag`<>'0' 
    INNER JOIN
    `customer_info` c
    ON
    c.`customer_id`=bm.`customer_id` and p.`customer_id`=c.`customer_id`
    GROUP by bill,job_no,customer_nm,bm.bill_dt,customer_reg,customer_vehicle
    )A
    where due > 1 AND (date(A.bill_dt) BETWEEN '$from_dt' AND '$to_dt') AND A.`ref`<>'SYS' 
    
    order by bill_dt,customer_nm
    ");
}

	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>

						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->bill_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_reg}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>

						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->ref}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->received}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->bonus}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->due}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->vat_wav}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->charge}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_vehicle}}</td>
						
					</tr>
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->due;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
<strong>Total Due Amount	TK. {{number_format(($amount), 2, '.', ',')}}</strong>				
<br>				
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