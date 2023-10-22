<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")
	||(session('role')=="Store")||(session('role')=="Administrator"))
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
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase </li>
					<li class="breadcrumb-item active" aria-current="page">
					<form  target="_blank" style="display: inline;" action="printPurchase02" method="post">{{ csrf_field() }}
					<input type="hidden" name="dt01" value="{{$dt01}}">
					<input type="hidden" name="dt02" value="{{$dt02}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form></li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Purchase Report with Supplier [From Date: {{date('d-M-Y', strtotime($dt01))}} to {{date('d-M-Y', strtotime($dt02))}}]</h5>
                   
					</div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table border='1' id="example2" class="table table-bordered mb-0" style="font-size: 11px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">PCH</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Suppliers</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Product</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Req.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">GRN</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">QTY</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Rate</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sub Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Grand Total</th>
						</tr>
					</thead>
					<tbody>				
<?php


$amount='0';
$result02 = DB::select("
SELECT a.`purchase_dt` , a.`supplier_id` ,b.supplier_name, 
sum(c.qty*c.rate) Sub_Total FROM `purchase_mas` a, `suppliers` b, `purchase_det` c 
WHERE a.`purchase_dt` BETWEEN '$dt01' AND '$dt02'  
AND a.supplier_id = b.supplier_id AND a.purchase_id=c.purchase_id 
group by a.`purchase_dt` , a.`supplier_id` ,b.supplier_name 
order by a.`purchase_dt`, supplier_name;
	");
foreach($result02 as $item02)
{		
	$supplier_id = $item02->supplier_id;
	$purchase_dt = $item02->purchase_dt;

	$result01 = DB::select("
	SELECT a.`purchase_dt` , a.`supplier_ref` ,a.`purchase_id` , a.`supplier_id` ,b.supplier_name, 
	sum(c.qty*c.rate) Sub_Total FROM `purchase_mas` a, `suppliers` b, `purchase_det` c 
	WHERE 
	a.supplier_id = b.supplier_id AND a.purchase_id=c.purchase_id 
	AND a.supplier_id = '$supplier_id'
	AND a.purchase_dt = '$purchase_dt'
	group by a.`purchase_dt` , a.`supplier_ref` ,a.`purchase_id` , a.`supplier_id` ,b.supplier_name 
	order by a.`purchase_dt`, supplier_name; 
		");
	foreach($result01 as $item01)
	{		
		$purchase_id = $item01->purchase_id;

		$result = DB::select("
		SELECT a.`purchase_dt` bill_dt, a.`supplier_ref` bill_no ,a.`purchase_id` pch, a.`supplier_id` suppliers, 
		b.supplier_name, c.prod_id, c.prod_name product_name, c.req ,c.grn ,c.qty , c.rate , c.qty*c.rate Sub_Total
		FROM `purchase_mas` a, `suppliers` b, `purchase_det` c
		WHERE 
		a.purchase_dt = '$purchase_dt'
		AND a.supplier_id = b.supplier_id
		AND a.purchase_id=c.purchase_id
		AND a.purchase_id='$purchase_id'
		order by bill_dt, supplier_name
		");
			$sl = '1'; 			
		foreach($result as $item)
		{		
		?>				
		<tr>
			<td scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</td>
			<td style="border: 1px solid black;text-align: center;">{{date('d-m-Y', strtotime($item->bill_dt))}}</td>
			<td style="border: 1px solid black;text-align: left;">{{$item->bill_no}}</td>
			<td style="border: 1px solid black;text-align: center;">{{$item->pch}}</td>
		<td style="border: 1px solid black;text-align: center;">[{{$item->suppliers}}] - {{ $item->supplier_name}}</td>
		<td style="border: 1px solid black;text-align: center;">[{{$item->prod_id}}] - {{ $item->product_name}}</td>
			<td style="border: 1px solid black;text-align: center;">{{$item->req}}</td>
			<td style="border: 1px solid black;text-align: center;">{{$item->grn}}</td>
			<td style="border: 1px solid black;text-align: center;">{{$item->qty}}</td>
			<td style="border: 1px solid black;text-align: center;">{{number_format(($item->rate), 2, '.', ',')}}</td>
			<td style="border: 1px solid black;text-align: center;">{{number_format(($item->Sub_Total), 2, '.', ',')}}</td>
			<td style="border: 1px solid black;text-align: center;"></td>
			<td></td>
		</tr>
		<?php
		$sl = $sl+1;
		} 
		?>

		<tr>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;background: aquamarine;">{{number_format(($item01->Sub_Total), 2, '.', ',')}}</td>
		
		</tr>
	<?php
	}
	?>
		<tr>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;"></td>
		<td style="border: 1px solid black;text-align: center;background: cyan;">{{number_format(($item02->Sub_Total), 2, '.', ',')}}</td>
		
		</tr>




<?php
		$amount = $amount+$item02->Sub_Total;

}
?>








					</tbody>
				</table>
				
<strong>Total Purchase Amount: Tk. {{number_format(($amount), 2, '.', ',')}}	</strong>
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