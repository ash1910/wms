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
    
.h3, h3 {
  font-size: 1.4rem;
}
  </style>
  
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      <header class="top-header">        
        <nav class="navbar navbar-expand">
          <div class="mobile-toggle-icon d-xl-none">
              <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar d-none d-xl-block">
            
            </div>
            
            <form class="searchbar d-none d-xl-flex ms-auto">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"></div>
                <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>
            </form>
            <div class="top-navbar-right ms-3">
              <ul class="navbar-nav align-items-center">
<?php 
///////////////// Advance Check /////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Advance Money Received Check" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/advanceCheck" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `pay` a
WHERE  job_no='Advance'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				A
                </div>
              </a>
			  </li>
<?php } 
///////////////// MFS Check /////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Mobile Financial Services Check" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/mfsCheck" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `pay` a
WHERE a.pay_type = 'bkash' and a.pay_check = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  MFS
                </div>
              </a>
			  </li>
<?php } 
///////////////// Card Check /////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Card Check" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/cardCheck" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `pay` a
WHERE a.pay_type = 'card' and a.pay_check = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <font>Card</font>
                </div>
              </a>
			  </li>
<?php } 
///////////////// Cheque Confirm /////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Check Confirm" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/chequeConfirm" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `cheque_pending` a
WHERE a.confirm = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <font>Chq</font>
                </div>
              </a>
			  </li>
<?php } 
///////////////// Cheque Approval /////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Cheque Approval" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/chequeApproval" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `cheque_pending` a
WHERE a.flag = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <i class="fadeIn animated bx bx-credit-card-front"></i>
                </div>
              </a>
			  </li>
<?php } 

///////////////// Gate pass print/////////////////////
if (
(session('role')=="Super Administrator")||(session('role')=="Administrator")||
(session('role')=="Accounts")||(session('role')=="Service Engineer")||(session('role')=="PRO")
){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Gate Pass Print" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/gatePassPrint" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `gatepass` a
WHERE a.flag = '1'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <i class="lni lni-car"></i>
                </div>
              </a>
			  </li>
<?php } 

///////////////// APPROVAL /////////////////////

if ((session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Accounts")||(session('role')=="PRO")){
//if (session('user')=="Nishan"){
?> 			  
			  <li class="nav-item dropdown dropdown-large">
              <a title="Bill Approval" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/approval" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `bill_mas` a
WHERE a.flag = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <i class="bi bi-bell-fill"></i> 
                </div>
              </a>
			  </li>
<?php } 

if ((session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Accounts")||(session('role')=="PRO")){ ?>  

<li class="nav-item dropdown dropdown-large">
              <a title="Estimate Approval" class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="/approvalEst" >
                <div class="notifications">
    
<?php
$num = "0";
$result = DB::select("
SELECT count(*) num
FROM `est_mas` a
WHERE a.flag = '0'
");
foreach($result as $item)
		{
			$num = $item->num;
		}
if($num!="0")
{	
?>
				  <span class="notify-badge">{{$num}}</span>
<?php 
} 
?>              
				  <i class="bi bi-calculator-fill"></i> 
                </div>
              </a>
			  </li>
<?php } ?> 



          
			 <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center gap-1">
                    <img src="assets/images/avatars/{{session('image')}}" class="user-img" alt="">
                    <div class="user-name d-none d-sm-block">{{session('user');}}</div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">
                          <img src="assets/images/avatars/{{session('image')}}" alt="" class="rounded-circle" width="60" height="60">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">{{session('full_name');}}</h6>
                            <small class="mb-0 dropdown-user-designation text-secondary">{{session('role');}}</small>
                          </div>
                       </div>
                     </a>
                   </li>
                   
                    <li><hr class="dropdown-divider"></li>
<?php 
if (session('user')=="Nishan"){
?>					
                    <li>
                      <a class="dropdown-item" href="ModifyAcceptBill">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="lni lni-pencil-alt"></i></div>
                           <div class="setting-text ms-3"><span>Modify Accept Bill</span></div>
                         </div>
                       </a>
                    </li>
<?php } ?>
<?php 
if ((session('user')=="Nishan")||(session('user')=="Mazharul"))
{
?>					
                    <li>
                      <a class="dropdown-item" href="ModifyBillDt">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="lni lni-pencil-alt"></i></div>
                           <div class="setting-text ms-3"><span>Bill Date As Job Date</span></div>
                         </div>
                       </a>
                    </li>
<?php } ?>					
					
                    <li>
                      <a class="dropdown-item" href="changePassword">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="lni lni-key"></i></div>
                           <div class="setting-text ms-3"><span>Change Password</span></div>
                         </div>
                       </a>
                    </li>					
                    <li>
                      <a class="dropdown-item" href="logout">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                           <div class="setting-text ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>					
                </ul>
              </li>
              
              
              
              </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->
	   
	   
