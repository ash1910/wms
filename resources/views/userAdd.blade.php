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
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">New User Entry Form</h6>
                <hr>
                <form class="row g-3" action="userAddOne" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">User Name</label>
                    <input id="tags01" placeholder="e.g: Nishan" type="text" class="form-control" name="user_name" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Full Name</label>
                    <input id="tags01" placeholder="e.g: Muktaderul Kader" type="text" class="form-control" name="full_name" required>
                  </div>				  
                  <div class="col-12">
                    <label class="form-label">Password</label>
                    <input placeholder="e.g: 1" type="text" class="form-control" name="password" required>
                  </div>				  
                   <div class="col-12">
                    <label class="form-label">Role</label>
								<select name="role" class="form-select mb-3" required>
									<option value="Accounts">Accounts</option>
									<option value="Administrator">Administrator</option>
									<option value="Service Engineer">Service Engineer</option>
									<option value="Store">Store</option>
								</select>
                  </div>                 
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New User?
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
foreach ($user_info as $p) 
{
echo '"'.$p->user_name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection