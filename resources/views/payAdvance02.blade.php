@extends("layouts.master")

@section("content")
<main class="page-content">
			  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Check</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Advance Money Received </li>
                  </ol>
                </nav>
              </div>
              
            </div>
<!---Alert message----> 
@if (Session::get('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-danger">
please enter valid job no!!!!
</div>
<script type="text/javascript">
$(document).ready(function () {
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
 });
</script>
@endif
<!---Alert message----> 


<link rel="stylesheet" href="assets/css/fontawesome-all-v5.6.3.css" >


<div class="card"  style="padding:20px">
	<div class="row">
	<div class="col-4 col-lg-4">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
				<form class="row g-3" action="payAdvance03" method='post' >
				{{ csrf_field() }}
					<div class="col-md-12">
						<label for="validationDefault01" class="form-label">Set Job No</label> 
						
						
					<select name="job_no" class="form-select" required="">
					
			<?php		
			$result01 = DB::select("
			SELECT `job_no` FROM `bill_mas` WHERE `customer_id` = '$customer_id' AND `flag` <> '3'
			");


					foreach($result01 as $post01)
						{
						
			echo '<option value="'.$post01->job_no.'">'.$post01->job_no.'</option>';		
							
						}
			?>				
							
					
					</select>			
						
						
						
						
					</div>

					<div class="col-12">
						<button class="btn btn-success" type="submit" name="register" value="register01"><i class="fadeIn animated bx bx-edit-alt"></i>Set Job No.</button>
					</div>
					
								<input type="hidden" name="customer_id" value="{{$customer_id}}">
								<input type="hidden" name="id" value="{{$id}}">

				</form>

			</div>
		</div>
	</div>
	<div class="col-4 col-lg-4">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
				<form class="row g-3" action="payAdvance04" method='post' >
				{{ csrf_field() }}
					<div class="col-md-12">
						<label for="validationDefault01" class="form-label">Change Vehicle No</label>
						
						
					<select name="change_customer" class="form-select" required="">
					
			<?php		
			$result01 = DB::select("
			SELECT `customer_reg`,`customer_id`  FROM `customer_info` WHERE `customer_nm` like '%$customer_nm%';
			");


					foreach($result01 as $post01)
						{
						
			echo '<option value="'.$post01->customer_id.'">'.$post01->customer_reg.'</option>';		
							
						}
			?>				
							
					
					</select>			
						
						
						
						
					</div>

					<div class="col-12">
						<button class="btn btn-success" type="submit" name="register" value="register01"><i class="fadeIn animated bx bx-edit-alt"></i>Set Vehicle No.</button>
					</div>
					
								<input type="hidden" name="customer_id" value="{{$customer_id}}">
								<input type="hidden" name="id" value="{{$id}}">

				</form>

			</div>
		</div>
		
	</div>

	<div class="col-4 col-lg-4">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
				<form class="row g-3" action="payAdvance05" method='post' >
				{{ csrf_field() }}
					<div class="col-md-12">
						<label for="validationDefault01" class="form-label">Set Job No</label> 
						
						
					<select name="job_no" class="form-select" required="">
					
			<?php		
			$result01 = DB::select("
			SELECT `job_no` FROM `bill_mas` WHERE `customer_id` = '$customer_id' AND `flag` <> '3'
			");


					foreach($result01 as $post01)
						{
						
			echo '<option value="'.$post01->job_no.'">'.$post01->job_no.'</option>';		
							
						}
			?>
					</select>			

					</div>

					<div class="col-md-12">
						<label for="validationDefault01" class="form-label">Set Amount</label>
						<input type="text" name="amount" value="" class="form-control" required="">
					</div>

					<div class="col-12">
						<button class="btn btn-success" type="submit" name="register" value="register01"><i class="fadeIn animated bx bx-edit-alt"></i>Distribute to Job No.</button>
					</div>
					
								<input type="hidden" name="customer_id" value="{{$customer_id}}">
								<input type="hidden" name="id" value="{{$id}}">

				</form>

			</div>
		</div>
	</div>

	</div>
</div>		

  
</main>  
@endsection