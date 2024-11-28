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
                    <li class="breadcrumb-item active" aria-current="page">Customer/Date</li>
                  </ol>
                </nav>
              </div>

            </div>
            <!--end breadcrumb-->

<div class="col-11">
<link rel="stylesheet" href="assets/css/fontawesome-all-v5.6.3.css" >

	<div class="card">
	<div class="row">

		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">
	<form class="row g-3" action="changeBillDetail01" method='post'>
	{{ csrf_field() }}
	        <input type="hidden" name="bill_no" value="{{$bill_no}}">
            <input type="hidden" name="job_no" value="{{$job_no}}">
			<div class="col-md-12">
				<label class="form-label">Change Bill Date:</label>
				<input  autofocus type="date" class="form-control" name='change_dt' >
			</div>
		<div class="col-12">
			<button class="btn btn-success" type="submit">
			<i class="lni lni-reload"></i> Change Date</button>
		</div>
	</form>
		</div>
		</div>
		</div>

	</div>
	</div>



</main>




@endsection
