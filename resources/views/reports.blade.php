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
                  </ol>
                </nav>
              </div>
              
            </div>

<div style="background-color: gainsboro;padding-top: 20px;padding-left: 20px;padding-right: 20px;">
	<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-6 row-cols-xxl-6">





<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Store")
	||(session('role')=="Administrator")||(session('role')=="Service Engineer")||(session('role')=="Executive")||(session('role')=="PRO")){
?>	  
	  <a href="/form01">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Draft Bills</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>


<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Store")
	||(session('role')=="Administrator")||(session('role')=="Service Engineer")||(session('role')=="Executive")||(session('role')=="PRO")){
?>	  
	  <a href="/form03">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Main Bills</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>


<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	  
	  <!--a href="/form04"-->
	  <a href="/receive">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Receive</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/aitReport">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>AIT</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/vatReport">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>VAT</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	  
	  <!---a href="/saleSummary">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			  <h3>Sales Summary</h3>
		  </div>
		</div>
	  </div>
	  </a---->
<?php } ?>


<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/purchaseReport">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Purchase</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Store")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/issueReport">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Issue</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	  
	  <a href="/grossProfit">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Gross Profit</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	  
	  <a href="/due">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Due</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

 <?php 
if ((session('role')=="Accounts")||(session('role')=="Inventory Incharge")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/gatepassList">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Gate Pass</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Executive")){
?>	  
	  <a href="/accounting">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-calculator"></i>
			</div>
			 <h3>Accounting</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){
?>	  
	  <a href="/wip01">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>WIP</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>

	</div>
</div>  
  
  
  
  
</main>  
@endsection