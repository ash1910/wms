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
<!--body onload="window.print()"-->
<script type="text/javascript">

	window.onload = function(){
		var imageGet = '<?=isset($_GET['image']) ? $_GET['image'] : ""?>';
		console.log(imageGet);
		if(imageGet)
		setUpDownloadPageAsImage();
		else
		CreatePDFfromHTML();
	}
//window.onfocus=function(){ window.close();}
</script>
<body>
	<div style="background-image: url(/assets/images/moneyReceiptBG.jpg);
    background-repeat: no-repeat;
    background-size: contain;
	max-width: 750px;
	height: 515px;
	position: relative;" id="wrapperContainer" class="html-content">

<?php
$sig_file_name = !empty($user_name) ? $user_name : "sig";

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
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
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
<br>
<br><br>

<center>
<br><br>
<h3><b>Money Receipt</b></h3>

<b>Bill:{{$bill}}</b><br><br>
</center>
<?php
$today=date("d-M-Y");

$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address,
b.customer_vehicle, b.customer_chas, `engineer`, `technician`, `job_no`, `bill_dt`, `user_id`, `total`
FROM `bill_mas` a, `customer_info` b
WHERE a.`job_no` = '$job_no'
AND a.customer_id = b.customer_id;
");
$result01 = DB::select("
SELECT `id`,`bill`, `job_no`, `customer_id`, `bill_dt`, `net_bill`, `received`, `pay_type`, due,
`dt`, `user_id`,  `trix`, `send`, `bank`, `chequeNo`, `chequeDt`,`charge`,`card_bank`, `card_no`, `card_type`, `merchant_bank`, `post_dt`, mer_bkash
FROM `pay` WHERE id='$id'
order by id
");
$result02 = DB::select("
SELECT sum(due) due, sum(bonus) bonus, sum(vat_wav) vat_wav FROM `pay` WHERE `job_no` = '$job_no'
");
		foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
				 $job_no = $post->job_no;
				 $bill_dt = $post->bill_dt;
				 $user_id = $post->user_id;
				 $total = $post->total;

			}
		foreach($result01 as $post01)
			{
				$id = $post01->id;
				$dt = $post01->dt;
				$post_dt = $post01->post_dt;
				$received = $post01->received;
				$ac_received = $post01->received;
				$pay_type = $post01->pay_type;
				$user_id_pay = $post01->user_id;
				$mer_bkash = $post01->mer_bkash;

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
	$received = $post01->received;
	$job_no = $post01->job_no;
	$chequeNo = $post01->chequeNo;
	$bank = $post01->bank;
	$chequeNo = $post01->chequeNo;
	$chequeDt = $post01->chequeDt;
	$dt = $post_dt;

$result04 = DB::select("
SELECT `received` FROM `cheque_pending` WHERE `job_no`='$job_no' and `flag` = '0' and `bank` = '$bank'
and `chequeNo` = '$chequeNo' and `chequeDt` = '$chequeDt'
");
		foreach($result04 as $post04)
			{
			$received = $post04->received;
			}




}
				$trix = $post01->trix;
				$trix = $post01->trix;
				$send = $post01->send;

			    $card_bank = $post01->card_bank;
				$card_no = $post01->card_no;
				$card_type = $post01->card_type;
				$merchant_bank = $post01->merchant_bank;
			}
		foreach($result02 as $post02)
			{
				$due = $post02->due;
				$bonus = $post02->bonus;
				$vat_wav = $post02->vat_wav;
			}
?>
<table style="margin: 0 auto;">
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
	<b>Date </b>: {{date('d-M-Y', strtotime($dt))}}</td>
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
	<td><b>Total Amount</b>: Tk.{{number_format(($total-$bonus-$vat_wav), 2, '.', ',')}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paid ({{$pay_type}})</b>
	: Tk.{{number_format(($received), 2, '.', ',')}}
	<?php if($pay_type=="cheque")
	{
		$flag='';
		$result03 = DB::select("SELECT `flag` FROM `cheque_pending` WHERE `job_no` = '$job_no'");
		foreach($result03 as $post03){$flag = $post03->flag;}
		if($flag=='0'){echo '(CIH)';}
	}?>
<?php
if($bill=="Advance")
{ ?>
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Advance</b>: Tk.{{number_format((abs($due)), 2, '.', ',')}}
<?php }
if($bill!="Advance")
{ ?>
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due

	</b>: Tk.{{number_format((abs($due)), 2, '.', ',')}}
<?php } ?>	</td>
</tr>
<?php
if($pay_type=="bkash")
{
?>
<tr>
	<td><b>Trix ID:</b> {{$trix}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Number:</b> {{$send}}
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Settlement Received:</b> Tk. {{number_format(($ac_received), 2, '.', ',');}}
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
	<b>Settlement Received:</b> Tk. {{number_format(($ac_received), 2, '.', ',');}}
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
<img src="/assets/images/seal01.png" style="width: 120px;
    position: absolute;
    bottom: 65px;
    right: 87px;" />
<img src="/assets/images/{{$user_id_pay == 7? 'Mosharraf' : ($user_id_pay == 12? 'Habibur' : 'Mazharul')}}.png" style="width: 80px;
    position: absolute;
    bottom: 70px;
    right: 42px;" />
<br>
</div>


<div id="editor"></div>
<!-- <button id="cmd">generate PDF</button> -->

<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="assets/js//html2canvas.js"></script>


<script type="text/javascript">
var fileName = `{{$job_no}}-{{$customer_reg}}-{{$customer_chas}}`;


function CreatePDFfromHTML() {
    var HTML_Width = $(".html-content").width();
    var HTML_Height = $(".html-content").height();
    var top_left_margin = 0;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    //var PDF_Height = (PDF_Width * 0.7) + (top_left_margin * 2);
	var PDF_Height = HTML_Height + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($(".html-content")[0], {scale:4}).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 10.0);

        var pdf = new jsPDF('l', 'pt', [PDF_Width-5, PDF_Height-5]); // l for bigger width and p for less width
		pdf.setFillColor(204, 204,204,0);
		pdf.rect(10, 10, 150, 160, "F");
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) {
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save(fileName+".pdf");
    });
}


function setUpDownloadPageAsImage() {
    html2canvas($(".html-content")[0], {scale:4}).then(function(canvas) {
      simulateDownloadImageClick(canvas.toDataURL(), fileName+".jpg");
    });
}

function simulateDownloadImageClick(uri, filename) {
  var link = document.createElement('a');
  if (typeof link.download !== 'string') {
    window.open(uri);
  } else {
    link.href = uri;
    link.download = filename;
    accountForFirefox(clickLink, link);
  }
}

function clickLink(link) {
  link.click();
}

function accountForFirefox(click) { // wrapper function
  let link = arguments[1];
  document.body.appendChild(link);
  click(link);
  document.body.removeChild(link);
}
</script>




