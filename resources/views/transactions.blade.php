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
                    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                  </ol>
                </nav>
              </div>
              
            </div>

<div style="background-color: gainsboro;padding-top: 20px;padding-left: 20px;padding-right: 20px;">
	<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-6 row-cols-xxl-6">





<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")){
?>	  
	  <a href="/payment">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Payment</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/paymentReport">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Payment Report</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/journal01">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Journal</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>
<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>	  
	  <a href="/contra">
	  <div class="col">
		<div class="card radius-10">
		  <div class="card-body text-center" style="height: 175px;">
			<div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
			  <i class="lni lni-files"></i>
			</div>
			 <h3>Contra</h3>
		  </div>
		</div>
	  </div>
	  </a>
<?php } ?>





	</div>
</div>  
  
  
  
  
</main>  
@endsection