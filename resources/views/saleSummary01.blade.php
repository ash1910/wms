
@extends("layouts.master")

@section("content")



<main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Reports</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sale Summary </li>
                  </ol>
                </nav>
              </div>
              
            </div>
            <!--end breadcrumb-->

	<div class="card border shadow-none">
	 <div class="card-header py-3">
		  <div class="row align-items-center g-3">
			<div class="col-12 col-lg-6">
			  <h5 class="mb-0">Sale Summary for the Fiscal Year of <b>[{{$from_dt}}]</b></h5>
			</div>
			<!--div class="col-12 col-lg-6 text-md-end">
			  <a href="javascript:;" class="btn btn-sm btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Export as PDF</a>
			  <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
			</div-->
		  </div>
	 </div>
		
		<div class="card-body">
		  <div class="table-responsive">
			
			<table>
				<tr>
					<th rowspan="2" style="text-align: center;border: 1px solid black;">ACCOUNT HEADS</th>

					<th colspan="4" style="text-align: center;border: 1px solid black;">Net Balance</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Jul-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Aug-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Sep-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Oct-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Nov-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Dec-22</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Jan-23</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Feb-23</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Mar-23</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Apr-23</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">May-23</th>
					<th colspan="4" style="text-align: center;border: 1px solid black;">Jun-23</th>
				
				</tr>
				<tr>
					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>

					<th style="text-align: center;border: 1px solid black;">Service</th>
					<th style="text-align: center;border: 1px solid black;">Parts</th>
					<th style="text-align: center;border: 1px solid black;">Discount</th>
					<th style="text-align: center;border: 1px solid black;">Total Sale</th>
					
				</tr>
				<tr>
				<td style="text-align: center;border: 1px solid black;">Engineering</td>
				</tr>
				<tr>
				<td style="text-align: center;border: 1px solid black;">Automobiles</td>
				</tr>				
				<tr>
				<td style="text-align: center;border: 1px solid black;">Inter Company</td>
				</tr>







				
			</table>
			
<br>
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