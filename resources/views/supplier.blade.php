
@extends("layouts.master")

@section("content")
<main class="page-content">

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif					
				<div class="card" >
				<a class="btn btn-success" href="/supplierAdd"><i class="fadeIn animated bx bx-add-to-queue"></i> Add New Supplier</a>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>Edit</th>
										<th>Supplier Code</th>
										<th>Supplier Name</th>
										<th>Address</th>
										<th>Contact</th>
										<th>E-mail</th>
										<th>Bank Detail</th>
										<th>2nd Bank Detail</th>
										 
									</tr>
								</thead>
								<tbody>
								
								@foreach($data as $item)
									<tr>
										<td style="text-align: center;"><a href = "supplierEdit?id={{$item->supplier_id}}"><i class="lni lni-pencil-alt"></i></a></td>
										<td>{{$item->supplier_id}}</td>
										<td>{{$item->supplier_name}}</td>
										<td>{{$item->address}}</td>
										<td>{{$item->contact}}</td>
										<td>{{$item->email}}</td>
										<td>
										<b>A/C name:</b> {{$item->ac_name}}<br>
										<b>A/C no:</b> {{$item->ac_no}}<br>
										<b>Bank Name:</b> {{$item->bank_name}}<br>
										<b>Branch Name:</b> {{$item->branch_name}}<br>
										<b>Routing No:</b> {{$item->routing_no}}<br>
										<b>Swift Code:</b> {{$item->swift_code}}<br>
										</td>
										<td>
										<b>A/C name:</b> {{$item->ac_name02}}<br>
										<b>A/C no:</b> {{$item->ac_no02}}<br>
										<b>Bank Name:</b> {{$item->bank_name02}}<br>
										<b>Branch Name:</b> {{$item->branch_name02}}<br>
										<b>Routing No:</b> {{$item->routing_no02}}<br>
										<b>Swift Code:</b> {{$item->swift_code02}}<br>
										</td>
										
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

