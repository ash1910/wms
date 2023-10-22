<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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


@extends("layouts.master")

@section("content")
<?php 
$parts_info = DB::table('bom_prod')->get();

$data01 = DB::select("
SELECT `avg_price`,`amount`,`stock_qty` FROM `bom_prod` WHERE `parts_id` = '$product_id'
");			
foreach($data01 as $item)
		{	
			$avg_price = $item->avg_price;
			$amount = $item->amount;
			$stock_qty = $item->stock_qty;
		}
?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Product Ledger</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
			
@if(session()->has('alert'))
    <div class="alert alert-danger">
        {{ session()->get('alert') }}
    </div>
@endif				

<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-5">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<form class="row g-3" action="productLedger01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Product: </strong></td>
						<td><input autofocus name="product" type="text" id="tags" required style="width: 100%;"></td>
						<td><button class="btn btn-success" type="submit" name="next" value="next">
						<i class="lni lni-chevron-right-circle"></i> Ledger</button></td>
					</tr>
				</table>	
			</form>
			</div>
		</div>
	</div>
</div>			
<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-12">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<center><h5>{{$product}}</h5></center>

<div class="row">

	<div class="col-12 col-lg-4">
			Current Stock Qty: {{$stock_qty}}<br>
	</div>
	<div class="col-12 col-lg-4">
			Rate Per Unit: {{$avg_price}}<br>
	</div>
	<div class="col-12 col-lg-4">
			Total Value: {{$amount}}
	</div>
</div>
			
<div class="row">			
			
	<div class="col-12 col-lg-6">
		<div class="card shadow-none border">
			<div class="card-body">
			<center><b>Purchase</b></center>

			<div class="table-responsive">
				<table id="example2" class="table table-bordered mb-0" style="font-size: 11px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">PID</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Supplier</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">GRN</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Qty</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Rate</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
						</tr>
					</thead>
					<tbody>				
						<?php
						$result = DB::select("
SELECT b.`prod_id`, b.`prod_name`,b.`qty` qty, b.`amount` amount, ((b.`amount`)/(b.`qty`)) rate,
a.`purchase_dt`, a.supplier_id, c.supplier_name, b.purchase_id, b.grn, a.supplier_ref
FROM `purchase_mas` a, `purchase_det` b, suppliers c
WHERE a.purchase_id = b.purchase_id and b.`prod_id` = '$product_id'
AND a.supplier_id = c.supplier_id order by a.`purchase_dt` desc
						");
						$qty01='0';				
						foreach($result as $item)
								{		
						?>				
						<tr>
							<td style="border: 1px solid black;text-align: center;">{{date('d-m-Y', strtotime($item->purchase_dt))}}</td>
							<td style="border: 1px solid black;text-align: center;"><a href="purchase02?id={{$item->purchase_id}}">{{$item->purchase_id}}</a></td>
							<td style="border: 1px solid black;text-align: left;">{{$item->supplier_id}} - {{$item->supplier_name}}</td>
							<td style="border: 1px solid black;text-align: center;">{{$item->supplier_ref}}</td>
							<td style="border: 1px solid black;text-align: center;">{{$item->grn}}</td>
							<td style="border: 1px solid black;text-align: center;">{{$item->qty}}</td>
							<td style="border: 1px solid black;text-align: center;">{{number_format((round($item->rate,2)), 2, '.', ',')}}</td>
							<td style="border: 1px solid black;text-align: center;">{{number_format((round($item->amount,2)), 2, '.', ',')}}</td>
						</tr>
						<?php
						$qty01 = $qty01+$item->qty;

						}  
						?>
					</tbody>
				</table>
				<br>
				Total Purchase Qty: {{$qty01}}
				<br>				
             </div>






			</div>
		</div>
	</div>	

	<div class="col-12 col-lg-6">
		<div class="card shadow-none border">
			<div class="card-body">
			<center><b>Issue</b></center>


			<div class="table-responsive">
				<table class="table table-bordered mb-0" style="font-size: 11px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Req No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">GIN</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Qty</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Rate</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
						</tr>
					</thead>
					<tbody>				
						<?php
						$result = DB::select("

						SELECT `gin`,`qty`,`avg_price`,`amount`,`job_no`,`dt`,`req`
						FROM `issue` 
						WHERE `prod_id` = '$product_id'
						order by id desc
						");
								$amount='0';$qty='0';		
						foreach($result as $item)
								{		
						?>				
						<tr>
							<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
							<td style="border: 1px solid black;text-align: center;"><a href="report02?job_no={{$item->job_no}}">{{$item->job_no}}</a></td>
							<td style="border: 1px solid black;text-align: center;">{{$item->req}}</td>
							<td style="border: 1px solid black;text-align: center;">{{$item->gin}}</td>
							<td style="border: 1px solid black;text-align: center;">{{$item->qty}}</td>
							<td style="border: 1px solid black;text-align: center;">{{number_format((round($item->avg_price,2)), 2, '.', ',')}}</td>
							<td style="border: 1px solid black;text-align: center;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						</tr>
						<?php
						$amount = $amount+$item->amount;
						$qty = $qty+$item->qty;
						}  
						?>
					</tbody>
				</table>
				<br>
				Total Issue Qty: {{$qty}}
				<br>				
             </div>


			</div>
		</div>
	</div>		
</div>			
			
			
			
			
			
			
			
			</div>
		</div>
	</div>
</div>



			
</main>
@endsection		 





@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($parts_info as $p) 
{
echo '"'.$p->parts_id.' - '.$p->parts_name.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 
 
 
 <script type="text/javascript">

    $(function() {

        $( "#datepicker" ).datepicker({ 
            changeYear: true,
            minDate: '-2D',
            maxDate: '+0D',
        });
    });


</script>



<script>
function validateForm() {
  let x = document.forms["myForm"]["dt"].value;
  if (x == "") {
    alert("Date must be filled out");
    return false;
  }
}
</script>
 
 @endsection
 
 
 
 
 @section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection
