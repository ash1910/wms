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
                    <li class="breadcrumb-item active" aria-current="page">Sale Summary</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<form class="row g-3" action="saleSummary01" method='get'>
	{{ csrf_field() }}
	<div class="col-12 col-lg-4">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
				<div class="col-12">
					<label class="form-label">SELECT FISCAL YEAR:</label>
					<select name="from_dt" class="form-select mb-3" required="">
						<option value="2022 - 2023">2022 - 2023</option>
					</select>
				</div>
				
				<button class="btn btn-success" type="submit" name="register" value="register">
				<i class="lni lni-files"></i> Generate Report</button>
			</div>
		</div>
	</div>
	</form>


			
			
</main>



		  
@endsection		 