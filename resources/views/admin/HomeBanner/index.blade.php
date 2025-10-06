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
				<h6 class="mb-0 text-uppercase">Home Banners</h6>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" id="createBannerBtn" data-bs-toggle="modal" data-bs-target="#homeBannerModal">Add Home Banner</button>
				<!-- Home Banner Modal -->
				<div class="modal fade" id="homeBannerModal" tabindex="-1" aria-labelledby="homeBannerModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="homeBannerForm" action="{{route('admin.home.banner.store')}}" enctype="multipart/form-data">
								@csrf
								<div class="modal-header">
									<h5 class="modal-title" id="homeBannerModalLabel">Add Home Banner</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<!-- Hidden ID for update -->
									<input type="hidden" id="banner_id" name="id">

									<div class="mb-3">
										<label for="banner_text" class="form-label">Banner Text</label>
										<textarea class="form-control" id="banner_text" name="text" rows="3" required></textarea>
									</div>

									<div class="mb-3">
										<label for="banner_link" class="form-label">Banner Link</label>
										<input type="text" class="form-control" id="banner_link" name="link" required>
									</div>

									<div class="mb-3">
										<label for="banner_image" class="form-label">Banner Image</label>
										<input type="file" class="form-control" id="banner_image" name="image" accept="image/*">
										<!-- Preview Box -->
										<div id="preview_image" class="mt-3 text-center" style="display:none;">
											<p class="mb-1">Image Preview:</p>
											<img id="preview_img_tag" src="" class="img-fluid rounded border" width="200" />
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="saveBannerBtn">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="homeBannerTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Text</th>
										<th>Link</th>
										<th>Image</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($homeBanners as $index => $banner)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ Str::limit($banner->text, 50) }}</td>
										<td><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></td>
										<td>
											@if($banner->image)
												<img src="{{ asset($banner->image) }}" alt="Banner Image" width="80" class="rounded">
											@else
												N/A
											@endif
										</td>
										<td>{{ $banner->created_at->format('M d, Y') }}</td>
										<td>
											<button class="btn btn-sm btn-primary editBannerBtn" 
													data-banner='@json($banner)'>
												Edit
											</button>
											<button class="btn btn-sm btn-danger deleteBannerBtn" 
													data-id="{{ $banner->id }}">
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
		$("#homeBannerForm").submit(function(e) {
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
							$("#homeBannerModal").modal("hide");
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
		$("#banner_image").on("change", function () {
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
			var table = $('#homeBannerTable').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );

			// Open modal for create
			$("#createBannerBtn").on("click", function () {
				$("#homeBannerModalLabel").text("Add Home Banner");
				$("#saveBannerBtn").text("Save");
				$("#homeBannerForm")[0].reset();
				$("#id").val("");
				$("#imagePreview").hide();
				$("#homeBannerModal").modal("show");
			});

			// Open modal for edit
			$(document).on("click", ".editBannerBtn", function () {
				let banner = $(this).data("banner");

				$("#homeBannerModalLabel").text("Edit Home Banner");
				$("#saveBannerBtn").text("Update");
				$("#banner_id").val(banner.id);
				$("#banner_text").val(banner.text);
				$("#banner_link").val(banner.link);

				if (banner.image) {
					$("#preview_img_tag").attr("src", banner.image);
					$("#preview_image").show();
				} else {
					$("#preview_img_tag").attr('src', '');
					$("#preview_image").hide();
				}

				$("#homeBannerModal").modal("show");
			});

			$(document).on("click", ".deleteBannerBtn", function () {
				let id = $(this).data("id");

				if (!confirm("Are you sure you want to delete this banner?")) return;

				$.ajax({
					url: "{{route('admin.home.banner.delete')}}",
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
						alert("Failed to delete banner");
					}
				});
			});
		} );
	</script>
@endsection