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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Ledger Accounts</li>
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
		


	<form class="row g-3" action="ledgerAccount01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Under: </strong></td>
						<td><input class="form-control" autofocus name="groups_id" type="text" id="tags" required></td></tr>
					<tr><td><strong class="text-inverse">Name: </strong></td>
						<td><input class="form-control" autofocus name="name" type="text" id="tags" required></td></tr>					
					<tr><td><strong class="text-inverse">Opening Balance: </strong></td>
						<td><input class="form-control" autofocus name="amount" type="text" id="tags" required></td></tr>					
					<tr><td><strong class="text-inverse">Type: </strong></td>
						<td>
						
						<select name="txtype" id="dropdown-menu" class="form-select">
						<option value="C">Credit</option>
						<option value="D">Debit</option>
						</select>						
						
						</td></tr>
					
					<tr style="height: 10px;"></tr>
					<tr><td></td><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Submit</button></td></tr>
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
$parts_info = DB::table('groups')->get();
foreach ($parts_info as $p) 
{
echo '"'.$p->id.' - '.$p->name.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 
 

 @endsection