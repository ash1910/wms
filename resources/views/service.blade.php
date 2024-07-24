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
					<a class="btn btn-success" href="/serviceAdd"><i class="fadeIn animated bx bx-add-to-queue"></i> Add New Service</a>
				@endif
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered" style="width:80%">
								<thead>
									<tr>
										<th>Edit</th>
										<th>Service Code</th>
										<th>Service Name</th>
										<th>Service Type</th>
									</tr>
								</thead>
								<tbody>
								
								@foreach($data as $item)
									<tr>
									<td style="text-align: center;"><a href = "serviceEdit?id={{$item->service_id}}"><i class="lni lni-pencil-alt"></i></a></td>
										<td>{{$item->service_id}}</td>
										<td>{{$item->service_name}}</td>
										<td>{{$item->section}}</td>
										
									</tr>
								@endforeach 
								
								</tbody>
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

