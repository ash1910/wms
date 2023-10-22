@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Reports</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Date Wise Supplier</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<form class="row g-3" action="supplierReport01" method='post'>
	{{ csrf_field() }}
		<div class="col-md-2">
			<label class="form-label">From Date:</label>
			<input  autofocus type="date" class="form-control" name='dt01' required>
		</div>
		<div class="col-md-2">
			<label class="form-label">To Date:</label>
			<input  autofocus type="date" class="form-control" name='dt02' required>
		</div>		

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="lni lni-files"></i> Generate Report</button>
		</div>
	</form>


			
			
</main>



		  
@endsection		 