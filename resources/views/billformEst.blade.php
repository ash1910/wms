
@extends("layouts.master")

@section("content")



<?php
foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
			}
?>
<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Estimate</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">
                <div class="btn-group">
                 
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                  </div>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->


          <div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Create Estimate</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
             <div class="card-header py-2 bg-light">
               <div class="row row-cols-1 row-cols-lg-3">
                 <div class="col-6">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Date: </strong>{{date("d-M-Y")}}<br>
                       <strong class="text-inverse">Customer's Name: </strong>{{$customer_nm}}<br>
                       <strong class="text-inverse">Address: </strong>{{$customer_address}}<br>
                       <strong class="text-inverse">Contact: </strong>{{$customer_mobile}}<br>

                    </address>
                   </div>
                 </div>
                 <div class="col-3">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Registration No.: </strong>{{$customer_reg}}<br>
                       <strong class="text-inverse">Chassis No.: </strong>{{$customer_chas}}<br>
                       <strong class="text-inverse">Vehicle: </strong>{{$customer_vehicle}}<br>

                    </address>
                   </div>
                </div>

                <div class="col-3">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Customer Group: </strong>{{$customer_group}}<br>
                       <strong class="text-inverse">Company: </strong>{{$company}}<br>
                       <strong class="text-inverse">Sister Companies: </strong>{{$sister_companies}}<br>

                    </address>
                   </div>
                </div>
                			
                
               </div>
             </div>
			 
			 
			 
			<div class="card">
				<div class="card-body">
					<div class="col-4">
					  <div class="">
						<!--small>to</small-->
						<address class="m-t-5 m-b-5">
						<form action="billcardEst" method="post"> {{ csrf_field() }}
						<table>
<?php if(session('role')=="Service Engineer"){ ?>
						   <tr><td><strong class="text-inverse">Engineer: </strong></td><td><input type="text" value="{{session('user')}}" disabled>
						   <input name="engineer" type="hidden" value="{{session('user')}}" ></td></tr>
<?php } ?>
<?php if(session('role')!="Service Engineer"){ ?>
						   <tr><td><strong class="text-inverse">Engineer: </strong></td><td><input name="engineer" type="text"></td></tr>
<?php } ?>
						   <tr><td><strong class="text-inverse">Technician: </strong></td><td><input name="technician" type="text"></td></tr>
						   <tr><td><strong class="text-inverse">KM: </strong></td><td><input name="km" type="text" ></td></tr>
						   <tr><td><strong class="text-inverse">Time Required: </strong></td><td><input name="days" type="text" maxlength="3" minlength="0"> Working Days</td></tr>
						   <!-- <tr><td><div class="form-check">
									<input required class="form-check-input" type="radio" name="work" value="engineering">
									<label class="form-check-label" for="flexRadioDefault1">Engineering&nbsp;&nbsp;&nbsp;</label>
								</div></td><td><div class="form-check">
									<input required class="form-check-input" type="radio" name="work" value="intercompany">
									<label class="form-check-label" for="flexRadioDefault1">Intercompany</label>
								</div></td><td><div class="form-check">
									<input required class="form-check-input" type="radio" name="work" value="automobile">
									<label class="form-check-label" for="flexRadioDefault1">Automobile</label>
								</div></td></tr> -->
						<tr><td>					
						<button class="btn btn-success" type="submit" name="register" value="register01">
						<i class="lni lni-chevron-right-circle"></i> Next</button>
						</td></tr>
						</table>
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
						<input type="hidden" name="customer_nm" value="{{$customer_nm}}">
						</form>
						</address>
					   </div>
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
foreach ($parts_info as $p) 
{
echo '"'.$p->parts_id.' - '.$p->parts_name.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($service_info as $p) 
{
echo '"'.$p->service_id.' - '.$p->service_name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection
 
  