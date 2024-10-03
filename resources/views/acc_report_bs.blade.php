
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
	
		DB::select("update tbl_acc_masters  set op_bal = 0,  debit = 0, credit = 0");


		DB::select("update tbl_acc_masters as t1
					inner join (SELECT tbl_acc_masters.id As myid, tbl_acc_masters.acc_name As myhead, SUM(tbl_acc_details.debit-tbl_acc_details.credit) AS 					amt
					FROM tbl_acc_masters 
					INNER JOIN tbl_acc_details ON tbl_acc_masters.acc_name = tbl_acc_details.ahead 
					WHERE tbl_acc_masters.type_id < 13 AND tbl_acc_details.ahead <> 'Primary' AND tbl_acc_details.tdate <= '$To_Date' 
					GROUP BY tbl_acc_masters.id, tbl_acc_masters.acc_name) as t2
					set t1.op_bal = t2.amt
					where t1.id = t2.myid;");

	

				
		/// Six Level Total Update

		//---Level-01
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");
		//---Level-02
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");
		//---Level-03
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");
		//---Level-04
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");
		//---Level-05
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");
		//---Level-06
		DB::select("update tbl_acc_masters as t1
		inner join (SELECT `grp_under`as myid, SUM(`op_bal`) as myopbal,  SUM(`debit`) as mydebit, SUM(`credit`) as mycredit FROM tbl_acc_masters GROUP BY `grp_under`) as t2
		set t1.op_bal = t2.myopbal,  t1.debit = t2.mydebit,  t1.credit = t2.mycredit
		where t1.id = t2.myid;");



 	}


	$rep_data_total = DB::select("SELECT sum(op_bal) as opening from tbl_acc_masters where grp_status = 'AH'");
  
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
		
		
		

		<table id="example4" class="table caption-top" >

			@if(isset( $rep_data_ComInfo))
				<caption style="text-align:center"> <font size="4"> <b>{{$rep_data_ComInfo[0]->com_name}}</b> </font> <br> <font size="3">Balance Sheet - {{$myOption}} </font><br>( As on {{date('d-m-Y', strtotime($To_Date))}} )</caption>
			@endif


				<thead class="table-light">

					<tr>
						<th>Particulars</th>
						<th>Code</th>
						<th style="text-align:right">Amount</th>
					</tr>
					
				</thead>
			
			
				  
				<tbody id="myBody">
					
				
					@foreach($categories as $category)

						<tr >
							<td style="font-size: 18px;"> <b>{{ $category->acc_name }}</b></td>
							<td> {{ $category->id}}</td>
							<td  style="text-align:right"> <b><?php  echo number_format($category->op_bal) ?></b></td>
						</tr>

						@if(count($category->childs))			
							@include('acc_manageChild_bs',['childs' => $category->childs])    										
						@endif


					@endforeach

					<tr>
						<td style="font-weight:bold;">(Profit)/Loss</td>
						<td></td>
						@if(isset( $rep_data_total ))
							<td style="text-align:right; font-weight:bold;"> <?php  echo number_format($rep_data_total[0]->opening) ?> </td>
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

