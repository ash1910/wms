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
                    <li class="breadcrumb-item active" aria-current="page">Accounting </li>
                    <li class="breadcrumb-item active" aria-current="page">Creditor Aging </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">

	<div class="card"  style="padding:20px">
		<div class="col-12">
			<div class="card shadow-none border radius-15">
				<div class="card-body">
					<form class="row g-3" action="creditor01" method='post'>
					{{ csrf_field() }}
					<div class="col-12">
						<div class="col-md-12">
							<label class="form-label">Year:</label>
							<select name='year' class="form-control">
								<option>2022</option>
								<option>2023</option>
								<option>2024</option>
								<option>2025</option>
							</select>
						</div>
					</div>
						
						<div class="col-12">
							<button class="btn btn-success" type="submit" name="register" value="register">
							<i class="lni lni-files"></i> Month wise Report</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
			
	<div class="card"  style="padding:20px">
		<div class="col-12">
			<div class="card shadow-none border radius-15">
				<div class="card-body">
					<form class="row g-3" action="creditor02" method='get'>
					{{ csrf_field() }}
					
						
						<div class="col-12">
							<button class="btn btn-success" type="submit" name="register" value="register">
							<i class="lni lni-files"></i> Year wise Report</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
	
	
</main>



		  
@endsection		 