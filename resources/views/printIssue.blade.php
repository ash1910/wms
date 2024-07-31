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
 
 
</style> 
</head>
<script type="text/javascript">
window.print();
window.onfocus=function(){ window.close();}
</script>
<body style="background: white;width:1000px">



<div>
<center>
<img src="assets/images/logo-icon2.png" class="logo-icon" style="width: 300px;"><br>
275, Tejgaon Industrial Area, Dhaka-1208, Phone: 8870818,8870820, Fax: 88-02-8819297<br>
</center>
</div>




	<div class="card border shadow-none">
		<div class="card-header py-3">
			  <div class="row align-items-center g-3">
				<div class="col-12">
				<center>
				  <h5 class="mb-0">Issue Report [From Date: {{date('d-M-Y', strtotime($from_dt))}} to {{date('d-M-Y', strtotime($to_dt))}}]</h5>
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
			<table class="table table-bordered mb-0" style="white-space: normal">
				<thead>
					<tr>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">#</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Date</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Code</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Product</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" style="text-align: center;" scope="col">GIN</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" style="text-align: center;" scope="col">RTN</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Job No.</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Req. No.</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Qty</th>
						<th style="text-align: center;background-color: darkgray;border: 1px solid black;" scope="col">Note</th>
					</tr>
				</thead>
				<tbody>
<!-------------> 
<?php               
		$inHistory01 = DB::table('issue')
			->whereBetween('dt', [$from_dt, $to_dt])
			->orderBy('dt', 'asc')->orderBy('prod_name', 'asc')
			->get(['prod_id','prod_name','gin','qty','req','avg_price','amount','job_no','note','dt']);
$sl = '1';$amount='0';
foreach($inHistory01 as $item)
		{	
?>					
			<tr>
				<th style="text-align: center;border: 1px solid black;" scope="row">{{$sl}}</th>
				<td style="text-align: center;border: 1px solid black;">{{$item->dt}}</td>
				<td style="text-align: center;border: 1px solid black;">{{$item->prod_id}}</td>
				<td style="text-align: left;width: 350px;word-wrap: break-word;border: 1px solid black;">{{$item->prod_name}}</td>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;border: 1px solid black;">{{$item->gin}}</td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;border: 1px solid black;"></td>
<?php } ?>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;border: 1px solid black;">{{$item->gin}}</td>
<?php } ?>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;border: 1px solid black;"></td>
<?php } ?>
				<td style="text-align: center;border: 1px solid black;">{{$item->job_no}}</td>
				<td style="text-align: center;border: 1px solid black;">{{$item->req}}</td>
<?php if($item->qty<0){?>
				<td style="text-align: center;border: 1px solid black;">{{-$item->qty}}</td>
<?php } ?>
<?php if($item->qty>0){?>
				<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
<?php } ?>
				<td style="text-align: center;border: 1px solid black;width: 180px;word-wrap: break-word;">{{$item->note}}</td>
			</tr>
<?php
			$sl = $sl+1;
			$amount = $amount+$item->amount;
		}  
?>
					<tr><td style="background-color: darkgray;border: 1px solid black;"></td>
						<td style="background-color: darkgray;border: 1px solid black;" colspan="8"><strong>Total Issue Amount	</strong></td>
						<td style="text-align: right;background-color: darkgray;border: 1px solid black;" ><strong>TK. {{number_format(intval($amount), 2, '.', ',')}}</strong></td>
					</tr>
				</tbody>
			</table>
				
				
				
			</div>
		</div>
	</div>