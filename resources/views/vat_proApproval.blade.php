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
                    <li class="breadcrumb-item active" aria-current="page">VAT </li>
                    <li class="breadcrumb-item active" aria-current="page">VAT Provision</li>
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
SELECT `job_no`, `vat_pro`FROM `pay` WHERE `id`='$id'
");
	$sl = '1';$amount='0'; 			
foreach($result as $item)
		{		
		$job_no = $item->job_no;
		$vat_pro = $item->vat_pro;
		}
?>

				<b>Job no: {{$job_no}}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>VAT Provision: Tk. {{number_format(($item->vat_pro), 2, '.', ',');}}</b>

				</div>
			</div>
		</div>





	<div class="col-12 col-lg-5">
	<div class="card shadow-none border radius-15">
		<div class="card-body">
		


	<form class="row g-3" action="vat_pro01" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">BIN No: </strong></td>
						<td style="width: 30px;"><input autofocus name="bin" type="text"></td>
					</tr>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">6.6 Chalan (VDS)No: </strong></td>
						<td><input autofocus name="chalan6no" type="text"></td>
					</tr>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">6.6 Chalan (VDS) Date: </strong></td>
						<td><input autofocus name="chalan6dt" type="text"></td>
					</tr>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">Tax Deposit(VDS Treasury)Date: </strong></td>
						<td><input autofocus name="taxdt" type="text"></td>
					</tr>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">6.3 Chalan No: </strong></td>
						<td><input autofocus name="chalan3no" type="text"></td>
					</tr>
					<tr style="border: 1px solid;"><td><strong class="text-inverse">6.3 Chalan Date: </strong></td>
						<td><input autofocus name="chalan3dt" type="text"></td>
					</tr>

					<input type="hidden" name="job_no" value="{{$job_no}}">
					<input type="hidden" name="vat_pro" value="{{$vat_pro}}">
					

					
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




