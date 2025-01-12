@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if (Session::get('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
<div class="alert alert-danger">
Invalid Customer, Please Signup the Entry Form
</div>
<script type="text/javascript">
$(document).ready(function () {
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
 });
</script>
@endif
<!---Alert message----> 

		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">New Customer Entry Form</h6>
                <hr>
                <form class="row g-3" action="customerCreate" method="post">{{ csrf_field() }}
                  <div class="col-12">
                    <label class="form-label">Registration</label> 
                    <input placeholder="e.g: DHK-123" type="text" class="form-control" name="customer_reg">
                  </div>				
                  <div class="col-6">
                    <label class="form-label">Chassis</label>
                    <input placeholder="e.g: ZYX10-2031342" type="text" class="form-control" name="customer_chas">
                  </div>		
                  <div class="col-3">
                    <label class="form-label">Year</label>
                    <input placeholder="e.g: 2020" value="" type="text" class="form-control" name="year">
                  </div>
                  <div class="col-3">
                    <label class="form-label">Engine No.</label>
                    <input placeholder="e.g: PJ12345U123456P" type="text" class="form-control" name="customer_eng">
                  </div>		
                  <div class="col-12">
                    <label class="form-label">Customer Name</label>
                    <input id="tags01" placeholder="e.g: Abdul Karim" type="text" class="form-control" name="customer_nm" required>
                  </div>
                  <div class="col-8">
                    <label class="form-label">Car User Name</label>
                    <input id="tags01" placeholder="e.g: Jobbar" type="text" class="form-control" name="car_user">
                  </div>
                  <div class="col-4">
                    <label class="form-label">Colour Code</label>
                    <input id="tags01" placeholder="e.g: Pearl" type="text" class="form-control" name="car_colour">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" rows="4" cols="4" name="customer_address"></textarea>
                  </div>                  
				  <div class="col-12">
                    <label class="form-label">Contact</label>
                    <input placeholder="e.g: 01711111111"  type="text" class="form-control" name="customer_mobile">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Contact Person</label>
                    <input id="tags01" placeholder="e.g: Abdul Karim" type="text" class="form-control" name="contact_person">
                  </div>
				  <div class="col-12">
                    <label class="form-label">Email</label>
                    <input placeholder="e.g: email@email.com"  type="text" class="form-control" name="email">
                  </div>                  
				  <div class="col-12">
                    <label class="form-label">Driver Contact</label>
                    <input placeholder="e.g: 01711111111"  type="text" class="form-control" name="driver_mobile" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Vehicle</label>
                    <input placeholder="e.g: Toyota C-HR 2017" type="text" class="form-control" name="customer_vehicle" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Customer Group</label>
                    <input id="tags04" placeholder="e.g: Individual Customer" type="text" class="form-control" name="customer_group" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Company</label>
                    <input id="tags02" placeholder="e.g: ASH Group" type="text" class="form-control" name="company" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Sister Companies</label>
                    <input id="tags03" placeholder="e.g: Alven System" type="text" class="form-control" name="sister_companies" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">BIN</label>
                    <input id="tags01" placeholder="e.g: 0111111111" type="text" class="form-control" name="bin">
                  </div>

                  <div class="col-12">
                    <center><label class="form-label"><h3>Bank Information</h3></label></center>
                    <center><label class="form-label">Company Account Information</label></center>
                  </div>
				  
				  
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: lavender;"id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code" >
                  </div>


				
                  <div class="col-12">
                    <center><label class="form-label">Personal Account Information</label></center>
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: blanchedalmond;" id="tags01" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code02" >
                  </div>

                  <div class="col-12">
                    <center><label class="form-label"><h3>Contact Person Information</h3></label></center>
                  </div>

                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 1</b></label></center>
                  </div>
                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact1_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact1_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact1_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact1_purpose" >
                  </div>
                </div>
                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 2</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact2_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact2_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact2_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact2_purpose" >
                  </div>
                </div>
                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 3</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact3_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact3_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact3_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: lavender;" type="text" class="form-control" name="contact3_purpose" >
                  </div>
                </div>
                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 4</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact4_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact4_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact4_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: blanchedalmond;" type="text" class="form-control" name="contact4_purpose" >
                  </div>
                </div>

                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Customer?
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
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
foreach ($customer_info as $p) 
{
echo '"'.$p->customer_nm.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($company as $p) 
{
echo '"'.$p->company.'",';
}
					   ?>
    ];
    $( "#tags02" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
foreach ($sister_companies as $p) 
{
echo '"'.$p->sister_companies.'",';
}
					   ?>
    ];
    $( "#tags03" ).autocomplete({
      source: availableTags
    });
  } );
  </script>  

<script>
  $( function() {
    $( "#tags04" ).autocomplete({
      source: ["Individual Customer","ASH Automobiles","Inter-Company"]
    });
  } );
  </script>  
  
  
 @endsection