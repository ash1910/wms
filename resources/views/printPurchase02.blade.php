<!doctype html>
<html lang="en" class="light-theme">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="assets/css/font-roboto.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
  <!--Theme Styles-->
  <link href="assets/css/dark-theme.css" rel="stylesheet" />
  <link href="assets/css/light-theme.css" rel="stylesheet" />
  <link href="assets/css/semi-dark.css" rel="stylesheet" />
  <link href="assets/css/header-colors.css" rel="stylesheet" />
  <title>Workshop Management System</title>
  <style>


@page 
{
  size: A4;
  margin: 30px;
  margin-bottom: 10px;
}   


@media print 
{
  div.divHeader 
  {
    position: fixed;
    bottom: 10px;
  }
  div.divMid 
  {
  position: relative;
  }
}

table td {
word-wrap:break-word;
white-space: normal;
}

</style> 
</head>
<script type="text/javascript">
window.print();
window.onfocus=function(){ window.close();}
</script>
<body style="background-color: #ffff;width:1000px;">



<div>
<center>
<img src="assets/images/logo-icon2.png" class="logo-icon" style="width: 300px;"><br>
132 My Street, Kingston, New York 12401 Phone: +1(123)456-789103<br>
</center>
</div>




	<div class="card border shadow-none">
		<div class="card-header py-3">
			  <div class="row align-items-center g-3">
				<div class="col-12 col-lg-6">
				<center>
				  <h5 class="mb-0">Purchase Report [From Date: {{date('d-M-Y', strtotime($dt01))}} to {{date('d-M-Y', strtotime($dt02))}}]</h5>
				</center>
				</div>
				<!--div class="col-12 col-lg-6 text-md-end">
				  <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
				  <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
				</div-->
			  </div>
		</div>
		
		<div class="card-body">
            <div class="table-responsive">
                
				
<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}if (strlen(strstr($agent, 'Firefox')) > 0) {
    $browser = 'firefox';
}
if (strlen(strstr($agent, 'Chrome')) > 0) {
    $browser = 'Chrome';
}
?>




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
				
				
				
				
				
			
				

<div class="divHeader" style="width:1000px">
    
    <div style="float: left;width: 250px;font-size: small;">
    <center>
    ------------------------------<br>
    Prepared By <br>
    
    </center>
    </div> 
    <div style="float: left;width: 250px;font-size: small;">
    <center>
    ------------------------------<br>
    Purchaser By <br>
    
    </center>
    </div> 
    <div style="float: left;width: 250px;font-size: small;">
    <center>
    ------------------------------<br>
    Store In-charge <br>
    
    </center>
    </div> 
    
    <div style="float: left;font-size: small;width: 250px;"><center>
    ------------------------------<br>
    Approval By <br>
    </center>
    </div>
    
</div>

				
				
				
			</div>
		</div>
	</div>