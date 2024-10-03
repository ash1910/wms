
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" ></script>

@extends("layouts.master")



@section("content")


<?php 

$myRef = request()->get('ref');



if(isset($myRef)){

    //echo ($myRef);
    $editAccVoucher1 = DB::table('tbl_acc_details')->where('ref', $myRef)->first();

    $editAccVoucher2 = DB::table('tbl_acc_details')->where('ref', $myRef)->get();

}





$data_AccHead = DB::select("SELECT acc_name FROM `tbl_acc_masters` WHERE grp_status = 'AH' and `type_id`< 13 ORDER BY acc_name");

$data_AccType = DB::table('tbl_acc_types')->get();

$data_AccGroup = DB::table('tbl_acc_masters')->get();

//$data_bankinfo = DB::table('tbl_acc_types')->get()->pluck('type_head')->toArray();

$data_bankinfo = DB::table('tbl_acc_types')->where('type_head','Bank')->get()->pluck('type_head')->toArray();

//$data_bankinfo = DB::table('tbl_acc_types')->select('type_head','id')->get()->toArray();

//$data_Voucher_ref_BP = DB::table('tbl_acc_details')->max('ref')->where('ref', 'like', '%BP-%')->pluck('ref')->toArray();


?>





<main class="page-content">

{{-- Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('success')}}
    </div>
@endif
   



      <div class="card" >
				    <a class="btn btn-primary active" href="/acc_opening_bal_list"><i class="fadeIn animated bx bx-add-to-queue"></i> List of Opening Balance </a>
	  <div class="card-body">
		
    
    
        
            <div class="container-md" id = "myID">

                    <form class="row g-3" action="{{url('acc_opening_bal')}}" method="post">{{ csrf_field() }}

                            <div class="container-md" >
                                
                                <table   class="table table-success table-striped" id ="myTable_01">
                                    
                                    <tbody >

                                        <tr >
                                            <td>Voucher</td>
                                            <td>
                                                <div class="select">
                                                    <select name="vType" id="ass_special"  class="form-select form-select-sm"> 
                                                      
                                                        <option value="Opening Balance">Opening Balance </option>
                                                      
                                                    </select> 
                                                </div>
                                            </td>

                                            <td>Ref</td>
                                            <td><input readonly type="Text" name="voucherRef" id="voucherRef" class="form-control form-control-sm" value="OpeningBal-01" required ></td>

                                            <td>Date</td>
                                            <td><input type="Date" name="trnDate" id="trnDate"  class="form-control form-control-sm" 
                                            @if(isset( $editAccVoucher1 )) value="{{$editAccVoucher1->tdate}}" @else value="<?= date('Y-m-d') ?>" @endif  
                                            required ></td>

                                            <td><input type="Text" disabled name="t_Debit" id="t_Debit" value="0"  class="form-control form-control-sm"></td>
                                            <td><input type="Text" disabled name="t_Credit" id="t_Credit" value="0"  class="form-control form-control-sm"></td>
                                            <td><input  type="number" disabled name="out_of_bal[]" id="out_of_bal" value="0" class="form-control form-control-sm"></td>

                                        </tr>

                                    
                                        
                                        
                                    </tbody>
                                </table>
                            
                            </div>

                            <div class="container-md" >

                            
                                <table  class="table table-sm" id="myTable_02">
                                    
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 30%" >Accounts</th>
                                                <th style="width: 15%">Debit</th>
                                                <th style="width: 15%">Credt</th>
                                                <th style="width: 40%">Remarks</th>
                            
                                                <th></th>
                                                <th></th>
                                            </tr>

                                            <tr>

                                                <th>
                                                    <select name="My_accHead" id="My_accHead"  class="form-select form-select-sm" required>
                                                        @if(isset( $data_AccHead   ))
                                                            @foreach ( $data_AccHead  as $item)
                                                                <option  value="{{$item->acc_name}}">{{$item->acc_name}}</option>
                                                            @endforeach
                                                            
                                                        @endif

                                                    </select>
                                                </th>

                                                <th><input  type="number" onblur="makeZeroCredit()"  value="0"  name="My_accDebit" id="My_accDebit" class="form-control form-control-sm" ></th>
                                                <th><input  type="number" onblur="makeZeroDebit()"   value="0"  name="My_accCredit" id="My_accCredit" class="form-control form-control-sm" ></th>
                                                <th><input  type="text"   name="My_accRemarks" id="My_accRemarks" maxlength="50" class="form-control form-control-sm" > </th>
                                                <th colspan="2" id="myTHead_01" ><a href="javascript:;" class ="btn btn-info addRow" onclick="focusInput()">+</a></th>
                                                <th></th>
                                           
                                                
                                               
                                            </tr>



                                        </thead>


                                        <tbody id="myTbody_02">

                                    

                                        </tbody>


                                        <tr>  
                                        @if(isset(  $editAccVoucher2 ))  
                                        <td> <button type="submit"  class="btn btn-primary" onclick="return DataVerification();"  >  Update  </button></td>
                                        @else
                                        <td> <button type="submit"  class="btn btn-success" onclick="return DataVerification();"  >  Create  </button></td>
                                        @endif
                                        <td>  </td>
                                        <td> </td>
                                        <td> <input  hidden type="number" value = "-1" name="myRowIndex" id="myRowIndex" class="form-control form-control-sm" > </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                       
                                        </tr>

                                </table>



                            </div>
                           
                    </form>
            </div>




@if(isset(  $editAccVoucher2  ))

        

    <script>

        

        let users = @json($editAccVoucher2)


        //alert(JSON.stringify(users));

        const tableBody = document.getElementById('myTbody_02');
        for (const user of users) {
            const tr = document.createElement('tr');
            const content = `
            <td><input  type="text" readonly  name="accHead[]" id="accHead" class="form-control form-control-sm" value= "${user.ahead}"> </td>
            <td><input  type="number"  readonly name="accDebit[]" id="accDebit" class="form-control form-control-sm" value= ${user.debit}> </td>
            <td><input  type="number" readonly  name="accCredit[]" id="accCredit" class="form-control form-control-sm"  value= ${user.credit}> </td>
            <td><input  type="text"  readonly  name="accRemarks[]" id="accRemarks" class="form-control form-control-sm" value= "${user.narration}" > </td>
            <td><a href="javascritp:;" class="btn btn-warning editRow"><</a></td>
            <td><a href="javascritp:;" class="btn btn-danger deleteRow">-</a></td>`;
            

            tr.innerHTML = content;
            tableBody.appendChild(tr)

            
        

            }

            getTotalDebit();

            getTotalCredit();



            //document.getElementById("myTable").deleteRow(1);

            function getTotalDebit(){

                var sum = 0;
                var amts =  document.getElementsByName("accDebit[]");

                for (let index = 0; index < amts.length; index++ ){

                    var t_dr = amts[index].value;

                    sum = + (sum) + +(t_dr) ; 

                    //alert(sum);

                }

                document.getElementById("t_Debit").value = sum;
                document.getElementById("out_of_bal").value =  sum -  document.getElementById("t_Credit").value;

            }

   
            function getTotalCredit(){

                var sum = 0;
                var amts =  document.getElementsByName("accCredit[]");

                for (let index = 0; index < amts.length; index++ ){

                    var t_dr = amts[index].value;

                    sum = + (sum) + +(t_dr) ; 

                    //alert(sum);

                }

                document.getElementById("t_Credit").value = sum;
                document.getElementById("out_of_bal").value =  sum -  document.getElementById("t_Debit").value;

            }



            

    </script>

    


                                    

 

                                                                                                  
@endif

<script>

        
    function DataVerification(){


    var dr = parseFloat(document.getElementById("t_Debit").value);

    var bal = parseFloat(document.getElementById("out_of_bal").value);


    if (dr == 0 ) {

    //alert (bal );
    alert('Transactions not found can not save !');
    return false;

    } 

    if (bal !== 0 ) {

        //alert (bal );
        alert('Transactions out of Balance can not save !');
        return false;

    } 

    }

</script>
 

</main>  


@endsection




@section("js")

  <link rel="stylesheet" href="assets/js/jquery-ui.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  
  
  
  <script>

    $('#myTHead_01').on('click', function(){
        
        if (document.getElementById("My_accDebit").value == 0 && document.getElementById("My_accCredit").value == 0) {

            alert('Please insert an amount in Debit or Credit box!');
            return;
        } 

       var ckIndex = document.getElementById("myRowIndex").value;

       if (ckIndex == -1){

        addRow();

       }else{
        
        UpdateRow();

       }

        getTotalDebit();

        getTotalCredit();
     
        makeReverseValue();

    });


    
  
  

    function addRow(){

            
            let myAccHead = {};
            myAccHead = JSON.stringify(document.getElementById("My_accHead").value);

            let myAccDebit = {};
            myAccDebit = JSON.stringify(document.getElementById("My_accDebit").value);
           
            let myAccCredit = {};
            myAccCredit = JSON.stringify(document.getElementById("My_accCredit").value);

            let myAccRemarks = {};
            myAccRemarks = JSON.stringify(document.getElementById("My_accRemarks").value);


            var tr = '<tr>'+
            
            '<td><input type="text" readonly value='+ myAccHead +'  name="accHead[]" id="accHead"  class="form-control form-control-sm"> </td>'+ 
            '<td><input type="text"  readonly value='+ myAccDebit +'  name="accDebit[]" id="accDebit"  class="form-control form-control-sm"> </td>'+ 
            '<td><input  type="number" readonly value='+ myAccCredit +' name="accCredit[]" id="accCredit"  class="form-control form-control-sm" > </td>'+
            '<td><input  type="text"  readonly value='+ myAccRemarks +' name="accRemarks[]" id="accRemarks" class="form-control form-control-sm" > </td>'+
             '<td><a href="javascritp:;" class="btn btn-warning editRow"><</a></td>'+
            '<td><a href="javascritp:;" class="btn btn-danger deleteRow">-</a></td>'+ 

            '</tr>';

            $("#myTbody_02").append(tr);

    }


    $('tbody').on('click', '.deleteRow', function(){

        var ckIndex = document.getElementById("myRowIndex").value;

       if (ckIndex == -1){

        $(this).parent().parent().remove();
        
        getTotalDebit();

        getTotalCredit();

       }

       

    });




    $('tbody').on('click', '.editRow', function(){

        var ckIndex = document.getElementById("myRowIndex").value;

        if (ckIndex == -1){


            var index = $(this).parent().parent().index();

            //alert (index);

            document.getElementById("myRowIndex").value = index;

            document.getElementById("My_accHead").value = document.getElementsByName("accHead[]")[index].value;
            document.getElementById("My_accDebit").value = document.getElementsByName("accDebit[]")[index].value;
            document.getElementById("My_accCredit").value = document.getElementsByName("accCredit[]")[index].value;
            document.getElementById("My_accRemarks").value = document.getElementsByName("accRemarks[]")[index].value;

        
            
            // if (document.getElementsByName("accChNo[]")[index] !=null){
            //     alert ("Yes");
            //     //document.getElementById("My_accChNo").disabled=true;
            // }else{

            //     alert("No");
            //     //document.getElementById("My_accChNo").disabled=false;
            // }

            document.getElementsByName("accHead[]")[index].style.backgroundColor = "orange";
            document.getElementsByName("accDebit[]")[index].style.backgroundColor = "orange";
            document.getElementsByName("accCredit[]")[index].style.backgroundColor = "orange";
            document.getElementsByName("accRemarks[]")[index].style.backgroundColor = "orange";
      


        }

      


    });


 
    function UpdateRow(){

        var index = document.getElementById("myRowIndex").value;

        //alert (index);

        document.getElementsByName("accHead[]")[index].value = document.getElementById("My_accHead").value;
        document.getElementsByName("accDebit[]")[index].value = document.getElementById("My_accDebit").value;
        document.getElementsByName("accCredit[]")[index].value = document.getElementById("My_accCredit").value;
        document.getElementsByName("accRemarks[]")[index].value = document.getElementById("My_accRemarks").value;

      
        document.getElementsByName("accHead[]")[index].style.backgroundColor = "#E8E8E8";
        document.getElementsByName("accDebit[]")[index].style.backgroundColor = "#E8E8E8";
        document.getElementsByName("accCredit[]")[index].style.backgroundColor = "#E8E8E8";
        document.getElementsByName("accRemarks[]")[index].style.backgroundColor = "#E8E8E8";
     

        document.getElementById("myRowIndex").value = -1;

    }



    function focusInput() {
        
        document.getElementById("My_accHead").focus();
        //document.getElementById("My_accDebit").value = 0;
        //document.getElementById("My_accCredit").value = 0;
    } 

    function makeReverseValue() {

        if ($('#My_accDebit').val() > 0) {
            $('#My_accCredit').val($('#t_Debit').val());
            $('#My_accDebit').val(0);
        }
        
    } 


    function makeZeroCredit() {
        //alert('working');
        if ($('#My_accDebit').val() > 0) {
            $('#My_accCredit').val(0);
        }

        if ($('#My_accDebit').val() == "") {
            $('#My_accDebit').val(0);
        }


        }

    function makeZeroDebit() {
        
        if ($('#My_accCredit').val() > 0) {
            $('#My_accDebit').val(0);
        }

        if ($('#My_accCredit').val() == "") {
            $('#My_accCredit').val(0);
        }

        
    }



    function getTotalDebit(){

        var sum = 0;
        var amts =  document.getElementsByName("accDebit[]");

        for (let index = 0; index < amts.length; index++ ){

            var t_dr = amts[index].value;

            sum = + (sum) + +(t_dr) ; 

            //alert(sum);

        }

        document.getElementById("t_Debit").value = sum;
        document.getElementById("out_of_bal").value =  sum -  document.getElementById("t_Credit").value;

    }


    function getTotalCredit(){

        var sum = 0;
        var amts =  document.getElementsByName("accCredit[]");

        for (let index = 0; index < amts.length; index++ ){

            var t_dr = amts[index].value;

            sum = + (sum) + +(t_dr) ; 

            //alert(sum);

        }

        document.getElementById("t_Credit").value = sum;
        document.getElementById("out_of_bal").value =  sum -  document.getElementById("t_Debit").value;

    }




  </script>
  
 
 

 
 @endsection
