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
	@media print 
	{
	  div.divHeader 
	  {
		position: fixed;
		top: 0;
	  }
	  div.divMid 
	  {
	  position: relative;
	  
	  }
	 @page {size: landscape} 
	}
  </style>
</head>
<body onload="window.print()" style="background: white;">



<div style="float: left;width: 0px;">
</div>
<div>
<center>
<img src="assets/images/logo-icon2.png" class="logo-icon" style="width: 300px;"><br>
132 My Street, Kingston, New York 12401 Phone: +1(123)456-789103<br>
</center>
</div>

<center><b>Mobile Financial Services [Settlement Date: {{date('d-M-Y', strtotime($to_dt))}}]</b></center>
<center><b>bKash-01777781{{$mer_bkash}}</b></center>

<div class="col-12 col-lg-12 d-flex">
				<div class="table-responsive" >
				<table id="example2" class="table table-bordered mb-0" style="font-size: 10px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">TRIX</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sender</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">MFS Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Trans. Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement</th>
							
							
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer Info</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Settlement By</th>
						</tr>
					</thead>
					<tbody>				
<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}if (strlen(strstr($agent, 'Firefox')) > 0) {
    $browser = 'firefox';
}
if (strlen(strstr($agent, 'Chrome')) > 0) {
    $browser = 'Chrome';
}

$where_mer_bkash = "";
if( $mer_bkash == "330"){
	$where_mer_bkash = "a.mer_bkash = 330";
}
else{
  $where_mer_bkash = "( a.mer_bkash <> 330 OR a.mer_bkash IS NULL )";
}

$result = DB::select("
SELECT a.`id`, a.`pay_type`, a.`trix`, a.`send`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_vehicle, c.bill_no, a.dt, a.approval_dt, a.check_approval, d.user_name, charge
FROM `pay` a, customer_info b, bill_mas c, user d
WHERE a.customer_id = b.customer_id
and b.customer_id= c.customer_id
and c.job_no = a.job_no
AND a.`pay_check`='1' and a.`pay_type` = 'bkash' and a.approval_dt = '$to_dt' AND $where_mer_bkash 
and a.check_approval = d.user_id
order by a.`id`; 
");
	$sl = '1'; 	$amount='0';	$charge='0';	$amount1='0';		
foreach($result as $item)
		{		
?>				
					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->trix}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->send}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type}}</td>
						<td style="border: 1px solid black;text-align: center;">
						{{number_format(($item->received+$item->charge), 2, '.', ',')}}</td><td style="border: 1px solid black;text-align: center;">
						{{number_format(($item->charge), 2, '.', ',')}}</td><td style="border: 1px solid black;text-align: center;">
						{{number_format(($item->received), 2, '.', ',')}}</td>
						
						
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->job_no}}</a></td>
						<td style="border: 1px solid black;text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
						<br><b>Car Reg.:</b> {{$item->customer_reg}}
						<br><b>Car Name:</b> {{$item->customer_vehicle}}
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->user_name}}</td>
					</tr>




			<?php   
			if($sl=='8')
			{
					echo '<tr><td colspan="9" style="text-align: center;">Page 1 of 2</td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td colspan="9" style="height: 50px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td colspan="9" style="height: 70px;"></td></tr>';
				}			
				?>
						
						
					
	<?php   } ?>





					
					
					
		<?php
		$sl = $sl+1;
        $amount=$amount+$item->received;
        $charge=$charge+$item->charge;
        $amount1=$amount1+($item->received+$item->charge);
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>				
				


Total Transaction Amount:	<b>TK. {{number_format(($amount1), 2, '.', ',')}}</b>&nbsp;&nbsp;&nbsp;&nbsp;
Total Charge Amount:	<b>TK. {{number_format(($charge), 2, '.', ',')}}</b>&nbsp;&nbsp;&nbsp;&nbsp;
Total Settlement Amount:	<b>TK. {{number_format(($amount), 2, '.', ',')}}</b>

<br>
<br>
<center>
<font style="font-size: xx-small;">
*This is a computer-generated Bill / Cash Memo. Design & Developed by Techno Mole Creations (TMC) 
</font>
</center>
							
                          </div>
                         
                    </div>