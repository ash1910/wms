
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
                           <form action="purchase03" method="post" class="row g-3">{{ csrf_field() }}
 							<div class="col-12">
							  <label class="form-label">Job No</label>
							  <input disabled id="id-3" required type="text" class="form-control" placeholder="{{$job_no}}">
                            </div>                            
                            <div class="col-12">
                               <label class="form-label">Product</label>
                               <input disabled id="tags" name="prod" type="text" class="form-control" >
                             </div>

							<div class="col-12">
							  <label class="form-label">QTY</label>
							  <input disabled id="id-3" required type="text" class="form-control" >
                            </div>
							<div class="col-12">
                               <label class="form-label">Date</label>
                               <input disabled required name="job_no" type="text" class="form-control" maxlength="7">
                            </div>
							<div class="col-12">
                               <label class="form-label">Note</label>
                               <input disabled required name="job_no" type="text" class="form-control" maxlength="7">
                            </div>

                            
                            
                            <div class="col-12">
                              <div class="d-grid">
                                <button class="btn btn-secondary" disabled>Add Issue Product</button>
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






