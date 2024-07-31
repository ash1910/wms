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

SELECT  c.`customer_id`, c.customer_nm, c.customer_mobile, c.customer_vehicle, c.customer_reg, c.customer_chas
FROM customer_info c
WHERE 
c.customer_id = $customer_id
;
");
foreach($result as $item)
		{	
			$customer_id = $item->customer_id;
			$customer_nm = $item->customer_nm;
			$customer_mobile = $item->customer_mobile;
			$customer_reg = $item->customer_reg;
			$customer_chas = $item->customer_chas;
			$customer_vehicle = $item->customer_vehicle;
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
                    <li class="breadcrumb-item active" aria-current="page">Receivable</li>
                    <li class="breadcrumb-item active" aria-current="page">Advance</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0"></h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              
					<div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-3">


                     
                      <div class="col-12 col-lg-4">
                        <div class="card border shadow-none bg-light radius-10">
                          <div class="card-body">
						  <form action="pay04" method="post">{{ csrf_field() }} 
                              <div class="d-flex align-items-center mb-4">
                                 <div>
                                    <h5 class="mb-0">Advance Money</h5>
                                 </div>
                                 
                              </div>
                               

                              
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Received </p>
                                </div>
                                <div class="ms-auto">
                                  Tk. <input id="id-1" name="received" type="text" required>

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
								




<script type="text/javascript">
    function ShowHideDiv() {
        var Cash = document.getElementById("Cash");
        var dvCash = document.getElementById("dvCash");
        dvCash.style.display = Cash.checked ? "block" : "none";
		
        var Online = document.getElementById("Online");
        var dvOnline = document.getElementById("dvOnline");
        dvOnline.style.display = Online.checked ? "block" : "none";
		
        var Bkash = document.getElementById("Bkash");
        var dvBkash = document.getElementById("dvBkash");
        dvBkash.style.display = Bkash.checked ? "block" : "none";
		
        var Cheque = document.getElementById("Cheque");
        var dvCheque = document.getElementById("dvCheque");
        dvCheque.style.display = Cheque.checked ? "block" : "none";
		
        var Card = document.getElementById("Card");
        var dvCard = document.getElementById("dvCard");
        dvCard.style.display = Card.checked ? "block" : "none";
    }
</script>

<label for="Cash">
    <input value="cash" type="radio" id="Cash" name="pay_type" onclick="ShowHideDiv()" required/>
    Cash
</label>
<label for="Bkash">
    <input value="bkash" type="radio" id="Bkash" name="pay_type" onclick="ShowHideDiv()" required/>
    Bkash
</label>
<label for="Cheque">
    <input value="cheque" type="radio" id="Cheque" name="pay_type" onclick="ShowHideDiv()" required/>
    Cheque
</label>
<label for="Card">
    <input value="card" type="radio" id="Card" name="pay_type" onclick="ShowHideDiv()" required/>
    Card
</label>
<label for="Online">
    <input value="online" type="radio" id="Online" name="pay_type" onclick="ShowHideDiv()" required/>
    Online
</label>
<hr />
<div id="dvCash" style="display: none">
	
</div>
<div id="dvOnline" style="display: none">
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Merchant Bank</p>
	  </div>
	  <div style="width: 70%;">
		<select name="merchant_online" class="form-select">
			<option value='MTBL'>HNS Engineering & Services Ltd & A/C No.:#(MTBL-0022-0210004676)</option>
			<option value='CBL'>HNS Auto Solutions & A/C No.:#(MTBL-01301-000217814)</option>
		</select>		
		
	  </div>
	</div>
</div>

<div id="dvBkash" style="display: none">
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">bKash Merchant No</p>
	  </div>
	  <div style="width: 70%;">
		<select name="mer_bkash" class="form-select">
			<option value='797'>bKash (01777781797)</option>
			<option value='330'>bKash (01777781330)</option>
		</select>		
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Trix </p>
	  </div>
	  <div style="width: 70%;">
		<input type="text" name="trix" style="width: 100%;"/>
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Send </p>
	  </div>
	  <div style="width: 70%;">
		<input type="text" name="send" style="width: 100%;"/>
	  </div>
	</div>
</div>


<div id="dvCheque" style="display: none">
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Bank Name</p>
	  </div>
	  <div style="width: 70%;">
		<select name="bank" class="form-select">
			<option value=""></option>
			<option value='AB Bank Limited'>AB Bank Limited</option>
			<option value='Agrani Bank Ltd'>Agrani Bank Ltd</option>
			<option value='Al-Arafah Islami Bank Limited'>Al-Arafah Islami Bank Limited</option>
			<option value='Bangladesh Bank'>Bangladesh Bank</option>
			<option value='Bangladesh Commerce Bank Limited'>Bangladesh Commerce Bank Limited</option>
			<option value='Bank Al-Falah Limited (Pakistan)'>Bank Al-Falah Limited (Pakistan)</option>
			<option value='Bank Asia Limited'>Bank Asia Limited</option>
			<option value='Basic Bank Ltd'>Basic Bank Ltd</option>
			<option value='Bengal Commercial Bank Limited'>Bengal Commercial Bank Limited</option>
			<option value='BRAC Bank Limited'>BRAC Bank Limited</option>
			<option value='Citibank N.A (United States of America)'>Citibank N.A (United States of America)</option>
			<option value='City Bank Limited'>City Bank Limited</option>
			<option value='Commercial Bank Of Ceylon PLC'>Commercial Bank Of Ceylon PLC</option>
			<option value='Community Bank Bangladesh Limited'>Community Bank Bangladesh Limited</option>
			<option value='Dhaka Bank Limited'>Dhaka Bank Limited</option>
			<option value='Dutch-Bangla Bank Limited'>Dutch-Bangla Bank Limited</option>
			<option value='Eastern Bank Limited'>Eastern Bank Limited</option>
			<option value='EXIM Bank Limited'>EXIM Bank Limited</option>
			<option value='First Security Islami Bank Limited'>First Security Islami Bank Limited</option>
			<option value='Global Islamic Bank Ltd'>Global Islamic Bank Ltd</option>
			<option value='Habib Bank Limited'>Habib Bank Limited</option>
			<option value='HSBC'>HSBC</option>
			<option value='ICB Islamic Bank Limited'>ICB Islamic Bank Limited</option>
			<option value='IFIC Bank Limited'>IFIC Bank Limited</option>
			<option value='Islami Bank Bangladesh Limited'>Islami Bank Bangladesh Limited</option>
			<option value='Jamuna Bank Limited'>Jamuna Bank Limited</option>
			<option value='Lanka Bangla Finance'>Lanka Bangla Finance</option>
			<option value='Meghna Bank Limited'>Meghna Bank Limited</option>
			<option value='Mercantile Bank Limited'>Mercantile Bank Limited</option>
			<option value='Midland Bank Limited'>Midland Bank Limited</option>
			<option value='Modhumoti Bank Limited'>Modhumoti Bank Limited</option>
			<option value='Mutual Trust Bank Limited'>Mutual Trust Bank Limited</option>
			<option value='National Bank Limited'>National Bank Limited</option>
			<option value='NRB Bank Limited'>NRB Bank Limited</option>
			<option value='NRB Commercial Bank Ltd'>NRB Commercial Bank Ltd</option>
			<option value='One Bank Limited'>One Bank Limited</option>
			<option value='Padma Bank Limited'>Padma Bank Limited</option>
			<option value='Premier Bank Limited'>Premier Bank Limited</option>
			<option value='Prime Bank Limited'>Prime Bank Limited</option>
			<option value='Pubali Bank Limited'>Pubali Bank Limited</option>
			<option value='Rupali Bank PLC'>Rupali Bank PLC</option>
			<option value='SBAC Bank'>SBAC Bank</option>
			<option value='Shahjalal Islami Bank Limited'>Shahjalal Islami Bank Limited</option>
			<option value='Shimanto Bank Ltd'>Shimanto Bank Ltd</option>
			<option value='Social Islami Bank Limited'>Social Islami Bank Limited</option>
			<option value='Sonali Bank Ltd'>Sonali Bank Ltd</option>
			<option value='Southeast Bank Limited'>Southeast Bank Limited</option>
			<option value='Standard Bank Limited'>Standard Bank Limited</option>
			<option value='Standard Chartered Bank'>Standard Chartered Bank</option>
			<option value='Trust Bank Limited'>Trust Bank Limited</option>
			<option value='Union Bank Limited'>Union Bank Limited</option>
			<option value='United Commercial Bank Ltd'>United Commercial Bank Ltd</option>
			<option value='Uttara Bank Limited'>Uttara Bank Limited</option>
			<option value='Woori Bank'>Woori Bank (South Korea)</option>
		</select>
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Cheque No.</p>
	  </div>
	  <div style="width: 70%;">
		<input type="text" name="chequeNo" style="width: 100%;"/>
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Cheque Date</p>
	  </div>
	  <div style="width: 70%;">
		<input type="text" name="chequeDt" style="width: 100%;"/>
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Merchant Bank</p>
	  </div>
	  <div style="width: 70%;">
		<select name="merchant_checque" class="form-select">
			<option value='MTBL'>HNS Engineering & Services Ltd & A/C No.:#(MTBL-0022-0210004676)</option>
			<option value='CBL'>HNS Auto Solutions & A/C No.:#(MTBL-01301-000217814)</option>
		</select>		
		
	  </div>
	</div>
</div>


<div id="dvCard" style="display: none">
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Card Bank</p>
	  </div>
	  <div style="width: 70%;">
		<select name="card_bank" class="form-select">
			<option value=""></option>
			<option value='AB Bank Limited'>AB Bank Limited</option>
			<option value='Agrani Bank Ltd'>Agrani Bank Ltd</option>
			<option value='Al-Arafah Islami Bank Limited'>Al-Arafah Islami Bank Limited</option>
			<option value='Bangladesh Bank'>Bangladesh Bank</option>
			<option value='Bangladesh Commerce Bank Limited'>Bangladesh Commerce Bank Limited</option>
			<option value='Bank Al-Falah Limited (Pakistan)'>Bank Al-Falah Limited (Pakistan)</option>
			<option value='Bank Asia Limited'>Bank Asia Limited</option>
			<option value='Basic Bank Ltd'>Basic Bank Ltd</option>
			<option value='Bengal Commercial Bank Limited'>Bengal Commercial Bank Limited</option>
			<option value='BRAC Bank Limited'>BRAC Bank Limited</option>
			<option value='Citibank N.A (United States of America)'>Citibank N.A (United States of America)</option>
			<option value='City Bank Limited'>City Bank Limited</option>
			<option value='Commercial Bank Of Ceylon PLC'>Commercial Bank Of Ceylon PLC</option>
			<option value='Community Bank Bangladesh Limited'>Community Bank Bangladesh Limited</option>
			<option value='Dhaka Bank Limited'>Dhaka Bank Limited</option>
			<option value='Dutch-Bangla Bank Limited'>Dutch-Bangla Bank Limited</option>
			<option value='Eastern Bank Limited'>Eastern Bank Limited</option>
			<option value='EXIM Bank Limited'>EXIM Bank Limited</option>
			<option value='First Security Islami Bank Limited'>First Security Islami Bank Limited</option>
			<option value='Global Islamic Bank Ltd'>Global Islamic Bank Ltd</option>
			<option value='Habib Bank Limited'>Habib Bank Limited</option>
			<option value='HSBC'>HSBC</option>
			<option value='ICB Islamic Bank Limited'>ICB Islamic Bank Limited</option>
			<option value='IFIC Bank Limited'>IFIC Bank Limited</option>
			<option value='Islami Bank Bangladesh Limited'>Islami Bank Bangladesh Limited</option>
			<option value='Jamuna Bank Limited'>Jamuna Bank Limited</option>
			<option value='Lanka Bangla Finance'>Lanka Bangla Finance</option>
			<option value='Meghna Bank Limited'>Meghna Bank Limited</option>
			<option value='Mercantile Bank Limited'>Mercantile Bank Limited</option>
			<option value='Midland Bank Limited'>Midland Bank Limited</option>
			<option value='Modhumoti Bank Limited'>Modhumoti Bank Limited</option>
			<option value='Mutual Trust Bank Limited'>Mutual Trust Bank Limited</option>
			<option value='National Bank Limited'>National Bank Limited</option>
			<option value='NRB Bank Limited'>NRB Bank Limited</option>
			<option value='NRB Commercial Bank Ltd'>NRB Commercial Bank Ltd</option>
			<option value='One Bank Limited'>One Bank Limited</option>
			<option value='Padma Bank Limited'>Padma Bank Limited</option>
			<option value='Premier Bank Limited'>Premier Bank Limited</option>
			<option value='Prime Bank Limited'>Prime Bank Limited</option>
			<option value='Pubali Bank Limited'>Pubali Bank Limited</option>
			<option value='Rupali Bank PLC'>Rupali Bank PLC</option>
			<option value='SBAC Bank'>SBAC Bank</option>
			<option value='Shahjalal Islami Bank Limited'>Shahjalal Islami Bank Limited</option>
			<option value='Shimanto Bank Ltd'>Shimanto Bank Ltd</option>
			<option value='Social Islami Bank Limited'>Social Islami Bank Limited</option>
			<option value='Sonali Bank Ltd'>Sonali Bank Ltd</option>
			<option value='Southeast Bank Limited'>Southeast Bank Limited</option>
			<option value='Standard Bank Limited'>Standard Bank Limited</option>
			<option value='Standard Chartered Bank'>Standard Chartered Bank</option>
			<option value='Trust Bank Limited'>Trust Bank Limited</option>
			<option value='Union Bank Limited'>Union Bank Limited</option>
			<option value='United Commercial Bank Ltd'>United Commercial Bank Ltd</option>
			<option value='Uttara Bank Limited'>Uttara Bank Limited</option>
			<option value='Woori Bank'>Woori Bank (South Korea)</option>
		</select>
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Card No</p>
	  </div>
	  <div style="width: 70%;">
		<input maxlength="4" type="text" name="card_no" style="width: 100%;" />
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Card Type</p>
	  </div>
	  <div style="width: 70%;">
		<select name="card_type" class="form-select">
			<option value=""></option>
			<option value="Master" class="MTBL CBL">Master Card</option>
			<option value="Visa" class="MTBL CBL">Visa Card</option>
			<option value="Amex" disabled class="CBL">City-AMEX</option>
			<option value="CityVMQU" disabled class="CBL">City-VISA/Master/Q-Cash/Union Pay</option>
		</select>
		
	  </div>
	</div>
	<div class="d-flex align-items-center mb-3" style="width: 100%;">
	  <div style="width: 30%;">
		<p class="mb-0">Merchant Bank</p>
	  </div>
	  <div style="width: 70%;">
		<select name="merchant" class="form-select">
			<option value='MTBL'>HNS Engineering & Services Ltd & A/C No.:#(MTBL-0022-0210004676)</option>
			<option value='CBL'>HNS Auto Solutions & A/C No.:#(MTBL-01301-000217814)</option>
		</select>	
	  </div>
	</div>
</div>


							
 
                            <div class="d-flex align-items-center mb-3">
                              <div>
                                <p class="mb-0"></p>
                              </div>
                              <div class="ms-auto">
                                <input type="submit" name="submit" value="Submit" class="btn btn-outline-success px-3">
                            </div>
                          </div>
						  
						<input type="hidden" name="customer_id" value="{{$customer_id}}">  
						  
						</form>
                          </div>
                        </div>




                     </div>
					 
                       <div class="col">
                         <div class="card border shadow-none radius-10">
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
                                 <p class="mb-1"><b>Chas:</b> {{$customer_chas}}</p>
                                 <p class="mb-1"><b>Vehicle:</b> {{$customer_vehicle}}</p>
                              </div>
                           </div>
                           </div>
                         </div>
                       					 
					   <div class="card border shadow-none radius-10"style="margin-bottom: 0.5rem;">
                           <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="fadeIn animated bx bx-money"></i>
                              </div>
                              <div class="info">
							  	<table class="SettlementAmount">
									<thead>
										<tr>
											<td><h6 class="mb-2">Settlement Amount</h6></td>
											<td><h6 class="mb-2">Charge Amount</h6></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><p class="mb-1"><b>Bkash-797:</b> TK. <input type="text" id="id-6" disabled ></p></td>
											<td>TK. <input type="text" id="id-6-c" disabled ></td>
										</tr>
										<tr>
											<td><p class="mb-1"><b>Bkash-330:</b> TK. <input type="text" id="id-6-1" disabled ></p></td>
											<td>TK. <input type="text" id="id-6-c-1" disabled ></td>
										</tr>
										<tr>
											<td><p class="mb-1"><b>Card-Visa/Master: &nbsp;</b> TK. <input type="text" id="id-7" disabled></p></td>
											<td>TK. <input type="text" id="id-7-c" disabled ></td>
										</tr>
										<tr>
											<td><p class="mb-1"><b>City-AMEX: &nbsp;</b> TK. <input type="text" id="id-11" disabled></p></td>
											<td>TK. <input type="text" id="id-11-c" disabled ></td>
										</tr>
										<tr>
											<td><p class="mb-1"><b>City-VISA/Master/<br>Q-Cash/Union Pay: &nbsp;</b> TK. <input type="text" id="id-12" disabled></p></td>
											<td>TK. <input type="text" id="id-12-c" disabled ></td>
										</tr>
									</tboday>
								</table>
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

<style>
.SettlementAmount input {
    width: 80px;
}
.SettlementAmount tr > td:last-child {
    text-align: right;
}
.SettlementAmount b {
    font-size: 14px;
}
</style>

		  
@endsection		 





@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection
 
 
 
<script>

$(function () {
  $("#id-1").keyup(function () {
	$("#id-6").val((+$("#id-1").val()*.985 ));
	$("#id-6-1").val((+$("#id-1").val()*.988 ));
    $("#id-7").val((+$("#id-1").val()*.987 ));
	$("#id-11").val((+$("#id-1").val()*.980 ));
	$("#id-12").val((+$("#id-1").val()*.983 ));

	$("#id-6-c").val((+$("#id-1").val()*.015 ));
	$("#id-6-c-1").val((+$("#id-1").val()*.012 ));
    $("#id-7-c").val((+$("#id-1").val()*.013 ));
	$("#id-11-c").val((+$("#id-1").val()*.020 ));
	$("#id-12-c").val((+$("#id-1").val()*.017 ));
  });

  
 
  $("select[name='merchant']").on('change', function() {
		//alert( this.value );
		$("select[name='card_type']").val('');
		$("select[name='card_type'] option").attr('disabled', 'disabled');
		$("select[name='card_type'] option").filter("."+this.value).removeAttr('disabled');
	});

});
</script>
 



