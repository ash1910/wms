@extends("layouts.master")

@section("content")

<?php 
if ((session('user')=="Nishan")){
?>

<main class="page-content">


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >


	<form class="row g-3" action="ModifyAcceptBill01" method='post'>
	{{ csrf_field() }}
		<div class="col-md-4">
			<label for="validationDefault01" class="form-label">Enter Modify Job ID</label>
			<input autofocus placeholder="&#xf002" type="text" class="fas form-control" name='job' required="">
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register"><i class="fadeIn animated bx bx-edit-alt"></i> Search</button>
		</div>
	</form>



  
</main>  



<?php } ?>
@endsection