
@extends("layouts.master")

@section("content")

<?php 

//$bill_no = session('bill_no');
$bill_no = $_GET["bill"];


$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle,
b.customer_chas, `engineer`, `technician`, `job_no`, `job_dt`, `user_id`, `net_bill` ,`km`, `cartridge`, a.flag
FROM `bill_mas` a, `customer_info` b
WHERE a.`bill_no` = $bill_no
AND a.customer_id = b.customer_id;
");
			$parts_info = DB::table('parts_info')->get();
			$service_info = DB::table('service_info')->get();





		foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $customer_chas = $post->customer_chas;
				 $engineer = $post->engineer;
				 $technician = $post->technician;
				 $job_no = $post->job_no;
				 $km = $post->km;
				 $job_dt = $post->job_dt;
				 $user_id = $post->user_id;
				 $flag = $post->flag;
				 $cartridge = $post->cartridge;
			}
			
if($flag!='0')
{
return redirect('home');
}
			
?>
		<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Bill</div>
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
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Create Bill/ Cash Memo [Bill No: {{$bill_no}}]
					  
					<form  target="_blank" style="display: inline;" action="billPrint_as" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form>
			
					<form style="display: inline;" action="changeCustomer" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<input type="hidden" name="job_no" value="{{$job_no}}">
					<input type="hidden" name="km" value="{{$km}}">
					<input type="hidden" name="engineer" value="{{$engineer}}">
					<input type="hidden" name="technician" value="{{$technician}}">
					<input type="hidden" name="cartridge" value="{{$cartridge}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated lni lni-reload"></i> Change Customer/Date/JobID</button>
					</form>					
					  
					  </h5>
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
                       <strong class="text-inverse">Job Date: </strong>{{date('d-M-Y', strtotime($job_dt))}}<br>
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
					<table>
                       <strong class="text-inverse">Engineer: </strong>{{$engineer}}<br>
                       <strong class="text-inverse">Technician: </strong>{{$technician}}<br>
                       <strong class="text-inverse">KM:  </strong>{{$km}}<br>
                       <strong class="text-inverse">Job No.:  </strong>{{$job_no}}<br>
					</table>
					</address>
				   </div>
				</div>			
                
               </div>
             </div>
	
	
			 
			 
			<div class="card">
				<div class="card-body">
					<div class="row">
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
						<div class="tab-content py-3  col-lg-4">	
						<!----------------parts--------------------->							
							<div class="tab-pane fade active show" id="parts" role="tabpanel">
								<div class="col-12 d-flex">
									<div class="card border shadow-none w-100">
										<div class="card-body">
										<form action="billMemoOne" method="post" class="row g-3">{{ csrf_field() }}
										<input type="hidden" name="bill_no" value="{{$bill_no}}">
										 <div class="col-12">
										   <label class="form-label">Product</label>
										   <input autofocus required id="tags" name="prod" type="text" class="form-control" placeholder="e.g.- Engine Hood">
										 </div>
										 <div class="col-12">
										  <label class="form-label">Quantity</label>
										  <input required name="qty" type="text" class="form-control" placeholder="e.g.- 1">
										</div>
										<div class="col-12">
										   <label class="form-label">Unit Rate</label>
										   <input required name="salepp" type="text" class="form-control" placeholder="e.g.- 25000">
										 </div>
										<div class="col-12">
										  <div class="d-grid">
											<button class="btn btn-primary">Add Bill</button>
										  </div>
										</div>
									   </form>
										</div>
									</div>
								</div>
							</div>
						<!----------------service--------------------->							
							<div class="tab-pane fade" id="service" role="tabpanel">
								<div class="col-12 d-flex">
									<div class="card border shadow-none w-100">
										<div class="card-body">
										<form action="billMemoTwo" method="post" class="row g-3">{{ csrf_field() }}
										<input type="hidden" name="bill_no" value="{{$bill_no}}">
										 <div class="col-12">
										   <label class="form-label">Service</label>
										   <input  required id="tags01" name="prod" type="text" class="form-control" placeholder="e.g.- Engine Hood">
										 </div>
										 <div class="col-12">
										  <label class="form-label">Quantity</label>
										  <input required name="qty" type="text" class="form-control" placeholder="e.g.- 1">
										</div>
										<div class="col-12">
										   <label class="form-label">Unit Rate</label>
										   <input required name="salepp" type="text" class="form-control" placeholder="e.g.- 25000">
										 </div>
										<div class="col-12">
										  <div class="d-grid">
											<button class="btn btn-primary">Add Bill</button>
										  </div>
										</div>
									   </form>
										</div>
									</div>
								</div>
							</div>
									<center>
					<!--form action="billPrint" method="post">{{ csrf_field() }}
						<input type="hidden" name="bill_no" value="{{$bill_no}}">
                        <button type="submit" class="btn btn-lg btn-outline-success px-5">
						<i class="fadeIn animated bx bx-printer"></i> Print</button>
                    </form-->
									</center>

							
						</div>					
					
					
						
						
						
						
						
						
						
						
	<div class="col-12 col-lg-8 d-flex">
		<div class="card border shadow-none w-100">
			<div class="card-body">
				<div class="table-responsive">
			


					<div class="col-7">
						<div class="">
							<!--small>from</small-->
							<address class="m-t-5 m-b-5">
							   <strong class="text-inverse">Total Amount: Tk. 
							   <?php
								$data = DB::select("SELECT SUM(`net_bill`) net_bill, SUM(`total`) total  FROM `bill_mas` WHERE `bill_no`=$bill_no;");
								foreach($data as $item){ 
								$net_bill = $item->net_bill;
								$total = $item->total; }
								echo number_format(intval($net_bill), 2, '.', ',');
							   ?>
							   <br></strong>
							   <strong class="text-inverse">Total (Amount+VAT): Tk. {{number_format(intval($total), 2, '.', ',')}}
							</address>
						</div>
					 </div>
				
				
				
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col">Edit</th>
							<th scope="col">Sl.</th>
							<th scope="col">Product</th>
							<th scope="col">Quantity</th>
							<th scope="col">Unit Rate</th>
							<th scope="col">Amount(Tk.)</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
					
<tr><td colspan="7"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parts</strong></td></tr>
					
<?php
	$stock = DB::select("
	SELECT `id`,`bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`, id
	FROM `bill_det` WHERE type = '1' and `bill_no`=$bill_no;");
	$sl="1";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<td style="text-align: center;" class="sorting_1">
						
						
							<form style="display: inline;" action="billMemoEdit" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="bill_no" value="{{$item->bill_no}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>
						
						</td>
						<td scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: center;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						<td><center>
							<form style="display: inline;" action="billMemoThree" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<button class="btn btn-sm btn-danger me-2" type="submit" name="" value=""><i class="fadeIn animated bx bx-trash"></i>&nbsp;</button>
							</form>
							</center>
						</td>
					</tr>
		<?php
		$sl = $sl+1;
		}  
				
?>
<tr><td colspan="7"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</strong></td></tr>
<?php
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`, id
	FROM `bill_det` WHERE type = '2' and `bill_no`=$bill_no;");
	$sl="1";
	foreach($stock as $item)
		{ 					
?>					<tr>
						<td style="text-align: center;" class="sorting_1">
						
						
							<form style="display: inline;" action="billMemoEdit" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="bill_no" value="{{$item->bill_no}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>
						
						</td>
						<td scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: center;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						<td><center>
							<form style="display: inline;" action="billMemoThree" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<button class="btn btn-sm btn-danger me-2" type="submit" name="" value=""><i class="fadeIn animated bx bx-trash"></i>&nbsp;</button>
							</form>
							</center>
						</td>
					</tr>
		<?php
		$sl = $sl+1;
		}  
				
?>							
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>


							
                          </div>
                         
                        </div>
                      </div>
                    </div>
					</div><!--end row-->
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
 
  