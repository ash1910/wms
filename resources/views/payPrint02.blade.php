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
	.watermark01
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
<body style="background: none;">


<?php
$today=date("d-M-Y");		

$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle,
b.customer_chas, `engineer`, `technician`, `job_no`, `bill_dt`, `user_id`, `net_bill` 
FROM `bill_mas` a, `customer_info` b
WHERE a.`bill_no` = '$bill'
AND a.customer_id = b.customer_id;
");
$result01 = DB::select("
SELECT `bill`, `job_no`, `customer_id`, `bill_dt`, `net_bill`, `received`, `bonus`, `due`, `pay_type`, `dt`, `user_id` 
FROM `pay` WHERE bill='$bill';
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
			}
		foreach($result01 as $post01)
			{
				$net_bill = $post01->net_bill;
				$received = $post01->received;
				$pay_type = $post01->pay_type;
				$bonus = $post01->bonus;
			}
?>

<center>
<img src="assets/images/logo-icon4.png" class="logo-icon" style="width: 300px;"><br> 
132 My Street, Kingston, New York 12401 Phone: +1(123)456-789103<br>
<br><br>
<h3><b>GATEPASS</b></h3><b>Job No.: {{$job_no}}</b>
<br>
</center>

<?php
foreach($result as $item1)
			{
				$customer_nm = $item1->customer_nm;
				$customer_address = $item1->customer_address;
				$customer_reg = $item1->customer_reg;
				$customer_chas = $item1->customer_chas;
				$customer_vehicle = $item1->customer_vehicle;
			}
$today=date("d-M-Y");				
?>


			<div class="card-header py-2"><div class="watermark01"><center><img src="assets/images/logo-icon3.png" class="logo-icon" style="width: 300px;"></center></div>
               <div class="row row-cols-1 row-cols-lg-3">
                 <div class="col-7">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Receiver's Name: </strong>{{$customer_nm}}<br>
                       <strong class="text-inverse">Address: </strong>{{$customer_address}}<br>
                       <strong class="text-inverse">Registration No.: <h4>{{$customer_reg}}</strong></h4>

                    </address>
                   </div>
                 </div>
                 <div class="col-5">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Date: <h4></strong>{{$today}}</h4>
                       <strong class="text-inverse">Chassis No.:<h4>{{$customer_chas}} </strong></h4>
                       <strong class="text-inverse">Vehicle: </strong>{{$customer_vehicle}}<br>

                    </address>
                   </div>
                </div>

			
               </div>
			   
<br><br><br>		
&nbsp;&nbsp;&nbsp;------------------------------ 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
------------------------------<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recevied By 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Authorized By <br><br><br>
           
		   
<div style="text-align: center;color: white;background: black;">		   
www.hnsautomobiles.com
</div>	   
		   
		   
		   
		   
		   </div>


		 
			 