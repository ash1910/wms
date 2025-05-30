
@extends("layouts.master")

@section("content")
<main class="page-content">

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif					
				<div class="card" >
				<a class="btn btn-success" href="/userAdd"><i class="fadeIn animated bx bx-add-to-queue"></i> Add New User</a>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered" style="width:40%">
								<thead>
									<tr>
										<th>User Name</th><th>Role</th>
										
									</tr>
								</thead>
								<tbody>
								
								@foreach($data as $item)
									<tr>

										<td>{{$item->user_name}}</td>
										<td>{{$item->role}}</td>
										
									</tr>
								@endforeach 
								
								</tbody>
								<tfoot>
									<tr>
										<th>User Name</th><th>Role</th>
									
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

