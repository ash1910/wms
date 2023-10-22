@extends("layouts.master")

@section("content")



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
                    <li class="breadcrumb-item active" aria-current="page">Create Groups</li>
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
			<form class="row g-3" style="padding-left: 10px;" action="groupAccount01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Name: </strong></td>
						<td><input autofocus name="group" type="text" id="tags" required></td></tr>
					<tr><td style="padding-top: 20px;"><input id="enable-dropdown" type = "checkbox"><strong class="text-inverse"> Parent</strong></td>
						<td></td>
					</tr><tr><td><strong class="text-inverse">Under: </strong></td>
						<td><select name="parent_id" id="dropdown-menu" disabled class="form-select">
<?php						
$data = DB::select("SELECT `id`,`name` FROM `groups` order by `name`");
foreach($data as $item){ 

							echo '<option value="'.$item->id.'">'.$item->name.'</option>';

}
?>							
							  

							</select>
						</td></tr>
					

					
					<tr style="height: 10px;"></tr>
					<tr><td><button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Submit</button></td></tr>
				</table>	
			</form>
		</div>
	</div></div>
</div>			




			
</main>
@endsection		 






@section("js")






<script>
const checkbox = document.getElementById('enable-dropdown');
const dropdown = document.getElementById('dropdown-menu');

checkbox.addEventListener('change', function() {
  if (checkbox.checked) {
    dropdown.disabled = false;
  } else {
    dropdown.disabled = true;
  }
});
</script>
 
 @endsection