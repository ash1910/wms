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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
275, Tejgaon Industrial Area, Dhaka-1208, Phone: 8870818,8870820, Fax: 88-02-8819297<br>
</center>
</div>

<center><b>Card [Settlement Date: {{date('d-M-Y', strtotime($s_dt))}}]</b></center>
<center><b>Debit A/C: @if($merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($merchant_bank == 'CBL') HAS-MTBL-7814 @endif</b></center>

<div class="col-12 col-lg-12 d-flex">
				<div class="table-responsive" >
				<table id="example2" class="table table-bordered mb-0" style="font-size: 10px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Transaction Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card's Bank</th>
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

$where_merchant_bank = "";
if( $merchant_bank == "CBL"){
	$where_merchant_bank = "a.merchant_bank = 'CBL'";
}
else{
  $where_merchant_bank = "( a.merchant_bank <> 'CBL' OR a.merchant_bank IS NULL )";
}

$result = DB::select("
SELECT a.`id`, a.`card_type`, a.`card_bank`, a.`card_no`, `received`, `due`, a.`job_no`, b.customer_nm ,
b.customer_reg,b.customer_vehicle, c.bill_no, a.dt, a.approval_dt, a.check_approval, d.user_name, charge
FROM `pay` a, customer_info b, bill_mas c, user d
WHERE a.customer_id = b.customer_id
and b.customer_id= c.customer_id
and c.job_no = a.job_no
AND a.`pay_check`='1' and a.`pay_type` = 'card' 
and a.approval_dt = '$s_dt' AND $where_merchant_bank 
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
						<td style="border: 1px solid black;text-align: center;">****{{$item->card_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_type}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->card_bank}}</td>
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
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}if (strlen(strstr($agent, 'Firefox')) > 0) {
    $browser = 'firefox';
}
if (strlen(strstr($agent, 'Chrome')) > 0) {
    $browser = 'Chrome';
}			
			
			if($sl=='7')
			{
					echo '<tr><td colspan="5" style="text-align: center;">Page 1 </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 150px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 170px;"></td></tr>';
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
<center>
<font style="font-size: xx-small;">
*This is a computer-generated Bill / Cash Memo. Design & Developed by Techno Mole Creations (TMC) 
</font>
</center>
<br></br>							
<br></br>							
<br></br>							
                          </div>
                         
                    </div>