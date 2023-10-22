@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if(session()->has('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
                <h6 class="mb-0 text-uppercase">Ledger Sub Group Entry Form</h6>
                <hr>
                <form class="row p-3" action="led_sub02" method="post">{{ csrf_field() }}
                 				
                 <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Master Name</label>
					<div class="col-sm-8">
						<select id="sub_category_name" name="master_id" class="form-select mb-3">
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
                    <label class="col-sm-4 col-form-label">Group Name</label>
					<div class="col-sm-8">
						<select class="form-select mb-3" id="sub_category"></select> 
					</div>
				 </div>
				  
                 <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Sub Group01 Name</label>
					<div class="col-sm-8">
						<select name="parent_id" class="form-select mb-3" id="sub_category01"></select> 
					</div>
				 </div>
				  
                 <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Sub Group02 Name</label>
					<div class="col-sm-8">
                    <input id="tags01" placeholder="e.g: Current Assets" type="text" class="form-control" name="name" required>
					</div>
				  </div>
				  
 
                  
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Ledger Sub Group?
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

  
  
  
  
    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
                $(document).ready(function () {
                $('#sub_category_name').on('change', function () {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'masTogroup/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Select Group Name*</option>`);
                $('#sub_category').append(``);
                response.forEach(element => {
                    $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });
    </script>
    <script>
                $(document).ready(function () {
                $('#sub_category').on('change', function () {
                let id = $(this).val();
                $('#sub_category01').empty();
                $('#sub_category01').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'masTogroup01/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#sub_category01').empty();
               // $('#sub_category01').append(`<option value="0" disabled selected>Select Group Name*</option>`);
                $('#sub_category01').append(``);
                response.forEach(element => {
                    $('#sub_category01').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });
    </script>

 @endsection