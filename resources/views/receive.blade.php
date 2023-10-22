@extends("layouts.master")

@section("content")
<main class="page-content">

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif	   



            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Receive </li>
                  </ol>
                </nav>
              </div>
              
            </div>

<div style="background-color: gainsboro;padding-top: 20px;padding-left: 20px;padding-right: 20px;">
	<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-6 row-cols-xxl-6">





<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/form04">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Date Wise</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/moneyReceipt">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Money Receipt</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/advanceReceipt">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Advance Receipt</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/advanceRefund">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Advance Refund</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")){
?>	  
	  <a href="/mfsReceipt">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>MFS</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")){
?>	  
	  <a href="/cardReceipt">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Card</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/form08">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>VAT Waive</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/financialCharge">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Financial Charge</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/declineBankPOS">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Bank Decline (POS)</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>





	</div>
</div>  
  
  
  
  
</main>  
@endsection