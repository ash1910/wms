@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if (Session::get('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">New Parts Entry Form</h6>
                <hr>
                <form class="row g-3" action="partsAddOne" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">Parts Name</label>
                    <input id="tags01" placeholder="e.g: Oil Filter" type="text" class="form-control" name="parts_name" required>
                  </div>
                  
                  <div class="col-12">
                    <label class="form-label">Category</label>
                    <input id="tags02" placeholder="e.g: lubricant" type="text" class="form-control" name="cat" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Sub Category</label>
                    <input id="tags03" placeholder="e.g: Engine Oil" type="text" class="form-control" name="sub_cat" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Parts Type</label>
                    <select class="form-control" name="section" >
                      <option value="">Select</option>
                      <option value="General Repair" >General Repair</option>
                      <option value="A.C & Electric">A.C & Electric</option>
                      <option value="Body & Paint">Body & Paint</option>
                      <option value="Maintenance">Maintenance</option>
                      <option value="CNG & LPG">CNG & LPG</option>
                    </select>
                  </div>
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Parts?
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