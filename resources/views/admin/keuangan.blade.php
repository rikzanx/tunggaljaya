@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Keuangan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Keuangan</li>
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
                <a href="{{ route('keuangan.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> tambah transaksi</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p>Saldo: @rupiahonly($saldo)</p>
                <p>Total Pemasukan: @rupiahonly($sumPemasukan)</p>
                <p>Total Pengeluaran: @rupiahonly($sumPengeluaran)</p>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah</th>
                    <th>Tipe</th>
                    <!-- <th>Balance After</th> -->
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($keuangan as $item)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}</td> <!-- Menambahkan tanggal transaksi -->
                        <td>@if ($item->tipe == "pemasukan")
                            @rupiahonly($item->amount)
                            @else
                                <span class="text-danger">-@rupiahonly(abs($item->amount))</span>
                            @endif
                        </td>
                        {{-- <td>{{ $item->tipe }}</td> --}}
                        <td>
                          <div class="d-inline-flex mb-3 px-2 py-1 <?php echo ($item->tipe == "pemasukan")?"bg-success":"bg-danger"; ?>" role="alert">
                            <?php echo $item->tipe;?>
                          </div>
                        </td>
                        <!-- <td>@rupiahonly($item->balance_after)</td> -->
                        <!-- <td>{{ $item->description }}</td> -->
                        <td>{!! $item->description !!}</td>
                        <td>
                          <!-- <a class="btn btn-primary" href="{{ route('keuangan.edit',$item->id) }}"><span class="fas fa-edit"></span></a> -->
                            <!-- <a class="btn btn-success" href="{{ route('keuangan.show',$item->id) }}" target="_blank"><span class="fas fa-eye"></span></a> -->
                            <button class="btn btn-danger" onclick="modaldelete({{ $item->id }})"><span class="fas fa-trash"></span></button>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Tanggal Transaksi</th>
                      <th>Jumlah</th>
                      <th>Tipe</th>
                      <!-- <th>Balance After</th> -->
                      <th>Deskripsi</th>
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
        <form action="{{ route('keuangan.destroy', ':id') }}" method="POST" class="delete-form">
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
        "responsive": true, 
        "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "initComplete": function () {
            this.api().columns(2).every(function () {
                var column = this;
                var sum = column.data().reduce(function (a, b) {
                    var number = parseFloat(b.replace(/[^\d.-]/g, ''));
                    return a + number;
                }, 0);
                $(column.footer()).html('Total: ' + sum);
            });
        },
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