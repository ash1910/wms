
@extends("layouts.master")

@section("content")

<?php


$data = DB::select("SELECT a.purchase_id, b.supplier_name,b.supplier_id, a.amount, a.supplier_ref FROM `purchase_mas` a, suppliers b
WHERE a.`supplier_id` = '$supplier_id' AND a.`supplier_ref`= '$supplier_ref' AND a.supplier_id= b.supplier_id;");
foreach($data as $item){ $supplier_name = $item->supplier_name ;$amount = $item->amount;
$supplier_ref = $item->supplier_ref;$supplier_id = $item->supplier_id;$purchase_id = $item->purchase_id;}

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
                    <li class="breadcrumb-item active" aria-current="page">Purchase</li>
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
                               <label class="form-label">Product</label>
                               <input required id="tags" name="prod" type="text" class="form-control" placeholder="e.g.- Engine Hood">
                             </div>
                             <div class="row row-cols-xl-2">
								<div >
								  <label class="form-label">Quantity</label>
								  <input id="id-1" required name="qty" type="text" class="form-control" placeholder="e.g.- 1">
								</div>  
								<div >
								   <label class="form-label">Buy (Per Unit)</label>
								   <input id="id-2" required name="rate" type="text" class="form-control" placeholder="e.g.- 25000">
								</div>  
							</div>
							<div class="col-12">
							  <label class="form-label">Buy (Total)</label>
							  <input id="id-3" required type="text" class="form-control" placeholder="e.g.- 1">
                            </div>
							<div class="col-12">
                               <label class="form-label">Job No.</label>
                               <input required name="job_no" type="text" class="form-control" placeholder="e.g.- 1111-22" maxlength="7">
                            </div>
							<div class="col-12">
                               <label class="form-label">Req. No.</label>
                               <input required name="req" type="text" class="form-control" placeholder="e.g.- 1111" maxlength="4">
                            </div>
                             <input type="hidden" name="purchase_id" value="{{$purchase_id}}">
                            
                            
                            <div class="col-12">
                              <div class="d-grid">
                                <button class="btn btn-secondary" disabled>Add Product</button>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="d-grid">
								<a href="/purchase" class="btn btn-danger">Exit</a> </div>
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
                       <strong class="text-inverse">Supplier: [{{$supplier_id}}]  {{$supplier_name}}</strong><br>
                    </address>
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Supplier's Bill No.: </strong>{{$supplier_ref}}<br>
                    </address>					
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Total Amount: Tk. {{$amount}}<br>
					   </strong>
                    </address>
                   </div>
                 </div>
				
				
				
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col"></th>
							<th scope="col">#</th>
							<th scope="col">Code</th>
							<th scope="col">Product</th>
							<th scope="col">Job No.</th>
							<th scope="col">Req. No.</th>
							<th scope="col">Qty</th>
							<th scope="col">Buy (Per Unit)</th>
							<th scope="col">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$stock = DB::table('purchase_det')->where('purchase_id', $purchase_id)->get(); 
	$sl = '1';
	foreach($stock as $item)
		{ 					
?>					<tr>
						<td><center>
							<form style="display: inline;" action="purchaseReturn03" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item->id}}">
							<input type="hidden" name="supplier_id" value="{{$supplier_id}}">
							<input type="hidden" name="supplier_ref" value="{{$supplier_ref}}">
							<button class="btn btn-sm btn-sucess me-2" type="submit" name="" value=""><i class="lni lni-pencil-alt"></i></button>
							</form>
							</center>
						</td>
						<th scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}}</td>
						<td>{{$item->prod_name}}</td>
						<td>{{$item->job_no}}</td>
						<td>{{$item->req}}</td>
						<td>{{$item->qty}}</td>
						<td>{{$item->rate}}</td>
						<td>{{$item->amount}}</td>
						
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







@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
 
 <?php
$parts_info = DB::table('parts_info')->get();
 
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
  
 
 @endsection
 
 
 
<script src="assets/jquery.min.js"></script> 
 <script>
$(function () {
  $("#id-1, #id-2").keyup(function () {
    $("#id-3").val( (+$("#id-1").val() * +$("#id-2").val()));
  });
});
</script>
 <script>
$(function () {
  $("#id-1, #id-3").keyup(function () {
    $("#id-2").val( (+$("#id-3").val() / +$("#id-1").val()));
  });
});
</script>