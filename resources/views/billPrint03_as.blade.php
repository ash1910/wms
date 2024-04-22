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
	.watermark 
	{
	position: fixed !important;
	top: 300px;
	left: 250px;
	z-index: 1; /* watermark has to be on top of other web content */
	height: 100%;
	width: 100%;
	opacity: 0.3;
	color: BLACK;
	font-size:xxx-large;
	overflow: hidden;
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	}
}


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
  
 
}


@page 
{
  size: A4;
  margin: 30px;
  margin-bottom: 10px;
  
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
<body style="background: white;">
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? ' ' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Taka Only. ' : '') . $get_paise;
}
?>


<div class="divHeader" style="width:710px">

<div style="float: left;width: 0px;">
<img src="assets/images/bkash.png" class="logo-icon" style="width: 70px;">
</div>
<div>
<center>
<img src="assets/images/logo-icon4.png" class="logo-icon" style="width: 300px;"><br>
&emsp;&emsp;275, Tejgaon Industrial Area, Dhaka-1208, Phone: 8870818,8870820, Fax: 88-02-8819297<br>
</center>
</div>

&emsp;&emsp;&emsp;&emsp;&emsp;<font style="font-size: small;">bKash Payment-01777781797</font>
&emsp;&emsp;<b><font style="font-size: large;">BILL/CASH MEMO</font></b>
&emsp;&emsp;&emsp;&emsp;<b>BIN: 004882855-0203</b><br><br>
<center><b>Bill:{{$bill_no}}</b></center>
<?php
$today=date("d-M-Y");		

$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle,
b.customer_chas, `engineer`, `technician`, `job_no`,`job_dt`, `bill_dt`, `user_id`, `net_bill` , driver_mobile, km, email
FROM `bill_mas` a, `customer_info` b
WHERE a.`bill_no` = $bill_no
AND a.customer_id = b.customer_id;
");
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();
		foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $email = $post->email;
				 $driver_mobile = $post->driver_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
				 $engineer = $post->engineer;
				 $technician = $post->technician;
				 $job_no = $post->job_no;
				 $km = $post->km;
				 $job_dt = $post->job_dt;
				 $bill_dt = $post->bill_dt;
				 $user_id = $post->user_id;
			}
			
$result01 = DB::select("
SELECT `full_name` FROM `user` WHERE user_id = $user_id
");
		foreach($result01 as $post01)
			{
				 $full_name = $post01->full_name;
			}


if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}if (strlen(strstr($agent, 'Firefox')) > 0) {
    $browser = 'firefox';
}
if (strlen(strstr($agent, 'Chrome')) > 0) {
    $browser = 'Chrome';
}
		
?>


               <div class="row row-cols-1 row-cols-lg-3">
			   
                 <div style="width: 300px;padding-right: 2px;">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 150px;">
					<table style="font-size: 11px;">
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Date</strong></td><td style="font-style: MS Gothic;"> : {{date('d-M-Y', strtotime($bill_dt))}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Name </strong></td><td style="font-style: MS Gothic;">: {{$customer_nm}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Address </strong></td><td style="font-style: MS Gothic;">:{{$customer_address}}</td></tr>
                    <?php if($customer_mobile!=""){?>   
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Contact </strong></td><td style="font-style: MS Gothic;">: {{$customer_mobile}}</td></tr>
					<?php } ?> 
                   <?php if($email!=""){?>   
					   <tr><td><strong class="text-inverse" style="font-family: Arial;">Email </strong></td><td style="font-style: MS Gothic;">: {{$email}}</td></tr>
					<?php } ?>                
					<?php if($driver_mobile!=""){?>   
					   <tr><td><strong class="text-inverse" style="font-family: Arial;">Attend </strong></td><td style="font-style: MS Gothic;">: {{$driver_mobile}}</td></tr>
					<?php } ?>
					</table>
                    </address>
                 </div>
                 <div style="width: 180px;padding: 0;">
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 150px;">
                    <!--small>to</small-->
                    <table style="font-size: 11px;" >
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Reg</strong></td><td style="font-style: MS Gothic;"> : {{$customer_reg}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Chas </strong></td><td style="font-style: MS Gothic;">: {{$customer_chas}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">KM </strong></td><td style="font-style: MS Gothic;">: {{$km}}</td ></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Model </strong></td><td style="font-style: MS Gothic;line-height: 0.8;">:{{$customer_vehicle}}</td></tr>
					</table>
                   </address>
                </div>
                 <div style="width: 250px;padding-left: 2px;">
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 150px;">
                    <!--small>to</small-->
                    <table style="font-size: 11px;">
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Engineer</strong></td><td style="font-style: MS Gothic;"> : {{$engineer}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Technician </strong></td><td style="font-style: MS Gothic;width: 180px;word-wrap: anywhere;">:{{$technician}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Job No. </strong></td><td style="font-style: MS Gothic;">: <b>{{$job_no}}</b></td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Job Date</strong></td><td style="font-style: MS Gothic;">: {{date('d-M-Y', strtotime($job_dt))}}</td></tr>
					</table>
                   </address>
                </div>                
               </div>
</div>

<div class="divMid" style="margin-top: 290px;">

<div class="col-12 col-lg-8 d-flex">
	<div class="table-responsive" style="width:707px">
			
<?php
	$stock01 = DB::select("
	SELECT sum(`received`) received, sum(`bonus`) bonus, sum(`vat_wav`) vat_wav, 
	sum(`ait`) ait, sum(`due`)due, sum(charge) charge,sum(vat_pro) vat_pro, 
	sum(sales_return) sales_return,sum(advance_refund) advance_refund,sum(complementary_work) complementary_work,
	sum(rework) rework, sum(damage_work) damage_work, sum(supplier_adj) supplier_adj
	FROM `pay` WHERE `bill`=$bill_no;");
	foreach($stock01 as $item01)
		{ 					
				$received = $item01->received;						
				$discount = $item01->bonus;						
				$vat_wav = $item01->vat_wav;						
				$ait = $item01->ait;						
				$vat_pro = $item01->vat_pro;						
				$due = $item01->due;						
				$charge = $item01->charge;	

				$sales_return = $item01->sales_return;	
				$advance_refund = $item01->advance_refund;	
				$complementary_work = $item01->complementary_work;	
				$rework = $item01->rework;	
				$damage_work = $item01->damage_work;	
				$supplier_adj = $item01->supplier_adj;	
				
		} 
?>					
				
				
				
	<table  style="font-size: small;"><div class="watermark"><center><b>
			<?php if($due>1){	?>
				DUE
				
				<?php  $pay_type='';
				$stock02 = DB::select("
				SELECT `job_no` pay_type FROM `cheque_pending` WHERE `job_no`='$job_no' AND `flag`='0'
				");
				foreach($stock02 as $item02){$pay_type = $item02->pay_type;}
				if($pay_type!=''){echo '<br>Cheque In Hand';}
				?>
				
			<?php }?>
			<?php if($due<1){	?>
				Paid
			<?php }?>

				</b></center></div>
					
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Qty</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
					
					<tbody>
					
<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parts</strong></td></tr>
					
<?php
	$stock = DB::select("SELECT count(*) count FROM `bill_det` WHERE `bill_no`='$bill_no';");
    foreach($stock as $item)
		{ $count = $item->count;}
		$page_no='0';
		if($count>'0'){$page_no='1';}
		if($count>24){$page_no='2';}
		if($count>50){$page_no='3';}
		if($count>75){$page_no='4';}

	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '1' and `bill_no`='$bill_no';");
	$row='0'; $sl="1"; $subtotal="0";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row" style="text-align: center;border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
						<td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
					</tr>
			<?php   
			if($sl=='24')
			{
					echo '<tr><td colspan="5" style="text-align: center;">Page 1 of '.$page_no.' </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 450px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 470px;"></td></tr>';
				}			
				?>
						
							<tr style="background: darkgrey;">
								<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
								<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
								<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
								<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
								<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
							</tr>					
					
	<?php   }
			if($sl=='50')
			{
					echo '<tr><td colspan="5" style="text-align: center;">Page 2 of '.$page_no.' </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 450px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 470px;"></td></tr>';
				}			
				?>
						
							<tr style="background: darkgrey;">
								<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
								<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
								<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
								<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
								<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
							</tr>					
					
	<?php   }	
	
	
		$row = $sl;
		$sl = $sl+1;
		$subtotal=$subtotal+$item->amount;
		}  
				
?>
<tr><td colspan="2" style="border: 1px solid black;"></td>
<td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>
<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</strong></td></tr>
<?php
//////////////////////////////////////////////////////////Service////////////////////////////////////////////////////////////////////////
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '2' and `bill_no`=$bill_no;");
	$row1=$row+1; $sl="1"; $subtotal01="0";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row" style="text-align: center;border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
						<td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
					</tr>
		<?php 
		$row1 = $sl+$row;
		if($row1=='24')
		{
					echo '<tr><td colspan="5" style="text-align: center;">Page 1 of '.$page_no.' </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 450px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 470px;"></td></tr>';
				}			
			?>
					
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
					
		<?php
		}
		
		if($row1=='46')
		{
					echo '<tr><td colspan="5" style="text-align: center;">Page 2 of '.$page_no.' </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 450px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 470px;"></td></tr>';
				}			
			?>
					
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
					
		<?php
		}		
		if($row1=='75')
		{
					echo '<tr><td colspan="5" style="text-align: center;">Page 3 of '.$page_no.' </td></tr>';

				if($browser!='firefox')
				{
					echo '<tr><td style="height: 450px;"></td></tr>';
				}
				if($browser=='firefox')
				{
					
					echo '<tr><td style="height: 470px;"></td></tr>';
				}			
			?>
					
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
					
		<?php
		}		
		
		
		
		
		
		
		
		
		
		$sl = $sl+1;
		$subtotal01=$subtotal01+$item->amount;
		}  
		?>			












			
<tr><td colspan="2" style="border: 1px solid black;"></td>
<td colspan="2" style="border: 1px solid black;text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal01), 2, '.', ',')}}</strong></td></tr>

				
						<tr><td colspan="2" style="max-width: 200px;font-size: smaller;">IN WORDS: <?php 
						 $total = $subtotal+$subtotal01;
						 $vat= $total/10;
						 
							
						 
						echo AmountInWords($total+$vat-$discount-$vat_wav)?></td>
							<td colspan="2"><strong>Total TK:</strong></td><td style="text-align: right;"><strong>
							<?php echo number_format(($total), 2, '.', ','); ?>
							</strong></td>
						</tr>
						<tr><td colspan="2" >
<strong>I hereby, take this vehicle with proper Checkup & Test drive.</strong>
</td>
							<td colspan="2"><strong>VAT: </strong></td><td style="text-align: right;"><strong>
							+<?php echo number_format(($vat), 2, '.', ','); ?></td>
							</strong></td>
						</tr>
						<tr><td colspan="2" >
<strong>Now this vehicle is okey & I am satisfy with this service.</strong>
						    
						</td>
							<td colspan="2"><strong>Bill Tk.: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($total+$vat), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>

						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Discount: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($discount+$vat_wav), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
						
<?php if($sales_return>0){ ?>						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Sale Return: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($sales_return), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } ?>

<?php if($complementary_work>0){ ?>						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Complementary Work: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($complementary_work), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } ?>
<?php if($rework>0){ ?>						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Rework: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($rework), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } ?>
<?php if($damage_work>0){ ?>						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Damage Work: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($damage_work), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } 

    $pay_type_refund='';
	$stock04 = DB::select("SELECT sum(due) due FROM `pay` WHERE `bill`='$bill_no' and pay_type = 'A/C Refund' AND ref is not null;");
	foreach($stock04 as $item04)
		{ 					
			$pay_type_refund = $item04->due;						
		}			

if($pay_type_refund!='')
{?>
                        <tr><td colspan="2" ></td>
							<td colspan="2" style="white-space: unset;"><strong>

					 A/C Refund: </strong></td><td style="text-align: right;"><strong>
							
							<?php 
							echo number_format(($pay_type_refund), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>
<?php
}
?>

						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Net Bill: </strong></td><td style="text-align: right;border-top: 1px solid black;"><strong>
							<?php 
							echo number_format(($total+$vat-$discount-$vat_wav+$pay_type_refund), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>
						
<?php		$pay_type='';$pay_type_adj='';				
			$stock03 = DB::select("SELECT `pay_type` FROM `pay` WHERE `bill`='$bill_no';");
			foreach($stock03 as $item03)
				{ 					
					$pay_type = $item03->pay_type;						
					if($pay_type=='Adj-Cust')
					{$pay_type_adj='2';}
				}
				if($pay_type_adj=='2'){
					
			$stock04 = DB::select("SELECT `pay_type`, due FROM `pay` WHERE `bill`='$bill_no' and pay_type='Adj-Cust'");
			foreach($stock04 as $item04)
				{ 					
					
					
					
?>						
						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Adj with Automobile: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($item04->due), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
				<?php } } ?>
						
						
						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Paid Tk.: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($received+$charge+$pay_type_refund), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>
						
<?php if($supplier_adj>0){ ?>						
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>Adj. with Supplier: </strong></td><td style="text-align: right;"><strong>
							-
							<?php 
							echo number_format(($supplier_adj), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } ?>						

<?php if($ait!='0'){ ?>
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>AIT Tk.: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($ait), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>
<?php } ?>

<?php if($vat_pro!='0'){ 
		$checkVat = '';
		$data01 = DB::select("SELECT `job_no` FROM `vat_pro` WHERE job_no='$job_no' and flag='1'");
		foreach($data01 as $item05){ $checkVat = $item05->job_no; }		 
?>
						<tr><td colspan="2" ></td>
							<td colspan="2"><strong style="font-size: smaller;">VAT 
							<?php if($checkVat==''){ echo 'Provision:';}
							 if($checkVat!=''){ echo 'Collect:';} ?>

							</strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($vat_pro), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>
<?php } ?>

<?php if($advance_refund<0){ 

			$acrefund = ''; $ac_refund='0';
			$stock03 = DB::select("SELECT `pay_type` FROM `pay` WHERE `bill`='$bill_no';");
			foreach($stock03 as $item03)
				{ 					
					$acrefund = $item03->pay_type;						
					if($acrefund=='A/C Refund')
					{$ac_refund='1';}
				}


?>						
						<tr><td colspan="2" ></td>
							<td colspan="2" style="white-space: unset;"><strong>
							<?php 
					if($ac_refund=='0'){echo 'Cash';}
					if($ac_refund=='1'){echo 'Ledger';}
					?> Refund: </strong></td><td style="text-align: right;"><strong>
							
							<?php 
							echo number_format(($advance_refund), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>	
<?php } ?>



						<tr><td colspan="2" ></td>
							<td colspan="2"><strong>
<?php if($due<0){?>
							Payable
<?php } else { ?>
							Due
<?php } ?>
							: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(($due), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>


						
					</tbody>
				</table>


<div style="float: left;width: 25%;font-size: small;">
<center>
------------------------------<br>
Prepared By <br>
{{$full_name}}
</center>
</div>

<div style="float: left;width: 25%;font-size: small;"><center>
------------------------------<br>
Approved By <br>
</center>
</div>

<div style="float: none;width: 25%;font-size: small;"><center>
------------------------------<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received By <br>
</center>
</div>


<br>
<center>
<font style="font-size: xx-small;">
*This is a computer-generated Bill / Cash Memo. Design & Developed by Techno Mole Creations (TMC) 
</font>
</center>
							
                          </div>
                         
                    </div>
				</div>
				
				
				
				



 
