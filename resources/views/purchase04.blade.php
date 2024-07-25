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
                    <li class="breadcrumb-item active" aria-current="page">Supplier's Bill / Purchase Date:</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

		<div class="col-12">


	<link rel="stylesheet" href="assets/css/fontawesome-all-v5.6.3.css" >
		

	<form class="row g-3" action="purchase041" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{$id}}">
	<input type="hidden" name="dt01" value="{{$dt01}}">
	<input type="hidden" name="dt02" value="{{$dt02}}">
		<div class="col-md-4">
			<label for="validationDefault01" class="form-label">Supplier's Bill No.</label>
			<input value="{{$supplier_ref}}" type="text" class="fas form-control" name='supplier_ref' required>
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register">
			<i class="fadeIn animated bx bx-edit-alt"></i>Change Supplier's Bill No.</button>
		</div>
	</form>
	
	<br><br>
	
	<form class="row g-3" action="purchase042" method='post'>
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{$id}}">
	<input type="hidden" name="dt01" value="{{$dt01}}">
	<input type="hidden" name="dt02" value="{{$dt02}}">
			<div class="col-md-4">
				<label class="form-label">Change Purchase Date:</label>
				<input  autofocus type="date" class="form-control" name='purchase_dt' >
			</div>		
		<div class="col-12">
			<button class="btn btn-success" type="submit">
			<i class="lni lni-reload"></i> Change Purchase Date</button>
		</div>
	</form>	
			
			
</main>



		  
@endsection		 