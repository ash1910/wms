

<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />



@extends("layouts.master")

@section("content")


<?php


$myF_date = request()->get('f_date');
//echo ($myF_date);
$myT_date = request()->get('t_date');

$myOption = request()->get('option');


if (isset($myF_date)) 
{ 

 $From_Date = $myF_date; 

 $To_Date = $myT_date; 

 $Option = $myOption; 

 if ($Option=='All Journal'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
								FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' Order by `tdate`, `ref`  ;");
 }

 if ($Option=='Cash Receipt'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Cash Receipt' Order by `tdate`, `ref`;");
 }

 if ($Option=='Bank Receipt'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Bank Receipt' Order by `tdate`, `ref`;");
 }


 if ($Option=='Cash Payment'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Cash Payment' Order by `tdate`, `ref`;");
 }

 if ($Option=='Bank Payment'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Bank Payment' Order by `tdate`, `ref`;");
 }
  
 if ($Option=='Bank Transfer'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Bank Transfer' Order by `tdate`, `ref`;");
 }

 if ($Option=='Cash Deposit'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Cash Deposit' Order by `tdate`, `ref`;");
 }
 
 if ($Option=='Cash Withdrawn'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Cash Withdrawn' Order by `tdate`, `ref`;");
 }
 
 if ($Option=='Journal Voucher'){

	$dt_Report_Journal = DB::select("SELECT`vr_type`,`ref`,`tdate`,`ahead`,`debit`,`credit`,`narration` 
			FROM `tbl_acc_details` WHERE `tdate` BETWEEN '$From_Date'  AND '$To_Date' AND `vr_type` = 'Journal Voucher' Order by `tdate`, `ref`;");
 }
  
  
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


		@php
			$first_ref = "";
			$t_debit = 0;
			$t_credit = 0;
			$remove_ref = 0;

			$gt_debit = 0;
			$gt_credit = 0;

		@endphp


		<table id="example4" class="table caption-top">

				@if(isset( $rep_data_ComInfo))
				 <caption style="text-align:center"> <font size="4"> <b>{{$rep_data_ComInfo[0]->com_name}}</b> </font> <br> <font size="3">Journal Entry - {{$myOption}} </font><br>( Period from {{date('d-m-Y', strtotime($From_Date))}} and {{date('d-m-Y', strtotime($To_Date))}} )</caption>
				@endif

		
				<thead style="display: table-header-group;" >

					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>

	
					<tr>
						<th>Date</th>
						<th>Ref</th>
						<th>Accounts Head</th>
						<th>Narration</th>
						<th style="text-align:right">Debit</th>
						<th style="text-align:right">Credit</th>
						
					</tr>
					
				</thead>

				<tbody id="myBody">
					@if(isset( $dt_Report_Journal ))
						@foreach( $dt_Report_Journal as $item)
							
							@if ($loop->first)
								<?php $first_ref  = $item->ref; ?>
							@endif


							@if ($first_ref  !== $item->ref)

							<tr>
								<td></td>
								<td></td>
								<td style="font-weight:bold;">Sub Total:</td>
								<td ></td>
								<td style="text-align:right; font-weight:bold;"><?php  echo number_format($t_debit) ?></td>
								<td style="text-align:right; font-weight:bold;"><?php  echo number_format($t_credit) ?></td>
								
								
							</tr>
							<?php $first_ref  = $item->ref;?>
							@php $t_debit = 0; $t_credit = 0; $remove_ref = 0; @endphp
							@endif


							@if ($first_ref  == $item->ref)

								@if ($remove_ref == 0)
									<tr>
										<td>{{date('d-m-Y', strtotime($item->tdate))}}</td>
										<td>{{$item->ref}}</td>
										<td>{{$item->ahead}}</td>
										<td>{{$item->narration}}</td>
										<td style="text-align:right"><?php  echo number_format($item->debit) ?></td>
										<td style="text-align:right"><?php  echo number_format($item->credit) ?></td>
										
									</tr>
									@php $remove_ref = 1; @endphp
								@else
									<tr>
											<td></td>
											<td></td>
											<td>{{$item->ahead}}</td>
											<td>{{$item->narration}}</td>
											<td style="text-align:right"><?php  echo number_format($item->debit) ?></td>
											<td style="text-align:right"><?php  echo number_format($item->credit) ?></td>
											
										</tr>

								@endif

								<?php $t_debit  += $item->debit;?>
								<?php $t_credit  += $item->credit;?>
							@endif

							
							@if ($loop->last)
								<tr>
									<td></td>
									<td></td>
									<td style="font-weight:bold;">Sub Total</td>
									<td></td>
									<td style="text-align:right; font-weight:bold;"><?php  echo number_format($t_debit) ?></td>
									<td style="text-align:right; font-weight:bold;"><?php  echo number_format($t_credit) ?></td>
								
									
								</tr>
							@endif

							<?php $gt_debit  += $item->debit;?>
							<?php $gt_credit += $item->credit;?>
							
						@endforeach 
					@endif

					<tr>
						<td></td>
						<td></td>
						<td style="font-weight:bold;">Grand Total</td>
						<td></td>
						<td style="text-align:right; font-weight:bold;"><?php  echo number_format($gt_debit) ?></td>
						<td style="text-align:right; font-weight:bold;"><?php  echo number_format($gt_credit) ?></td>
					
					</tr>
				
				</tbody>

				<tfoot >

					<tr>
						<th> </th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</tfoot>
				

		 </table>
		
		
	</div>                <!-- *********************Printing Area End -->


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

