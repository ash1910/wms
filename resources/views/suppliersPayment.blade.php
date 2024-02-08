@extends("layouts.master")

@section("content")

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
                    <li class="breadcrumb-item active" aria-current="page">Cash Out </li>
                    <li class="breadcrumb-item active" aria-current="page">Suppliers Payment </li>
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
		


	<form class="row g-3" action="suppliersPayment01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Supplier: </strong></td>
						<td><input autofocus name="supplier" type="text" id="tags" required></td></tr>

					<tr>
						<td>
							<select name='mon' style="width: 100%;height: 25px;">
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
							</select>
						</td>
						<td>
							<select name='year' style="width: 73%;height: 25px;">
							<option value="2023">2024</option>
							<option value="2023">2023</option>
							<option value="2022">2022</option>
							<option value="2021">2021</option>
							<option value="2020">2020</option>
							<option value="2019">2019</option>
							</select>
						</td>
					</tr>
					

					
					<tr style="height: 10px;"></tr>
					<tr><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Next</button></td></tr>
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
$parts_info = DB::table('suppliers')->get();
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