
@extends("layouts.master")

@section("content")

<?php
$data = DB::select("SELECT `prod_id`,`prod_name`,`qty`,`note` FROM `issue` WHERE `id` = '$id';");
foreach($data as $item){ $prod_id = $item->prod_id ;$prod_name = $item->prod_name;
$qty = $item->qty;$note = $item->note;}
?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Issue</li>
                    <li class="breadcrumb-item active" aria-current="page">Return</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

              <div class="card">
                
                <div class="card-body">
                   <div class="row">
                     <div class="col-12 col-lg-4 d-flex">
                       <div class="card border shadow-none w-100">
                         <div class="card-body">
                           <form action="issueReturn03" method="post" class="row g-3">{{ csrf_field() }}
 							<div class="col-12">
							  <label class="form-label">Job No</label>
							  <input disabled  type="text" class="form-control" placeholder="{{$job_no}}">
                            </div>                            
                            <div class="col-12">
                               <label class="form-label">Product</label>
                               <input disabled  type="text" class="form-control" placeholder="{{$prod_id}}-{{$prod_name}}">
                             </div>

							<div class="col-12">
							  <label class="form-label">QTY</label>
							  <input name="qty" required type="text" class="form-control" value="{{$qty}}">
                            </div>
							<div class="col-12">
							  <label class="form-label">Date</label>
							  <!--input name='dt' type="text" onkeydown="event.preventDefault()" id="datepicker" class="form-control" required-->
							  <input name='dt' type="date" class="form-control" required>
                            </div>
							<div class="col-12">
                               <label class="form-label">Note</label>
                               <input disabled required type="text" class="form-control" maxlength="7" placeholder="{{$note}}">
                            </div>
							<input type="hidden" name="id" value="{{$id}}">
							<input type="hidden" name="job_no" value="{{$job_no}}">
							<input type="hidden" name="note" value="{{$note}}">
							<input type="hidden" name="prod_id" value="{{$prod_id}}">
							<input type="hidden" name="prod_name" value="{{$prod_name}}">
                            
                            
                            <div class="col-12">
                              <div class="d-grid">
                                <button class="btn btn-success" >Add Issue Return</button>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="d-grid">
								<a href="/issueReturn" class="btn btn-danger">Exit</a> </div>
                            </div>							
                           </form>
                         </div>
                       </div>
                     </div>
                     <div class="col-12 col-lg-8 d-flex">
                      <div class="card border shadow-none w-100">
                        <div class="card-body">
                          <div class="table-responsive">
                            


				<div class="col-7">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Job No: {{$job_no}}</strong><br>
                    </address>

                   </div>
                 </div>
				
				
				
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="width: 60px;"></th>
							<th scope="col" style="width: 60px;">#</th>
							<th scope="col">Code</th>
							<th scope="col">Product</th>
							<th scope="col">Qty</th>
							<th scope="col">Note</th>
						</tr>
					</thead>
					<tbody>
<?php
	$stock = DB::table('issue')->where('job_no', $job_no)->get(); 
	$sl = '1';
	foreach($stock as $item)
		{ 					
?>					<tr>
						<td><center>
							<form style="display: inline;" action="issueReturn02" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="job_no" value="{{$item->job_no}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>
							</center>
						</td>
						<th scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}}</td>
						<td>{{$item->prod_name}}</td>
						<td>{{$item->qty}}</td>
						<td>{{$item->note}}</td>
						
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

          </main>



		  
@endsection		  






