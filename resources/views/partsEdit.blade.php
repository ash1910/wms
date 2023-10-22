@extends("layouts.master")

@section("content")
<?php
$data = DB::select("SELECT `parts_id`,`parts_name`,`cat`,`sub_cat` FROM `parts_info` WHERE `parts_id` = '$id'");
foreach($data as $item){ $parts_id = $item->parts_id ;$parts_name = $item->parts_name ;
$cat = $item->cat ;$sub_cat = $item->sub_cat ;}
?>

<main class="page-content">

		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Parts Modification</h6>
                <hr>
                <form class="row g-3" action="partsEditOne" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">Parts Name</label>
                    <input value="{{$parts_id}} - {{$parts_name}}" disabled type="text" class="form-control" >
					<input name="id" value="{{$parts_id}}" type="hidden">
                  </div>
                  
                  <div class="col-12">
                    <label class="form-label">Category</label>
                    <input value="{{$cat}}" id="tags02" placeholder="e.g: lubricant" type="text" class="form-control" name="cat" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Sub Category</label>
                    <input value="{{$sub_cat}}" id="tags03" placeholder="e.g: Engine Oil" type="text" class="form-control" name="sub_cat" >
                  </div>
				  

                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Update</button>
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

  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($company as $p) 
{
echo '"'.$p->cat.'",';
}
					   ?>
    ];
    $( "#tags02" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($sister_companies as $p) 
{
echo '"'.$p->sub_cat.'",';
}
					   ?>
    ];
    $( "#tags03" ).autocomplete({
      source: availableTags
    });
  } );
  </script> 
 
 @endsection