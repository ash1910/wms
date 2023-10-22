<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")
	||(session('role')=="Store")||(session('role')=="Administrator"))
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

<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message----> 
@if(session()->has('alert'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <div class="alert alert-success">
        {{ session()->get('alert') }}
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

 <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                    <li class="breadcrumb-item active" aria-current="page">Reports </li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase </li>
					<li class="breadcrumb-item active" aria-current="page">
					<form  target="_blank" style="display: inline;" action="printPurchase" method="post">{{ csrf_field() }}
					<input type="hidden" name="dt01" value="{{$dt01}}">
					<input type="hidden" name="dt02" value="{{$dt02}}">
					<button class="btn btn-sm btn-success me-2" type="submit" name="" value="">
					<i class="fadeIn animated bx bx-printer"></i> Print</button>
					</form></li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-12">
                      <h5 class="mb-0">Purchase Report without Supplier [From Date: {{date('d-M-Y', strtotime($dt01))}} to {{date('d-M-Y', strtotime($dt02))}}]</h5>
                   
					</div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				
<?php

$t_amount01= '0';$line = '1';	
foreach($inHistory as $item02)
{	
		$supplier_id = $item02->supplier_id;	
		$inHistory01 = DB::table('purchase_mas')
			->distinct()->whereBetween('purchase_dt', [$dt01, $dt02])
			->where('supplier_id', $supplier_id)->orderBy('purchase_id', 'asc')
			->get(['purchase_id','supplier_id','supplier_ref','purchase_dt','flag']);

	$supplier = DB::select("SELECT `supplier_id`, `supplier_name` FROM `suppliers` WHERE `supplier_id`=$supplier_id;");
	foreach($supplier as $item)
	{ 	
		$supplier_id = $item->supplier_id;$supplier_name = $item->supplier_name;
	}
?>
<strong> Supplier: [{{$supplier_id}}] {{$supplier_name}}</strong><br>		
<?php
$t_amount = '0';			
foreach($inHistory01 as $item01)
		{	$purchase_id = $item01->purchase_id;
			$purchase_dt = $item01->purchase_dt;
			$supplier_id = $item01->supplier_id;	
			$supplier_ref = $item01->supplier_ref;	
			$flag = $item01->flag;	
?>		
<strong> Supplier's Bill No. : 
<?php if($flag!='1'){?>
<a href="/purchase04?id={{$purchase_id}}&&dt01={{$dt01}}&&dt02={{$dt02}}"><?php } ?>{{$supplier_ref}}</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Entry No: 
<?php if($flag!='1'){?><a href="/purchase02?id={{$purchase_id}}"><?php } ?>PCH-{{$purchase_id}}</a>	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Date: {{date('d-M-Y', strtotime($purchase_dt))}}</strong>		
			<table  style="font-size: small;" class="table table-bordered mb-0">
				<thead>
					<tr>
						<th style="text-align: center;background-color: darkgray;" scope="col">#</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Code</th>
						<th style="text-align: center;width: 350px;background-color: darkgray;" scope="col">Product</th>
						<th style="text-align: center;background-color: darkgray;" style="text-align: center;" scope="col">GRN</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Job No.</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Req. No.</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Qty</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Buy (Per Unit)</th>
						<th style="text-align: center;background-color: darkgray;" scope="col">Total</th>
					</tr>
				</thead>
				<tbody style="font-size: 12px;">
<?php
$inHistory01 = DB::table('purchase_det')
		->join('bom_prod', 'bom_prod.parts_id', '=', 'purchase_det.prod_id')
		->where('purchase_id',$purchase_id)
		->orderBy('purchase_id', 'asc')->get();
$sl = '1'; $amount='0';
foreach($inHistory01 as $item)
		{ 	$buy = '';				
?>					
			<tr>
				<th style="text-align: center;" scope="row">{{$sl}}</th>
				<td style="text-align: center;">{{$item->prod_id}}</td>
				<td style="text-align: left;">{{$item->prod_name}}</td>
				<td style="text-align: center;"><a href="/purchase05?id={{$item->id}}&&dt01={{$dt01}}&&dt02={{$dt02}}">{{$item->grn}}</a></td>
				<td style="text-align: center;">{{$item->job_no}}</td>
				<td style="text-align: center;">{{$item->req}}</td>
				<td style="text-align: center;">{{$item->qty}}</td>
				<td style="text-align: center;">{{$item->rate}}</td>
				<td style="text-align: right;">{{$item->qty*$item->rate}}</td>
			</tr>
<?php
			
			
			$line = $line+1;
			$sl = $sl+1;
			$amount = $amount+($item->qty*$item->rate);
		}  
?>
					<tr><td style="background-color: darkgray;"></td>
						<td style="background-color: darkgray;" colspan="5"><strong>Total Purchase from {{$supplier_name}}	</strong></td>
						<td style="text-align: right;background-color: darkgray;" colspan="4"><strong>TK. {{number_format(($amount), 2, '.', ',')}}</strong></td>
					</tr>



					
					<!--tr>
						<td colspan="3"><strong>Total Amount: Tk.</strong></td>
					</tr-->
				</tbody>
			</table>
				
				
<?php $t_amount = $amount+$t_amount; 
		}$t_amount01 = $t_amount01+$t_amount;
?>
<center>				
	<b>Total Purchase from {{$supplier_name}} : Tk.	{{number_format(($t_amount), 2, '.', ',')}}</b>
</center>				


<?php		
	}?>				
							
				
				
<center>				
	<h3>Total Purchase Amount: Tk.	{{number_format(($t_amount01), 2, '.', ',')}}</h3>
</center>
				
			
				
				
				
				
				
				
				
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