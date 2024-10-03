




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

//$rep_data_voucher = DB::select("SELECT * FROM tbl_acc_details where ref= '$myRef'");

$rep_data_voucher = DB::select("SELECT * , customer_info.customer_nm, customer_reg ,customer_chas, customer_vehicle  
FROM `tbl_acc_details` INNER JOIN customer_info on tbl_acc_details.others_id = customer_info.customer_id 
WHERE `ref`='$myRef'");

$t_debit = 0;
$t_credit = 0;

foreach($rep_data_voucher as $item)
{
    $t_debit = $t_debit + $item->debit;

    $t_credit = $t_credit + $item->credit;
}


// $data_count = count($rep_data_voucher);


// if(empty($rep_data_voucher) || $data_count == 1 ){

//     $rep_data_voucher = DB::select("SELECT * FROM tbl_acc_details where ref= '$myRef'");
// }

if( empty($rep_data_voucher) || $t_debit != $t_credit ){

    $rep_data_voucher = DB::select("SELECT * FROM tbl_acc_details where ref= '$myRef'");
}

//dd($rep_data_voucher);

$rep_data_total = DB::select("SELECT ref, sum(debit) as debit, sum(credit) as credit from tbl_acc_details  WHERE ref = '$myRef' GROUP BY ref");


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
                <th>
                <?php if(!empty($rep_data_voucher[0]->customer_nm)) {
                 echo"Customer: "; echo ($rep_data_voucher[0]->customer_nm);
                } ?>
                </th>
                <th>
                <?php if(!empty($rep_data_voucher[0]->customer_vehicle)) {
                 echo"Car Name: "; echo ($rep_data_voucher[0]->customer_vehicle);
                } ?>
                </th>

                <th>
                <?php if(!empty($rep_data_voucher[0]->customer_reg)) {
                 echo"Reg No: "; echo ($rep_data_voucher[0]->customer_reg);
                } ?>
                </th>

                <th style="text-align:right">
                <?php if(!empty($rep_data_voucher[0]->customer_chas)) {
                 echo"Chasis No: "; echo ($rep_data_voucher[0]->customer_chas);
                } ?>
                </th>

                <th style="text-align:right">
                <?php if(!empty($rep_data_voucher[0]->job_no)) {
                 echo"Job No: "; echo ($rep_data_voucher[0]->job_no);
                } ?>
                </th>
                
            </tr>
            <tr>  </tr>

            @endif

            </thead>

        </table>


        <table id="myTable_04" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th style="width: 20%">Accounts Head</th>
                    <th style="width: 25%">Narration</th>
                    <th style="width: 10%">Ch No</th>
                    <th style="width: 10%">Ch Date</th>
                    <th style="width: 15%">Bank</th>
                    <th style="text-align:right; width: 10%">Debit</th>
                    <th style="text-align:right; width: 10%">Credit</th>
                </tr>
            </thead>
            <tbody>

                @if(isset( $rep_data_voucher ))
                @foreach($rep_data_voucher as $item)
                    <tr>
                    <tr>
                        <td >{{$item->ahead}}</td>
                        <td>{{$item->narration}}</td>
                        <td>{{$item->ch_no}}</td>
                        <td>{{$item->ch_date}}</td>
                        <td>{{$item->b_name}}</td>
                        <td style="text-align:right"><?php  echo number_format($item->debit) ?></td>
                        <td style="text-align:right" ><?php  echo number_format($item->credit) ?></td>
                        
                        
                    </tr>
                @endforeach 
                @endif
                
                </tbody>
                <tr>
                    <td>Total: </td>

                    <td colspan="4">Amount (in word) : <?php  echo NumberintoWords($rep_data_total[0]->debit); ?> only</td>
                    
                    @if(isset( $rep_data_total ))
                        <td style="text-align:right"> <?php  echo number_format($rep_data_total[0]->debit) ?> </td>
                    @endif

                    @if(isset( $rep_data_total ))
                        <td style="text-align:right"> <?php  echo number_format($rep_data_total[0]->credit) ?></td>
                    @endif


                </tr>

       
			
             
       
	

            </table>




</div>


    
</body>
</html>


