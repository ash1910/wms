




<?php 



function NumberintoWords(float $number)
{
    $number_after_decimal = round($number - ($num = floor($number)), 2) * 100;

    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Fourty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $number = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($number) {
            $add_plural = (($counter = count($string)) && $number > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($number < 21) ? $change_words[$number] . ' ' . $here_digits[$counter] . $add_plural . '
       ' . $amt_hundred : $change_words[floor($number / 10) * 10] . ' ' . $change_words[$number % 10] . '
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else $string[] = null;
    }
    $implode_to_Words = implode('', array_reverse($string));
    $get_word_after_point = ($number_after_decimal > 0) ? "Point " . ($change_words[$number_after_decimal / 10] . "
        " . $change_words[$number_after_decimal % 10]) : '';
    return ($implode_to_Words ? $implode_to_Words : ' ') . $get_word_after_point;
}


//echo NumberintoWords(12038941);




$myRef = Route::input('ref');

//echo ($myRef);

$part_ref = explode("-", $myRef);

//$rep_data_voucher = DB::select("SELECT * FROM tbl_acc_details where ref= '$myRef'");



if(empty($rep_data_voucher)){

    $rep_data_voucher = DB::select("SELECT * FROM tbl_acc_details where ref= '$myRef'");
}



//dd($rep_data_voucher);

//$rep_data_total = DB::select("SELECT ref, sum(debit) as debit, sum(credit) as credit from tbl_acc_details  WHERE ref = '$myRef' GROUP BY ref");



$rep_data_pur_master = DB::select("SELECT purchase_mas.supplier_id, suppliers.supplier_name, purchase_mas.supplier_ref 
                                    FROM `purchase_mas` INNER JOIN suppliers ON purchase_mas.supplier_id = suppliers.supplier_id 
                                    WHERE purchase_mas.purchase_id ='$part_ref[1]';");

$rep_data_pur_details = DB::select("SELECT `id`,`purchase_id`,`prod_id`,`prod_name`,`qty`,`req`,`rate`,`amount`,`grn`,`job_no`,`note`,`user_id`,`dt`
                                 FROM `purchase_det` WHERE `purchase_id` = '$part_ref[1]'AND `qty` > 0;");

$rep_data_sum = DB::select("SELECT sum(`qty`) as qty, sum(`amount`) as amt FROM purchase_det WHERE `purchase_id` = '$part_ref[1]' AND `qty` > 0;");



$rep_data_ComInfo = DB::select("SELECT * FROM `tbl_company`");


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<link rel="shortcut icon" type="image/png" href="/media/images/favicon.png">
	

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Accounts Voucher</title>
  
</head>
<body>


<div class="container-md" id="accounts_voucher" >


<hr>

<table id="example" class="display nowrap" style="width:100%">
            
            <thead>
             
            </thead>
            <tbody>
                @if(isset( $rep_data_ComInfo))
                <tr></tr>
                <tr></tr>
                <tr  align="center"> <th style="font-size: 22px;"> {{$rep_data_ComInfo[0]->com_name}}</th>  </tr>
                <tr  align="center"> <th style="font-size: 18px;"> {{$rep_data_ComInfo[0]->com_address}}</th>  </tr>
                @endif
            </tbody>

        </table>

        <table id="myTable_02" class="table table-striped table-bordered" >
            
            <thead>
             
            </thead>
            <tbody>
                @if(isset( $rep_data_voucher))
                <tr  align="center"> <th> {{$rep_data_voucher[0]->vr_type}}</th>  </tr>
                @endif
            </tbody>

        </table>

        <table id="myTable_03" class="table table-striped table-bordered" >
            
            <thead>

            @if(isset( $rep_data_voucher))

            <tr> 
                <th> Ref  : {{$rep_data_voucher[0]->ref}}</th> 
                <th ></th>
                <th></th>
                <th></th>
                <th style="text-align:right"> Date : {{date('d-m-Y', strtotime($rep_data_voucher[0]->tdate))}}</th> 
            </tr>
            <tr>
                <th> Supplier : {{$rep_data_pur_master[0]->supplier_id}} - {{$rep_data_pur_master[0]->supplier_name}}</th>
                <th>Supplier's Bill No.: {{$rep_data_pur_master[0]->supplier_ref}} </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>  </tr>

            @endif

            </thead>

        </table>


        <table id="myTable_04" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Job No. </th>
                    <th>Req. No</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Rate</th>
                    <th style="text-align:right">Amount</th>
                </tr>
                </tr>
            </thead>
            <tbody>

                @if(isset( $rep_data_pur_details ))
                @foreach($rep_data_pur_details as $item)
                    <tr>
                    <tr>
                        <td >{{$item->prod_id}}</td>
                        <td>{{$item->prod_name}}</td>
                        <td>{{$item->job_no}}</td>
                        <td>{{$item->req}}</td>
                        <td style="text-align:right"><?php  echo number_format($item->qty) ?></td>
                        <td style="text-align:right" ><?php  echo number_format($item->rate) ?></td>
                        <td style="text-align:right" ><?php  echo number_format($item->amount) ?></td>
                        
                    </tr>
                @endforeach 
                @endif
                
                </tbody>
                <tr>
                    <td>Total: </td>

                    <td>Amount (in word) : <?php  echo NumberintoWords($rep_data_sum[0]->amt); ?> only</td>

                    <td></td>
                    <td></td>
                    @if(isset( $rep_data_sum ))
                        <td style="text-align:right"> <?php  echo number_format($rep_data_sum[0]->qty) ?> </td>
                    @endif
                    <td></td>
                    @if(isset( $rep_data_sum ))
                        <td style="text-align:right"> <?php  echo number_format($rep_data_sum[0]->amt) ?></td>
                    @endif


                </tr>

       
			
             
       
	

            </table>




</div>


    
</body>
</html>


