@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $type }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $type }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $type }} List</h3>
                            <a href="" class="float-right btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#blogssAddModal"> <i class="fas fa-plus-circle"></i> Add
                                {{ $type }}</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Create Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- create modal start here  --}}
    <div class="modal fade" id="blogssAddModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create {{ $type }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select2bs4" name="category_id" style="width: 100%;">
                                    <option>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Category</label>
                                <select class="form-control select2bs4" name="sub_category_id" style="width: 100%;">
                                    <option>Select Sub-Category</option>
                                    @foreach ($sub_categories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sub Title</label>
                                <textarea name="sub_title" class="form-control" style="width: 100%;" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" style="width: 100%;" id="summernote" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>SEO Description</label>
                                <input type="text" name="seo_description" class="form-control" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>SEO Keywoords</label>
                                <input type="text" id="keywords" name="seo_description" class="form-control"
                                    style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Hash Keywoords</label>
                                <input type="text" name="hashKeyword" class="form-control" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Status</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" name="status" checked value="1">
                                    <label for="radioPrimary1">Active
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" name="status" value="0">
                                    <label for="radioPrimary2">Inactive
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label>Status</label>

                                <input type="radio" name="staus"> Active
                                <input type="radio" name="staus"> Inactive
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- create modal end here  --}}
@endsection



@push('scripts')
    <script>
        $(function() {
            $('#summernote').summernote();
            // Initialize Select2
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // });

            // create form submition start here
            // Handle save button click
            $('.modal-footer .btn-primary').click(function() {
                // Collect form data
                let formData = new FormData();

                // Add all form fields to FormData
                formData.append('category_id', $('select[name="category_id"]').val());
                formData.append('sub_category_id', $('select[name="sub_category_id"]').val());
                formData.append('title', $('input[name="title"]').val());
                formData.append('sub_title', $('textarea[name="sub_title"]').val());
                formData.append('description', $('#summernote').summernote('code'));
                formData.append('seo_description', $('input[name="seo_description"]').val());
                formData.append('seo_keywords', $('#keywords').val());
                formData.append('hashKeyword', $('input[name="hashKeyword"]').val());
                formData.append('status', $('input[name="status"]:checked').val() === 'on' ? '1' :
                    '0');

                // Add file if selected
                let imageFile = $('input[name="image"]')[0].files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                // Add CSRF token for Laravel
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                var url = "{{ route('admin.blog.store') }}"

                // Send AJAX request
                $.ajax({
                    url: url, // Update this to your actual endpoint
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success
                        console.log(response);
                        if (response.status === "success") { // Check if status equals "success"
                            toastr.success(response.message);
                            $('#blogssAddModal').modal('hide');
                            // Optionally refresh the page or update the table
                            // location.reload();
                            $('#data-table').DataTable().draw(false);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Handle errors
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    }
                });
            });

            // data table code start here
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route($route) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'img',
                        name: 'blogs.img',
                        render: function(data) {
                            return data ?
                                '<img src="https://bestdreamcar.com/frontend/assets/images/blog/' +
                                data + '" width="50">' : 'No Image';
                        }
                    },
                    {
                        data: 'title',
                        name: 'blogs.title'
                    },
                    {
                        data: 'created_at',
                        name: 'blogs.created_at'
                    },
                    {
                        data: 'status',
                        name: 'blogs.status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });
        });
    </script>
@endpush
