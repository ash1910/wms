<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")

<?php
$where_billtype = "";
$filter_header = "";
if( $billtype == "all_dues"){
	$where_billtype = "HAVING due > 0";
	$filter_header = ", All Dues";
}
elseif( $billtype == "engineering_dues"){
	$where_billtype = "HAVING due > 0 AND work = 'engineering'";
	$filter_header = ", Engineering Dues";
}
elseif( $billtype == "automobile_dues"){
	$where_billtype = "HAVING due > 0 AND work = 'automobile'";
	$filter_header = ", Automobile Dues";
}
elseif( $billtype == "intercompany_dues"){
	$where_billtype = "HAVING due > 0 AND work = 'intercompany'";
	$filter_header = ", Intercompany Dues";
}
elseif( $billtype == "all_received"){
	$where_billtype = "HAVING received > 0";
	$filter_header = ", All Received Bills";
}
elseif( $billtype == "engineering_received"){
	$where_billtype = "HAVING received > 0 AND work = 'engineering'";
	$filter_header = ", Engineering Received Bills";
}
elseif( $billtype == "automobile_received"){
	$where_billtype = "HAVING received > 0 AND work = 'automobile'";
	$filter_header = ", Automobile Received Bills";
}
elseif( $billtype == "intercompany_received"){
	$where_billtype = "HAVING received > 0 AND work = 'intercompany'";
	$filter_header = ", Intercompany Received Bills";
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
                    <li class="breadcrumb-item active" aria-current="page">Main Bill</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">Main Bill Report [From Date: {{date('d-M-Y',strtotime($from_dt))}} To: {{date('d-M-Y',strtotime($to_dt))}}] <?php echo $filter_header;?></h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table id="example3" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Date</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Customer</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Reg.No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Chas.No</th>					
							<th scope="col" style="border: 1px solid black;text-align: center;">Vehicle</th>					
							<th scope="col" style="border: 1px solid black;text-align: center;">Mobile</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job No</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Service</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Parts</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Total</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Vat</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Bill</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Card Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">MFS Charge</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">AIT</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">VAT Wave</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Received</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Due Ref</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Payment Status</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Work Type</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Bill Created By</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Engineer</th>

						</tr>
					</thead>
					<tbody>
<?php

$user_list = array();
	$users_db = DB::select("
	SELECT user_id, user_name FROM `user`");
	foreach($users_db as $user_db)
		{ 					
				$user_list[$user_db->user_id] = $user_db->user_name;	
		}  

$result = DB::select("

SELECT `job_dt`,`bill_no`, a.customer_id, MIN(a.work) work, b.customer_nm, b.customer_mobile, a.`job_no`, 
a.`user_id`, a.`net_bill` ,customer_reg,customer_chas,customer_vehicle, total, parts, service,a.bill_dt,
sum(c.`received`) received, sum(c.`bonus`) bonus, sum(c.`vat_wav`) vat_wav, sum(c.`ait`) ait,sum(c.`due`) due,
sum(c.`charge`) charge, sum(c.`supplier_adj`) supplier_adj, sum(supplier_name) supplier_name, engineer, MIN(c.pay_type) pay_type 
FROM `bill_mas` a, customer_info b, `pay` c
WHERE a.`bill_dt` between '$from_dt' and '$to_dt'
and a.customer_id = b.customer_id
AND a.`job_no` = c.job_no
and a.bill_dt is not null 
 
group by `job_dt`,`bill_no`, a.customer_id, b.customer_nm, b.customer_mobile, a.`job_no`, 
a.`user_id`, a.`net_bill` ,customer_reg,customer_chas,customer_vehicle, total, parts, service,a.bill_dt, engineer $where_billtype
;
");
	$sl = '1'; 	$total02 = '0'; $total03 = '0';
foreach($result as $item)
		{		$total01 = '0';
				$net_bill = $item->net_bill; $vat= (int)$net_bill*.1;
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">{{date('d-m-Y',strtotime($item->bill_dt))}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_nm}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_reg}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_chas}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_vehicle}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->customer_mobile}}</td>
						<td style="border: 1px solid black;text-align: center;"><a href="report02?bill={{$item->bill_no}}">{{$item->bill_no}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->service}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->parts}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->net_bill}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$vat}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->total), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type === 'card' ? number_format(($item->charge), 2, '.', ',') : '0.00'}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->pay_type === 'bkash' ? number_format(($item->charge), 2, '.', ',') : '0.00'}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->ait), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->vat_wav), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->received), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->bonus), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->due), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">
<?php
if((number_format(($item->total-($item->received+$item->bonus+$item->vat_wav+$item->ait+$item->charge+$item->supplier_adj)), 2, '.', ','))!='0')
{
    $result01 = DB::select("
    SELECT `ref` FROM `pay` WHERE `job_no` = '$item->job_no' AND pay_type<>'sys' GROUP by ref
    ");
    foreach($result01 as $item01)
		{  
		    if($item01->ref!='Advance')
		    {
		    echo $item01->ref;
		    }
		}
}		
?>						    
						</td>
						<td style="border: 1px solid black;text-align: center;">
<?php if(($item->due)>'0')
{
	echo 'DUE';
	
	

		$pay_type='';
		$stock02 = DB::select("
		SELECT `job_no` pay_type,received FROM `cheque_pending` WHERE `job_no`='$item->job_no' AND `flag`='0'
		");
		foreach($stock02 as $item02){  $received = $item02->received; echo ' CIH['.number_format(($received), 0, '.', ',').'] ';}
		
		
		$pay_type='';
		$stock02 = DB::select("
		SELECT `job_no` pay_type, `denyImage` FROM `cheque_pending` WHERE `job_no`='$item->job_no' AND `flag`='2'
		");
		foreach($stock02 as $item02){$pay_type = $item02->pay_type;$denyImage = $item02->denyImage;}
		if($pay_type!=''){$imageUrl = asset('upload/deny/'.$denyImage); ?>
		
		<a href="{{ $imageUrl }}" target="_blank">[Deny]</a>
		
		
		<?php } 

	
	
	
}
else { 
if($item->supplier_adj!='')
{
$supplier_name = $item->supplier_name;	
$supplier_name01='';	   
$stock03 = DB::select("SELECT `supplier_name` FROM `suppliers` WHERE `supplier_id` = '$supplier_name';");
foreach($stock03 as $item03)
	{ 					
		$supplier_name01 = $item03->supplier_name;						
	}	
echo 'Adjusted With Supplier ['.$supplier_name01.']'; 
}

if($item->supplier_adj=='')
{
echo 'Received'; 
}
    $complementary_work = '';
	$stock01 = DB::select("
	SELECT sum(complementary_work) complementary_work
	FROM `pay` WHERE `job_no`='$item->job_no';");
	foreach($stock01 as $item01)
		{ 					
				$complementary_work = $item01->complementary_work;	
		}  
	if($complementary_work!='')
	{
	    echo ' with Adjustment';
	}

}
	?>						
						</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->work}}</td>
						<td style="border: 1px solid black;text-align: center;">{{@$user_list[$item->user_id]}}</td>
						<td style="border: 1px solid black;text-align: center;">{{$item->engineer}}</td>
					</tr>
		<?php
		$sl = $sl+1;
		$total01 = $item->total;
		$total02 = $total01+$total02;
		$total03 = $total03+$item->net_bill;

		}  
?>
						<!---tr>
							<td colspan="7"><strong>Total Draft Amount: Tk.</strong></td>
							<td>{{$total02}}</td>
						</tr--->
						
					</tbody>
				</table>
				
<strong>Total Amount: Tk. {{number_format(($total03), 2, '.', ',')}}	</strong><br>
<strong>Total Amount (10% vat): Tk. {{number_format(($total02), 2, '.', ',')}}	</strong>
			
<?php if ((session('role')=="Accounts")||(session('role')=="Super Administrator")
	||(session('role')=="Administrator")){
?>
				
				<table class="table table-bordered mb-0"style="width: 700px;">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">#</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sales Segment</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Job Qty</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Service</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Parts</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sale Amount</th>
						
							<th scope="col" style="border: 1px solid black;text-align: center;">Sale Return</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sale Discount</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Re-work</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Damage to Work</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Complementary</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Net Sales</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Sales Ratio</th>

						</tr>
					</thead>
					<tbody>				
<?php

$data = DB::select("SELECT sum(sale_amount) sale_amount,sum(sales_return) sales_return,sum(bonus) bonus,
sum(rework) rework,sum(damage_work) damage_work,sum(complementary_work) complementary_work,
sum(advance_refund) advance_refund
from
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(`service`) service, sum(`parts`) parts, sum(a.`net_bill`) sale_amount,COUNT(a.`job_no`)job_no 
FROM `bill_mas` a WHERE a.`bill_dt` BETWEEN '$from_dt' and '$to_dt' GROUP by work) a
left JOIN
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(b.sales_return)sales_return, SUM(b.bonus) bonus, SUM(b.rework) rework, sum(b.damage_work)damage_work, 
SUM(b.complementary_work)complementary_work,SUM(b.advance_refund)advance_refund 
FROM `bill_mas` a, ( SELECT DISTINCT bill, sum(sales_return)sales_return, SUM(bonus) bonus, 
SUM(rework) rework, sum(damage_work)damage_work, SUM(complementary_work)complementary_work,
SUM(advance_refund)advance_refund from pay where dt BETWEEN '$from_dt' and '$to_dt' 
GROUP by bill )b WHERE a.bill_no=b.bill GROUP by work) b
on a.sales_segment = b.sales_segment
UNION
SELECT sum(sale_amount) sale_amount,sum(sales_return) sales_return,sum(bonus) bonus,
sum(rework) rework,sum(damage_work) damage_work,sum(complementary_work) complementary_work,
sum(advance_refund) advance_refund
from
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(`service`) service, sum(`parts`) parts, sum(a.`net_bill`) sale_amount,COUNT(a.`job_no`)job_no 
FROM `bill_mas` a WHERE a.`bill_dt` BETWEEN '$from_dt' and '$to_dt' GROUP by work) a
right JOIN
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(b.sales_return)sales_return, SUM(b.bonus) bonus, SUM(b.rework) rework, sum(b.damage_work)damage_work, 
SUM(b.complementary_work)complementary_work,SUM(b.advance_refund)advance_refund 
FROM `bill_mas` a, ( SELECT DISTINCT bill, sum(sales_return)sales_return, SUM(bonus) bonus, 
SUM(rework) rework, sum(damage_work)damage_work, SUM(complementary_work)complementary_work,
SUM(advance_refund)advance_refund from pay where dt BETWEEN '$from_dt' and '$to_dt' GROUP by bill )b 
WHERE a.bill_no=b.bill GROUP by work) b
on a.sales_segment = b.sales_segment;");
$totalAmount = '0';
foreach($data as $item){ 
$totalAmount = $item->sale_amount-($item->sales_return+$item->bonus+$item->rework+$item->damage_work+$item->complementary_work+$item->advance_refund) ;
}




$result = DB::select("
SELECT a.sales_segment,service,parts,sale_amount,job_no,
sales_return,bonus,rework,damage_work,complementary_work,advance_refund
from
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(`service`) service, sum(`parts`) parts, sum(a.`net_bill`) sale_amount,COUNT(a.`job_no`)job_no 
FROM `bill_mas` a WHERE a.`bill_dt` BETWEEN '$from_dt' and '$to_dt' and a.`flag` <> '0' GROUP by work) a
left JOIN
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(b.sales_return)sales_return, SUM(b.bonus) bonus, SUM(b.rework) rework, sum(b.damage_work)damage_work, 
SUM(b.complementary_work)complementary_work,SUM(b.advance_refund)advance_refund 
FROM `bill_mas` a, ( SELECT DISTINCT bill, sum(sales_return)sales_return, SUM(bonus) bonus, 
SUM(rework) rework, sum(damage_work)damage_work, SUM(complementary_work)complementary_work,
SUM(advance_refund)advance_refund from pay where dt BETWEEN '$from_dt' and '$to_dt' 
GROUP by bill )b WHERE a.bill_no=b.bill GROUP by work) b
on a.sales_segment = b.sales_segment
UNION
SELECT b.sales_segment,service,parts,sale_amount,job_no,
sales_return,bonus,rework,damage_work,complementary_work,advance_refund
from
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(`service`) service, sum(`parts`) parts, sum(a.`net_bill`) sale_amount,COUNT(a.`job_no`)job_no 
FROM `bill_mas` a WHERE a.`bill_dt` BETWEEN '$from_dt' and '$to_dt' and a.`flag` <> '0' GROUP by work) a
right JOIN
(SELECT CASE WHEN work='engineering' THEN 'Engineering' 
WHEN work='intercompany' THEN 'Inter-Company' 
WHEN work='automobile' THEN 'Automobiles' END as `sales_segment`, 
sum(b.sales_return)sales_return, SUM(b.bonus) bonus, SUM(b.rework) rework, sum(b.damage_work)damage_work, 
SUM(b.complementary_work)complementary_work,SUM(b.advance_refund)advance_refund 
FROM `bill_mas` a, ( SELECT DISTINCT bill, sum(sales_return)sales_return, SUM(bonus) bonus, 
SUM(rework) rework, sum(damage_work)damage_work, SUM(complementary_work)complementary_work,
SUM(advance_refund)advance_refund from pay where dt BETWEEN '$from_dt' and '$to_dt' GROUP by bill )b 
WHERE a.bill_no=b.bill GROUP by work) b
on a.sales_segment = b.sales_segment;
");
	$sl = '1';$service = '0';$parts = '0';$sale_amount = '0';$job_no = '0';		
	$sales_return = '0';$bonus = '0';$rework = '0';$damage_work = '0';
	$complementary_work = '0';$advance_refund = '0';$Net_Sales = '0';
foreach($result as $item)
		{	
			if($item->sales_segment!='')
			{
?>					<tr>
						<th scope="row" style="border: 1px solid black;text-align: center;">{{$sl}}</th>
						<td style="border: 1px solid black;text-align: center;">
						<a href='report031?segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{$item->sales_segment}}</a></td>
						<td style="border: 1px solid black;text-align: center;">{{$item->job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->service), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->parts), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($item->sale_amount), 2, '.', ',');}}</td>

						<td style="border: 1px solid black;text-align: center;">
						<a href='report032?adjust=return&&segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{number_format(($item->sales_return), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href='report032?adjust=discount&&segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{number_format(($item->bonus), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href='report032?adjust=rework&&segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{number_format(($item->rework), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href='report032?adjust=damage&&segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{number_format(($item->damage_work), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">
						<a href='report032?adjust=comple&&segment={{$item->sales_segment}}&&from_dt={{$from_dt}}&&to_dt={{$to_dt}}'>{{number_format(($item->complementary_work), 2, '.', ',');}}</td>
						<td style="border: 1px solid black;text-align: center;">
						{{number_format((
		$item->sale_amount-($item->sales_return+$item->bonus+$item->rework+$item->damage_work+$item->complementary_work+$item->advance_refund)
						), 2, '.', ',');}}</td>
<?php if($totalAmount!=''){?>
						<td style="border: 1px solid black;text-align: center;">
						{{
		round((($item->sale_amount-($item->sales_return+$item->bonus+$item->rework+$item->damage_work+$item->complementary_work+$item->advance_refund))/$totalAmount)*100,2)
						;}}%</td>
<?php } ?>
						

					</tr>
		<?php
			}
		$sl = $sl+1;
		$service = $item->service+$service;
		$parts = $item->parts+$parts;
		$sale_amount = $item->sale_amount+$sale_amount;
		$job_no = $item->job_no+$job_no;
		
		$sales_return = $item->sales_return+$sales_return;
		$bonus = $item->bonus+$bonus;
		$rework = $item->rework+$rework;
		$damage_work = $item->damage_work+$damage_work;
		$complementary_work = $item->complementary_work+$complementary_work;
		$advance_refund = $item->advance_refund+$advance_refund;

		$Net_Sales = $item->sale_amount-($item->sales_return+$item->bonus+$item->rework+$item->damage_work+$item->complementary_work+$item->advance_refund)+$Net_Sales;
		
		}  
?>
					<tr>
						<td style="border: 1px solid black;text-align: center;"></td>
						<td style="border: 1px solid black;text-align: center;">Total:</td>
						<td style="border: 1px solid black;text-align: center;">{{$job_no}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($service), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($parts), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($sale_amount), 2, '.', ',')}}</td>
					
						<td style="border: 1px solid black;text-align: center;">{{number_format(($sales_return), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($bonus), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($rework), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($damage_work), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($complementary_work), 2, '.', ',')}}</td>
						<td style="border: 1px solid black;text-align: center;">{{number_format(($Net_Sales), 2, '.', ',')}}</td>
					
					</tr>
					</tbody>
				</table>
<?php } ?>				
<br><br><br>				
				
				
				
				
				
				
				
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