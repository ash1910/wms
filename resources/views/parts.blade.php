<?php 
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")||(session('role')=="Store")||(session('role')=="Service Engineer"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
//echo session('role');
}
else {
?>
  <script>
    window.location = "/logout";
  </script>
<?php  
}
?>

  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")
<main class="page-content">

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif					
				<div class="card" >
				@if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator"))
					<a class="btn btn-success" href="/partsAdd"><i class="fadeIn animated bx bx-add-to-queue"></i> Add New Parts</a>
				@endif
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Edit</th>
										<th>Parts Code</th>
										<th>Parts Name</th>
										<th>Category</th>
										<th>Sub Category</th>
										<th>Parts Type</th>
									</tr>
								</thead>
								<tbody>
								
								@foreach($data as $item)
									<tr>
										<td style="text-align: center;"><a href = "partsEdit?id={{$item->parts_id}}"><i class="lni lni-pencil-alt"></i></a></td>
										<td>{{$item->parts_id}}</td>
										<td>{{$item->parts_name}}</td>
										<td>{{$item->cat}}</td>
										<td>{{$item->sub_cat}}</td>
										<td>{{$item->section}}</td>
									</tr>
								@endforeach 
								
								</tbody>
								<tfoot>
									<tr>
										<th>Parts Code</th>
										<th>Parts Name</th>
									
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>






  
</main>  
@endsection




@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection

