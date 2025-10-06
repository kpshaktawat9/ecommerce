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
				<h6 class="mb-0 text-uppercase">Size</h6>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" id="createSizeBtn" data-bs-toggle="modal" data-bs-target="#SizeModal">Add Size Size</button>
				<!-- Size Size Modal -->
				<div class="modal fade" id="SizeModal" tabindex="-1" aria-labelledby="SizeModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="SizeForm" action="{{route('admin.size.store')}}" enctype="multipart/form-data">
								@csrf
								<div class="modal-header">
									<h5 class="modal-title" id="SizeModalLabel">Add Size Size</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<!-- Hidden ID for update -->
									<input type="hidden" id="size_id" name="id">

									<div class="mb-3">
										<label for="size_name" class="form-label">Name</label>
										<textarea class="form-control" id="size_name" name="name" rows="3" required></textarea>
									</div>

									<div class="mb-3">
										<label for="size_value" class="form-label">Value</label>
										<input type="text" class="form-control" id="size_value" name="value" required>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="saveSizeBtn">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="SizeTable" class="table table-striped table-bordered">
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
									@foreach($sizes as $index => $size)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $size->name}}</td>
										<td><a href="{{ $size->value }}" target="_blank">{{ $size->value }}</a></td>
										<td>{{ $size->created_at->format('M d, Y') }}</td>
										<td>
											<button class="btn btn-sm btn-primary editSizeBtn" 
													data-size='@json($size)'>
												Edit
											</button>
											<button class="btn btn-sm btn-danger deleteSizeBtn" 
													data-id="{{ $size->id }}">
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
		$("#SizeForm").submit(function(e) {
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
							$("#SizeModal").modal("hide");
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
			var table = $('#SizeTable').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );

			// Open modal for create
			$("#createSizeBtn").on("click", function () {
				$("#SizeModalLabel").text("Add Size Size");
				$("#saveSizeBtn").text("Save");
				$("#SizeForm")[0].reset();
				$("#id").val("");
				$("#SizeModal").modal("show");
			});

			// Open modal for edit
			$(document).on("click", ".editSizeBtn", function () {
				let size = $(this).data("size");

				$("#SizeModalLabel").text("Edit Size Size");
				$("#saveSizeBtn").text("Update");
				$("#size_id").val(size.id);
				$("#size_name").val(size.name);
				$("#size_value").val(size.value);

				$("#SizeModal").modal("show");
			});

			$(document).on("click", ".deleteSizeBtn", function () {
				let id = $(this).data("id");

				if (!confirm("Are you sure you want to delete this size?")) return;

				$.ajax({
					url: "{{route('admin.size.delete')}}",
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
						alert("Failed to delete size");
					}
				});
			});
		} );
	</script>
@endsection