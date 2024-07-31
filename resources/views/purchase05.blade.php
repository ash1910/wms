@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Change</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase's Req / Job No:</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

		<div class="col-12">


	<link rel="stylesheet" href="assets/css/fontawesome-all-v5.6.3.css" >
		

	<form class="row g-3" action="purchase051" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{$id}}">
	<input type="hidden" name="dt01" value="{{$dt01}}">
	<input type="hidden" name="dt02" value="{{$dt02}}">
		<div class="col-md-4">
			<label for="validationDefault01" class="form-label">Req. No.</label>
			<input value="{{$req}}" type="text" class="fas form-control" name='req' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Purchase's Req. No.</button>
		</div>

	</form>
	<br><br>
	
	<form class="row g-3" action="purchase052" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{$id}}">
	<input type="hidden" name="dt01" value="{{$dt01}}">
	<input type="hidden" name="dt02" value="{{$dt02}}">
		<div class="col-md-4">
			<label for="validationDefault01" class="form-label">Job. No.</label>
			<input value="{{$job_no}}" type="text" class="fas form-control" name='job_no' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Job. No.</button>
		</div>

	</form>
	
	<br><br>
	

			
			
</main>



		  
@endsection		 