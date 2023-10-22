@extends("layouts.master")

@section("content")

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   ?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">AIT </li>
                    <li class="breadcrumb-item active" aria-current="page">AIT Pending</li>
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
<?php
$result = DB::select("
SELECT `job_no`, `ait`FROM `ait` WHERE `id`='$id'
");
	$sl = '1';$amount='0'; 			
foreach($result as $item)
		{		
		$job_no = $item->job_no;
		$ait = $item->ait;
		}
?>

				<b>Job no: {{$job_no}}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>AIT Amount: {{$ait}}</b>

				</div>
			</div>
		</div>





	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">
		


	<form class="row g-3" action="ait01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">TR No: </strong></td>
						<td><input autofocus name="tr_no" type="text"></td>
					</tr>

					<tr><td><strong class="text-inverse">TR Date: </strong></td>
						<td><input autofocus name="tr_dt" type="text"></td>
					</tr>

					<tr><td><strong class="text-inverse">Customer's BIN No: </strong></td>
						<td><input autofocus name="bin" type="text"></td>
					</tr>

					<input type="hidden" name="id" value="{{$id}}">
					

					
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




