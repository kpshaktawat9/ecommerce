@extends('admin.layout')

@section('page-style')
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <h6 class="mb-0 text-uppercase">Products</h6>
        <button type="button" class="btn btn-primary" id="createProductBtn" data-bs-toggle="modal" data-bs-target="#ProductModal">
            Add Product
        </button>

        <!-- Product Modal -->
        <div class="modal fade" id="ProductModal" tabindex="-1" aria-labelledby="ProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="ProductForm" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="ProductModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body row">
                            <input type="hidden" id="product_id" name="id">

                            <!-- Basic info -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" id="product_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" name="slug" id="product_slug">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" id="product_sku">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Item Code</label>
                                <input type="text" class="form-control" name="item_code" id="product_item_code">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category_id" id="product_category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="attribute-section" class="mt-4">
                                <!-- Attributes will be dynamically loaded here -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Brand</label>
                                <select class="form-control" name="brand_id" id="product_brand_id">
                                    <option value="" disabled selected>Select Brand</option>
                                    @foreach($allBrands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax</label>
                                <select class="form-control" name="tex_id" id="product_tex_id">
                                    <option value="" disabled selected>Select Tax</option>
                                    @foreach($allTaxes as $tax)
                                    <option value="{{$tax->id}}">{{$tax->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Image</label>
                                <input type="file" class="form-control" name="image" id="product_image">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Extra Images</label>
                                <input type="file" class="form-control" name="images[]" id="product_images" multiple>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keywords</label>
                                <input type="text" class="form-control" name="keywords" id="product_keywords">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="product_description"></textarea>
                            </div>

                            <!-- Attributes -->
                            <div class="col-md-12">
                                <h6>Product Attributes</h6>
                                <table class="table table-bordered" id="productAttrTable">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>MRP</th>
                                            <th>Qty</th>
                                            <th>SKU</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attrBody">
                                        <tr>
                                            <td>
                                                <select name="attr_color_id[]" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($allColors as $color)
                                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="attr_size_id[]" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($allSizes as $size)
                                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" step="0.01" name="attr_price[]" class="form-control"></td>
                                            <td><input type="number" step="0.01" name="attr_mrp[]" class="form-control"></td>
                                            <td><input type="number" name="attr_qty[]" class="form-control"></td>
                                            <td><input type="text" name="attr_sku[]" class="form-control"></td>
                                            <td><input type="file" name="images[]" multiple></td>
                                            <td><button type="button" class="btn btn-sm btn-success addAttrRow">+</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveProductBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products table -->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ProductTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>SKU</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>{{ $product->brand->name ?? '-' }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary editProductBtn" data-product='@json($product)'>Edit</button>
                                    <button class="btn btn-sm btn-danger deleteProductBtn" data-id="{{ $product->id }}">Delete</button>
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
@endsection

@section('page-script')
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
$(document).ready(function() {

    // datatable
    var table = $('#ProductTable').DataTable({
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print']
    });
    table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

    // add row in attributes
    $(document).on("click", ".addAttrRow", function() {
        let row = `<tr>
            <td>
                <select name="attr_color_id[]" class="form-control">
                    <option value="">Select</option>
                    @foreach($allColors as $color)
                    <option value="{{$color->id}}">{{$color->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="attr_size_id[]" class="form-control">
                    <option value="">Select</option>
                    @foreach($allSizes as $size)
                    <option value="{{$size->id}}">{{$size->name}}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" step="0.01" name="attr_price[]" class="form-control"></td>
            <td><input type="number" step="0.01" name="attr_mrp[]" class="form-control"></td>
            <td><input type="number" name="attr_qty[]" class="form-control"></td>
            <td><input type="text" name="attr_sku[]" class="form-control"></td>
            <td><input type="file" name="images[]" multiple></td>
            <td><button type="button" class="btn btn-sm btn-danger removeAttrRow">x</button></td>
        </tr>`;
        $("#attrBody").append(row);
    });

    // remove row
    $(document).on("click", ".removeAttrRow", function() {
        $(this).closest("tr").remove();
    });

    // create product modal
    $("#createProductBtn").on("click", function() {
        $("#ProductModalLabel").text("Add Product");
        $("#saveProductBtn").text("Save");
        $("#ProductForm")[0].reset();
        $("#product_id").val("");
        $("#ProductModal").modal("show");
    });

    // form submit ajax
    $("#ProductForm").submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            data: data,
            processData: false,
            contentType: false,
            type: 'post',
            success: function(result) {
                sweetAlert('success', result.message);
                $("#ProductModal").modal("hide");
                location.reload();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            sweetAlert('error', message);
                        });
                    });
                } else {
                    sweetAlert('error', 'An unknown error occurred.');
                }
            }
        });
    });

    // delete
    $(document).on("click", ".deleteProductBtn", function() {
        let id = $(this).data("id");
        if (!confirm("Are you sure?")) return;
        $.post("{{ route('admin.product.delete') }}", {
            _token: "{{ csrf_token() }}",
            id: id
        }, function(res) {
            sweetAlert('success', res.message);
            location.reload();
        }).fail(function() {
            sweetAlert('error', 'Delete failed');
        });
    });

    $("#product_category_id").change(function(){
        var categoryId = $(this).val();
        if(!categoryId) return;

        $.ajax({
            url: "{{route('admin.category.get-attributes')}}",
            type: "POST",
            data:{
                _token: "{{csrf_token()}}",
                id: categoryId,
            },
            success: function(attributes) {
                $("#attribute-section").empty();

                attributes.forEach(function(catAttr) {
                    let attr = catAttr.attribute;
                    let values = attr.values;

                    let html = `<div class="mb-3">
                        <label>${attr.name}</label>
                        <select name="attributes[${attr.id}]" class="form-control" required>
                            <option value="">-- Select ${attr.name} --</option>`;
                    
                    values.forEach(function(val){
                        html += `<option value="${val.id}">${val.name}</option>`;
                    });

                    html += `</select></div>`;

                    $("#attribute-section").append(html);
                });
            }
        });
    });
});
</script>
@endsection
