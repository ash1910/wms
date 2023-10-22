@extends("layouts.master")

@section("content")
<main class="page-content">
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Receivable</li>
                    <li class="breadcrumb-item active" aria-current="page">Advance</li>
                  </ol>
                </nav>
              </div>
              
            </div>
<!---Alert message----> 
@if (Session::get('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >


	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">


	<form class="row g-3" action="searchClient" method='get'  target="_blank">
	{{ csrf_field() }}
		<div class="col-md-12">
			<label for="validationDefault01" class="form-label">Search Job No</label>
			<input autofocus placeholder="&#xf002" type="text" class="fas form-control" name='search' required="">
		</div>

		<div class="col-12">
			<button class="btn btn-success" type="submit" name="register" value="register01"><i class="fadeIn animated bx bx-edit-alt"></i> Job No.</button>
		</div>
	</form>

</div>
	</div></div>
</div>		

  
</main>  
@endsection