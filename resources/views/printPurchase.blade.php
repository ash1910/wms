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

$t_amount01= '0';$line = '1';	
foreach($inHistory as $item02)
{	
		$supplier_id = $item02->supplier_id;	
		$inHistory01 = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->where('supplier_id', $supplier_id)->orderBy('purchase_id', 'asc')
			->get(['purchase_id','supplier_id','supplier_ref','purchase_dt']);

	$supplier = DB::select("SELECT `supplier_id`, `supplier_name` FROM `suppliers` WHERE `supplier_id`=$supplier_id;");
	foreach($supplier as $item)
	{ 	
		$supplier_id = $item->supplier_id;$supplier_name = $item->supplier_name;
	}
?>
<strong> Supplier: [{{$supplier_id}}] {{$supplier_name}}</strong><br>		
<?php
$t_amount = '0';			
foreach($inHistory01 as $item01)
		{	$purchase_id = $item01->purchase_id;
			$purchase_dt = $item01->purchase_dt;
			$supplier_id = $item01->supplier_id;	
			$supplier_ref = $item01->supplier_ref;	
?>		
<strong> Supplier's Bill No. : {{$supplier_ref}} 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Entry No: <a href="/purchase02?id={{$purchase_id}}">PCH-{{$purchase_id}}</a>	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Date: {{date('d-M-Y', strtotime($purchase_dt))}}</strong>		
			<table  style="font-size: small;" class="table table-bordered mb-0">
				<thead>
					<tr>
						<th style="text-align: center;background-color: darkgray;" scope="col">#</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Code</th>
						<th style="text-align: center;width: 350px;background-color: darkgray;" scope="col">Product</th>
						<th style="text-align: center;background-color: darkgray;" style="text-align: center;" scope="col">GRN</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Job No.</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Req. No.</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Qty</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Buy (Per Unit)</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Total</th>
					</tr>
				</thead>
				<tbody style="font-size: 12px;">
<?php
$inHistory01 = DB::table('purchase_det')
		->join('bom_prod', 'bom_prod.parts_id', '=', 'purchase_det.prod_id')
		->where('purchase_id',$purchase_id)
		->orderBy('purchase_id', 'asc')->get();
$sl = '1'; $amount='0';
foreach($inHistory01 as $item)
		{ 	$buy = '';				
?>					
			<tr>
				<th style="text-align: center;" scope="row">{{$sl}}</th>
				<td style="text-align: center;">{{$item->prod_id}}</td>
				<td style="text-align: left;">{{$item->prod_name}}</td>
				<td style="text-align: center;">{{$item->grn}}</td>
				<td style="text-align: center;">{{$item->job_no}}</td>
				<td style="text-align: center;">{{$item->req}}</td>
				<td style="text-align: center;">{{$item->qty}}</td>
				<td style="text-align: center;">{{$item->rate}}</td>
				<td style="text-align: right;">{{$item->qty*$item->rate}}</td>
			</tr>
<?php
			
			
			
			if($line=='12')
			{
					echo '<tr><td colspan="5" style="text-align: center;">Page 1 of 2</td></tr>';

				if($browser!='firefox')
				{
					///echo '<tr><td style="height: 460px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					///echo '<tr><td style="height: 480px;"></td></tr>';
				}			
				?>
						
							
							
	<?php 	}			
			
			
			
			$line = $line+1;
			$sl = $sl+1;
			$amount = $amount+($item->qty*$item->rate);
		}  
?>
					<tr><td style="background-color: darkgray;"></td>
						<td style="background-color: darkgray;" colspan="5"><strong>Total Purchase from {{$supplier_name}}	</strong></td>
						<td style="text-align: right;background-color: darkgray;" colspan="4"><strong>TK. {{number_format(($amount), 2, '.', ',')}}</strong></td>
					</tr>



					
					<!--tr>
						<td colspan="3"><strong>Total Amount: Tk.</strong></td>
					</tr-->
				</tbody>
			</table>
				
				
<?php $t_amount = $amount+$t_amount; 
		}$t_amount01 = $t_amount01+$t_amount;
?>
<center>				
	<b>Total Purchase from {{$supplier_name}} : Tk.	{{number_format(($t_amount), 2, '.', ',')}}</b>
</center>				


<?php		
	}?>				
				
				
<center>				
	<h3>Total Purchase Amount: Tk.	{{number_format(($t_amount01), 2, '.', ',')}}</h3>
</center>				
				

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