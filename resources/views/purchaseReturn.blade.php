@extends("layouts.master")

@section("content")
<?php 
$parts_info = DB::table('suppliers')->get();
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
                    <li class="breadcrumb-item active" aria-current="page">Purchase</li>
                    <li class="breadcrumb-item active" aria-current="page">Return</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
@if(session()->has('alert'))
    <div class="alert alert-success">
        {{ session()->get('alert') }}
    </div>
@endif				
			

	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">
			<form class="row g-3" action="purchaseReturn01" method='post'>
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Supplier: </strong></td>
						<td><input value="{{ session()->get('supplier_id') }}" name="supplier" type="text" id="tags" required></td></tr>
					<tr><td><strong class="text-inverse">Supplier's Bill No.: </strong></td><td>
					<input value="{{ session()->get('supplier_ref') }}" required name="ref" type="text" ></td></tr>
					<tr style="height: 10px;"></tr>
					<tr><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Search</button></td></tr>
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
echo '"'.$p->supplier_id.' - '.$p->supplier_name.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 
 @endsection