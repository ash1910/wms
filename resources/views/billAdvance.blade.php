@extends("layouts.master")

@section("content")
<main class="page-content">

<!---Alert message----> 

<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-danger">
Job No Not Found ! Please Create Bill First !
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

<!---Alert message----> 


<link rel="stylesheet" href="assets/css/fontawesome-all-v5.6.3.css" >

	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="searchClient" method='get' target="_blank">
	{{ csrf_field() }}
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Search Client</label>
			<input autofocus placeholder="&#xf002" type="text" class="fas form-control" name='search' required="">
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register"><i class="fadeIn animated bx bx-edit-alt"></i> Registration No.</button>
			<button class="btn btn-success" type="submit" name="chas" value="chas"><i class="fadeIn animated bx bx-car"></i> Chassis No.</button>
		</div>
	</form>

</div>
	</div></div>
</div>		


  
</main>  
@endsection