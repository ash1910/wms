
@extends("layouts.master")

@section("content")

<?php
$id= '';
$mess= '';
$req= '';
$dt= '';


if (Session::has('job_no'))
{
	$job_no = Session::get('job_no');
	$mess = Session::get('mess');
  $req = Session::get('req');
  $dt = Session::get('dt');
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
                    <li class="breadcrumb-item active" aria-current="page">Issue
					<a href="/issueModi" class="btn btn-sm btn-success me-2">
					<i class="fadeIn animated bx bx-edit-alt"></i> Modify</a>
					</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
<?php if($mess!=""){ ?>
    <div class="alert alert-danger">{{$mess}}</div>
<?php } ?>
              <div class="card">
                
                <div class="card-body">
                   <div class="row">
                     <div class="col-12 col-lg-4 d-flex">
                       <div class="card border shadow-none w-100">
                         <div class="card-body">
                           <form action="issue01" method="post" class="row g-3">{{ csrf_field() }}
                             
<?php
if($job_no==""){
	?>
							<div class="col-12">
							  <label class="form-label">Job No</label>
							  <input autofocus value="{{$job_no}}" id="id-3" required name="job_no" type="text" class="form-control" placeholder="e.g.- 1111-22" maxlength="7">
                            </div>
<?php } ?>							
<?php
if($job_no!=""){
	?>
							<div class="col-12">
							  <label class="form-label">Job No</label>
							  <input disabled  value="{{$job_no}}" id="id-3" required name="job_no" type="text" class="form-control" placeholder="e.g.- 1111-22" maxlength="7">
							  <input name="job_no" value="{{$job_no}}" type="hidden">
							</div>
<?php } ?>							
							
							
                            <div class="col-12">
                               <label class="form-label">Product</label>
                               <input autofocus required id="tags" name="prod" type="text" class="form-control" placeholder="e.g.- Engine Hood">
                             </div>
						
                            <div class="col-12">
                                <label class="form-label">Quantity</label>
                                <input min='0' required type="text" name='qty' class="form-control" placeholder="e.g.- 1">
                            </div>


<?php if($dt==""){ ?>    
                <div class="col-12">
                  <label class="form-label">Date</label>
                  <input name='dt' type="date" class="form-control" required>
                </div>
<?php } ?>
<?php if($dt!=""){ ?>
                <div class="col-12">
                  <label class="form-label">Date</label>
                  <input disabled  value="{{$dt}}" required name="dt" type="date" class="form-control">
							    <input name="dt" value="{{$dt}}" type="hidden">
                </div>
<?php } ?>	

<?php if($req==""){ ?>    
                <div class="col-12">
                  <label class="form-label">Requisition</label>
                  <input required name="req" type="text" class="form-control" placeholder="e.g.- 1111">
                </div>
<?php } ?>
<?php if($req!=""){ ?>

                <div class="col-12">
                  <label class="form-label">Requisition</label>
                  <input disabled  value="{{$req}}" required name="req" type="text" class="form-control" placeholder="e.g.- 1111">
							    <input name="req" value="{{$req}}" type="hidden">
                </div>
<?php } ?>	
 
							<div class="col-12">
							  <label class="form-label">Note</label>
							  <input name="note" type="text" class="form-control" placeholder="e.g.- note here">
                            </div>

                            <div class="col-12">
                              <div class="d-grid">
                                <button class="btn btn-primary">Add Issue Product</button>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="d-grid">
								<a href="/issue" class="btn btn-danger">Exit</a> </div>
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
                       <strong class="text-inverse">Job No: {{$job_no}}</strong><br>
                    </address>

                   </div>
                 </div>
				
				
				
				<table class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Code</th>
							<th scope="col">Product</th>
              <th scope="col">Date</th>
							<th scope="col">GIN</th>
							<th scope="col">Qty</th>
							<th scope="col">Req.</th>
							<th scope="col">Note</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
<?php
	$stock = DB::table('issue')->where('job_no', $job_no)->get(); 
	$sl = '1';
	foreach($stock as $item)
		{ 					
?>					<tr>
						<th scope="row">{{$sl}}</th>
						<td>{{$item->prod_id}}</td>
						<td>{{$item->prod_name}}</td>
            <td>{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td>{{$item->gin}}</td>
						<td>{{$item->qty}}</td>
						<td>{{$item->req}}</td>
						<td>{{$item->note}}</td>
						<td><center>
							<form style="display: inline;" action="issueDel" method="post">{{ csrf_field() }}
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="hidden" name="job_no" value="{{$job_no}}">
                <button class="btn btn-sm btn-danger me-2" type="submit" name="" value=""><i class="fadeIn animated bx bx-trash"></i>&nbsp;</button>
							</form>
							</center>
						</td>
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
$bom_prod = DB::table('bom_prod')->get();
 
foreach ($bom_prod as $p) 
{
echo '"'.$p->parts_id.' - '.$p->parts_name.' -['.$p->stock_qty.'] '.'",';
}
					   ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
  
 <script type="text/javascript">

    $(function() {

        $( "#datepicker" ).datepicker({ 
            changeYear: true,
            minDate: '-2D',
            maxDate: '+0D',
        });
    });


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