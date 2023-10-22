@extends("layouts.master")

@section("content")

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   ?>


<main class="page-content">
            <!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Receive </li>
                    <li class="breadcrumb-item active" aria-current="page">Money Receipt Print</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="moneyReceipt01" method='post'>
	{{ csrf_field() }}
	<div class="col-12">
		<div class="col-md-12">
			<label class="form-label">Search by Job No:</label>
			<input placeholder="XXXX-XX"  autofocus type="text" class="form-control" name='job_no' required>
		</div>
	</div>
		
		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="lni lni-files"></i> Search</button>
		</div>
	</form>

</div>
	</div>
	
	
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="moneyReceipt04" method='post'>
	{{ csrf_field() }}
	<div class="col-12">
		<div class="col-md-12">
			<label class="form-label">Search by Money Receipt No:</label>
			<input placeholder="XXXXXX"  autofocus type="text" class="form-control" name='id' required>
		</div>
	</div>
		
		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="lni lni-files"></i> Search</button>
		</div>
	</form>

</div>
	</div>
	</div>
</div>			
			
</main>



		  
@endsection		 