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
  <title>Estimate - Workshop Management System</title>

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
  margin-top: 30px;
}
@page:first{

}
table td {
word-wrap:break-word;
white-space: normal;
}
address.add-info td {
    font-size: 10px;
}

.signatureContainer{
    width: 100%;
}
</style>

</head>
<script type="text/javascript">
window.print();
//window.onfocus=function(){ window.close();}
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

$today=date("d-M-Y");

$result = DB::select("
SELECT `est_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle,
b.customer_chas, `engineer`, `technician`, `days`, `est_dt`, `bill_dt`, `user_id`, `net_bill` , driver_mobile, km, email, year, car_colour
FROM `est_mas` a, `customer_info` b
WHERE a.`est_no` = $est_no
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
				 $days = $post->days;
				 $km = $post->km;
				 $est_dt = $post->est_dt;
				 $bill_dt = $post->bill_dt;
				 $user_id = $post->user_id;
				 $year = $post->year;
				 $car_colour = $post->car_colour;
			}

$result01 = DB::select("
SELECT `full_name` FROM `user` WHERE user_id = $user_id
");
		foreach($result01 as $post01)
			{
				 $full_name = $post01->full_name;
			}

?>

		<div class="divMid" style="margin-top: 0px;">
			<div class="col-12 col-lg-8 d-flex">
				<div class="table-responsive" style="width:100%;">

				<table style="font-size: small;">
                    <thead>
                        <tr><th colspan="5" style="font-size: small;">


               <div style="width: 100%; display: flex; justify-content: space-between;">
                 <div style="width: 240px;padding-right: 2px;">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5 add-info" style="border: 1px solid #000; padding: 5px; border-radius: 6px;">
					<table style="font-size: 11px;">
                        @if($est_dt)<tr><td><strong class="text-inverse" style="font-family: Arial;">Date</strong></td><td style="font-style: MS Gothic;">: {{date('d-M-Y', strtotime($est_dt))}}</td></tr>@endif
                        @if($customer_nm)<tr><td><strong class="text-inverse" style="font-family: Arial;">Name </strong></td><td style="font-style: MS Gothic;">: {{$customer_nm}}</td></tr>@endif
                        @if($customer_address)<tr><td><strong class="text-inverse" style="font-family: Arial;">Address </strong></td><td style="font-style: MS Gothic;">: {{$customer_address}}</td></tr>@endif
                        @if($customer_mobile)<tr><td><strong class="text-inverse" style="font-family: Arial;">Contact </strong></td><td style="font-style: MS Gothic;">: {{$customer_mobile}}</td></tr>@endif
					    @if($email)<tr><td><strong class="text-inverse" style="font-family: Arial;">Email </strong></td><td style="font-style: MS Gothic;">: {{$email}}</td></tr>@endif
                        @if($driver_mobile)<tr><td><strong class="text-inverse" style="font-family: Arial;">Attend </strong></td><td style="font-style: MS Gothic;">: {{$driver_mobile}}</td></tr>@endif
                        @if($customer_reg)<tr><td><strong class="text-inverse" style="font-family: Arial;">Reg</strong></td><td style="font-style: MS Gothic;"> : {{$customer_reg}}</td></tr>@endif
                        @if($customer_chas)<tr><td><strong class="text-inverse" style="font-family: Arial;">Chas </strong></td><td style="font-style: MS Gothic;">: {{$customer_chas}}</td></tr>@endif
                        @if($km)<tr><td><strong class="text-inverse" style="font-family: Arial;">KM </strong></td><td style="font-style: MS Gothic;">: {{$km}}</td ></tr>@endif
					</table>
                    </address>
                 </div>
                 <div style="width: 260px;padding: 0;">
                    <table>
                        <tr><td style=" text-align: center;"><img src="assets/images/logo-icon4.png" class="logo-icon" style="width: 100%; margin: 0 0 0 -10px;"></td></tr>
                        <tr><td style="font-size: 10px; text-align: center;">275, Tejgaon Industrial Area, Dhaka-1208, Phone: 8870818,8870820, BIN: 004882855-0203</td></tr>
                        <tr><td style="font-size: 28px; text-align: center; font-weight: bolder;">ESTIMATE</td></tr>
                        <tr><td style="font-size: 14px; text-align: center;"><b>Estimate No:{{$est_no}}</b></td></tr>
                    </table>
                </div>
                 <div style="width: 220px;padding-left: 2px;">
                    <address class="m-t-5 m-b-5 add-info"  style="border: 1px solid #000; padding: 5px; border-radius: 6px;">
                    <!--small>to</small-->
                    <table style="font-size: 11px;">
                       @if($engineer)<tr><td><strong class="text-inverse" style="font-family: Arial;">Engineer</strong></td><td style="font-style: MS Gothic;"> : {{$engineer}}</td></tr> @endif
                       @if($technician)<tr><td><strong class="text-inverse" style="font-family: Arial;">Technician </strong></td><td style="font-style: MS Gothic;width: 180px;word-wrap: anywhere;">:{{$technician}}</td></tr> @endif
                       @if($days)<tr><td><strong class="text-inverse" style="font-family: Arial;">Time Required </strong></td><td style="font-style: MS Gothic;">: {{$days}} Working Days</td></tr> @endif
                       @if($est_dt)<tr><td><strong class="text-inverse" style="font-family: Arial;">Estimate Date</strong></td><td style="font-style: MS Gothic;">: {{date('d-M-Y', strtotime($est_dt))}}</td></tr> @endif
                       @if($customer_vehicle)<tr><td><strong class="text-inverse" style="font-family: Arial;">Model </strong></td><td style="font-style: MS Gothic;line-height: 0.8;">: {{$customer_vehicle}}</td></tr> @endif
					   @if($year)<tr><td><strong class="text-inverse" style="font-family: Arial;">Year</strong></td><td style="font-style: MS Gothic;">: {{$year}}</td></tr> @endif
					   @if($car_colour)<tr><td><strong class="text-inverse" style="font-family: Arial;">Colour</strong></td><td style="font-style: MS Gothic;">: {{$car_colour}}</td></tr> @endif
					</table>
                   </address>
                </div>
               </div>



                        </th></tr>
						<tr style="background: darkgrey;">
							<th scope="col" style="width: 3%;border: 1px solid black;">SL No.</th>
							<th scope="col" style="width: 80%;border: 1px solid black;">Description</th>
							<th scope="col" style="width: 2%;border: 1px solid black;">Qty</th>
							<th scope="col" style="width: 5%;border: 1px solid black;">Unit Rate</th>
							<th scope="col" style="width: 10%;border: 1px solid black;">Amount(Tk.)</th>
						</tr>
                    </thead>
                    <tfoot>
                        <tr><th><div style="width: 100%;height: 60px;"></div></th></tr>
                        <tr><th colspan="5" style="text-align: center;">...</th></tr>
                    </tfoot>
					<tbody>

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section = 'General Repair' and `est_no`=$est_no;");
$row='0'; $sl="1"; $subtotal=0; $total=0; $total_gross_parts=0; $total_gross_services=0; $total_gross=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;General Repair Parts</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section = 'General Repair' and `est_no`=$est_no;");
$row='0'; $sl="1"; $total_gross_parts += $total; $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;General Repair Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total General Repair</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif


<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section = 'A.C & Electric' and `est_no`=$est_no;");
$row='0'; $sl="1"; $subtotal=0; $total_gross += $total; $total=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A.C & Electric Parts</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section = 'A.C & Electric' and `est_no`=$est_no;");
$row='0'; $sl="1"; $total_gross_parts += $total; $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A.C & Electric Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total A.C & Electric</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif


<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section = 'Body & Paint' and `est_no`=$est_no;");
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Body & Paint Parts</strong></td></tr>@endif
<?php
$row='0'; $sl="1"; $subtotal=0; $total_gross += $total; $total=0;
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section = 'Body & Paint' and `est_no`=$est_no;");
$row='0'; $sl="1";$total_gross_parts += $total;  $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Body & Paint Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total Body & Paint</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section = 'Maintenance' and `est_no`=$est_no;");
$row='0'; $sl="1"; $subtotal=0; $total_gross += $total; $total=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maintenance Parts</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section = 'Maintenance' and `est_no`=$est_no;");
$row='0'; $sl="1"; $total_gross_parts += $total; $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maintenance Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total Maintenance</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section = 'CNG & LPG' and `est_no`=$est_no;");
$row='0'; $sl="1"; $subtotal=0; $total_gross += $total; $total=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CNG & LPG Parts</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section = 'CNG & LPG' and `est_no`=$est_no;");
$row='0'; $sl="1";$total_gross_parts += $total;  $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CNG & LPG Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total CNG & LPG</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `parts_info` b WHERE a.prod_id = b.parts_id AND a.type = '1' AND b.section IS NULL and `est_no`=$est_no;");
$row='0'; $sl="1"; $subtotal=0; $total_gross += $total; $total=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other Parts</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif

<?php
$stock = DB::select("SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, a.amount FROM `est_det` a, `service_info` b WHERE a.prod_id = b.service_id AND a.type = '2' AND b.section IS NULL and `est_no`=$est_no;");
$row='0'; $sl="1"; $total_gross_parts += $total; $subtotal=0;
?>
@if(count($stock))<tr><td colspan="5" style="border: 1px solid black;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other Service</strong></td></tr>@endif
<?php
foreach($stock as $item){ $subtotal=$subtotal+$item->amount; $total += $item->amount;
?>
<tr>
    <th scope="row" style="text-align: center;border: 1px solid black;">{{$sl++}}</th>
    <td style="border: 1px solid black;">{{$item->prod_id}} - {{$item->prod_name}}</td>
    <td style="text-align: center;border: 1px solid black;">{{$item->qty}}</td>
    <td style="text-align: center;border: 1px solid black;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
    <td style="text-align: right;border: 1px solid black;">{{number_format(($item->amount), 2, '.', ',')}}</td>
</tr>
<?php }?>
@if(count($stock))<tr><td colspan="2" style="border: 1px solid black;"></td><td colspan="2" style="text-align: center;"><strong>Sub-Total</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($subtotal), 2, '.', ',')}}</strong></td></tr>@endif
@if($total>0)<tr><td colspan="4" style="border: 1px solid black; text-align: right; padding-right: 50px; font-size: 16px;"><strong>Total Other Parts & Services</strong></td><td style="border: 1px solid black;text-align: right;"><strong> {{number_format(($total), 2, '.', ',')}}</strong></td></tr>@endif


						<tr><td colspan="5" style="max-width: 200px;font-size: smaller;">IN WORDS: <?php
                         $total_gross += $total;
						 $vat= $total_gross/10;
						echo AmountInWords($total_gross+$vat)?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" text-align: right; padding-right: 50px; font-size: 16px;"><strong>TOTAL PARTS</strong></td>
                            <td style="text-align: right; font-size: 16px;"><strong>
                                <?php echo number_format(($total_gross_parts), 2, '.', ','); ?>
                                </strong>
                            </td>
						</tr>
                        <tr>
                            <td colspan="4" style=" text-align: right; padding-right: 50px; font-size: 16px;"><strong>TOTAL SERVICES</strong></td>
                            <td style="text-align: right; font-size: 16px;"><strong>
                                <?php echo number_format(($total_gross-$total_gross_parts), 2, '.', ','); ?>
                                </strong>
                            </td>
						</tr>
                        <tr>
                            <td colspan="4" style=" text-align: right; padding-right: 50px; font-size: 16px;"><strong>TOTAL SERVICE & PARTS</strong></td>
                            <td style="text-align: right; font-size: 16px;"><strong>
                                <?php echo number_format(($total_gross), 2, '.', ','); ?>
                                </strong>
                            </td>
						</tr>
						<tr><td colspan="4" style=" text-align: right; padding-right: 50px; font-size: 16px;"><strong>VAT @ 10%</strong></td>
							<td style="text-align: right; font-size: 16px;"><strong>
							<?php echo number_format(($vat), 2, '.', ','); ?></td>
							</strong></td>
						</tr>
						<tr><td colspan="4" style=" text-align: right; padding-right: 50px; font-size: 16px;"><strong>TOTAL AMOUNT</strong></td>
                            <td style="text-align: right; font-size: 16px;"><strong>
							<?php
							echo number_format(($total_gross+$vat), 2, '.', ',');
							?></td>
							</strong></td>
						</tr>




					</tbody>
				</table>

<div class="signatureContainer">
    <br><br>
    <div style="float: left;width: 50%;font-size: small;">
    <center>
    ------------------------------<br>
    Prepared By <br>
    {{$full_name}}
    </center>
    </div>

    <div style="font-size: small;"><center>
    ------------------------------<br>
    Approved By <br>
    </center>
    </div>
    <br>
    <center>
    <div class="watermark" style="text-align: center;"><b>ESTIMATE</b></div>
    <font style="font-size: xx-small;">
    *This is a computer-generated Bill / Cash Memo. Design & Developed by Techno Mole Creations LTD (TMC)
    </font>
    </center>
</div>

                          </div>

                    </div>
				</div>
