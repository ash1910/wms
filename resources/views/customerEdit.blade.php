
@extends("layouts.master")

@section("content")
<main class="page-content">

				
				<div class="card">
					<a class="btn btn-success" href="/customer"><i class="fadeIn animated bx bx-add-to-queue"></i> Add New Customer</a>
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Edit</th>
										<th style="text-align: center;">ID</th>
										<th>Customer Info</th>
										<th>Vehicle Info</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								
								@foreach($data as $item)
									<tr>
										<td style="text-align: center;"><a href = "customerEditOne?id={{$item->customer_id}}"><i class="lni lni-pencil-alt"></i></a></td>

										<td style="text-align: center;">{{$item->customer_id}}</td>
										<td style="text-align: left;"><b>C/N:</b> {{$item->customer_nm}}
										<br><b>Mobile:</b> {{$item->customer_mobile}}
										<br><b>Email:</b> {{$item->email}}
										<br><b>Address:</b> {{$item->customer_address}}
										@if($item->contact_person)<br><b>Contact Person:</b> {{$item->contact_person}} @endif
										@if($item->car_user)<br><b>User Name:</b> {{$item->car_user}} @endif
										</td>
										<td style="text-align: left;"><b>Car Name:</b> {{$item->customer_vehicle}}
										<br><b>Car Reg.:</b> {{$item->customer_reg}}
										<br><b>Car Chasis:</b> {{$item->customer_chas}}
										<br><b>Engine No:</b> {{$item->customer_eng}}
										
										</td>
										<td><a data-id="{{$item->customer_id}}" class="custDetailAnchor" href="javascript:;">Details</a></td>
									</tr>
								@endforeach 
								
								</tbody>
								<tfoot>
									<tr>
										<th>Edit</th>
										<th>ID</th>
										<th>Customer Info</th>
										<th>Vehicle Info</th>
										<th></th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

				<div class="modal" tabindex="-1" role="dialog" id="my_modal">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel">Customer Detail Information</h4>
								<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<table class="table table-striped">
									<tbody class="custData"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
</main>  

@endsection




@section("dataTable")
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
  <script type="text/javascript">
		$(".custDetailAnchor").on("click", function(e){
			e.preventDefault();
			let cust_id = $(this).data("id");
			var $modal = $('#my_modal');
			
			$.ajax({                 
                method: "GET",               
				url: '/api/getCustomerDataById?id='+cust_id,
				cache: false,
				success: function(data)
				{
					let custHtml = "";
					let comBankDet = `<b>A/C name:</b> ${data.ac_name || ''}<br>
										<b>A/C no:</b> ${data.ac_no || ''}<br>
										<b>Bank Name:</b> ${data.bank_name || ''}<br>
										<b>Branch Name:</b> ${data.branch_name || ''}<br>
										<b>Routing No:</b> ${data.routing_no || ''}<br>
										<b>Swift Code:</b> ${data.swift_code || ''}<br>`;
					let perBankDet = `<b>A/C name:</b> ${data.ac_name02 || ''}<br>
										<b>A/C no:</b> ${data.ac_no02 || ''}<br>
										<b>Bank Name:</b> ${data.bank_name02 || ''}<br>
										<b>Branch Name:</b> ${data.branch_name02 || ''}<br>
										<b>Routing No:</b> ${data.routing_no02 || ''}<br>
										<b>Swift Code:</b> ${data.swift_code02 || ''}<br>`;
					let contactPer1 = `<b>Name:</b> ${data.contact1_name || ''}<br>
										<b>Mobile No:</b> ${data.contact1_mobile || ''}<br>
										<b>Designation:</b> ${data.contact1_desig || ''}<br>
										<b>Purpose of Contact:</b> ${data.contact1_purpose || ''}<br>`;
					let contactPer2 = `<b>Name:</b> ${data.contact2_name || ''}<br>
										<b>Mobile No:</b> ${data.contact2_mobile || ''}<br>
										<b>Designation:</b> ${data.contact2_desig || ''}<br>
										<b>Purpose of Contact:</b> ${data.contact2_purpose || ''}<br>`;
					let contactPer3 = `<b>Name:</b> ${data.contact3_name || ''}<br>
										<b>Mobile No:</b> ${data.contact3_mobile || ''}<br>
										<b>Designation:</b> ${data.contact3_desig || ''}<br>
										<b>Purpose of Contact:</b> ${data.contact3_purpose || ''}<br>`;
					let contactPer4 = `<b>Name:</b> ${data.contact4_name || ''}<br>
										<b>Mobile No:</b> ${data.contact4_mobile || ''}<br>
										<b>Designation:</b> ${data.contact4_desig || ''}<br>
										<b>Purpose of Contact:</b> ${data.contact4_purpose || ''}<br>`;

					custHtml += `<tr><th scope="row">BIN</th><td>${data.bin || ''}</td></tr>`;
					custHtml += `<tr><th scope="row">Customer Group</th><td>${data.customer_group || ''}</td></tr>`;
					custHtml += `<tr><th scope="row">Company</th><td>${data.company || ''}</td></tr>`;
					custHtml += `<tr><th scope="row">Sister Companies</th><td>${data.sister_companies || ''}</td></tr>`;
					custHtml += `<tr><th scope="row">Company Bank Detail</th><td>${comBankDet}</td></tr>`;
					custHtml += `<tr><th scope="row">Personal Bank Detail</th><td>${perBankDet}</td></tr>`;
					custHtml += `<tr><th scope="row">Contact Person 1</th><td>${contactPer1}</td></tr>`;
					custHtml += `<tr><th scope="row">Contact Person 2</th><td>${contactPer2}</td></tr>`;
					custHtml += `<tr><th scope="row">Contact Person 3</th><td>${contactPer3}</td></tr>`;
					custHtml += `<tr><th scope="row">Contact Person 4</th><td>${contactPer4}</td></tr>`;

					if(custHtml!='')
					{
						$modal.modal('show');
						$(".custData").html(custHtml);
					}
		
				}
 			});
		});
  </script>
 @endsection

