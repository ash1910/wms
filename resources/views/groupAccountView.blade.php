<?php 
if ((session('role')=="Super Administrator")||(session('role')=="Accounts")||(session('role')=="Administrator"))
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


@extends("layouts.master")

@section("content")



<main class="page-content">
<!---Alert message----> 
@if(session()->has('alert'))
<script src="assets/js/jquery-1.12.4.min.js"></script>
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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">View Groups</li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
             <div class="card-header py-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                      <h5 class="mb-0">View Groups</h5>
                    </div>
                    <!--div class="col-12 col-lg-6 text-md-end">
                      <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
                      <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                    </div-->
                  </div>
             </div>
		
            <div class="card-body">
              <div class="table-responsive">
                
				<table style="width: 50%;" id="example3" class="table table-bordered mb-0">
					<thead>
						<tr>
							<th scope="col" style="border: 1px solid black;text-align: center;">Edit</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Group Name</th>
							<th scope="col" style="border: 1px solid black;text-align: center;">Parent Name</th>
						</tr>
					</thead>
					<tbody>				
<?php

$result = DB::select("
SELECT `id`, `name`, `parent_id` FROM `groups`;
");
	$sl = '1'; 	$amount='0';		
foreach($result as $item)
		{		$parent_id='';
?>				
			<tr>
				<th scope="row" style="border: 1px solid black;text-align: center;">
					<a href=""><i class="lni lni-pencil-alt"></i></a></th>
				<td style="border: 1px solid black;text-align: left;">{{$item->name}}</td>
			<?php
				$parent_id=$item->parent_id;
				if($parent_id!='')
				{
					$result = DB::select("SELECT `name` FROM `groups` WHERE `id` = '$parent_id';");
					foreach($result as $item)
					{
					?>
					<td style="border: 1px solid black;text-align: left;">{{$item->name}}</td>
					<?php	
					}
				}
				if($parent_id=='')
				{
					?>
					<td style="border: 1px solid black;text-align: center;"></td>
					<?php	
				}
			?>		

				
					</tr>
		<?php
		$sl = $sl+1;
		}  
?>
						<!--tr>
							<td colspan="3"><strong>Total Amount: Tk.</strong></td>
						</tr-->
					</tbody>
				</table>
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





@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
 @endsection