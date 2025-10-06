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
				<h6 class="mb-0 text-uppercase">Categories</h6>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" id="createCategoryBtn" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button>
				<!-- Category Modal -->
				<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="categoryForm" action="{{route('admin.category.store')}}" enctype="multipart/form-data">
								@csrf
								<div class="modal-header">
									<h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<!-- Hidden ID for update -->
									<input type="hidden" id="category_id" name="id">

									<div class="mb-3">
										<label for="category_name" class="form-label">Category Name</label>
										<input type="text" class="form-control" id="category_name" name="name" required>
									</div>

									<div class="mb-3">
										<label for="category_slug" class="form-label">Category Slug</label>
										<input type="text" class="form-control" id="category_slug" name="slug" required>
									</div>

									<div class="mb-3">
										<label for="parent_category_id" class="form-label">Parent Category</label>
										<select class="form-control" name="parent_category_id" id="parent_category_id">
											<option value=""></option>
											@foreach($parentCategories as $categoryData)
												<option value="{{$categoryData->id}}">{{$categoryData->name}}</option>
											@endforeach
										</select>
									</div>

									<div class="mb-3">
										<label for="category_image" class="form-label">Category Image</label>
										<input type="file" class="form-control" id="category_image" name="image" accept="image/*">
										<!-- Preview Box -->
										<div id="preview_image" class="mt-3 text-center" style="display:none;">
											<p class="mb-1">Image Preview:</p>
											<img id="preview_img_tag" src="" class="img-fluid rounded border" width="200" />
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="saveCategoryBtn">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="categoryTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Slug</th>
										<th>Parent Category</th>
										<th>Image</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($categories as $index => $category)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{$category->name}}</td>
										<td>{{ $category->slug }}</td>
										<td>{{ $category->parent_category_id?$category->parentCategory->name:'' }}</td>
										<td>
											@if($category->image)
												<img src="{{ asset($category->image) }}" alt="Category Image" width="80" class="rounded">
											@else
												N/A
											@endif
										</td>
										<td>{{ $category->created_at->format('M d, Y') }}</td>
										<td>
											<button class="btn btn-sm btn-primary editCategoryBtn" 
													data-category='@json($category)'>
												Edit
											</button>
											<button class="btn btn-sm btn-danger deleteCategoryBtn" 
													data-id="{{ $category->id }}">
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
		$("#categoryForm").submit(function(e) {
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
							$("#categoryModal").modal("hide");
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
		// Preview uploaded image
		$("#category_image").on("change", function () {
			let file = this.files[0];
			if (file) {
				let reader = new FileReader();
				reader.onload = function (e) {
					$("#preview_img_tag").attr("src", e.target.result);
					$("#preview_image").show();
				}
				reader.readAsDataURL(file);
			} else {
				$("#preview_image").hide();
				$("#preview_img_tag").attr("src", "");
			}
		});
		$(document).ready(function() {
			var table = $('#categoryTable').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );

			// Open modal for create
			$("#createCategoryBtn").on("click", function () {
				$("#categoryModalLabel").text("Add Category");
				$("#saveCategoryBtn").text("Save");
				$("#categoryForm")[0].reset();
				$("#id").val("");
				$("#imagePreview").hide();
				$("#parent_category_id option").show();
				$("#categoryModal").modal("show");
			});

			// Open modal for edit
			$(document).on("click", ".editCategoryBtn", function () {
				let category = $(this).data("category");

				$("#categoryModalLabel").text("Edit Category");
				$("#saveCategoryBtn").text("Update");
				$("#category_id").val(category.id);
				$("#category_name").val(category.name);
				$("#category_slug").val(category.slug);
				$("#parent_category_id").val(category.parent_category_id);
				// hide same option from parent category select
				$("#parent_category_id option").show();
				$("#parent_category_id option[value='" + category.id + "']").hide();

				if (category.image) {
					$("#preview_img_tag").attr("src", category.image);
					$("#preview_image").show();
				} else {
					$("#preview_img_tag").attr('src', '');
					$("#preview_image").hide();
				}

				$("#categoryModal").modal("show");
			});

			$(document).on("click", ".deleteCategoryBtn", function () {
				let id = $(this).data("id");

				if (!confirm("Are you sure you want to delete this category?")) return;

				$.ajax({
					url: "{{route('admin.category.delete')}}",
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
						alert("Failed to delete category");
					}
				});
			});
		} );
	</script>
@endsection