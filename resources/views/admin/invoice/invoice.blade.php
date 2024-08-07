@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produk</li>
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
                <a href="{{ route('invoice.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> tambah invoice</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Name Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Profit</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $total = count($invoices); ?>
                    @foreach ($invoices as $item)
                    <tr>
                        <td>{{ $total }}</td>
                        <td>{{ $item->no_invoice }}</td>
                        <td>{{ $item->name_customer }}</td>
                        <td>{{ $item->duedate }}</td>
                        <td>@rupiah($item->total - ($item->diskon_rate) + ($item->tax_rate*$item->total/100))</td>
                        <td>@rupiah($item->profit)</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('print_invoice',$item->id) }}" target="_blank"><span class="fas fa-eye"></span></a>
                            <a class="btn btn-warning" href="{{ route('surat_jalan',$item->id) }}" target="_blank"><span class="fas fa-eye"></span></a>
                            <a class="btn btn-primary" href="{{ route('invoice.edit',$item->id) }}"><span class="fas fa-edit"></span></a>
                            <button class="btn btn-danger" onclick="modaldelete({{ $item->id }})"><span class="fas fa-trash"></span></button>
                            {{-- <a class="btn btn-primary" href="{{ route('produk.edit',$item->id) }}"><span class="fas fa-edit"></span></a>
                            <button class="btn btn-danger" onclick="modaldelete({{ $item->id }})"><span class="fas fa-trash"></span></button> --}}
                        </td>
                    </tr>
                    <?php $total--; ?>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                    <th>No Invoice</th>
                    <th>Name Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Profit</th>
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
        <form action="{{ route('invoice.destroy', ':id') }}" method="POST" class="delete-form">
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