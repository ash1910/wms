@extends("layouts.master")

@section("content")


<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Multi Job No</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->
			
			

		<div class="card border shadow-none">
             <div class="card-header py-3">
			  <div class="row align-items-center g-3">
				<div class="col-12 col-lg-6">
				  <h5 class="mb-0">Multi Receivable Review</h5>
				</div>
			  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
			<form method="post" action="pay03">{{ csrf_field() }}
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
<?php			
		$number = count($job_no);
		$t_received1 = '0';
		if($number>1)
		{
			for($i=0; $i<$number; $i++)
			{
				if(trim($job_no[$i])!='')
				{
					 $bill1=$bill[$i];
					 $job_no1 = $job_no[$i];
					 $customer_id1 = $customer_id[$i];
					 $bonus1=$bonus[$i];
					 $vat_wav1=$vat_wav[$i];
					 $received_c1=$received_c[$i];
					 $received_k1=$received_k[$i];
					 $received_p1=$received_p[$i];
					 $received_b1=$received_b[$i];
					 $ref1=$ref[$i];
					 $note1=$note[$i];
					 $trix1=$trix[$i];
					 $send1=$send[$i];
					 $bank1=$bank[$i];
					 $chequeNo1=$chequeNo[$i];
					 $chequeDt1=$chequeDt[$i];
					 $received1=($received_c1+$received_k1+$received_p1+$received_b1);
					 $total1= $total[$i];
					 $due1=$total1-($received1+$bonus1+$vat_wav1);
					 $t_received1 = $t_received1+$received1;
if($received1>0)
{
?>						
	
              <div class="col">
                <div class="card border shadow-none bg-light radius-10">
                  <div class="card-body text-left">
                    
                     
                     <p class="mb-0"><b>Job No: {{$job_no1}}</b></p>
                     <p class="mb-0"><b>Due Pay:</b> TK. {{number_format(intval($total1), 2, '.', ',');}}</p>
                     <p class="mb-0"><b>Discount:</b> TK. {{number_format(intval($bonus1), 2, '.', ',');}}</p>
                     <p class="mb-0"><b>Vat Waiver:</b> TK. {{number_format(intval($vat_wav1), 2, '.', ',');}}</p>
                     <p class="mb-0"><b>Received: TK. {{number_format(intval($received1), 2, '.', ',');}}</b></p>
                     <p class="mb-0"><b>Due: TK. {{number_format(intval($due1), 2, '.', ',');}}</b></p>
					 <hr>
@if($ref1!='')		 <p class="mb-0"><b>Due Ref.:</b> {{$ref1}}</p> @endif
@if($note1!='')		 <p class="mb-0"><b>Note:</b> {{$note1}}</p> @endif
@if($received_c1!='')		 <p class="mb-0"><b>Cash:</b> TK. {{number_format(intval($received_c1), 2, '.', ',');}}</p>
@endif
@if($received_k1!='')		 <p class="mb-0"><b>Bkash:</b> TK. {{number_format(intval($received_k1), 2, '.', ',');}}</p>
							 <p class="mb-0"><b>Trix:</b> {{$trix1}}</p>
							 <p class="mb-0"><b>Send:</b> {{$send1}}</p>
@endif
@if($received_p1!='')		 <p class="mb-0"><b>POS:</b> TK. {{number_format(intval($received_p1), 2, '.', ',');}}</p>
@endif
@if($received_b1!='')		 <p class="mb-0"><b>Cheque:</b> TK. {{number_format(intval($received_b1), 2, '.', ',');}}</p>
							 <p class="mb-0"><b>Bank:</b> {{$bank1}}</p>
							 <p class="mb-0"><b>Cheque No:</b> {{$chequeNo1}}</p>
							 <p class="mb-0"><b>Cheque Date:</b> {{$chequeDt1}}</p>
@endif                 
				  
				  </div>
                </div>
              </div>
              
              
              
<input type="hidden" name="job_no" value="$job_no">             
              
            

	
						
<?php						
}
				}
				
			}
		}
?>
		</div>	
			
			
			
			
<b>Total Received: TK {{number_format(intval($t_received1), 2, '.', ',');}}</b>
			
			
			<br>
            <input type="submit" name="submit" value="Submit" class="btn btn-outline-success px-3">
			</form>
			<br>				
				
			
				
				
				
				
				
				
				
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