@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if(session()->has('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
    <div class="alert alert-success">
        {{ session()->get('alert') }}
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
                <h6 class="mb-0 text-uppercase">Ledger Group Entry Form</h6>
                <hr>
                <form class="row p-3" action="led_group01" method="post">{{ csrf_field() }}
                 				
                 <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Master Name</label>
					<div class="col-sm-9">
						<select name="master_id" class="form-select mb-3" aria-label="Default select example">
							<option selected="">Open this select menu</option>

						<?php	
							$data = DB::select("SELECT `id`,`name` FROM `coa` where parent_id = '0'");
							foreach($data as $item){ 
							
							echo '<option value="'.$item->id.'">'.$item->name.'</option>' ;
							
							}
						?>	
						</select>
					</div>
				 </div>
                 <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Group Name</label>
					<div class="col-sm-9">
                    <input id="tags01" placeholder="e.g: Current Assets" type="text" class="form-control" name="name" required>
					</div>
				  </div>
				  
 
                  
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Ledger Group?
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

  
  
 						<?php	
							$led_group = DB::select("SELECT `name` FROM `coa`");
						?>	
 
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($led_group as $p) 
{
echo '"'.$p->name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection