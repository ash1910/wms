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
<body onload="window.print()">




<center>
<img src="assets/images/logo-icon.png" class="logo-icon" style="width: 300px;"><br>
275, Tejgaon Industrial Area, Dhaka-1208<br>

<h2>GATEPASS</h2>
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


			<div class="card-header py-2 bg-light">
               <div class="row row-cols-1 row-cols-lg-3">
                 <div class="col-7">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Receiver's Name: </strong>{{$customer_nm}}<br>
                       <strong class="text-inverse">Address: </strong>{{$customer_address}}<br>
                       <strong class="text-inverse">Registration No.: </strong>{{$customer_reg}}<br>

                    </address>
                   </div>
                 </div>
                 <div class="col-5">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Date: </strong>{{$today}}<br>
                       <strong class="text-inverse">Chassis No.: </strong>{{$customer_chas}}<br>
                       <strong class="text-inverse">Vehicle: </strong>{{$customer_vehicle}}<br>

                    </address>
                   </div>
                </div>
                
               </div>
             </div>
