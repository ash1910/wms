@extends("layouts.master")


@section("content")
<main class="page-content">
	@foreach($data as $item)
		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Customer Modification</h6>
                <hr>
                <form class="row g-3" action="customerEditTwo" method="post">{{ csrf_field() }}
				          <input type="hidden" name="id" value="{{$item->customer_id}}">
                  <div class="col-12">
                    <label class="form-label">Customer Name</label>
                    <input value="{{$item->customer_nm}}" type="text" class="form-control" name="customer_nm" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Mobile</label>
                    <input value="{{$item->customer_mobile}}" type="text" class="form-control" name="customer_mobile" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Contact Person</label>
                    <input value="{{$item->contact_person}}" placeholder="e.g: Abdul Karim" type="text" class="form-control" name="contact_person">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Email</label>
                    <input value="{{$item->email}}" type="text" class="form-control" name="email" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Vehicle</label>
                    <input value="{{$item->customer_vehicle}}" type="text" class="form-control" name="customer_vehicle" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Register</label>
                    <input value="{{$item->customer_reg}}" type="text" class="form-control" disabled>
                    <input value="{{$item->customer_reg}}" type="hidden" class="form-control" name="customer_reg">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Chas</label>
                    <input name="customer_chas" value="{{$item->customer_chas}}" type="text" class="form-control" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" rows="4" cols="4" name="customer_address">{{$item->customer_address}}</textarea>
                  </div>
 
                  <div class="col-12">
                    <label class="form-label">Driver Contact</label>
                    <input value="{{$item->driver_mobile}}" type="text" class="form-control" name="driver_mobile">
                  </div>		
                  
                  <div class="col-12">
                    <label class="form-label">Customer Group</label>
                    <input id="tags04" placeholder="e.g: Individual Customer" type="text" class="form-control" name="customer_group" value="{{$item->customer_group}}">
                  </div>
 
                  <div class="col-12">
                    <label class="form-label">Company</label>
                    <input id="tags02" placeholder="e.g: HNS Group" type="text" class="form-control" name="company" value="{{$item->company}}">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Sister Companies</label>
                    <input id="tags03" value="{{$item->sister_companies}}" placeholder="e.g: Techno Mole Creations" type="text" class="form-control" name="sister_companies" >
                  </div>
                  <div class="col-12">
                    <label class="form-label">BIN</label>
                    <input value="{{$item->bin}}" placeholder="e.g: 0111111111" type="text" class="form-control" name="bin">
                  </div>

                  <div class="col-12">
                    <center><label class="form-label"><h3>Bank Information</h3></label></center>
                    <center><label class="form-label">Company Account Information</label></center>
                  </div>
				  
				  
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: lavender;" value="{{$item->ac_name}}" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: lavender;" value="{{$item->ac_no}}" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: lavender;" value="{{$item->bank_name}}" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: lavender;" value="{{$item->branch_name}}" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: lavender;" value="{{$item->routing_no}}" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: lavender;" value="{{$item->swift_code}}" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code" >
                  </div>


				
                  <div class="col-12">
                    <center><label class="form-label">Personal Account Information</label></center>
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC Name</label>
                    <input style="background: blanchedalmond;" value="{{$item->ac_name02}}" placeholder="e.g: ABCD" type="text" class="form-control" name="ac_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">AC No</label>
                    <input style="background: blanchedalmond;" value="{{$item->ac_no02}}" placeholder="e.g: XXXX XXXX XXXX XXXX" type="text" class="form-control" name="ac_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Bank Name</label>
                    <input style="background: blanchedalmond;" value="{{$item->bank_name02}}" placeholder="e.g: ABCD" type="text" class="form-control" name="bank_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Branch Name</label>
                    <input style="background: blanchedalmond;" value="{{$item->branch_name02}}" placeholder="e.g: Gulshan" type="text" class="form-control" name="branch_name02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Routing No</label>
                    <input style="background: blanchedalmond;" value="{{$item->routing_no02}}" placeholder="e.g: XXXX" type="text" class="form-control" name="routing_no02" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Swift Code</label>
                    <input style="background: blanchedalmond;" value="{{$item->swift_code02}}" placeholder="e.g: XXXX" type="text" class="form-control" name="swift_code02" >
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
                    <input style="background: lavender;" value="{{$item->contact1_name}}" type="text" class="form-control" name="contact1_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: lavender;" value="{{$item->contact1_mobile}}" type="text" class="form-control" name="contact1_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: lavender;" value="{{$item->contact1_desig}}" type="text" class="form-control" name="contact1_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: lavender;" value="{{$item->contact1_purpose}}" type="text" class="form-control" name="contact1_purpose" >
                  </div>
                </div>

                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 2</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact2_name}}" type="text" class="form-control" name="contact2_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact2_mobile}}" type="text" class="form-control" name="contact2_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact2_desig}}" type="text" class="form-control" name="contact2_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact2_purpose}}" type="text" class="form-control" name="contact2_purpose" >
                  </div>
                </div>

                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 3</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: lavender;" value="{{$item->contact3_name}}" type="text" class="form-control" name="contact3_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: lavender;" value="{{$item->contact3_mobile}}" type="text" class="form-control" name="contact3_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: lavender;" value="{{$item->contact3_desig}}" type="text" class="form-control" name="contact3_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: lavender;" value="{{$item->contact3_purpose}}" type="text" class="form-control" name="contact3_purpose" >
                  </div>
                </div>

                <div class="row" style="border: 2px solid #0b5ed7; margin: 15px 0px 10px 0px; padding: 15px;">
                  <div class="col-12">
                    <center><label class="form-label"><b>Contact Person 4</b></label></center>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact4_name}}" type="text" class="form-control" name="contact4_name" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Mobile No</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact4_mobile}}" type="text" class="form-control" name="contact4_mobile" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Designation</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact4_desig}}" type="text" class="form-control" name="contact4_desig" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Purpose of Contact</label>
                    <input style="background: blanchedalmond;" value="{{$item->contact4_purpose}}" type="text" class="form-control" name="contact4_purpose" >
                  </div>
                </div>
 
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div>
		</div>
	@endforeach


  
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
      source: ["Individual Customer","HNS Automobiles","Inter-Company"]
    });
  } );
  </script>  
  
 @endsection