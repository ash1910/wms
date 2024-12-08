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

	<form class="row g-3" action="changeCustomerEst01" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Customer Registration No.</label>
			<input placeholder="&#xf002" type="text" class="fas form-control" name='customer_reg' required="">
		</div>

		<div class="col-md-12">
			<button class="btn btn-success" type="submit" name="register" value="register"><i class="fadeIn animated bx bx-edit-alt"></i>Change Registration No.</button>
			<button class="btn btn-success" type="submit" name="register" value="register01"><i class="fadeIn animated bx bx-edit-alt"></i>Change Chasis No.</button>
		</div>
	</form>
		</div>
		</div>
		</div>

		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">
	<form class="row g-3" action="changeCustomerEst02" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
			<div class="col-md-12">
				<label class="form-label">Change Estimate Date:</label>
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


	<div class="card">
	<div class="row">
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="changeCustomerEst05" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Engineer's Name</label>
			<input value="{{$engineer}}" type="text" class="fas form-control" name='engineer' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Engineer's Name</button>
		</div>
	</form>
		</div>
		</div>
		</div>
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">
	<form class="row g-3" action="changeCustomerEst06" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Technician's Name</label>
			<input value="{{$technician}}" type="text" class="fas form-control" name='technician' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Technician's Name</button>
		</div>
	</form>
		</div>
		</div>
		</div>

	</div>
	</div>


	<div class="card">
	<div class="row">
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="changeCustomerEst03" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Time Required</label>
			<input value="{{$days}}" type="text" class="fas form-control" name='days' required> Days
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Time Required</button>
		</div>
	</form>
		</div>
		</div>
		</div>
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">
	<form class="row g-3" action="changeCustomerEst04" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">KM</label>
			<input value="{{$km}}" type="text" class="fas form-control" name='km' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change KM.</button>
		</div>
	</form>
		</div>
		</div>
		</div>



	</div>
	</div>

	<div class="card">
	<div class="row">
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="changeCustomerEst07" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Validity</label>
			<input value="{{$validity}}" type="text" class="fas form-control" name='validity' required> Days
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Validity</button>
		</div>
	</form>
		</div>
		</div>
		</div>
		<div class="col-6">
		<div class="card shadow-none border radius-15">
		<div class="card-body">
	<form class="row g-3" action="changeCustomerEst08" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="est_no" value="{{$est_no}}">
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Note</label>
			<input value="{{$note}}" type="text" class="fas form-control" name='note' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Note</button>
		</div>
	</form>
		</div>
		</div>
		</div>



	</div>
	</div>

</main>




@endsection
