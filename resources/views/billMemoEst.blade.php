
@extends("layouts.master")

@section("content")

<?php
$est_no = $_GET["est_no"];


$result = DB::select("
SELECT `est_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle, year, car_colour,
b.customer_chas, `engineer`, `technician`, `days`, `est_dt`, `user_id`, `net_bill` ,`km`, a.flag
FROM `est_mas` a, `customer_info` b
WHERE a.`est_no` = $est_no
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
				 $km = $post->km;
				 $est_dt = $post->est_dt;
				 $user_id = $post->user_id;
				 $flag = $post->flag;
				 $days = $post->days;
				 $year = $post->year;
				 $car_colour = $post->car_colour;
			}

if($flag!='0')
{
//return redirect('home');
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
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Create Estimate [Estimate No: {{$est_no}}]

					<form  target="_blank" style="display: inline;" action="billPrint_asEst" method="post">{{ csrf_field() }}
					<input type="hidden" name="est_no" value="{{$est_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form>

					<form style="display: inline;" action="changeCustomerEst" method="post">{{ csrf_field() }}
					<input type="hidden" name="est_no" value="{{$est_no}}">
					<input type="hidden" name="days" value="{{$days}}">
					<input type="hidden" name="km" value="{{$km}}">
					<input type="hidden" name="engineer" value="{{$engineer}}">
					<input type="hidden" name="technician" value="{{$technician}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated lni lni-reload"></i> Modify</button>
					</form>
<?php
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")||(session('role')=="Store")||(session('role')=="PRO")){
?>
                    <form style="display: inline;" action="cloneEst" method="post">{{ csrf_field() }}
                        <input type="hidden" name="est_no" value="{{$est_no}}">
                        <button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
                        <i class="fadeIn animated lni lni-reload"></i> Clone</button>
					</form>
<?php } ?>


                    <form  target="_blank" style="display: inline;" action="billPrint_asEst?detail=1" method="post">{{ csrf_field() }}
					<input type="hidden" name="est_no" value="{{$est_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print in Detail</button>
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
                       <strong class="text-inverse">Estimate Date: </strong>{{date('d-M-Y', strtotime($est_dt))}}<br>
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
					   <strong class="text-inverse">Year: </strong>{{$year}}<br>
					   <strong class="text-inverse">Colour Code: </strong>{{$car_colour}}<br>
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
                       <strong class="text-inverse">Time Required:  </strong>{{$days}} Working Days<br>
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
										<form action="billMemoOneEst" method="post" class="row g-3">{{ csrf_field() }}
										<input type="hidden" name="est_no" value="{{$est_no}}">
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
										<form action="billMemoTwoEst" method="post" class="row g-3">{{ csrf_field() }}
										<input type="hidden" name="est_no" value="{{$est_no}}">
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
						<input type="hidden" name="est_no" value="{{$est_no}}">
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
								$data = DB::select("SELECT SUM(`net_bill`) net_bill, SUM(`total`) total  FROM `est_mas` WHERE `est_no`=$est_no;");
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


<style>
table#example4.table-bordered.dataTable thead th,table#example4.table-bordered.dataTable tbody th, table#example4.table-bordered.dataTable tbody td {
    border-bottom-width: 1px;
}
</style>
				<table id="example4" class="table table-bordered mb-0">
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

<tr><td colspan="7"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parts</strong></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
</tr>

<?php
	$stock = DB::select("
	SELECT `id`,`est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`, id
	FROM `est_det` WHERE type = '1' and `est_no`=$est_no;");
	$sl="1";
	foreach($stock as $item)
		{
?>					<tr>
						<td style="text-align: center;" class="sorting_1">


							<form style="display: inline;" action="billMemoEditEst" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="est_no" value="{{$item->est_no}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>

						</td>
						<td scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: center;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						<td><center>
							<form style="display: inline;" action="billMemoThreeEst" method="post">{{ csrf_field() }}
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
<tr><td colspan="7"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</strong></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
</tr>
<?php
	$stock = DB::select("
	SELECT `est_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`, id
	FROM `est_det` WHERE type = '2' and `est_no`=$est_no;");
	$sl="1";
	foreach($stock as $item)
		{
?>					<tr>
						<td style="text-align: center;" class="sorting_1">


							<form style="display: inline;" action="billMemoEditEst" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="est_no" value="{{$item->est_no}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>

						</td>
						<td scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: center;">{{number_format(($item->unit_rate), 2, '.', ',')}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',')}}</td>
						<td><center>
							<form style="display: inline;" action="billMemoThreeEst" method="post">{{ csrf_field() }}
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

 @section("dataTable")

  <script src="assets/js/table-datatable.js"></script>
 @endsection
