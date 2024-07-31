@extends("layouts.master")

@section("content")
<?php
$data = DB::select("SELECT `service_id`,`service_name`,`section` FROM `service_info` WHERE `service_id` = '$id'");
foreach($data as $item){ $service_id = $item->service_id ;$service_name = $item->service_name ;
$section = $item->section ;}
?>

<main class="page-content">

		<div class="col-xl-6 mx-auto">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Service Modification</h6>
                <hr>
                <form class="row g-3" action="serviceEditOne" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">Service Name</label>
                    <input value="{{$service_id}} - {{$service_name}}" disabled type="text" class="form-control" >
					          <input name="id" value="{{$service_id}}" type="hidden">
                  </div>

                  <div class="col-12">
                    <label class="form-label">Service Type</label>
                    <select class="form-control" name="section" >
                      <option value="">Select</option>
                      <option value="General Repair" @if($section == "General Repair")selected @endif>General Repair</option>
                      <option value="A.C & Electric" @if($section == "A.C & Electric")selected @endif>A.C & Electric</option>
                      <option value="Body & Paint" @if($section == "Body & Paint")selected @endif>Body & Paint</option>
                      <option value="Maintenance" @if($section == "Maintenance")selected @endif>Maintenance</option>
                      <option value="CNG & LPG" @if($section == "CNG & LPG")selected @endif>CNG & LPG</option>

                    </select>
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



  
</main>  
@endsection






