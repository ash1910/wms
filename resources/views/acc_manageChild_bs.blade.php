

<?php 


$data_ComInfo = DB::table('tbl_company')->select('com_name','com_address','fy_opening','fy_closing')->get()->toArray();


if(isset($data_ComInfo)){

	$f_date= $data_ComInfo[0]->fy_opening;
	$t_date =$data_ComInfo[0]->fy_closing;

	//echo $f_date;
}


?>


							
	@foreach($childs as $child)

		

		
		<tr>
			
			@if ($child->grp_status == 'GR')

				
				
				<td>{!! "&nbsp;&nbsp;&nbsp;" !!}<b>{{ $child->acc_name }}</b></td>
				<td> {{ $child->id}}</td>
				<td  style="text-align:right"> <b><?php echo number_format($child->op_bal) ?></b></td>
				
			@endif

			@if ($child->grp_status == 'AH' and ($child->op_bal <> 0 or $child->debit <> 0 or $child->credit <> 0))

			  

				<td><a href = "acc_report_ledger?f_date=<?php echo($f_date);?>&t_date=<?php echo($t_date);?>&acc={{$child->acc_name}}"><div style="margin-left: 25px;">{{ $child->acc_name }}</div></td>
				<td> {{ $child->id}}</td>
				<td  style="text-align:right"> <?php echo number_format($child->op_bal) ?></td>
				

			@endif


		</tr>


			@if(count($child->childs))

				@include('acc_manageChild_bs',['childs' => $child->childs]) 

			@endif

			
			


	@endforeach



