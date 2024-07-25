<?php 
if ((session('role')=="Super Administrator")||(session('user')=="Mosharraf"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
//echo session('role');
}
else {
?>
  <script>
    window.location = "/logout";
  </script>
<?php  
}
?>

@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if (Session::get('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-danger">
Invalid Customer, Please Signup the Entry Form
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

<div class="col-xl-6 mx-auto">
	<div class="card" style="background: lightyellow;">
	  <div class="card-body">
		<div class="border p-3 rounded">
		<h6 class="mb-0 text-uppercase">New BOM Parts Entry Form</h6>
		<hr>
		<form class="row g-3" action="bomPartsAddOne" method="post">{{ csrf_field() }}
						
		  <div class="col-12">
			<label class="form-label">BOM Parts Name</label>
			<input id="tags01" placeholder="e.g: Oil Filter" type="text" class="form-control" name="parts_name" required>
		  </div>
		  
		  <div class="col-12">
			<label class="form-label">Category</label>
			<input id="tags02" placeholder="e.g: lubricant" type="text" class="form-control" name="company" >
		  </div>
		  <div class="col-12">
			<label class="form-label">Sub Category</label>
			<input id="tags03" placeholder="e.g: Engine Oil" type="text" class="form-control" name="sister_companies" >
		  </div>
		  
		  <div class="col-12">
			<div class="form-check d-flex justify-content-center gap-2">
			  <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
			  <label class="form-check-label" for="gridCheck3-c" required>
				Create a New BOM Parts?
			  </label>
			</div>
		  </div>
		  <div class="col-12">
			<div class="d-grid">
			  <button type="submit" class="btn btn-primary">Create</button>
			</div>
		  </div>
		</form>
	  </div>
	  </div>
	</div>
</div>



  
</main>  
@endsection






@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>

  
  
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($parts_info as $p) 
{
echo '"'.$p->parts_name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
 
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($company as $p) 
{
echo '"'.$p->cat.'",';
}
					   ?>
    ];
    $( "#tags02" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($sister_companies as $p) 
{
echo '"'.$p->sub_cat.'",';
}
					   ?>
    ];
    $( "#tags03" ).autocomplete({
      source: availableTags
    });
  } );
  </script> 
 
 @endsection