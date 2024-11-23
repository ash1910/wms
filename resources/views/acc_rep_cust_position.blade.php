
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


    DB::table('tbl_rep_cust_position')->delete();


   
    $dt_insert_opening = DB::select("SELECT tbl_acc_details.others_id as id, customer_info.customer_nm as cname, sum(tbl_acc_details.debit-tbl_acc_details.credit) as opening, 0 as debit, 0 as credit 
                                    FROM tbl_acc_details 
                                    INNER JOIN customer_info ON tbl_acc_details.others_id = customer_info.customer_id
                                    WHERE (tbl_acc_details.ahead='$Option') And (tbl_acc_details.tdate < '$From_Date')
                                    GROUP BY tbl_acc_details.others_id, customer_info.customer_nm;");

   
 

    foreach($dt_insert_opening as $data){DB::table('tbl_rep_cust_position')->insert(['cust_id'=>$data->id, 'cust_name'=>$data->cname,'opening'=>$data->opening,'debit'=>$data->debit, 'credit'=>$data->credit]);}



    $dt_insert_debit = DB::select("SELECT tbl_acc_details.others_id as id, customer_info.customer_nm as cname, 0 as opening, sum(tbl_acc_details.debit) as debit, sum(tbl_acc_details.credit) as credit 
                                    FROM tbl_acc_details 
                                    INNER JOIN customer_info ON tbl_acc_details.others_id = customer_info.customer_id
                                    WHERE (tbl_acc_details.ahead='$Option') And (tbl_acc_details.tdate BETWEEN '$From_Date' AND '$To_Date')
                                    GROUP BY tbl_acc_details.others_id, customer_info.customer_nm;");

   

    foreach($dt_insert_debit as $data){DB::table('tbl_rep_cust_position')->insert(['cust_id'=>$data->id, 'cust_name'=>$data->cname,'opening'=>$data->opening,'debit'=>$data->debit, 'credit'=>$data->credit]);}






 }


 DB::table('tbl_rep_cust_position')->where('opening', 0)->where('debit',  0)->where('credit', 0)->delete();


 $dt_Report_CustPos = DB::select("SELECT cust_id, cust_name, SUM(opening) AS opening, SUM(debit) As debit, Sum(credit) As credit FROM `tbl_rep_cust_position`
 									 GROUP BY `cust_id`,`cust_name`
									 having (sum(`opening`)+sum(`debit`)-SUM(`credit`)) > 0 ORDER By cast(`cust_id` as unsigned);");
  

 $rep_data_total = DB::select("SELECT SUM(`opening`) AS opening, SUM(`debit`) As debit, Sum(`credit`) As credit FROM `tbl_rep_cust_position`;");

 $rep_data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();


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
		
		
	<table id="example4" class="table caption-top">


	@if(isset( $rep_data_ComInfo))
		<caption style="text-align:center"> <font size="4"> <b>{{$rep_data_ComInfo[0]->com_name}}</b> </font> <br> <font size="3">Customer Position- {{$myOption}} </font><br>( Period from {{date('d-m-Y', strtotime($From_Date))}} and {{date('d-m-Y', strtotime($To_Date))}} )</caption>
	@endif


	<thead style="display: table-header-group;" >

		<tr>
			<th>ID</th>
			<th>Customer Name</th>
			<th  style="text-align:right">Opening</th>
			<th style="text-align:right">Debit</th>
			<th style="text-align:right">Credit</th>
			<th style="text-align:right">Closing</th>
			
		</tr>

	</thead>

	<tbody id="myBody">

	  
		@foreach($dt_Report_CustPos as $item)

			<tr >
				<td> <a href = "acc_report_cust_ledger?f_date=<?php echo($From_Date);?>&t_date=<?php echo($To_Date );?>&acc={{$item->cust_id}}"> {{ $item->cust_id }}</td>
				<td> {{ $item->cust_name}}</td>
				<td  style="text-align:right"> <?php  echo number_format($item->opening) ?></td>
				<td  style="text-align:right"> <?php echo number_format($item->debit) ?></td>
				<td  style="text-align:right"> <?php echo number_format($item->credit) ?></td>
				<td  style="text-align:right"> <?php echo number_format($item->opening+$item->debit-$item->credit) ?></td>
			</tr>

			
			

		@endforeach

			<tr>
								
				<td></td>
				<td style="font-weight:bold;">Total:</td>
				@if(isset( $rep_data_total ))
					<td style="text-align:right; font-weight:bold;"> <?php  echo number_format($rep_data_total[0]->opening) ?> </td>
					<td style="text-align:right; font-weight:bold;"> <?php  echo number_format($rep_data_total[0]->debit) ?> </td>
					<td style="text-align:right; font-weight:bold;"> <?php  echo number_format($rep_data_total[0]->credit) ?> </td>
					<td style="text-align:right; font-weight:bold;"> <?php  echo number_format($rep_data_total[0]->opening + $rep_data_total[0]->debit-$rep_data_total[0]->credit) ?> </td>
				@endif

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
