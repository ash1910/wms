
@extends("layouts.master")

@section("content")

<?php

$bill_no = $bill;

$result = DB::select("
SELECT `bill_no`, b.customer_id, b.customer_nm, b.customer_reg, b.customer_mobile, b.customer_address, b.customer_vehicle, est_no,
b.customer_chas, `engineer`, `technician`, `job_no`, `job_dt`, cartridge, c.user_name, `net_bill` ,a.flag flag, bill_dt, a.work
FROM `bill_mas` a, `customer_info` b, `user` c
WHERE a.`bill_no` = $bill_no
AND a.customer_id = b.customer_id
AND a.user_id=c.user_id;
");


		$parts_info = DB::table('parts_info')->get();
		$service_info = DB::table('service_info')->get();

		foreach($result as $post)
			{
				 $customer_id = $post->customer_id;
				 $customer_nm = $post->customer_nm;
				 $customer_reg = $post->customer_reg;
				 $customer_mobile = $post->customer_mobile;
				 $customer_address = $post->customer_address;
				 $customer_vehicle = $post->customer_vehicle;
				 $work = $post->work;
				 $customer_chas = $post->customer_chas;
				 $engineer = $post->engineer;
				 $technician = $post->technician;
				 $job_no = $post->job_no;
				 $job_dt = $post->job_dt;
				 $bill_dt = $post->bill_dt;
				 $flag = $post->flag;
				 $user_name = $post->user_name;
				 $cartridge = $post->cartridge;
				 $est_no = $post->est_no;
			}
?>
		<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Reports</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Daily Bill
					&nbsp;


<?php
if(session('role')!="Service Engineer")
{
if(session('role')!="PRO")
    {

		if(session('role')!="Executive")
		{
			if($flag=='0')
				{
			?>
				<a href="/billMemo?bill={{$bill_no}}" class="btn btn-sm btn-success me-2"><i class="fadeIn animated bx bx-edit-alt"></i> Modify</a>
			<?php }
			if($flag!='0')
				{
			?>
				<a href="" class="btn btn-sm btn-secondary me-2"><i class="fadeIn animated bx bx-edit-alt"></i> Modify</a>
			<?php }

		}

    }
}
?>



					<form  target="_blank" style="display: inline;" action="billPrintView" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> View</button>
					</form>

					<form  target="_blank" style="display: inline;" action="billPrint_as" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form>

					<form  target="_blank" style="display: inline;" action="billPrintRef" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Due Ref</button>
					</form>


<?php
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator"))
{
	if($flag!='0')
		{
	?>

					<form  target="_blank" style="display: inline;" action="moneyReceipt01" method="post">{{ csrf_field() }}
					<input type="hidden" name="job_no" value="{{$job_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Receipt</button>
					</form>



	<?php }
	if($flag=='0')
		{
	?>
		<a href="" class="btn btn-sm btn-secondary me-2"><i class="fadeIn animated bx bx-printer"></i> Receipt</a>
	<?php }
}
?>


<?php
if ((session('role')=="Super Administrator")||(session('role')=="Accounts"))
{
?>
					<form style="display: inline;" action="pay" method="post" target="_blank">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="lni lni-coin"></i> Receive</button>
					</form>
<?php } ?>

					<form  target="_blank" style="display: inline;" action="billPrint" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> HNS Engineering</button>
					</form>

<?php
if ((session('role')=="Super Administrator"))
{
	if($flag!='0'){
	?>
                    <form style="display: inline;" action="moveToDraft" method="post">{{ csrf_field() }}
                        <input type="hidden" name="job_no" value="{{$job_no}}">
                        <input type="hidden" name="bill_no" value="{{$bill_no}}">
                        <button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
                        <i class="fadeIn animated bx bx-printer"></i> Move to Draft</button>
					</form>

                    <form style="display: inline;" action="changeBillDetail" method="post">{{ csrf_field() }}
                        <input type="hidden" name="bill_no" value="{{$bill_no}}">
                        <input type="hidden" name="job_no" value="{{$job_no}}">
                        <button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
                        <i class="fadeIn animated lni lni-reload"></i> Change Bill Date</button>
					</form>

<?php }

}
?>

					<!-- <form  target="_blank" style="display: inline;" action="billPDF_as" method="post">{{ csrf_field() }}
					<input type="hidden" name="bill_no" value="{{$bill_no}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> PDF</button>
					</form> -->


					</li>
                  </ol>
                </nav>

              </div>
              <div class="ms-auto">

              <?php
if ((session('role')=="Super Administrator")){
if($flag=='0'){
?>
                <form style="display: flex;gap: 10px;" action="updateBillWork" method="post">{{ csrf_field() }}
				   <input type="hidden" name="bill_no" value="{{$bill_no}}">
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="engineering">
                    <label class="form-check-label" for="flexRadioDefault1">Engineering&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="intercompany">
                    <label class="form-check-label" for="flexRadioDefault1">Intercompany</label>
                  </div>
                  <div class="form-check">
                    <input required class="form-check-input" type="radio" name="work" value="automobile">
                    <label class="form-check-label" for="flexRadioDefault1">Automobile</label>
                  </div>
                  <div class="form-check">
                    <button class="btn btn-outline-success px-3" type="submit" name="" value="">Update</button>
                  </div>
                </form>

<?php
    }
}
?>
                <div class="btn-group">

                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                  </div>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->


          <div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Create Bill/ Cash Memo [Bill No: {{$bill_no}}]</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
             <div class="card-header py-2 bg-light">
               <div class="row row-cols-1 row-cols-lg-3">
                 <div class="col-6">
                  <div class="">
                    <!--small>from</small-->
                    <address class="m-t-5 m-b-5">
                       <strong class="text-inverse">Job Date: </strong>{{date('d-M-Y', strtotime($job_dt))}}<br>
                       <strong class="text-inverse">Customer's Name: </strong>{{$customer_nm}}<br>
                       <strong class="text-inverse">Address: </strong>{{$customer_address}}<br>
                       <strong class="text-inverse">Contact: </strong>{{$customer_mobile}}<br>

                    </address>
                   </div>
                 </div>
                 <div class="col-3">
                  <div class="">
                    <!--small>to</small-->
                    <address class="m-t-5 m-b-5">
<?php
if($flag!='0')
		{?>
        <strong class="text-inverse">Bill Date: </strong>{{date('d-M-Y', strtotime($bill_dt))}}<br>
<?php	}
?>


					   <strong class="text-inverse">Registration No.: </strong>{{$customer_reg}}<br>
                       <strong class="text-inverse">Chassis No.: </strong>{{$customer_chas}}<br>
                       <strong class="text-inverse">Vehicle: </strong>{{$customer_vehicle}}<br>
                       <strong class="text-inverse">Work Type: </strong>{{$work}}<br>

                    </address>
                   </div>
                </div>
				<div class="col-3">
				  <div class="">
					<!--small>to</small-->
					<address class="m-t-5 m-b-5">
					<table>
                       <strong class="text-inverse">Engineer: </strong>{{$engineer}}<br>
                       <strong class="text-inverse">Technician: </strong>{{$technician}}<br>
                       <strong class="text-inverse">Job No.:  </strong>{{$job_no}}<br>
                       <strong class="text-inverse">Bill Create By:  </strong>{{$user_name}}<br>
					   @if($cartridge)<strong class="text-inverse">Cartridge No:  </strong>{{$cartridge}}<br>@endif
					   @if($est_no)<strong class="text-inverse">Estimate No:  </strong>{{$est_no}}<br>@endif
                       <strong class="text-inverse">CID: </strong>{{$customer_id}}<br>
					</table>
					</address>
				   </div>
				</div>

               </div>
             </div>




			<div class="card">
				<div class="card-body">
					<ul class="nav nav-tabs nav-primary" role="tablist">
<?php
if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){?>

						<li class="nav-item" role="presentation">
							<a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
								<div class="d-flex align-items-center">
									<div class="tab-icon"><i class="lni lni-clipboard"></i>
									</div>
									<div class="tab-title">Received Summary</div>
								</div>
							</a>
						</li>
<?php } ?>

						<li class="nav-item" role="presentation">
							<a class="nav-link <?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else {echo 'active';}?>" data-bs-toggle="tab" href="#primarypart" role="tab" aria-selected="false">
								<div class="d-flex align-items-center">
									<div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
									</div>
									<div class="tab-title">Bill</div>
								</div>
							</a>
						</li>
<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")||(session('role')=="Store")){?>

						<li class="nav-item" role="presentation">
							<a class="nav-link" data-bs-toggle="tab" href="#primarybom" role="tab" aria-selected="false">
								<div class="d-flex align-items-center">
									<div class="tab-icon"><i class="fadeIn animated bx bx-food-menu"></i>
									</div>
									<div class="tab-title">BOM</div>
								</div>
							</a>
						</li>
<?php } ?>
<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")||(session('role')=="Administrator")){?>

						<li class="nav-item" role="presentation">
							<a class="nav-link" data-bs-toggle="tab" href="#primarySale" role="tab" aria-selected="false">
								<div class="d-flex align-items-center">
									<div class="tab-icon"><i class="fadeIn animated lni lni-coin"> </i>
									</div>
									<div class="tab-title">&nbsp;Sales Commission</div>
								</div>
							</a>
						</li>
<?php } ?>



					</ul>
					<div class="tab-content py-3">
<?php

	$data = DB::select("SELECT SUM(`net_bill`) net_bill, SUM(`total`) total,
	SUM(`parts`) parts, SUM(`service`) service  FROM `bill_mas`
	WHERE `bill_no`=$bill_no;");
	foreach($data as $item){
	$net_bill = $item->net_bill;$parts = $item->parts;$service = $item->service;
	$total = $item->total; }

if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){?>
<!---------Summary TAB-------------->
	<div class="tab-pane fade active show" id="primaryhome" role="tabpanel">
        <div class="col-12 col-lg-12 d-flex">
			<div class="col-3">
				<address class="m-t-5 m-b-5">
					<strong class="text-inverse">Total Amount: Tk.
					<?php
					echo number_format(($net_bill), 2, '.', ',');

					$ref = '';
					$stock02 = DB::select("
					SELECT ref FROM `pay` WHERE `bill`='$bill_no' and ref<>'SYS'");
					foreach($stock02 as $item02)
						{
								$ref = $item02->ref;
						}


					$stock01 = DB::select("
					SELECT sum(`received`) received, sum(`bonus`) bonus, sum(`vat_wav`) vat_wav,
					sum(`ait`) ait, sum(`due`)due, sum(charge) charge, sum(vat_pro) vat_pro,
					sum(sales_return) sales_return,sum(advance_refund) advance_refund,sum(complementary_work) complementary_work,
					sum(rework) rework, sum(damage_work) damage_work, sum(supplier_adj) supplier_adj, sum(supplier_name) supplier_name
					FROM `pay` WHERE `bill`='$bill_no';");
					foreach($stock01 as $item01)
						{
								$received = $item01->received;
								$discount = $item01->bonus;
								$vat_wav = $item01->vat_wav;
								$ait = $item01->ait;
								$due = $item01->due;
								$charge = $item01->charge;

								$vat_pro = $item01->vat_pro;
								$sales_return = $item01->sales_return;
								$advance_refund = $item01->advance_refund;
								$complementary_work = $item01->complementary_work;
								$rework = $item01->rework;
								$damage_work = $item01->damage_work;
								$supplier_adj = $item01->supplier_adj;
								$supplier_name = $item01->supplier_name;
						}
					$acrefund = ''; $ac_refund='0';
					$stock03 = DB::select("SELECT `pay_type` FROM `pay` WHERE `bill`='$bill_no';");
					foreach($stock03 as $item03)
						{
							$acrefund = $item03->pay_type;
							if($acrefund=='A/C Refund')
							{$ac_refund='1';}
						}

					$AdjCustDue = 0;
					$AdjCust01 = DB::select("SELECT sum(`due`)due FROM `pay` WHERE `bill`='$bill_no' AND `pay_type` = 'Adj-Cust';");
					foreach($AdjCust01 as $AdjCustItem01)
						{
							$AdjCustDue = $AdjCustItem01->due;
						}



					?>
					<br>
					</strong>
					<strong class="text-inverse">Bill (Amount+VAT): Tk. {{number_format(($total), 2, '.', ',');}}</strong><br>
					<strong class="text-inverse">Parts: Tk.  {{number_format(($parts), 2, '.', ',');}}</strong><br>
				    <strong class="text-inverse">Service: Tk.  {{number_format(($service), 2, '.', ',');}}</strong><br>

				</address>
			</div>

			<div class="col-3">
				<address class="m-t-5 m-b-5">
				    <strong class="text-inverse">Discount: Tk.  {{number_format(($discount+$vat_wav), 2, '.', ',');}}</strong><br>
				    <strong class="text-inverse">Net Bill: Tk.  {{number_format(($total-$discount-$vat_wav), 2, '.', ',');}}</strong><br>
				    <strong class="text-inverse">Received: Tk.  {{number_format(($received), 2, '.', ',');}}</strong><br>
				    <strong class="text-inverse">
<?php if($due<0){?>
							Payable :
<?php } else { ?>
							Due :
<?php } ?>
					Tk. {{number_format(($due), 2, '.', ',');}}

					</strong>
				</address>
			</div>
			<div class="col-3">
				<address class="m-t-5 m-b-5">
							  <strong class="text-inverse">Due Reference:</b> {{$ref}}</strong><br>
<?php if($ait!=''){?><strong class="text-inverse">AIT: Tk.</b> {{number_format(($ait), 2, '.', ',');}}</strong><br><?php } ?>
<?php if($vat_pro!=''){?><strong class="text-inverse">VAT Provision: Tk.</b> {{number_format(($vat_pro), 2, '.', ',');}}</strong><br><?php } ?>
<?php if($sales_return!=''){?><strong class="text-inverse">Sales Return:</b> {{$sales_return}}</strong><br><?php } ?>
<?php if($advance_refund!=''){?><strong class="text-inverse">
					<?php
					if($ac_refund=='0'){echo 'Cash';}
					if($ac_refund=='1'){echo 'Ledger';}
					?>

				   Refund:</b> {{$advance_refund}}</strong><br><?php } ?>
<?php if($complementary_work!=''){?><strong class="text-inverse">Complementary Work:</b> {{$complementary_work}}</strong><br><?php } ?>
				</address>
			</div>
			<div class="col-3">
				<address class="m-t-5 m-b-5">
<?php if($rework!=''){?><strong class="text-inverse">Rework:</b> {{$rework}}</strong><br><?php } ?>
<?php if($damage_work!=''){?><strong class="text-inverse">Damage Work:</b> {{$damage_work}}</strong><br><?php } ?>
							<strong class="text-inverse">Cheque In Hand:</b>


<?php   $pay_type='';
		$stock02 = DB::select("
		SELECT `job_no` pay_type,received FROM `cheque_pending` WHERE `job_no`='$job_no' AND `flag`='0'
		");
		foreach($stock02 as $item02){  $received = $item02->received; echo '['.number_format(($received), 0, '.', ',').'] ';}


		$pay_type='';
		$stock02 = DB::select("
		SELECT `job_no` pay_type, `denyImage`, `denyDt`, `received` FROM `cheque_pending` WHERE `job_no`='$job_no' AND `flag`='2'
		");
		foreach($stock02 as $item02){$pay_type = $item02->pay_type;$denyImage = $item02->denyImage; $denyDt = $item02->denyDt; $received = $item02->received;
		if($pay_type!=''){$imageUrl = asset('upload/deny/'.$denyImage); ?>
		<br>
		{{$denyDt ? $denyDt : '0000-00-00'}} - {{$received}} - <a href="{{ $imageUrl }}" target="_blank">[Deny]</a>

		<?php } }

			$supplier_name01='';
			$stock03 = DB::select("SELECT `supplier_name` FROM `suppliers` WHERE `supplier_id` = '$supplier_name';");
			foreach($stock03 as $item03)
				{
					$supplier_name01 = $item03->supplier_name;
				}
			?>
				   </strong><br>
<?php if($supplier_name01!=''){?><strong class="text-inverse">Supplier Adj:</b> Tk: {{$supplier_adj}} [{{$supplier_name01}}]</strong><?php } ?>
<?php if($AdjCustDue != 0){

	$customer_id_adj = DB::table('pay')->where('job_no', $job_no."[adj]")->first()->customer_id;
	$customer_nm_adj = DB::table('customer_info')->where('customer_id', $customer_id_adj)->first()->customer_nm;


	?><strong class="text-inverse">Customer Adj:</b> Tk: {{$AdjCustDue}} [{{$customer_nm_adj}}]</strong><?php } ?>

				</address>
			</div>
		</div>
        <div class="col-12 col-lg-12 d-flex">
			<div class="col-12">




				<table class="table table-bordered mb-0">
					<tr>
						<th scope="col" style="text-align: center;">#</th>
						<th scope="col" style="text-align: center;">Money Receipt</th>
						<th scope="col" style="text-align: center;">Received Date</th>
						<th scope="col" style="text-align: center;">Received Amount(Tk.)</th>
						<th scope="col" style="text-align: center;">Settle Amount(Tk.)</th>
						<th scope="col" style="text-align: center;">Method</th>
						<th scope="col" style="text-align: center;">Debit A/C</th>
						<th scope="col" style="text-align: center;">Bkash</th>
						<th scope="col" style="text-align: center;">Cheque</th>
						<th scope="col" style="text-align: center;">Card</th>
					</tr>
<?php
					$data = DB::select("SELECT a.id,`received`,`pay_type`,`dt`,
					`charge`,`trix`,`send`,`bank`,`chequeNo`,`chequeDt`,`post_dt`,`card_bank`,`card_no`,`card_type`,`distributed_from_pay_id`, `merchant_bank`, `mer_bkash`
					FROM `pay` a, bill_mas b
					WHERE a.job_no = b.job_no AND a.`job_no` = '$job_no' and a.pay_type<>'SYS'
					and a.pay_type<>'due'
					order by id desc");
					$sl="1";
					foreach($data as $item)
					{
?>
					<tr>
						<th scope="row" style="text-align: center;">{{$sl}}</th>
						<td style="text-align: center;">

	<form class="row g-3" action="moneyReceipt02" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$bill_no}}">
		<input type="hidden" name="job_no" value="{{$job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> {{$item->id}}</button>
		</div>
	</form>
	<br>
	<form class="row g-3" action="moneyReceipt06" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$bill_no}}">
		<input type="hidden" name="job_no" value="{{$job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> PDF</button>
		</div>
	</form>
	<br>
	<form class="row g-3" action="moneyReceipt06?image=1" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$bill_no}}">
		<input type="hidden" name="job_no" value="{{$job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Image</button>
		</div>
	</form>

	<br>
	<form class="row g-3" action="moneyReceipt07?image=1" method='post' target="_blank">{{ csrf_field() }}
		<div class="col-12">
		<input type="hidden" name="id" value="{{$item->id}}">
		<input type="hidden" name="bill" value="{{$bill_no}}">
		<input type="hidden" name="job_no" value="{{$job_no}}">
			<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> HNS Auto Solutions</button>
		</div>
	</form>


						</td>
						<td style="text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}

<?php if ((session('role')=="Super Administrator")){?>
    <form style="display: inline;" action="changePaymentDate" method="post">{{ csrf_field() }}
        <input type="hidden" name="id" value="{{$item->id}}">
        <input type="date" class="form-control" name='change_dt'>
        <button class="btn btn-outline-success px-3" type="submit" name="" value="">Update Date</button>
    </form>
<?php } ?>
                        </td>
						<td style="text-align: right;">{{number_format(($item->received+$item->charge), 2, '.', ',');}}</td>
						<td style="text-align: right;">{{number_format(($item->received), 2, '.', ',');}}</td>
						<td style="text-align: center;">{{$item->pay_type}}

<?php
	if($item->pay_type=='cheque')
	{
		$pay_type='';
		echo '</br>';
		$stock04 = DB::select("
		SELECT `dt`, job_no, chequeNo FROM `cheque_disorder` WHERE `job_no`='$job_no' AND `chequeNo`='$item->chequeNo'
		");
		foreach($stock04 as $item04)
		{
		    $date = $item04->dt;

		$stock05 = DB::select("
		SELECT job_no, chequeNo,denyImage FROM `cheque_pending` WHERE `job_no`='$job_no' AND `chequeNo`='$item->chequeNo'
		");
		foreach($stock05 as $item05)
		{
		    $denyImage = $item05->denyImage;
		}	 $imageUrl = asset('upload/deny/'.$denyImage);
		    ?>
		    <a href="{{ $imageUrl }}" target="_blank">
		    <b>Dishonor:</b></a>{{date('d-M-Y', strtotime($date))}}</br>


		<?php
		}
		 ?>




<?php } ?>
						</td>
						<td>
						@if($item->merchant_bank == 'MTBL') ESL-MTBL-4676 @elseif($item->merchant_bank == 'CBL') HAS-MTBL-7814 @elseif($item->merchant_bank == 'BRAC') HAS-BRAC-0001 @elseif($item->merchant_bank == 'DBBL') HAS-DBBL-1152 @endif
						@if($item->pay_type == 'bkash') bKash-01777781{{$item->mer_bkash}} @endif
						</td>
<?php if($item->pay_type=='bkash'){?>
						<td style="text-align: left;"><b>TRIX:</b>{{$item->trix}}<br>
							<b>Send:</b>{{$item->send}}</td>
<?php } else { echo "<td></td>";}?>
<?php if($item->pay_type=='cheque'){

		if( (int)$item->distributed_from_pay_id > 0){
			$item_distributed_from_pay = DB::table('pay')->where('id', (int)$item->distributed_from_pay_id)->first();
			?>
						<td style="text-align: left;"><b>Bank:</b>{{$item_distributed_from_pay->bank}}<br>
						<b>Cheque:</b>{{$item_distributed_from_pay->chequeNo}}<br><b>Date:</b>{{$item_distributed_from_pay->chequeDt}}
						<br><b>Posting Date: </b>{{date('d-M-Y', strtotime($item_distributed_from_pay->post_dt))}}</td>
<?php } else { ?>
						<td style="text-align: left;"><b>Bank:</b>{{$item->bank}}<br>
						<b>Cheque:</b>{{$item->chequeNo}}<br><b>Date:</b>{{$item->chequeDt}}
						<br><b>Posting Date: </b>{{date('d-M-Y', strtotime($item->post_dt))}}</td>
<?php } }

if(($item->pay_type=='cash')&&($item->bank!='')){?>
						<td style="text-align: left;"><b>Bank:</b>{{$item->bank}}<br>
						<b>Cheque:</b>{{$item->chequeNo}}<br><b>Date:</b>{{$item->chequeDt}}</td>
<?php }


else { echo "<td></td>";}?>


<?php if($item->pay_type=='card'){

	$row_bdp = DB::table('bank_decline_payments')->where('pay_id', $item->id)->first();
	?>
						<td style="text-align: left;"><b>Card Bank:</b>{{$item->card_bank}}<br>
						<b>Card No:</b>{{$item->card_no}}<br><b>Type:</b>{{$item->card_type}}

						<?php if(!empty($row_bdp)){ $imageUrl = asset('upload/deny/'.$row_bdp->image);?>
						<br><br><b>Bank Decline(POS):</b> <a href="{{ $imageUrl }}" target="_blank">[Decline]</a>
						<br><b>Return Amount:</b>{{$row_bdp->received}}
						<br><b>Charge:</b>{{$row_bdp->charge}}
						<br><b>Date:</b>{{$row_bdp->dt}}
						<?php } ?>
					</td>
<?php } else { echo "<td></td>";}?>
					</tr>
<?php
					$sl = $sl+1;
					}
?>



				</table>
			</div>
		</div>
	</div>

<?php } ?>
<!---------Bill TAB-------------->
						<div class="tab-pane fade <?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){}else {echo ' active show';}?>" id="primarypart" role="tabpanel">



                    <!--small>from</small-->

	<style>
		table#example4.table-bordered.dataTable thead th,table#example4.table-bordered.dataTable tbody th, table#example4.table-bordered.dataTable tbody td {
    border-bottom-width: 1px;
}
	</style>


				<table class="table table-bordered mb-0" id="example4">
					<thead>
						<tr>
							<th scope="col" style="text-align: center;">#</th>
							<th scope="col" style="text-align: center;">Product</th>
							<th scope="col" style="text-align: center;">Quantity</th>
							<th scope="col" style="text-align: center;">Unit Rate</th>
							<th scope="col" style="text-align: center;">Amount(Tk.)</th>
						</tr>
					</thead>
					<tbody>
<tr><td colspan="5"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parts</strong></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
</tr>

<?php
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '1' and `bill_no`=$bill_no;");
	$sl="1";
	foreach($stock as $item)
		{
?>					<tr>
						<th scope="row" style="text-align: center;">{{$sl}}</th>
						<td style="text-align: left;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: right;">{{number_format(($item->unit_rate), 2, '.', ',');}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',');}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		}

?>
<tr><td colspan="5"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</strong></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
	<td style="display: none;"></td>
</tr>
<?php
	$stock = DB::select("
	SELECT `bill_no`, `prod_id`, `prod_name`, `qty`, `unit_rate`, `amount`
	FROM `bill_det` WHERE type = '2' and `bill_no`=$bill_no;");
	$sl="1";
	foreach($stock as $item)
		{
?>					<tr>
						<th scope="row" style="text-align: center;">{{$sl}}</th>
						<td style="text-align: left;">{{$item->prod_id}} - {{$item->prod_name}}</td>
						<td style="text-align: center;">{{$item->qty}}</td>
						<td style="text-align: right;">{{number_format(($item->unit_rate), 2, '.', ',');}}</td>
						<td style="text-align: right;">{{number_format(($item->amount), 2, '.', ',');}}</td>
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
<!---------BOM TAB-------------->

						<div class="tab-pane fade" id="primarybom" role="tabpanel">


					<table id="example3" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
                            <th scope="col" style="border: 1px solid black;text-align: center;">Issue Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Product</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Issued Req. No.</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Quantity</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Unit Rate</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Amount(Tk.)</th>
						</tr>
					</thead>
					<tbody>

<?php
	$stock = DB::select("
	SELECT `prod_id`, `prod_name`, `qty`, `avg_price`, `amount`, `note`,`req`,`dt`
	FROM `issue` where job_no = '$job_no'");
	$sl="1";$purchase='0';
	foreach($stock as $item)
		{
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
                        <td style="border: 1px solid black;text-align: center;">{{date('d-M-Y', strtotime($item->dt))}}</td>
						<td style="border: 1px solid black;text-align: left;">
						<a href="productLedger02?id={{$item->prod_id}} - {{$item->prod_name}}">{{$item->prod_id}} - {{$item->prod_name}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->req}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->qty}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->avg_price), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: right;">{{number_format(($item->amount), 2, '.', ',');}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$purchase= $item->amount+$purchase;
		}

?>


					</tbody>
				</table><br>
<strong>Total Bill Amount: Tk {{number_format(($net_bill), 2, '.', ',');}}<br>
Purchase Amount: Tk {{number_format(($purchase), 2, '.', ',');}}<br>
Gross Profit: Tk {{number_format(($net_bill-$purchase), 2, '.', ',');}}
</strong>


						</div>
<!---------Sales Commission TAB-------------->

					<div class="tab-pane fade" id="primarySale" role="tabpanel">



					</div>







					</div>
				</div>
			</div>





           </div>

        </main>




@endsection












@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection
