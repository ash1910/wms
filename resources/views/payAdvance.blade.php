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
	.watermark
	{
	position: fixed !important;
	top: 80px;
	z-index: 1; /* watermark has to be on top of other web content */
	height: 100%;
	width: 100%;
	opacity: 0.3;
	color: BLACK;
	font-size:xxx-large;
	overflow: hidden;
	}
}
</style>
</head>
<script type="text/javascript">
window.print();
window.onfocus=function(){ window.close();}
</script>
<body style="background-color: #ffff;">

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
       $add_plural = (($counter = count($string)) && $amount > 9) ? '' : null;
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

<br><br>

<center>
<br><br>
<h3><b>Advance Money Receipt</b></h3>

<!--b>Bill:</b><br><br-->
</center>
<?php
$today=date("d-M-Y");

/*
$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address,
b.customer_vehicle, b.customer_chas, `engineer`, `technician`, `job_no`, `bill_dt`, `user_id`, `total`
FROM `bill_mas` a, `customer_info` b
WHERE a.`bill_no` = $bill
AND a.customer_id = b.customer_id;
");
*/
$result01 = DB::select("
SELECT a.`id`, a.`bill`, a.`job_no`, a.`customer_id`, a.`bill_dt`, a.`net_bill`, a.`received`, a.`pay_type`,
a.`dt`, a.`user_id`,  a.`trix`, a.`send`, a.`bank`, a.`chequeNo`, a.`chequeDt`,due,
b.customer_nm, b.customer_mobile, b.customer_address, b.customer_reg, b.customer_chas,`charge`,`card_bank`, `card_no`, `card_type`, `merchant_bank`, mer_bkash
FROM `pay` a, customer_info b
WHERE  a.customer_id='$customer_id'
AND a.bill = 'Advance'
and a.customer_id = b.customer_id
order by id;
");


		foreach($result01 as $post01)
			{
				$id = $post01->id;
				$received = $post01->received;
				$ac_received = $post01->received;
				$job_no = $post01->job_no;
				$pay_type = $post01->pay_type;
if($pay_type=="bkash")
{
	$received = $received+$post01->charge;
}
if($pay_type=="card")
{
	$received = $received+$post01->charge;
}
if($pay_type=="cheque")
{
	$received = abs($post01->due);
	$chequeNo = $post01->chequeNo;
$result04 = DB::select("
SELECT `received` FROM `cheque_pending` WHERE `chequeNo`='$chequeNo' and flag = '0'
");
		foreach($result04 as $post04)
			{
			$received = $post04->received;
			}
}
                $trix = $post01->trix;
				$send = $post01->send;
				$bank = $post01->bank;
				$chequeNo = $post01->chequeNo;
				$chequeDt = $post01->chequeDt;

				$card_bank = $post01->card_bank;
				$card_no = $post01->card_no;
				$card_type = $post01->card_type;
				$merchant_bank = $post01->merchant_bank;


				$customer_nm = $post01->customer_nm;
				$customer_mobile = $post01->customer_mobile;
				$customer_address = $post01->customer_address;
				$customer_reg = $post01->customer_reg;
				$customer_chas = $post01->customer_chas;
				$mer_bkash = $post01->mer_bkash;
			}

?>
<table>
<tr>
	<td><b>M.R No.: {{$id}}</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>Date </b>: {{$today}}</td>
</tr>

<tr>
	<td colspan="3"><b>Received with thanks from </b>: {{$customer_nm}}</td>
</tr>
<tr>
	<td>
	<b>Job No.</b>: {{$job_no }}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reg. No.</b>: {{$customer_reg}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chassis No.</b>: {{$customer_chas}}
	</td>
</tr>
<tr>
	<td><b>Advance Receipt Amount ({{$pay_type}})</b>: Tk.{{number_format(($received), 2, '.', ',')}}
<?php if($pay_type=="cheque"){ echo '(CIH)';}?>
	</td>
</tr>
<?php
if($pay_type=="bkash")
{
?>
<tr>
	<td><b>Trix ID:</b> {{$trix}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Number:</b> {{$send}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Settlement Received:</b> Tk. {{$ac_received}}
	</td>
</tr>
<?php
}
?>
<?php
if($pay_type=="cheque")
{
?>
<tr>
	<td><b>Bank:</b> {{$bank}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque No:</b> {{$chequeNo}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Date:</b> {{$chequeDt}}
	</td>
</tr>
<?php
}
?>
<?php
if($pay_type=="card")
{
?>
<tr>
	<td><b>Card Bank:</b> {{$card_bank}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card No:</b> *******{{$card_no}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card Type:</b> {{$card_type}}<br>
	<b>Settlement Received:</b> Tk. {{$ac_received}}
	</td>
</tr>
<?php
}
?>



<tr>
	<td>
		<b>In words Tk:&nbsp;</b><?php echo AmountInWords(round($received)); ?>

		<?php if($pay_type=="bkash"){ ?>
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit A/C:</b> 01777781{{$mer_bkash}}
		<?php } ?>
		<?php if($pay_type=="cheque" || $pay_type=="card" || $pay_type=="online"){ ?>
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit A/C:</b> @if($merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($merchant_bank == 'CBL') HAS-MTBL-7814 @elseif($merchant_bank == 'BRAC') HAS-BRAC-0001 @elseif($merchant_bank == 'DBBL') HAS-DBBL-1152 @endif
		<?php } ?>
	</td>
</tr>
</table>

<br><br><br><br><br><br>
<br><br><br><br><br><br><br>


<center>
<br><br><br><br>
<h3><b>Advance Money Receipt</b></h3>

<!--b>Bill:</b><br><br-->
</center>

<table>
<tr>
	<td><b>M.R No.: {{$id}}</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>Date </b>: {{$today}}</td>
</tr>

<tr>
	<td colspan="3"><b>Received with thanks from </b>: {{$customer_nm}}</td>
</tr>
<tr>
	<td>
	<b>Job No.</b>: {{$job_no }}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reg. No.</b>: {{$customer_reg}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chassis No.</b>: {{$customer_chas}}
	</td>
</tr>
<tr>
	<td><b>Advance Receipt Amount ({{$pay_type}})</b>: Tk.{{number_format(($received), 2, '.', ',')}}
	<?php if($pay_type=="cheque"){ echo '(CIH)';}?>
	</td>
</tr>
<?php
if($pay_type=="bkash")
{
?>
<tr>
	<td><b>Trix ID:</b> {{$trix}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Number:</b> {{$send}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Settlement Received:</b> Tk. {{$ac_received}}
	</td>
</tr>
<?php
}
?>
<?php
if($pay_type=="cheque")
{
?>
<tr>
	<td><b>Bank:</b> {{$bank}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque No:</b> {{$chequeNo}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Date:</b> {{$chequeDt}}
	</td>
</tr>
<?php
}
?>
<?php
if($pay_type=="card")
{
?>
<tr>
	<td><b>Card Bank:</b> {{$card_bank}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card No:</b> *******{{$card_no}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card Type:</b> {{$card_type}}<br>
	<b>Settlement Received:</b> Tk. {{$ac_received}}
	</td>
</tr>
<?php
}
?>



<tr>
	<td>
		<b>In words Tk:&nbsp;</b><?php echo AmountInWords(round($received)); ?>

		<?php if($pay_type=="bkash"){ ?>
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit A/C:</b> 01777781{{$mer_bkash}}
		<?php } ?>
		<?php if($pay_type=="cheque" || $pay_type=="card" || $pay_type=="online"){ ?>
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit A/C:</b> @if($merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($merchant_bank == 'CBL') HAS-MTBL-7814 @elseif($merchant_bank == 'BRAC') HAS-BRAC-0001 @elseif($merchant_bank == 'DBBL') HAS-DBBL-1152 @endif
		<?php } ?>
	</td>
</tr>
</table>
