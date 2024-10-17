
<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@extends("layouts.master")

@section("content")


<?php

$myF_date = request()->get('f_date');
$myT_date = request()->get('t_date');
$myOption = request()->get('option');



if (isset($myF_date )) 
{ 

		$From_Date = $myF_date ; 

		$To_Date = $myT_date ; 

		$Option = $myOption;  

	

		DB::table('tbl_rep_rec_pay')->delete();

		$dt_opening = DB::select("SELECT
			'Opening' as op,
			'Opening' as rmk,
			tbl_acc_details.ahead as head,
			Sum(tbl_acc_details.debit-tbl_acc_details.credit) as amt
			FROM tbl_acc_masters
			INNER JOIN tbl_acc_details
			ON tbl_acc_masters.acc_name = tbl_acc_details.ahead
			WHERE (tbl_acc_masters.type_id = '6' or tbl_acc_masters.type_id = '7') and ( tbl_acc_details.tdate < '$From_Date')
			GROUP BY tbl_acc_details.ahead");

			foreach($dt_opening as $data){DB::table('tbl_rep_rec_pay')->insert(['t_type'=>$data->op, 'acc_head'=>$data->head,'remarks'=>$data->rmk,'amount'=>$data->amt]);}

		DB::table('tbl_rep_rec_pay_ref')->delete();
		$dt_insert_debit_ref = DB::select("SELECT DISTINCT 
			tbl_acc_details.ref as ref
			FROM tbl_acc_masters
			INNER JOIN tbl_acc_details
			ON tbl_acc_masters.acc_name = tbl_acc_details.ahead
			WHERE (tbl_acc_masters.type_id = '6' or tbl_acc_masters.type_id = '7') and ( tbl_acc_details.tdate 	BETWEEN '$From_Date' and '$To_Date') and (tbl_acc_details.debit > 0)
			");

			foreach($dt_insert_debit_ref as $data){DB::table('tbl_rep_rec_pay_ref')->insert(['ref'=>$data->ref]);}

		$dt_receipt = DB::select("SELECT
			tbl_rep_rec_pay_ref.ref,
			tbl_acc_details.ahead as head,
			SUM(tbl_acc_details.credit) AS amt
			FROM tbl_rep_rec_pay_ref
			INNER JOIN tbl_acc_details
			ON tbl_rep_rec_pay_ref.ref = tbl_acc_details.ref
			WHERE tbl_acc_details.credit > 0
			GROUP BY tbl_rep_rec_pay_ref.ref,
			tbl_acc_details.ahead");

			foreach($dt_receipt as $data){DB::table('tbl_rep_rec_pay')->insert(['t_type'=>'Receipt', 'acc_head'=>$data->head, 'remarks'=>$data->ref,'amount'=>$data->amt]);}
		
		DB::table('tbl_rep_rec_pay_ref')->delete();
		$dt_insert_credit_ref = DB::select("SELECT DISTINCT 
			tbl_acc_details.ref as ref
			FROM tbl_acc_masters
			INNER JOIN tbl_acc_details
			ON tbl_acc_masters.acc_name = tbl_acc_details.ahead
			WHERE (tbl_acc_masters.type_id = '6' or tbl_acc_masters.type_id = '7') and ( tbl_acc_details.tdate 	BETWEEN '$From_Date' and '$To_Date') and (tbl_acc_details.credit > 0)
			");

			foreach($dt_insert_credit_ref as $data){DB::table('tbl_rep_rec_pay_ref')->insert(['ref'=>$data->ref]);}
		
		$dt_payment = DB::select("SELECT
			tbl_rep_rec_pay_ref.ref,
			tbl_acc_details.ahead as head,
			SUM(-tbl_acc_details.debit) AS amt
			FROM tbl_rep_rec_pay_ref
			INNER JOIN tbl_acc_details
			ON tbl_rep_rec_pay_ref.ref = tbl_acc_details.ref
			WHERE tbl_acc_details.debit > 0
			GROUP BY tbl_rep_rec_pay_ref.ref,
			tbl_acc_details.ahead");

			foreach($dt_payment as $data){DB::table('tbl_rep_rec_pay')->insert(['t_type'=>'Payment', 'acc_head'=>$data->head, 'remarks'=>$data->ref,'amount'=>$data->amt]);}
		
	
		$dt_closing = DB::select("SELECT
			'Closing' as cl,
			'Closing' as rmk,
			tbl_acc_details.ahead as head,
			Sum(tbl_acc_details.debit-tbl_acc_details.credit) as amt
			FROM tbl_acc_masters
			INNER JOIN tbl_acc_details
			ON tbl_acc_masters.acc_name = tbl_acc_details.ahead
			WHERE (tbl_acc_masters.type_id = '6' or tbl_acc_masters.type_id = '7') and ( tbl_acc_details.tdate <= '$To_Date')
			GROUP BY tbl_acc_details.ahead");

			foreach($dt_closing as $data){DB::table('tbl_rep_rec_pay')->insert(['t_type'=>$data->cl, 'acc_head'=>$data->head,'remarks'=>$data->rmk,'amount'=>$data->amt]);}

		$dt_Report_RecPay = DB::select("SELECT `t_type`,`acc_head`,`remarks`,`amount` FROM `tbl_rep_rec_pay`");




		$rep_data_total = DB::select("SELECT sum(opening) as opening, sum(debit) as debit, sum(credit) as credit from tbl_rep_trial_bal ");
		
		$rep_data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();



} 

$data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();

?>





<main class="page-content">
			
	<div class="card"  style="padding:5px;" >
		<table id ="myTable_01" >
			<tbody>

				<tr >
					<td>
						<button class="btn btn-outline-dark" name="print" id="print" onClick="printdiv('printable_div_id');">   Print  </button> 
						<button  class="btn btn-outline-dark" name="btnExport" id="btnExport" onClick="exportTableToExcel('example4'); return false;">  Excel  </button> 
						<button  class="btn btn-outline-dark" name="btnCopy" id="btnCopy">  Copy </button>
					</td>
					<td width="30%">
						<div class="input-group rounded">
							<input onkeyup='searchSname()' id="mySearch" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	
	</div>


	<div id='printable_div_id' class="card"  style="padding:20px">  <!-- Printing Area Start -->
		
		
	@php $Opening = 0; 	@endphp
	@php $Receipt = 0; 	@endphp
	@php $Payment = 0; 	@endphp
	@php $Closing = 0; 	@endphp

	<table id="example4" class="table caption-top" >

		@if(isset( $rep_data_ComInfo))
			  <caption style="text-align:center"> <font size="4"> <b>{{$rep_data_ComInfo[0]->com_name}} </b> </font> <br> Receipt & Payment A/C <br> ( Period from {{date('d-m-Y', strtotime($From_Date))}} and {{date('d-m-Y', strtotime($To_Date))}} )</caption>
		@endif


		<tbody id="myBody">

		
			<tr>

				<td>

					<table class="table table-sm">
						<thead class="table-light">

							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>

							<tr>
								<th>Accounts Head</th>
								<th>Referance</th>
								<th style="text-align:right">Receipt</th>
							</tr>

						</thead>

						@if(isset( 	$dt_Report_RecPay  ))

							<!-- Opening -->
							@foreach( $dt_Report_RecPay  as $item)
								@if($item->t_type == 'Opening')
								<tr>
									<td>{{$item->acc_head}}</td>
									<td>{{$item->remarks}}</td>
									<td style="text-align:right"><?php  echo number_format($item->amount) ?></td>
								</tr>
								<?php $Opening += $item->amount ?>
								@endif
							@endforeach 
								<tr>
									<td style="font-weight:bold">A.</td>
									<td style="font-weight:bold">Total Opening</td>
									<td style="text-align:right;font-weight:bold;"><?php  echo number_format($Opening) ?></td>
								</tr>
						@endif

								
						@if(isset( 	$dt_Report_RecPay  ))

						<!-- Receipt-->
						@foreach( $dt_Report_RecPay  as $item)
							@if($item->t_type == 'Receipt')
							<tr>
								<td>{{$item->acc_head}}</td>
								<td>{{$item->remarks}}</td>
								<td style="text-align:right"><?php  echo number_format($item->amount) ?></td>
							</tr>
							<?php $Receipt += $item->amount ?>
							@endif
						@endforeach 
							<tr>
								<td style="font-weight:bold">B.</td>
								<td style="font-weight:bold">Total Receipt</td>
								<td style="text-align:right;font-weight:bold;"><?php  echo number_format($Receipt) ?></td>
							</tr>
						@endif

					</table>
					
				</td>

				<td>

					<table class="table table-sm">
							<thead class="table-light">
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>Accounts Head</th>
									<th>Referance</th>
									<th style="text-align:right">Payment</th>
								</tr>

							</thead>

							@if(isset( 	$dt_Report_RecPay  ))

							<!-- Payment-->
							@foreach( $dt_Report_RecPay  as $item)
								@if($item->t_type == 'Payment')
								<tr>
									<td>{{$item->acc_head}}</td>
									<td>{{$item->remarks}}</td>
									<td style="text-align:right"><?php  echo number_format(abs($item->amount)) ?></td>
								</tr>
								<?php $Payment += $item->amount ?>
								@endif
							@endforeach 
								<tr>
									<td style="font-weight:bold">C.</td>
									<td style="font-weight:bold">Total Payment</td>
									<td style="text-align:right;font-weight:bold;"><?php  echo number_format(abs($Payment)) ?></td>
								</tr>
							@endif

							@if(isset( 	$dt_Report_RecPay  ))

							<!-- Closing-->
							@foreach( $dt_Report_RecPay  as $item)
								@if($item->t_type == 'Closing')
								<tr>
									<td>{{$item->acc_head}}</td>
									<td>{{$item->remarks}}</td>
									<td style="text-align:right"><?php  echo number_format($item->amount) ?></td>
								</tr>
								<?php $Closing += $item->amount ?>
								@endif
							@endforeach 
								<tr>
									<td style="font-weight:bold">D = A+B-C</td>
									<td style="font-weight:bold">Total Closing</td>
									<td style="text-align:right;font-weight:bold;"><?php  echo number_format($Closing) ?></td>
								</tr>
							@endif
							

						
					</table>
						
				</td>


			</tr>
		</tbody>
	
	</table>
		
		
	</div>


	@if(isset($data_ComInfo))

	

	<div> <input hidden type="text"  id="op_date" name="op_date" value ="{{$data_ComInfo[0]->fy_opening}}"></div>
	<div> <input hidden type="text"  id="cl_date" name="cl_date" value ="{{$data_ComInfo[0]->fy_closing}}"></div>

	<div> <input hidden type="text"  id="op_date_m" name="op_date_m" value =<?php $query_date = date('Y-m-d'); echo date('Y-m-01', strtotime($query_date)); ?>></div>
	<div> <input hidden type="text"  id="cl_date_m" name="cl_date_m" value =<?php $query_date = date('Y-m-d'); echo date('Y-m-t', strtotime($query_date)); ?>></div>

	<div> <input hidden type="text"  id="op_date_pm" name="op_date_pm" value = <?php $first_date = date('Y-m-d', strtotime('first day of previous month')); echo $first_date; ?>></div>
	<div> <input hidden type="text"  id="cl_date_pm" name="cl_date_pm" value =<?php $last_date  = date('Y-m-d', strtotime('last day of previous month')); echo $last_date; ?>></div>

	


	
	<script>

		document.getElementById('date_range').addEventListener('change', function() {
        
		//alert(this.value);

		if (this.value == "Yearly"){
		document.getElementById("f_date").value =  document.getElementById("op_date").value;
		document.getElementById("t_date").value =  document.getElementById("cl_date").value;
			
		}

		if (this.value == "Current Month"){

			document.getElementById("f_date").value =  document.getElementById("op_date_m").value;
			document.getElementById("t_date").value =  document.getElementById("cl_date_m").value;
			
		}

		if (this.value == "Previous Month"){

			document.getElementById("f_date").value =  document.getElementById("op_date_pm").value;
			document.getElementById("t_date").value =  document.getElementById("cl_date_pm").value;
			
		}



        });

		

		

	</script>

	@endif






</main>





		  
@endsection		 


@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <!-- <script src="assets/js/table-datatable.js"></script> -->
  
<script>

	
function printdiv(elem) {
  var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
  var footer_str = '</body></html>';
  var new_str = document.getElementById(elem).innerHTML;
  var old_str = document.body.innerHTML;
  document.body.innerHTML = header_str + new_str + footer_str;
  window.print();
  document.body.innerHTML = old_str;
  return false;
}



function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }

}

</script>

<script>
    $(document).ready(function() {
        $("#btnCopy").on("click",
            function(e) {
                copyTable("example4", e);
            });

    });

    function copyTable(el, e) {
        e.preventDefault();
        var table = document.getElementById(el);
        
        if (navigator.clipboard) {
            var text = table.innerText.trim();
            navigator.clipboard.writeText(text).catch(function () { });
        }
    }



	function searchSname() {
		var input, filter, found, table, tr, td, i, j;
		input = document.getElementById("mySearch");
		filter = input.value.toUpperCase();
		table = document.getElementById("myBody");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td");
			for (j = 0; j < td.length; j++) {
				if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
					found = true;
				}
			}
			if (found) {
				tr[i].style.display = "";
				found = false;
			} else {
				tr[i].style.display = "none";
			}
		}
	}

	

</script>


 @endsection

