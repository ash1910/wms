
@extends("layouts.master")

@section("content")




<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Estimate</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sample</li>
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
                      <h5 class="mb-0">Sample Estimate</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
			
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-invoice">
                   <thead>
                      <tr>
                         <th class="text-center">Description</th>
                         <th class="text-center" width="10%">Quantity</th>
                         <th class="text-center" width="10%">Price</th>
                         <th class="text-center" width="10%">Add</th>
                      </tr>
                   </thead>
                   <tbody>
					<tr>
					<form action="jobSampleOne" method="post">{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
					<td><input name="sampleItem" class="form-control" type="text" placeholder="Sample Item"></td>
					<td><input name="sampleQty" class="form-control" type="text" placeholder="Qty"></td>
					<td><input name="samplePrice" class="form-control" type="text" placeholder="Price"></td>
					<td><button class="btn btn-success" type="submit" name="register" value="register"><i class="lni lni-circle-plus"></i> Add</button></td>
					</form>
					</tr>
                   </tbody>
                </table>
				
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
?>
                   </tbody>
                </table>
             </div>

             <div class="row bg-light align-items-center m-0">
			   <div class="col bg-dark col-auto p-4">
                <p class="mb-0 text-white">TOTAL</p>
                <h4 class="mb-0 text-white">Tk. {{number_format($total03, 2, '.', ',')}}</h4>
               </div>



             <div class="row bg-light align-items-center m-0">
               
               
               <div class="col col-auto me-auto p-4">
                  <p class="mb-0"></p>
				  
					<div class="col">
					<form action="jobModifyOneBack" method="get">
						<input type="hidden" name="customer_id" value="{{$customer_id}}">
                        <button type="submit" class="btn btn-lg btn-outline-danger px-5">
						<i class="fadeIn animated bx bx-exit"></i> Back</button>
                    </form>
					</div>				  
               </div>			   
               
			   
			   
             </div><!--end row-->

             <hr>
           <!-- begin invoice-note -->
           <div class="my-3">
            
           </div>
         <!-- end invoice-note -->
            </div>
            </div>
			
			

            <div class="card-footer py-3">
                <p class="text-center mb-2">
                   
                </p>
                
            </div>
           </div>

          </main>



 
@endsection















 
  