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
            var type = "{{ $type }}";
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



            // View functionality
            $(document).on('click', '.view', function() {

                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.blog.show') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Create a modal to display the blog details
                        var modal = `
            <div class="modal fade" id="viewBlogModal" tabindex="-1" role="dialog" aria-labelledby="viewBlogModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewBlogModalLabel">${type} Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="https://bestdreamcar.com/frontend/assets/images/blog/${response.img}" class="img-fluid" alt="Blog Image">
                                </div>
                                <div class="col-md-8">
                                    <h3>${response.title}</h3>
                                    <p><strong>Category:</strong> ${response.category_name}</p>
                                    <p><strong>Sub Category:</strong> ${response.sub_category_name}</p>
                                    <p><strong>Status:</strong> ${response.status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}</p>
                                    <p><strong>Created At:</strong> ${response.created_at}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h4>Description</h4>
                                    <div>${response.description}</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            `;

                        $('body').append(modal);
                        $('#viewBlogModal').modal('show');

                        // Remove modal on close
                        $('#viewBlogModal').on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr) {
                        toastr.error('Error fetching blog details');
                    }
                });
            });

            // Edit functionality
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.blog.edit') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Populate the edit modal with data
                        $('#blogssAddModal').modal('show');
                        $('#blogssAddModal .modal-title').text('Edit Blog');
                        $('select[name="category_id"]').val(response.category_id).trigger(
                            'change');
                        $('select[name="sub_category_id"]').val(response.sub_category_id)
                            .trigger('change');
                        $('input[name="title"]').val(response.title);
                        $('textarea[name="sub_title"]').val(response.sub_title);
                        $('#summernote').summernote('code', response.description);
                        $('input[name="seo_description"]').val(response.seo_description);
                        $('#keywords').val(response.seo_keywords);
                        $('input[name="hashKeyword"]').val(response.hashKeyword);
                        $('input[name="status"][value="' + response.status + '"]').prop(
                            'checked', true);

                        // Change the save button to update
                        $('#blogssAddModal .btn-primary').text('Update').off('click').on(
                            'click',
                            function() {
                                updateBlog(id);
                            });
                    },
                    error: function(xhr) {
                        toastr.error('Error fetching blog details');
                    }
                });
            });

            function updateBlog(id) {
                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('id', id);
                formData.append('category_id', $('select[name="category_id"]').val());
                formData.append('sub_category_id', $('select[name="sub_category_id"]').val());
                formData.append('title', $('input[name="title"]').val());
                formData.append('sub_title', $('textarea[name="sub_title"]').val());
                formData.append('description', $('#summernote').summernote('code'));
                formData.append('seo_description', $('input[name="seo_description"]').val());
                formData.append('seo_keywords', $('#keywords').val());
                formData.append('hashKeyword', $('input[name="hashKeyword"]').val());
                formData.append('status', $('input[name="status"]:checked').val());

                let imageFile = $('input[name="image"]')[0].files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: "{{ route('admin.blog.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message);
                            $('#blogssAddModal').modal('hide');
                            $('#data-table').DataTable().draw(false);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    }
                });
            }

            // Status toggle functionality
            $(document).on('click', '.status-toggle', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus ? 0 : 1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to " + (newStatus ? "activate" : "deactivate") + " this blog?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.blog.status') }}",
                            type: "POST",
                            data: {
                                id: id,
                                status: newStatus,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(response.message);
                                    $('#data-table').DataTable().draw(false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Error updating status');
                            }
                        });
                    }
                });
            });

            // Delete functionality
            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.blog.destroy') }}",
                            type: "DELETE",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(response.message);
                                    $('#data-table').DataTable().draw(false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Error deleting blog');
                            }
                        });
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
