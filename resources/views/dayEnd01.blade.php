
@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Account </li>
                    <li class="breadcrumb-item active" aria-current="page">Day End </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3 bg-gradient-warning">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <center><h5 class="mb-0">Date: {{date('d-M-Y', strtotime($dt))}}</h5></center>
                    </div>
                  </div>
             </div>
		
			
<?php
$cash='0';$bank='0';$mfs='0';$card='0';$online='0';

$timestamp = strtotime($dt);
$oneDayAgo = strtotime("-1 day", $timestamp);
$dt_o = date('Y-m-d', $oneDayAgo);

$data = DB::select("SELECT  `close_balance`, `cash`, `bank`, `mfs`, `card`, `online` FROM `day_end` where date = '$dt_o'");
foreach($data as $item)
{ 
$open_balance = $item->close_balance;
$cash = $item->cash; $cash_o = $item->cash;
$bank = $item->bank; $bank_o = $item->bank;
$mfs = $item->mfs; $mfs_o = $item->mfs;
$card = $item->card; $card_o = $item->card;
$online = $item->online; $online_o = $item->online;
}

$data01 = DB::select("SELECT `payment_type`, `amount` FROM `transactions01` WHERE date='$dt'");
foreach($data01 as $item01)
	{ 
	if($item01->payment_type=='cash'){$cash = $item01->amount + $cash;}
	if($item01->payment_type=='bank'){$bank = $item01->amount + $bank;}
	if($item01->payment_type=='mfs'){$mfs = $item01->amount + $mfs;}
	if($item01->payment_type=='card'){$card = $item01->amount + $card;}
	if($item01->payment_type=='online'){$online = $item01->amount + $online;}
	}
	
\DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query
$result01 = DB::select("
SELECT 
ROUND(SUM(CASE WHEN a.pay_type = 'cash' then `received` ELSE 0 END),2) AS `cash`,
ROUND(SUM(CASE WHEN a.pay_type = 'cheque' then `received` ELSE 0 END),2) AS `cheque`,
ROUND(SUM(CASE WHEN a.pay_type = 'online' then `received` ELSE 0 END),2) AS `online`,
SUM(`received`) total
FROM `pay` a
WHERE 
a.dt = '$dt' 
and a.pay_type<>'SYS'
order by bill, a.bill_dt desc;
");
		
foreach($result01 as $item01)
		{		
			$cash = $cash+$item01->cash;
			$bank = $bank+$item01->cheque;
			$online = $online+$item01->online;
		}					
$result02 = DB::select("
SELECT sum(`received`) received,`pay_type` 
FROM `pay` WHERE `approval_dt`='$dt' group by `pay_type`; 
");
		
foreach($result02 as $item02)
		{		
			if($item02->pay_type=='bkash'){$mfs = $item02->received + $mfs;}
			if($item02->pay_type=='card'){$card = $item02->received + $card;}
		}					
	$closing_balance = $cash+$bank+$mfs+$card+$online;
	
?>			
           </div>


<h5>Today's Openning Balance: {{number_format(($open_balance), 2, '.', ',');}}</h5>
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-5">
              <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Cash</p>
                              <h4 class="my-1">{{number_format(($cash_o), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="lni lni-coin"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Bank</p>
                                <h4 class="my-1">{{number_format(($bank_o), 2, '.', ',');}}</h4>
                            </div>
                            <div class="widget-icon-large bg-gradient-success text-black ms-auto"><i class="fadeIn animated bx bx-building-house"></i>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">MFS</p>
                              <h4 class="my-1">{{number_format(($mfs_o), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="fadeIn animated bx bx-mobile"></i>
                          </div>
                      </div>
                  </div>
               </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Card</p>
                              <h4 class="my-1">{{number_format(($card_o), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-warning text-black ms-auto"><i class="bi fadeIn animated bx bx-credit-card"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Online</p>
                              <h4 class="my-1">{{number_format(($online_o), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi lni lni-world"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
            </div>


<h5>Today's Closing Balance: {{number_format(($closing_balance), 2, '.', ',');}}</h5>
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-5">
              <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Cash</p>
                              <h4 class="my-1">{{number_format(($cash), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="lni lni-coin"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Bank</p>
                                <h4 class="my-1">{{number_format(($bank), 2, '.', ',');}}</h4>
                            </div>
                            <div class="widget-icon-large bg-gradient-success text-black ms-auto"><i class="fadeIn animated bx bx-building-house"></i>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">MFS</p>
                              <h4 class="my-1">{{number_format(($mfs), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="fadeIn animated bx bx-mobile"></i>
                          </div>
                      </div>
                  </div>
               </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Card</p>
                              <h4 class="my-1">{{number_format(($card), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-warning text-black ms-auto"><i class="bi fadeIn animated bx bx-credit-card"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Online</p>
                              <h4 class="my-1">{{number_format(($online), 2, '.', ',');}}</h4>
                          </div>
                          <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi lni lni-world"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
            </div>

			

<center>
<form action="dayEnd02" method="post">{{ csrf_field() }}
<input type="hidden" name="open_balance" value="{{$open_balance}}">
<input type="hidden" name="closing_balance" value="{{$closing_balance}}">
<input type="hidden" name="cash" value="{{$cash}}">
<input type="hidden" name="bank" value="{{$bank}}">
<input type="hidden" name="mfs" value="{{$mfs}}">
<input type="hidden" name="card" value="{{$card}}">
<input type="hidden" name="online" value="{{$online}}">
<input type="hidden" name="date" value="{{$dt}}">

<button class="btn btn-success" type="submit" name="register" value="register">Create Day End</button>
</form>
</center>








			
			
</main>



		  
@endsection		 









@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection