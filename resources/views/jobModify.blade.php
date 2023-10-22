
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
                    <li class="breadcrumb-item active" aria-current="page">Modify</li>
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
                      <h5 class="mb-0">Modify Estimate</h5>
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
                         <th class="text-center" width="3%">SL.</th>
                         <th class="text-center">Description</th>
                         <th class="text-center" width="10%">Quantity</th>
                         <th class="text-center" width="10%">Update</th>
                         <th class="text-center" width="10%">Delete</th>
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
$id = $item1->id;
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td class="text-center" >{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
						 <form action="jobModifyOne" method="post">{{ csrf_field() }}
                         <td class="text-center">
						 <input type="hidden" name="id" value="{{$id}}">
						 <input type="type" name="qty" value="{{$qty}}" style="width: 50px;text-align: center;">
						 </td>
						 <td>
						 
						 <button type="submit" class="btn btn-outline-success px-4 radius-30"><i class="lni lni-pencil-alt"></i> Update</button>
						 </form>
						 </td>
						 <td>
						 <form action="jobModifyDel" method='post'>{{ csrf_field() }}
						 <input type="hidden" name="id" value="{{$id}}">
						 <button type="type" class="btn btn-outline-danger px-4 radius-30"><i class="lni lni-trash"></i> Delete</button>
						 </form>
						 </td>						 
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
$id = $item1->id;
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td class="text-center" >{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
						 <form action="jobModifyOne" method="post">{{ csrf_field() }}
                         <td class="text-center">
						 <input type="hidden" name="id" value="{{$id}}">
						 <input type="type" name="qty" value="{{$qty}}" style="width: 50px;text-align: center;">
						 </td>
						 <td>
						 
						 <button type="submit" class="btn btn-outline-success px-4 radius-30"><i class="lni lni-pencil-alt"></i> Update</button>
						 </form>
						 </td>
						 <td>
						 <form action="jobModifyDel" method='post'>{{ csrf_field() }}
						 <input type="hidden" name="id" value="{{$id}}">
						 <button type="type" class="btn btn-outline-danger px-4 radius-30"><i class="lni lni-trash"></i> Delete</button>
						 </form>
						 </td>						 
                      </tr>
<?php
$sl = $sl+1;
$total02=$total02+$total;
} 
?> 
<tr style="text-align: center;"><td colspan="5"><b>Sample</b></td></tr>
<?php 
////////////Result Service//////////////////////// 
$sl = '1';                 
$total03 = '0';                 
foreach($estimate_sample as $item1)
{ 
$id = $item1->id;
$qty = $item1->qty;
$unit_price = $item1->unit_price;
$total = $qty*$unit_price;
?>
					<tr>
					  <td class="text-center" >{{$sl}}</td>
                         <td>
                            <span class="text-inverse">{{$item1->prod_id}}-{{$item1->prod_name}}</span><br>
                            <!--small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small-->
                         </td>
						 <form action="jobModifyOne" method="post">{{ csrf_field() }}
                         <td class="text-center">
						 <input type="hidden" name="id" value="{{$id}}">
						 <input type="type" name="qty" value="{{$qty}}" style="width: 50px;text-align: center;">
						 </td>
						 <td>
						 
						 <button type="submit" class="btn btn-outline-success px-4 radius-30"><i class="lni lni-pencil-alt"></i> Update</button>
						 </form>
						 </td>
						 <td>
						 <form action="jobModifyDel" method='post'>{{ csrf_field() }}
						 <input type="hidden" name="id" value="{{$id}}">
						 <button type="type" class="btn btn-outline-danger px-4 radius-30"><i class="lni lni-trash"></i> Delete</button>
						 </form>
						 </td>						 
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















 
  