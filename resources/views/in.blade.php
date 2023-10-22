
@extends("layouts.master")

@section("content")




<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Stock</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">IN</li>
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
                           <form action="inOne" method="post" class="row g-3">{{ csrf_field() }}
                             
							 <div class="col-12">
                               <label class="form-label">Supplier</label>
                               <input autofocus required id="tags01" value="{{Session::get('sup')}}" name="supplier" type="text" class="form-control" placeholder="e.g.- A R Autos">
                             </div>
							 <div class="col-12">
                               <label class="form-label">Reference</label>
                               <input required name="ref" value="{{Session::get('ref')}}" type="text" class="form-control" placeholder="e.g.- 220614" >
                             </div>                             <div class="col-12">
                               <label class="form-label">Product</label>
                               <input required id="tags" name="prod" type="text" class="form-control" placeholder="e.g.- Engine Hood">
                             </div>
                             <div class="col-12">
                              <label class="form-label">Quantity</label>
                              <input required name="qty" type="text" class="form-control" placeholder="e.g.- 1">
                            </div>
							<div class="col-12">
                               <label class="form-label">Buy (Per Unit)</label>
                               <input required name="buypp" type="text" class="form-control" placeholder="e.g.- 25000">
                             </div>
                             
                            
                            
                            <div class="col-12">
                              <div class="d-grid">
                                <button class="btn btn-primary">Add Product</button>
                              </div>
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
                       <strong class="text-inverse">Supplier: </strong>{{Session::get('sup')}}<br>
                    </address>
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Reference: </strong>{{Session::get('ref')}}<br>
                    </address>					
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Total Amount: Tk. 
					   <?php
				   if(Session::get('ref')!='')
					{
					   $buy = '0';
					   $total_buy = '0';
					   foreach($stock as $item1)
					   {
						   $buy =  ($item1->buypp)*($item1->qty);
						   $total_buy = $total_buy + $buy;
					   }
					   echo $total_buy;
					}  
					   ?>
					   <br></strong>
                    </address>
                   </div>
                 </div>
				
				
				
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Product</th>
							<th scope="col">Quantity</th>
							<th scope="col">Buy (Per Unit)</th>
							<th scope="col">Total Buy</th>
						</tr>
					</thead>
					<tbody>
<?php
if(Session::get('ref')!='')
	{$sl = '1';
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row">{{$sl}}</th>
						<td>{{$item->parts_name}}</td>
						<td>{{$item->qty}}</td>
						<td>{{$item->buypp}}</td>
						<td>{{($item->buypp)*($item->qty)}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		}  
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
foreach ($suppliers as $p1) 
{
echo '"'.$p1->supplier_id.' - '.$p1->supplier_name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection