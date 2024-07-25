@extends("layouts.master")

@section("content")
<?php 
$parts_info = DB::table('parts_info')->get();
?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Issue</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

<!---Alert message----> 
@if (Session::has('success'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-success">
Add Issue Successfully!
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

	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">
			<form class="row g-3" action="issue01" method='post'>
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Job No.: </strong></td>
					<td><input style="width:250px" required name="job_no" type="text" ></td></tr>
					<tr><td><strong class="text-inverse">Product: </strong></td>
					<td><input style="width:250px" name="prod" type="text" id="tags" required></td></tr>
					<tr><td><strong class="text-inverse">Quantity: </strong></td>
					<td><input style="width:250px" name="qty" type="text" required></td></tr>
					<tr><td><strong class="text-inverse">Note: </strong></td>
					<td><input style="width:250px" name="note" type="text" ></td></tr>
					
					<tr style="height: 10px;"></tr>
					<tr><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Issue</button></td></tr>
				</table>	
			</form>
		</div>
	</div></div>
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
echo '"'.$p->parts_id.' - '.$p->parts_name.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 
 @endsection