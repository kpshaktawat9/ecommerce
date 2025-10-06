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
				<h6 class="mb-0 text-uppercase">AttributeValue</h6>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" id="createAttributeValueBtn" data-bs-toggle="modal" data-bs-target="#AttributeValueModal">Add Attribute Value</button>
				<!-- AttributeValue AttributeValue Modal -->
				<div class="modal fade" id="AttributeValueModal" tabindex="-1" aria-labelledby="AttributeValueModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="AttributeValueForm" action="{{route('admin.attribute-value.store')}}" enctype="multipart/form-data">
								@csrf
								<div class="modal-header">
									<h5 class="modal-title" id="AttributeValueModalLabel">Add AttributeValue AttributeValue</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<!-- Hidden ID for update -->
									<input type="hidden" id="attribute_value_id" name="id">
									
									<div class="mb-3">
										<label for="attribute_value_attribute_id" class="form-label">Value</label>
										<select class="form-control" name="attribute_id" id="attribute_value_attribute_id" required>
											@foreach($allAttributes as $attribute)
												<option value="{{$attribute->id}}">{{$attribute->name}}</option>
											@endforeach
										</select>
									</div>

									<div class="mb-3">
										<label for="attribute_value_name" class="form-label">Name</label>
										<input type="text" class="form-control" id="attribute_value_name" name="name" required></input>
									</div>

								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="saveAttributeValueBtn">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="AttributeValueTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Attribute</th>
										<th>Value</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($attributeValues as $index => $attributeValue)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $attributeValue->singleAttribute->name }} ({{ $attributeValue->singleAttribute->slug }})</td>
										<td>{{ $attributeValue->name}}</td>
										<td>{{ $attributeValue->created_at->format('M d, Y') }}</td>
										<td>
											<button class="btn btn-sm btn-primary editAttributeValueBtn" 
													data-attributeValue='@json($attributeValue)'>
												Edit
											</button>
											<button class="btn btn-sm btn-danger deleteAttributeValueBtn" 
													data-id="{{ $attributeValue->id }}">
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
		$("#AttributeValueForm").submit(function(e) {
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
							$("#AttributeValueModal").modal("hide");
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
			var table = $('#AttributeValueTable').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );

			// Open modal for create
			$("#createAttributeValueBtn").on("click", function () {
				$("#AttributeValueModalLabel").text("Add AttributeValue AttributeValue");
				$("#saveAttributeValueBtn").text("Save");
				$("#AttributeValueForm")[0].reset();
				$("#id").val("");
				$("#AttributeValueModal").modal("show");
			});

			// Open modal for edit
			$(document).on("click", ".editAttributeValueBtn", function () {
				let attributeValue = $(this).data("attributevalue");

				$("#AttributeValueModalLabel").text("Edit AttributeValue AttributeValue");
				$("#saveAttributeValueBtn").text("Update");
				$("#attribute_value_id").val(attributeValue.id);
				$("#attribute_value_name").val(attributeValue.name);
				$("#attribute_value_attribute_id").val(attributeValue.attribute_id);

				$("#AttributeValueModal").modal("show");
			});

			$(document).on("click", ".deleteAttributeValueBtn", function () {
				let id = $(this).data("id");

				if (!confirm("Are you sure you want to delete this attributeValue?")) return;

				$.ajax({
					url: "{{route('admin.attribute-value.delete')}}",
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
						alert("Failed to delete attributeValue");
					}
				});
			});
		} );
	</script>
@endsection