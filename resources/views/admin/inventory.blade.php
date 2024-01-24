@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ config('app.name', 'Laravel') }} - Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Inventory</li>
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
                                <a href="{{ route('inventories.create') }}" class="btn btn-success">
                                    <span class="fas fa-plus"></span> Tambah inventory item
                                </a>
                                <button onclick="modalimportcsv()" class="btn btn-primary"><span class="fas fa-plus"></span> Import From CSV</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Lokasi</th>
                                        <th>Qty</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventories as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            @if(count($item->images) > 0)
                                            <a href="{{ asset($item->images[0]->image_inventory) }}" data-toggle="lightbox" data-title="{{ $item->name }}">
                                                <img src="{{ asset($item->images[0]->image_inventory) }}" style="width: 100px;height:100px;" alt="" srcset="">
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('inventories.edit', $item->id) }}">
                                                <span class="fas fa-edit"></span>
                                            </a>
                                            <button class="btn btn-danger" onclick="modaldelete({{ $item->id }})">
                                                <span class="fas fa-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Lokasi</th>
                                        <th>Qty</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Peringatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus data ini&hellip;</p>
                </div>
                <form action="{{ route('inventories.destroy', ':id') }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- Modal -->
    <div class="modal fade" id="modal-importcsv">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import CSV</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('import.csv-inventories') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
            <div class="modal-body">
                <p>
                Download CSV Template untuk upload
                </p>
                <input type="file" vlass="form-control" id="fileInput" name="file" accept=".csv" required>
                <div id="dataDisplay"></div>
            </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-button">Import</button>
                </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('js')
@if (session()->has('status'))
    <script>
        $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Info',
            subtitle: '',
            body: '{{ session()->get("status") }}'
        })
    </script>
@endif
<!-- Page specific script -->
<script>
    function modalimportcsv(){
      $('#modal-importcsv').modal('show');
    }
    function modaldelete(id){
        // alert(id);
        var url = $('.delete-form').attr('action');
        $('.delete-form').attr('action',url.replace(':id',id));
        $('#modal-default').modal('show');
    }
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection
