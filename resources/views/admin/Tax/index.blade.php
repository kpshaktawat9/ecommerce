@extends('admin.layout')
@section('page-style')
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Tables</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Tax</h6>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" id="createTaxBtn" data-bs-toggle="modal" data-bs-target="#TaxModal">Add Tax</button>
				<!-- Tax Modal -->
				<div class="modal fade" id="TaxModal" tabindex="-1" aria-labelledby="TaxModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="TaxForm" action="{{route('admin.tax.store')}}" enctype="multipart/form-data">
								@csrf
								<div class="modal-header">
									<h5 class="modal-title" id="TaxModalLabel">Add Tax</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<!-- Hidden ID for update -->
									<input type="hidden" id="tax_id" name="id">

									<div class="mb-3">
										<label for="tax_name" class="form-label">Name</label>
										<textarea class="form-control" id="tax_name" name="name" rows="3" required></textarea>
									</div>

									<div class="mb-3">
										<label for="tax_rate" class="form-label">Value</label>
										<input type="text" class="form-control" id="tax_rate" name="rate" required>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="saveTaxBtn">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="TaxTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Value</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($taxes as $index => $tax)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $tax->name}}</td>
										<td><a href="{{ $tax->rate }}" target="_blank">{{ $tax->rate }}</a></td>
										<td>{{ $tax->created_at->format('M d, Y') }}</td>
										<td>
											<button class="btn btn-sm btn-primary editTaxBtn" 
													data-tax='@json($tax)'>
												Edit
											</button>
											<button class="btn btn-sm btn-danger deleteTaxBtn" 
													data-id="{{ $tax->id }}">
												Delete
											</button>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->	
@endsection
@section('page-script')
	<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$("#TaxForm").submit(function(e) {
			e.preventDefault()
			if($(this).parsley().validate()) {
				var data = new FormData(this);

				$.ajax({
					url: $(this).attr('action'),
					data: data,
					processData: false,
					contentType: false,
					type: 'post',
					success: function(result) {
						if (result) {
							sweetAlert('success',result.message);
							$("#TaxModal").modal("hide");
                			location.reload();
						}
					},
					error: function(xhr, status, error) {
						if (xhr.responseJSON && xhr.responseJSON.errors) {
							var errors = xhr.responseJSON.errors;
							$.each(errors, function(field, messages) {
								$.each(messages, function(index, message) {
									sweetAlert('error', message);
								});
							});
						} else {
							sweetAlert('error', 'An unknown error occurred.');
						}
					}
				});
			}
		});
		$(document).ready(function() {
			var table = $('#TaxTable').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );

			// Open modal for create
			$("#createTaxBtn").on("click", function () {
				$("#TaxModalLabel").text("Add Tax");
				$("#saveTaxBtn").text("Save");
				$("#TaxForm")[0].reset();
				$("#id").val("");
				$("#TaxModal").modal("show");
			});

			// Open modal for edit
			$(document).on("click", ".editTaxBtn", function () {
				let tax = $(this).data("tax");

				$("#TaxModalLabel").text("Edit Tax");
				$("#saveTaxBtn").text("Update");
				$("#tax_id").val(tax.id);
				$("#tax_name").val(tax.name);
				$("#tax_rate").val(tax.rate);

				$("#TaxModal").modal("show");
			});

			$(document).on("click", ".deleteTaxBtn", function () {
				let id = $(this).data("id");

				if (!confirm("Are you sure you want to delete this tax?")) return;

				$.ajax({
					url: "{{route('admin.tax.delete')}}",
					method: "POST",
					data: {
						_token: "{{csrf_token()}}",
						id: id
					},
					success: function (res) {
						sweetAlert('success',res.message);
						location.reload();
					},
					error: function () {
						alert("Failed to delete tax");
					}
				});
			});
		} );
	</script>
@endsection