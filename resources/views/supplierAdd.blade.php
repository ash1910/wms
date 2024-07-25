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

		<div class="col-xl-7 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">New Supplier Entry Form</h6>
                <hr>
                <form class="row g-3" action="supplierAddOne" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">Supplier Name</label>
                    <input id="tags01" placeholder="e.g: A R Autos" type="text" class="form-control" name="supplier_name" required>
                  </div>


                  <div class="col-12">
                    <label class="form-label">Address</label>
                    <input id="tags01" placeholder="e.g: Gulshan 1" type="text" class="form-control" name="address" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Contact</label>
                    <input id="tags01" placeholder="e.g: 01XXXXXXXXX" type="text" class="form-control" name="contact" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">E-mail</label>
                    <input id="tags01" placeholder="e.g: xxxx@gmail.com" type="text" class="form-control" name="email" >
                  </div>

<?php if(session('role')!="Store"){ ?>
				  
                  <div class="col-12">
                    <center><label class="form-label"><h3>Bank Information</h3></label></center>
                    <center><label class="form-label">First Account Information</label></center>
                  </div>
				  
				  
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code" >
                  </div>


				
                  <div class="col-12">
                    <center><label class="form-label">Second Account Information</label></center>
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code02" >
                  </div>

<?php } ?>
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Supplier?
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
echo '"'.$p->supplier_name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection