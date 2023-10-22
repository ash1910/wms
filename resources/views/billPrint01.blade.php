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
</head>
<body onload="window.print()" style="background: white;">


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

<div style="float: left;width: 0px;">
<img src="assets/images/bkash.png" class="logo-icon" style="width: 70px;">
</div>
<div>
<center>
<img src="assets/images/logo-icon2.png" class="logo-icon" style="width: 300px;"><br>
275, Tejgaon Industrial Area, Dhaka-1208, Phone: 8870818,8870820, Fax: 88-02-8819297<br>
</center>
</div>

&emsp;&emsp;&emsp;&emsp;&emsp;<font style="font-size: small;">bKash Payment-01777781797</font>
&emsp;&emsp;<b><font style="font-size: large;">BILL/CASH MEMO</font></b>
&emsp;&emsp;&emsp;&emsp;<b>BIN: 000445917-0203</b><br><br>
<center><b>Bill:{{$bill_no}}</b></center>
<?php
$today=date("d-M-Y");		

$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle,
b.customer_chas, `engineer`, `technician`, `job_no`, `bill_dt`, `user_id`, `net_bill` , driver_mobile, km, job_dt
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
				 $driver_mobile = $post->driver_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
				 $engineer = $post->engineer;
				 $technician = $post->technician;
				 $job_no = $post->job_no;
				 $km = $post->km;
				 $bill_dt = $post->bill_dt;
				 $job_dt = $post->job_dt;
				 $user_id = $post->user_id;
			}
			
$result01 = DB::select("
SELECT `full_name` FROM `user` WHERE user_id = $user_id
");
		foreach($result01 as $post01)
			{
				 $full_name = $post01->full_name;
			}


		
?>


               <div class="row row-cols-1 row-cols-lg-3">
			   
                 <div style="width: 300px;padding-right: 2px;">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 140px;">
					<table style="font-size: 11px;">
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Date</strong></td><td style="font-style: MS Gothic;"> : {{date('d-M-Y', strtotime($bill_dt))}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Name </strong></td><td style="font-style: MS Gothic;">: {{$customer_nm}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Address </strong></td><td style="font-style: MS Gothic;">:{{$customer_address}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Contact </strong></td><td style="font-style: MS Gothic;">: {{$customer_mobile}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Attend </strong></td><td style="font-style: MS Gothic;">: {{$driver_mobile}}</td></tr>
					</table>
                    </address>
                 </div>
                 <div style="width: fit-content;padding: 0;">
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 140px;">
                    <!--small>to</small-->
                    <table style="font-size: 11px;" >
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Reg</strong></td><td style="font-style: MS Gothic;"> : {{$customer_reg}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Chas </strong></td><td style="font-style: MS Gothic;">: {{$customer_chas}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">KM </strong></td><td style="font-style: MS Gothic;">: {{$km}}</td ></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Model </strong></td><td style="font-style: MS Gothic;line-height: 0.8;">:{{$customer_vehicle}}</td></tr>
					</table>
                   </address>
                </div>
                 <div style="width: 260px;padding-right: 2px;padding-left: 2px;">
                    <address class="m-t-5 m-b-5" style="border-style: solid;border-width: thin;height: 140px;">
                    <!--small>to</small-->
                    <table style="font-size: 11px;">
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Engineer</strong></td><td style="font-style: MS Gothic;"> : {{$engineer}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Technician </strong></td><td style="font-style: MS Gothic;width: 180px;word-wrap: anywhere;">:{{$technician}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Job No. </strong></td><td style="font-style: MS Gothic;">: {{$job_no}}</td></tr>
                       <tr><td><strong class="text-inverse" style="font-family: Arial;">Job Date</strong></td><td style="font-style: MS Gothic;">: {{date('d-M-Y', strtotime($job_dt))}}</td></tr>
					</table>
                   </address>
                </div>                
               </div>



<div class="col-12 col-lg-8 d-flex">
				<div class="table-responsive" style="width:95%">
			


					
				
				
				
				<table  style="font-size: small;">
					<thead>
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Quantity</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
					</thead>
					<tbody>
					
<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parts</strong></td></tr>
					
<?php
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '1' and `bill_no`=$bill_no;");
	$sl="1"; $subtotal="0";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row" style="text-align: center;border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->unit_rate}}</td>
						<td style="text-align: right;border: 1px solid black;">{{number_format(intval($item->amount), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$subtotal=$subtotal+$item->amount;
		}  
				
?>
<tr><td colspan="3" style="border: 1px solid black;"></td>
<td ><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(intval($subtotal), 2, '.', ',')}}</strong></td></tr>
<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</strong></td></tr>
<?php
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '2' and `bill_no`=$bill_no;");
	$sl="1"; $subtotal01="0";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row" style="text-align: center;border: 1px solid black;">{{$sl}}</th>
						<td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
						<td style="text-align: center;border: 1px solid black;">{{$item->unit_rate}}</td>
						<td style="text-align: right;border: 1px solid black;">{{number_format(intval($item->amount), 2, '.', ',')}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$subtotal01=$subtotal01+$item->amount;
		}  
				
?>			
<tr><td colspan="3" style="border: 1px solid black;"></td>
<td style="border: 1px solid black;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(intval($subtotal01), 2, '.', ',')}}</strong></td></tr>

				
						<tr><td colspan="3" style="max-width: 200px;font-size: smaller;">IN WORDS: <?php 
						 $total = $subtotal+$subtotal01;
						 $vat= $total/10;
						echo AmountInWords($total+$vat)?></td>
							<td colspan="1"><strong>Total TK:</strong></td><td style="text-align: right;"><strong>
							<?php echo number_format(intval($total), 2, '.', ','); ?>
							</strong></td>
						</tr>
						<tr><td colspan="3" ></td>
							<td colspan="1"><strong>VAT: </strong></td><td style="text-align: right;"><strong>
							<?php echo number_format(intval($vat), 2, '.', ','); ?></td>
							</strong></td>
						</tr>
						<tr><td colspan="3" ></td>
							<td colspan="1"><strong>Bill Tk.: </strong></td><td style="text-align: right;"><strong>
							<?php 
							echo number_format(intval($total+$vat), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>						
					</tbody>
				</table>

<br><br>
<div style="float: left;width: 33%;font-size: small;">
<center>
------------------------------<br>
Prepared By <br>
{{$full_name}}
</center>
</div>

<div style="float: left;width: 33%;font-size: small;"><center>
------------------------------<br>
Approved By <br>
</center>
</div>

<div style="font-size: small;"><center>
------------------------------<br>
Recevied By <br>
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