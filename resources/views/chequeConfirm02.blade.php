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
                    <li class="breadcrumb-item active" aria-current="page">Cheque Confirm</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
			
@if(session()->has('alert'))
    <div class="alert alert-danger">
        {{ session()->get('alert') }}
    </div>
@endif				

<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-5">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<form class="row g-3" action="chequeConfirm03" method='post' enctype="multipart/form-data">
			{{ csrf_field() }}
				<table>
					<tr><td><strong class="text-inverse"><h3>Job No: {{$job_no}}</h3></strong></td></tr>
					<tr><td><strong class="text-inverse">Deny Document: </strong></td></tr>
					<tr>	<td><input required name='denyImage' class="form-control" id="formFileLg" type="file"></td>
						<td><button class="btn btn-success" type="submit" >
						<i class="lni lni-chevron-right-circle"></i> Upload</button></td>
					</tr>
				</table>	
		<input type="hidden" name="id" value="{{$id}}">
		<input type="hidden" name="job_no" value="{{$job_no}}">
		<input type="hidden" name="chequeNo" value="{{$chequeNo}}">
			</form>
			</div>
		</div>
	</div>
</div>			




			
</main>
@endsection		 





