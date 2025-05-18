@extends('Admin.Layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <table class="table table-bordered table-striped table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Stock</th>
                                <th>VIN</th>
                                <th>Year</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Dealer</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Listing Date</th>
                                <th>Active Start</th>
                                <th>Active End</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->



          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
<script>
$(function() {
    $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.inventory') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'stock', name: 'stock' },
            { data: 'vin', name: 'vin' },
            { data: 'year', name: 'year' },
            { data: 'make', name: 'make' },
            { data: 'model', name: 'model' },
            { data: 'admin_name', name: 'admin_name' },
            { data: 'admin_city', name: 'admin_city' },
            { data: 'admin_state', name: 'admin_state' },
            { data: 'created_date', name: 'created_date' },
            { data: 'created_at', name: 'created_at' },
            { data: 'active_till', name: 'active_till' },
            { data: 'package', name: 'package' },
            { data: 'inventory_status', name: 'inventory_status' },
            { data: 'is_visibility', name: 'is_visibility' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
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