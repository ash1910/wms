@extends("layouts.master")

@section("content")



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
                    <li class="breadcrumb-item active" aria-current="page">Issue </li>
                    <li class="breadcrumb-item active" aria-current="page">With Date </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="issueReport01" method='get'>
	{{ csrf_field() }}
	<div class="col-12">
		<div class="col-md-12">
			<label class="form-label">From Date:</label>
			<input  autofocus type="date" class="form-control" name='from_dt'>
		</div>
	</div>
		<div class="col-md-12">
			<label class="form-label">To Date:</label>
			<input  autofocus type="date" class="form-control" name='to_dt'>
		</div>
		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="lni lni-files"></i> Generate Report</button>
		</div>
	</form>

</div>
	</div></div>
</div>
			
			
</main>



		  
@endsection		 