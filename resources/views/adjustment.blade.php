

<!-- HAPS Code -->
<?php 

$dt_CashBankAcc = DB::select("SELECT `acc_name` FROM `tbl_acc_masters` WHERE (`type_id`='6' or `type_id`='7') and `grp_status`<>'GR';");


?>
<!-- End Code -->


<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
//return redirect ('home')->with('alert', 'Wrong URL!!!');	
//echo session('role');
}
else {
?>
  <script>
    window.location = "/logout";
  </script>
<?php  
}
?>



<script src="assets/jquery.min.js"></script>

@extends("layouts.master")

@section("content")


<?php
$result = DB::select("
SELECT  a.`bill`, a.`job_no`, a.`customer_id`, 
sum(a.`due`) net_bill, sum(a.`received`) received, sum(a.`bonus`) bonus, sum(a.`due`) due,
b.customer_nm, b.total total, (b.total-b.net_bill) vat, b.net_bill a_bill, b.bill_dt,
c.customer_mobile, c.customer_vehicle, c.customer_reg, c.customer_chas
FROM `pay` a, bill_mas b, customer_info c
WHERE a.`bill` = '$bill_no'
and a.bill = b.bill_no
and a.customer_id = c.customer_id
AND b.customer_id = c.customer_id
group by a.`bill`, a.`job_no`, a.`customer_id`, b.customer_nm, c.customer_mobile, c.customer_vehicle, 
c.customer_reg, c.customer_chas, b.total, (b.total-b.net_bill), b.net_bill, b.bill_dt;
");
foreach($result as $item)
		{	
			$job_no = $item->job_no;
			$bill_dt = $item->bill_dt;
			$customer_id = $item->customer_id;
			$customer_nm = $item->customer_nm;
			$customer_mobile = $item->customer_mobile;
			$customer_reg = $item->customer_reg;
			$customer_chas = $item->customer_chas;
			$customer_vehicle = $item->customer_vehicle;
			$net_bill01 = $item->net_bill;
			$net_bill = number_format(round($item->net_bill,2), 2, '.', ',');
			$a_bill = number_format(round($item->a_bill,2), 2, '.', ',');
			$total = number_format(round($item->total,2), 2, '.', ',');
			$vat = number_format(round($item->vat,2), 2, '.', ',');
		}  
$result01 = DB::select("
SELECT sum(`received`) advance FROM `pay` 
WHERE `bill` = 'Advance'
and `customer_id` = '$customer_id' and `job_no` = '$job_no';
");
foreach($result01 as $item01)
		{	
			$advance = $item01->advance;
		}
		
		
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
                    <li class="breadcrumb-item active" aria-current="page">Report</li>
                    <li class="breadcrumb-item active" aria-current="page">Receivable</li>
                    <li class="breadcrumb-item active" aria-current="page">Pay</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none"style="background: red;">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
					  <p class="mb-0">Bill No : #{{$bill_no}}</p>
                    </div>
                    
                  </div>
             </div>
		
            <div class="card-body">
              
					<div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-3">


                     
                      <div class="col-12 col-lg-4">
                        <div class="card border shadow-none bg-light radius-10">
                          <div class="card-body">
						  <form action="adjustment01" method="post">{{ csrf_field() }} 
                              <div class="d-flex align-items-center mb-4">
                                 <div>
                                    <h5 class="mb-0">Sales Adjustment</h5>
                                 </div>
                                 
                              </div>
                                <div class="d-flex align-items-center mb-3">
                                  <div>
                                    <p class="mb-0">Due Pay</p>
                                  </div>
                                  <div class="ms-auto">
                                    <h5 class="mb-0">TK. {{$net_bill}}</h5>
                                </div>
                              </div>
						  
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Sales return</p>
                                </div>
                                <div class="ms-auto">
                                  Tk. <input id="id-1" name="sales_return" type="text" value='0' required>
                              </div>
                              </div>							  
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Advance refund</p>
                                </div>
                                <div class="ms-auto">
                                  TK. <input id="id-2" name="advance_refund" type="text" value='0' required>
                              </div>
                              </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Complementary</p>
                                </div>
                                <div class="ms-auto">
                                  TK. <input id="id-3" name="complementary_work"  value='0' type="text" required>
                              </div>
                              </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Re-Work
								  <input maxlength="7" style="width: 80px;text-align: center;" name="rework_ref" placeholder="Job No Ref" type="text">
								  </p>
								</div>
                                <div class="ms-auto">
                                  TK. <input id="id-8" name="rework"  value='0' type="text" required>
                              </div>
                              </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Damage to the work</p>
                                </div>
                                <div class="ms-auto">
                                  TK. <input id="id-9" name="damage_work"  value='0' type="text" required>
                              </div>
                              </div>							  
                            <div class="d-flex align-items-center mb-3">
                              <div>
                                <p class="mb-0">Due</p>
                              </div>
                              <div class="ms-auto">
                                Tk. <input type="text" name="due" id="id-4" readonly />
							  </div>
							</div>
							<div class="d-flex align-items-center mb-3" style="width: 100%;">
								  <div style="width: 30%;">
									<p class="mb-0">Note</p>
								  </div>
								  <div style="width: 70%;">
									<input type="text" name="note" style="width: 100%;"/>
								  </div>
							</div>

               <!-- HAPS Code --Advance refund-->

               <div class="d-flex align-items-center mb-3" style="width: 100%;">
                <div style="width: 30%;">
                <p class="mb-0">Refund Type :</p>
                </div>
                <div style="width: 70%;">
                  <select id="refund01" name="refund01" style="width: 100%;"  class="form-select form-select-sm">
                    <option  value="Advance Refund"> Advance Refund </option>
                    <option  value="Receivable Refund"> Receivable Refund</option>
                    <option  value="Advance Transfer"> Advance Transfer</option>
                </select>
                </div>
              </div>

              <div class="d-flex align-items-center mb-3" style="width: 100%;">
                <div style="width: 30%;">
                <p class="mb-0">Cash/Bank :</p>
                </div>
                <div style="width: 70%;">
                  <select id="CashankAcc" name="CashankAcc" style="width: 100%;"  class="form-select form-select-sm">
                  @if(isset( $dt_CashBankAcc  ))
                    @foreach ( $dt_CashBankAcc as $item)
                    <option  value="{{$item->acc_name}}">{{$item->acc_name}}</option>
                    @endforeach
                  @endif
                </select>
                </div>
              </div>
              <!-- End Code -->

                            <div class="d-flex align-items-center mb-3">
                              <div>
                                <p class="mb-0"></p>
                              </div>
                              <div class="ms-auto">
                                <input type="submit" name="submit" value="Account Refund" class="btn btn-outline-danger px-3">
                            </div>
                              
							  <div>
                                <p class="mb-0"></p>
                              </div>
                              <div class="ms-auto">
                                <input type="submit" name="submit" value="Adjustment" class="btn btn-outline-danger px-3">
                            </div>
                          </div>
						  
						<input type="hidden" name="dueLeft" value="{{$net_bill01}}">  
						<input type="hidden" name="net_bill" value="{{$net_bill01}}">  
						<input type="hidden" name="bill_no" value="{{$bill_no}}">  
						<input type="hidden" name="job_no" value="{{$job_no}}">  
						<input type="hidden" name="customer_id" value="{{$customer_id}}">  
						<input type="hidden" name="bill_dt" value="{{$bill_dt}}">  
						  
						</form>
                          </div>
                        </div>




                     </div>
					 
                       <div class="col">
                         <div class="card border shadow-none radius-10"style="margin-bottom: 0.5rem;">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div>
                              <div class="info">
                                 <h6 class="mb-2">Customer</h6>
                                 <p class="mb-1"><b>Name:</b> {{$customer_nm}}</p>
                                 <p class="mb-1"><b>Mobile:</b> {{$customer_mobile}}</p>
                                 <p class="mb-1"><b>Reg:</b> {{$customer_reg}}</p>
                                 <p class="mb-1"><b>Chassis:</b> {{$customer_chas}}</p>
                                 <p class="mb-1"><b>Vehicle:</b> {{$customer_vehicle}}</p>
                              </div>
                           </div>
                           </div>
                         </div>
                         <div class="card border shadow-none radius-10"style="margin-bottom: 0.5rem;">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="lni lni-ticket"></i>
                              </div>
                              <div class="info">
                                 <h6 class="mb-2">Bill Info</h6>
                                 <p class="mb-1"><b>Job No.:</b> {{$job_no}}</p>
                                 <p class="mb-1"><b>Actual Bill:</b> TK. {{$a_bill}}</p>
                                 <p class="mb-1"><b>Vat (10%):</b> TK. {{$vat}}</p>
                                 <p class="mb-1"><b>Total:</b> TK. {{$total}}</p>
							  </div>
                           </div>
                           </div>
                         </div>						 
                         <div class="card border shadow-none radius-10"style="margin-bottom: 0.5rem;">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="lni lni-ticket"></i>
                              </div>
                              <div class="info">
                                 <h6 class="mb-2">Adjustment With Supplier</h6>
								<form action="adjustment02" method="post">{{ csrf_field() }} 
								 <table>
								 <tr><td><b>Supplier:</b></td><td><input style="width: 168px;" name="supplier_name" type="text" id="tags" required ></td></tr>
								 <tr><td><b>Amount:</b></td><td><input style="width: 168px;" name="supplier_adj" type="text" required ></td></tr>
								 <tr><td><b>Ref Voucher:</b></td><td><input style="width: 168px;" name="supplier_ref" type="text" ></td></tr>
								 </table>
								 <br>
								 <input type="submit" name="submit" value="Adjustment With Supplier" class="btn btn-outline-danger px-3">
						<input type="hidden" name="bill_no" value="{{$bill_no}}">  
						<input type="hidden" name="job_no" value="{{$job_no}}">  
						<input type="hidden" name="customer_id" value="{{$customer_id}}">  

								 </form>
							  </div>
                           </div>
                           </div>
                         </div>						 

                       </div>

                       <div class="col">
                          <div class="card border shadow-none radius-10"style="margin-bottom: 0.5rem;">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div>
                              <div class="info">
                                 <h6 class="mb-2">Adjustment With Customer</h6>
								 
								 <form action="adjustment03" method="post">{{ csrf_field() }} 
								 <table>
								 <tr><td><b>Customer:</b></td><td><input style="width: 168px;" name="customer_id" type="text" id="tags01" required ></td></tr>
								 <tr><td><b>Amount:</b></td><td><input style="width: 168px;" name="net_bill" type="text" required ></td></tr>
								 </table><br>
						<input type="submit" name="submit" value="Adjustment" class="btn btn-outline-danger px-3">
						<input type="hidden" name="bill_no" value="{{$bill_no}}">  
						<input type="hidden" name="job_no" value="{{$job_no}}">  
						<input type="hidden" name="vcustomer_id" value="{{$customer_id}}">  
						<input type="hidden" name="net_bill01" value="{{$net_bill01}}">  

								 </form>
								 
                              </div>
                           </div>
                           </div>
                         </div>
						</div>


					   
                  </div>
             <!--end row-->

             <hr>
			 
           <!-- begin invoice-note -->
           <div class="my-3">
            
           </div>
         <!-- end invoice-note -->
            </div>
			
			

          
           </div>


			
			
</main>



		  
@endsection		 





@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection
@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
 
<?php
$suppliers = DB::table('suppliers')->get();
foreach ($suppliers as $p) 
{
echo '"'.$p->supplier_id.' - '.$p->supplier_name.'",';
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
$suppliers = DB::table('customer_info')->get();
foreach ($suppliers as $p) 
{
echo '"'.$p->customer_id.' - '.$p->customer_nm.'",';
}
?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>  
  
@endsection


<?php if($advance=="") {?>
<script>
$(function () {
  $("#id-1, #id-2, #id-3, #id-8, #id-9").keyup(function () {
    $("#id-4").val(Math.round( {{$net_bill01}} - (+$("#id-1").val() + +$("#id-2").val()+ +$("#id-3").val()+ +$("#id-8").val()+ +$("#id-9").val())));
  });
});
</script>



<?php } ?>




