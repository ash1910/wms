@extends("layouts.master")

@section("content")



<main class="page-content">

<!---Alert message----> 
@if (Session::get('sucess'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-danger">
Password Change sucessfully !!!
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
                <h6 class="mb-0 text-uppercase">Enter Your New Password</h6>
                <hr>
                <form class="row g-3" action="changePassword01" method="post">{{ csrf_field() }}
                  <div class="col-12">
                    <label class="form-label">New Password</label> 
                    <input placeholder="e.g: password@123" type="text" class="form-control" name="password">
                  </div>				

				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Change your password?
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">New Password</button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div>
		</div>



  
</main>  
@endsection






