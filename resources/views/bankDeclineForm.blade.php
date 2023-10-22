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
                    <li class="breadcrumb-item active" aria-current="page">Bank Decline (POS)</li>
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

<div class="row">
	<div class="col-12 col-lg-5 " style="padding:20px">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<form class="row g-3" action="bankDeclinePayment" method='post' name="myForm" onsubmit="return validateForm()">{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Job Number: </strong><br><br></td>
						<td><input autofocus name="job_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr><td><strong class="text-inverse">Card last 4 digit: </strong><br><br></td>
						<td><input name="card_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr>
						<td colspan="2" style="text-align: right;"><button class="btn btn-success" type="submit" >
						<i class="lni lni-chevron-right-circle"></i> Submit</button></td>
					</tr>
				</table>	
			</form>
			</div>
		</div>
	</div>

  <div class="col-12 col-lg-5 " style="padding:20px">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<form class="row g-3" action="bankDeclinePayment01" method='post' name="myForm" onsubmit="return validateForm()">{{ csrf_field() }}
				<table>
					<tr><td><strong class="text-inverse">Reg Number: </strong><br><br></td>
						<td><input name="reg_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr><td><strong class="text-inverse">Card last 4 digit: </strong><br><br></td>
						<td><input name="card_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr>
						<td colspan="2" style="text-align: right;"><button class="btn btn-success" type="submit" >
						<i class="lni lni-chevron-right-circle"></i> Submit</button></td>
					</tr>
				</table>	
			</form>
			</div>
		</div>
	</div>

  <div class="col-12 col-lg-5 " style="padding:20px">
		<div class="card shadow-none border radius-15">
			<div class="card-body">
			<form class="row g-3" action="bankDeclinePayment01" method='post' name="myForm" onsubmit="return validateForm()">{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Chassis Number: </strong><br><br></td>
						<td><input name="chassis_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr><td><strong class="text-inverse">Card last 4 digit: </strong><br><br></td>
						<td><input name="card_no" type="text" id="tags" required style="width: 100%;"><br><br></td>
					</tr>
          <tr>
						<td colspan="2" style="text-align: right;"><button class="btn btn-success" type="submit" >
						<i class="lni lni-chevron-right-circle"></i> Submit</button></td>
					</tr>
				</table>	
			</form>
			</div>
		</div>
	</div>

  
</div>			




			
</main>
@endsection		 





