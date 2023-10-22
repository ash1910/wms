
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
                 <div class="col-7">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Customer's Name: </strong>{{$customer_nm}}<br>
                       <strong class="text-inverse">Address: </strong>{{$customer_address}}<br>
                       <strong class="text-inverse">Registration No.: </strong>{{$customer_reg}}<br>

                    </address>
                   </div>
                 </div>
                 <div class="col-5">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Chassis No.: </strong>{{$customer_chas}}<br>
                       <strong class="text-inverse">Vehicle: </strong>{{$customer_vehicle}}<br>
                       <strong class="text-inverse">Time Require: </strong><br>

                    </address>
                   </div>
                </div>
                
               </div>
             </div>
			 
			 
			 
<div class="card">
							<div class="card-body">
								<ul class="nav nav-tabs nav-primary" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="tab" href="#parts" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class="bx bx-cart font-18 me-1"></i>
												</div>
												<div class="tab-title">Parts</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#service" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class="bx bx-cog font-18 me-1"></i>
												</div>
												<div class="tab-title">Service</div>
											</div>
										</a>
									</li>
								</ul>
								<div class="tab-content py-3">
								<!---Parts---------->
									<div class="tab-pane fade active show" id="parts" role="tabpanel">
	

				<form class="row g-3" action="estimateAdd" method="post">{{ csrf_field() }}
                  <!--div class="col-2">
                    <input class="form-control" type="text" placeholder="Parts ID">
                  </div-->
				  
				  <input type="hidden" name="customer_id" value="{{$customer_id}}">
				  <input type="hidden" name="type" value="1">
				  
                  <div class="col-8">
                    <input id="tags" name="product" class="form-control" type="text" placeholder="Parts Name">
                  </div>
				  
				  
				  
				  
				  
				 <div class="col-2">
                    <input class="form-control" name="qty" type="text" placeholder="Parts Qty" value='1'>
                  </div>
                  
                 
                  
                  
                  <div class="col-1">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                  

                </form>				  
								
										
										
									</div>
								<!---Parts---------->
								<!---Service---------->
				<div class="tab-pane fade" id="service" role="tabpanel">
<form class="row g-3" action="estimateAdd" method="post">{{ csrf_field() }}
                  
				  
				  <input type="hidden" name="customer_id" value="{{$customer_id}}">
				  <input type="hidden" name="type" value="2">
				  
				  
                  <div class="col-8">
                    <input id="tags01" name="product" class="form-control" type="text" placeholder="Service Name">
                  </div>
				  
				  
				  
				  
				  
				 <div class="col-2">
                    <input class="form-control" name="qty" type="text" placeholder="Parts Qty" value='1'>
                  </div>
                  
                 
                  
                  
                  <div class="col-1">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                  

                </form>	
									</div>
								<!---Service---------->
								</div>
							</div>
						</div>			 
			 
			 
			 
			 
			 
			
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-invoice">
                   <thead>
                      <tr>
                         <th>SL.</th>
                         <th>Description</th>
                         <th class="text-center" width="10%">Quantity</th>
                         <th class="text-left" width="10%">Price</th>
                         <th class="text-right" width="20%">Total (Tk.)</th>
                      </tr>
                   </thead>
                   <tbody>
 
 <tr style="text-align: center;"><td colspan="5"><b>Parts</b></td></tr>                   
 <?php 
////////////Result Parts//////////////////////// 
$sl = '1';                 
$total01 = '0';                 
foreach($estimate_parts as $item1)
{ 
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td>{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
                         <td class="text-center">{{$qty}}</td>
                         <td class="text-right">{{number_format($unit_price, 2, '.', ',')}}</td>
                         <td class="text-right">{{number_format($total, 2, '.', ',')}}</td>
                      </tr>
<?php
$sl = $sl+1;
$total01=$total01+$total;
}  				
?> 
<tr style="text-align: center;"><td colspan="5"><b>Service</b></td></tr>
<?php 
////////////Result Service//////////////////////// 
$sl = '1';                 
$total02 = '0';                 
foreach($estimate_service as $item1)
{ 
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td>{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
                         <td class="text-center">{{$qty}}</td>
                         <td class="text-right">{{number_format($unit_price, 2, '.', ',')}}</td>
                         <td class="text-right">{{number_format($total, 2, '.', ',')}}</td>
                      </tr>
<?php
$sl = $sl+1;
$total02=$total02+$total;
} 
?>
<tr style="text-align: center;"><td colspan="5"><b>Sample</b></td></tr>
<?php 
////////////Result Sample//////////////////////// 
$sl = '1';                 
$total03 = '0';                 
foreach($estimate_sample as $item1)
{ 
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td>{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
                         <td class="text-center">{{$qty}}</td>
                         <td class="text-right">{{number_format($unit_price, 2, '.', ',')}}</td>
                         <td class="text-right">{{number_format($total, 2, '.', ',')}}</td>
                      </tr>
<?php
$sl = $sl+1;
$total03=$total03+$total;
} 







$total03= $total01+$total02+$total03;				
?> 




                    
                   </tbody>
                </table>
             </div>

             <div class="row bg-light align-items-center m-0">
               <div class="col col-auto p-4">
                  <p class="mb-0"></p>
			  
					<div class="col">
					<form action="jobAccept" method="get">{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
                        <button type="submit" class="btn btn-lg btn-outline-success px-5">
						<i class="fadeIn animated bx bx-check-circle"></i> Accept</button>
                    </form>
					</div>				  
				  
               </div>
               
               <div class="col col-auto me-auto p-4">
                  <p class="mb-0"></p>
				  
					<div class="col">
					<form action="jobModify" method="get">{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
                        <button type="submit" class="btn btn-lg btn-outline-primary px-5">
						<i class="fadeIn animated bx bx-edit-alt"></i> Modify</button>
                    </form>
					</div>				  
               </div>
               
               <div class="col col-auto me-auto p-4">
                  <p class="mb-0"></p>
				  
					<div class="col">
					<form action="jobSample" method="get">{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
                        <button type="submit" class="btn btn-lg btn-outline-primary px-5">
						<i class="lni lni-clipboard"></i> Sample</button>
                    </form>
					</div>				  
               </div>			   
               <div class="col col-auto me-auto p-4">
                  <p class="mb-0"></p>
				  
					<div class="col">
					<form action="jobCancel" method="get">{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
                        <button type="submit" class="btn btn-lg btn-outline-danger px-5">
						<i class="fadeIn animated bx bx-exit"></i> Cancel</button>
                    </form>
					</div>				  
               </div>			   
               
			   
			   <div class="col bg-dark col-auto p-4">
                <p class="mb-0 text-white">TOTAL</p>
                <h4 class="mb-0 text-white">Tk. {{number_format($total03, 2, '.', ',')}}</h4>
               </div>
             </div><!--end row-->

             <hr>
           <!-- begin invoice-note -->
           <div class="my-3">
            
           </div>
         <!-- end invoice-note -->
            </div>
			
			

            <div class="card-footer py-3">
                <p class="text-center mb-2">
                   
                </p>
                
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
 
  