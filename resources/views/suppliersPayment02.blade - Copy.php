@extends("layouts.master")

@section("content")

<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else { ?>
<script>window.location = "/home";</script>
<?php  }   ?>


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Cash Out </li>
                    <li class="breadcrumb-item active" aria-current="page">Suppliers Payment </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
	<div class="card"  style="padding:20px">
	<div class="col-12 col-lg-4">
	<div class="card shadow-none border radius-15">
		<div class="card-body">

	<form class="row g-3" action="suppliersPayment03" method='post' name="myForm" onsubmit="return validateForm()">
			{{ csrf_field() }}
			
				<table>
					<tr><td><strong class="text-inverse">Supplier: </strong></td>
						<td><input name="supplier" value="{{$supplier}}" type="text" disabled ></td></tr>

					<tr>
						<td><strong class="text-inverse">Month - Year</strong></td>
						<td><input name="dt" value="{{date('F-Y', strtotime($dt))}}" type="text" disabled ></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;word-wrap: anywhere;"><strong class="text-inverse">Ref: </strong>{{$supplier_ref}}</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;"><strong class="text-inverse">Total Amount: </strong> TK. {{number_format(($amount), 2, '.', ',')}}</td>
					</tr>
					
					
					<tr><td><strong class="text-inverse">Discount: </strong></td>
						<td><input autofocus name="discount" type="text" required></td></tr>
					<tr><td><strong class="text-inverse">Amount: </strong></td>
						<td><input autofocus name="pAmount" type="text" required placeholder="Amount to be Paid"></td></tr>
					
					<tr><td><strong class="text-inverse">Date: </strong></td>
						<td><input name="pDt" type="date" class="form-control" required=""></td></tr>
					<tr>
						<td colspan="2"><input autofocus name="note" type="text" placeholder="Note..."style="width: 100%;"></td>
					</tr>		
					<tr>
					<td><label for="Cash">
							<input value="Cash" type="radio" id="Cash" name="pay_type" onclick="ShowHideDiv()" required/>
							Cash
						</label></td>
					<td><label for="Cheque">
							<input value="Cheque" type="radio" id="Cheque" name="pay_type" onclick="ShowHideDiv()" required/>
							Cheque
						</label></td>
					</tr>
			
					
				</table>	
				
				
	
<script type="text/javascript">
    function ShowHideDiv() 
	{
        var Cheque = document.getElementById("Cheque");
        var dvCheque = document.getElementById("dvCheque");
        dvCheque.style.display = Cheque.checked ? "block" : "none";
    }
</script>




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
			<option value='Bangladesh Commerce Bank Limited'>Bangladesh Commerce Bank Limited</option>
			<option value='Bank Al-Falah Limited (Pakistan)'>Bank Al-Falah Limited (Pakistan)</option>
			<option value='Bank Asia Limited'>Bank Asia Limited</option>
			<option value='Bengal Commercial Bank Limited'>Bengal Commercial Bank Limited</option>
			<option value='BRAC Bank Limited'>BRAC Bank Limited</option>
			<option value='Citibank N.A (United States of America)'>Citibank N.A (United States of America)</option>
			<option value='City Bank Limited'>City Bank Limited</option>
			<option value='Commercial Bank of Ceylon (PLC)'>Commercial Bank of Ceylon (PLC)</option>
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
			<option value='NCC Bank'>NCC Bank</option>
			<option value='NRB Bank Limited'>NRB Bank Limited</option>
			<option value='NRB Commercial Bank Ltd'>NRB Commercial Bank Ltd</option>
			<option value='One Bank Limited'>One Bank Limited</option>
			<option value='Padma Bank Limited'>Padma Bank Limited</option>
			<option value='Premier Bank Limited'>Premier Bank Limited</option>
			<option value='Prime Bank Limited'>Prime Bank Limited</option>
			<option value='Pubali Bank Limited'>Pubali Bank Limited</option>
			<option value='SBAC Bank'>SBAC Bank</option>
			<option value='Shahjalal Islami Bank Limited'>Shahjalal Islami Bank Limited</option>
			<option value='Shimanto Bank Ltd'>Shimanto Bank Ltd</option>
			<option value='Social Islami Bank Limited'>Social Islami Bank Limited</option>
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
</div>


<button class="btn btn-success" type="submit" name="next" value="next">
					<i class="lni lni-chevron-right-circle"></i> Paid</button>				
				
				
<input type="hidden" name="supplier" value="{{$supplier}}">				
<input type="hidden" name="dt" value="{{$dt}}">				
<input type="hidden" name="supplier_ref" value="{{$supplier_ref}}">				
<input type="hidden" name="amount" value="{{$amount}}">				
				
				
			</form>

</div>
	</div></div>
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
$parts_info = DB::table('suppliers')->get();
foreach ($parts_info as $p) 
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
  
 
 

 @endsection