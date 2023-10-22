<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")



<main class="page-content">




<!---Alert message----> 
@if (Session::get('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="alert alert-success">
New Payment Add Sucessfully!!!
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
<!---Alert message----> 
@if (Session::get('alertDel'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="alert alert-danger">
Payment Delete Sucessfully!!!
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
	<div class="row">
		<div class="col-xl-5">
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Payment Entry Form</h6>
                <hr>
                <form class="row g-3" action="payment01" method="post">{{ csrf_field() }}
                 				
                  <div class="col-12">
                    <label class="form-label">Ledge</label>
                    <input id="tags01" placeholder="e.g: Bank Charges" type="text" class="form-control" name="ledge" required>
                  </div>

                  <div class="col-12">
                    <label class="form-label">Payment Type</label>
								<select name="payment_type" class="form-select mb-3" required>
									<option value="cash">Cash</option>
									<option value="bank">Bank</option>
								</select>
                  </div>  
                  
				  <div class="col-12">
                    <label class="form-label">Amount</label>
                    <input id="tags01" placeholder="e.g: 1000" type="text" class="form-control" name="amount" required>
                  </div>				  
				  <div class="col-12">
                    <label class="form-label">Note</label>
                    <input type="text" class="form-control" name="note" >
                  </div>				  
				  
				  
                  <div class="col-12">
                    <div class="form-check d-flex justify-content-center gap-2">
                      <input placeholder="Example: Nishan" class="form-check-input" type="checkbox" id="gridCheck1" required>
                      <label class="form-check-label" for="gridCheck3-c" required>
                        Create a New Payment?
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


<?php
$cash='0';$bank='0';$mfs='0';$card='0';$online='0';
$dt = date("Y-m-d", strtotime("-1 day"));
$dt01 = date("Y-m-d");
$date = date("d-M-Y");
$data = DB::select("SELECT  `close_balance`, `cash`, `bank`, `mfs`, `card`, `online` FROM `day_end` where date = '$dt'");
foreach($data as $item){ $open_balance = $item->close_balance;$cash = $item->cash;$bank = $item->bank;$mfs = $item->mfs;$card = $item->card;$online = $item->online;}

$data01 = DB::select("SELECT `payment_type`, `amount` FROM `transactions01` WHERE date='$dt01'");
foreach($data01 as $item01)
	{ 
	if($item01->payment_type=='cash'){$cash = $item01->amount + $cash;}
	if($item01->payment_type=='bank'){$bank = $item01->amount + $bank;}
	if($item01->payment_type=='mfs'){$mfs = $item01->amount + $mfs;}
	if($item01->payment_type=='card'){$card = $item01->amount + $card;}
	if($item01->payment_type=='online'){$online = $item01->amount + $online;}
	}
?>
		<div class="col-xl-7">
<table style="background: black;color: greenyellow;">
<tr><td style="width: 70px;">Cash: 	</td><td style="text-align: right;">{{number_format(($cash), 2, '.', ',');}}</td></tr>
<tr><td>Bank: 	</td><td style="text-align: right;">{{number_format(($bank+$card+$online), 2, '.', ',');}}</td></tr>
</table>
			<div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Date: {{$date}} 
				&nbsp;
				Total:
				
<?php
$data = DB::select("SELECT sum(`amount`) amount FROM `transactions01` WHERE `date` = '$dt01'");
$data02 = DB::select("SELECT sum(`amount`) amount FROM `transactions01` WHERE `date` = '$dt01' and payment_type = 'cash'");
$data03 = DB::select("SELECT sum(`amount`) amount FROM `transactions01` WHERE `date` = '$dt01' and payment_type = 'bank'");
foreach($data as $item){ echo $expense = number_format((abs($item->amount)), 2, '.', ',') ;}
?>				
[Cash: <?php foreach($data02 as $item02){ echo number_format((abs($item02->amount)), 2, '.', ',') ;}
?> 
Bank: <?php foreach($data03 as $item03){ echo number_format((abs($item03->amount)), 2, '.', ',') ;}
?>]				
				
				</h6>
                <hr>






<table id="example3" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Ledge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Note</th>
							<th scope="col" style="border: 1px solid black;text-align: center;"></th>
						</tr>
					</thead>
					<tbody>				
<?php

$result02 = DB::select("
SELECT a.`id`, b.name, `payment_type`, `amount`, `type`, `date`, `user_id`, `note` 
FROM `transactions01` a, `coa` b
WHERE a.ledge = b.id and date='$dt01' and type = 'C'
");
	$sl = '1'; 			
foreach($result02 as $item02)
		{		
?>				
					<tr>
						<td scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</td>
						<td style="border: 1px solid black;text-align: left;">{{$item02->name}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item02->payment_type}}</a></td>
						<td style="border: 1px solid black;text-align: right;">{{number_format((abs($item02->amount)), 2, '.', ',')}}</a></td>
						<td style="border: 1px solid black;text-align: left;">{{$item02->note}}</a></td>
						<td scope="row" style="border: 1px solid black;text-align: center;">
						
						
                            <form style="display: inline;" action="paymentDel" method="post">{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$item02->id}}">
							<button class="btn-danger" style="padding: 4px;" type="submit" name="" value=""><i class="fadeIn animated bx bx-trash"></i>&nbsp;</button>
							</form>						
						
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
	</div>


  
</main>  
@endsection






@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-ui.js"></script>

  
  
  
  <script>
  $( function() {
    var availableTags = [
 
  <?php
//$user_info = DB::table('user')->get(); 
$ledge = DB::select("SELECT `name` FROM `coa` WHERE `ledge` = '1'");

foreach ($ledge as $p) 
{
echo '"'.$p->name.'",';
}
					   ?>
    ];
    $( "#tags01" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
  
 @endsection
 
 
 @section("dataTable")
 
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection