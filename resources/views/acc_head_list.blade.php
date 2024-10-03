

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>


@extends("layouts.master")

@section("content")



<?php 
$data_AccGroup = DB::select("SELECT tbl_acc_masters.id, tbl_acc_masters.acc_name, tbl_acc_masters.grp_under,
tbl_acc_types.type_head, tbl_acc_masters.child_name 
FROM `tbl_acc_masters` INNER JOIN tbl_acc_types ON tbl_acc_masters.type_id= tbl_acc_types.id where grp_status = 'AH'");
?>





<main class="page-content">



{{-- Message --}}
@if(session('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('warning')}}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('info')}}
    </div>
@endif

@if(session('danger'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('danger')}}
    </div>
@endif
	

                	<div class="card" >
				    	<a class="btn btn-success" href="/acc_head_add"><i class="fadeIn animated bx bx-add-to-queue"></i> Back to Accounts Head</a>
					<div class="card-body">
					<div class="input-group rounded">
						<input onkeyup='searchSname()' id="mySearch" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" autofocus />
					</div>

					
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>Edit</th>
										<th>Delete</th>
										<th>ID</th>
										<th>Group Name</th>
										<th>Default Gruop</th>
										<th>Type</th>
									</tr>
								</thead>
								<tbody id="myBody">
                                @if(isset( $data_AccGroup ))
								@foreach($data_AccGroup as $item)
									<tr>
									<tr>
										<td style="text-align: center;"><a href = "acc_head_add?id={{$item->id}}"><i class="lni lni-pencil-alt"></i></a></td>

										<td style="text-align: center;"><a href = "acc_head_list?id={{$item->id}}"onclick="return confirm('Are you sure want to delete?')" style="color:red;" > X </a></td>
										
										<td>{{$item->id}}</td>
										<td>{{$item->acc_name}}</td>
										<td>{{$item->child_name}}</td>
										<td>{{$item->type_head}}</td>
										
										
									</tr>
								@endforeach 
                                @endif
								
								</tbody>
							</table>
						</div>
				



</main>  
@endsection


@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>

  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

  <script>

	function searchSname() {
			var input, filter, found, table, tr, td, i, j;
			input = document.getElementById("mySearch");
			filter = input.value.toUpperCase();
			table = document.getElementById("myBody");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td");
				for (j = 0; j < td.length; j++) {
					if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
						found = true;
					}
				}
				if (found) {
					tr[i].style.display = "";
					found = false;
				} else {
					tr[i].style.display = "none";
				}
			}
		}

  </script>
  
 
 

 
 @endsection
