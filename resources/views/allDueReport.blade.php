@extends("layouts.master")

@section("content")

<?php 
//$parts_info = DB::table('customer_info')->get();
$parts_info = DB::select("SELECT distinct(`customer_nm`) FROM `customer_info`");
?>

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   ?>


<main class="page-content">
            <!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">All Due Report </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
	
	
	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">
			<form class="row g-3" action="allDueReport01" method='post'>
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Customer: </strong></td>
						<td><input value="{{ session()->get('supplier_id') }}" name="supplier" type="text" id="tags" ></td></tr>

					<tr><td><strong class="text-inverse">From Date: </strong></td><td>
					<input  autofocus type="date" style="width: 177px;" name='from_dt'></td></tr>

					<tr><td><strong class="text-inverse">To Date: </strong></td><td>
					<input  autofocus type="date" style="width: 177px;" name='to_dt'></td></tr>

					<tr style="height: 10px;"></tr>
					<tr><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Generate Report</button></td></tr>
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
echo '"'.$p->customer_nm.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 
 @endsection