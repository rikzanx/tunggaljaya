@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pelanggan</li>
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
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Lihat Pelanggan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('customer.update',$customer->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Pelanggan</label>
                    <input type="text" name="name" value="{{ $customer->name }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alamat Kategori</label>
                    <input type="text" name="address" value="{{ $customer->address }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Pelanggan</label>
                    <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Pelanggan</label>
                    <input type="text" name="email" value="{{ $customer->email }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Daftar Invoice Pelanggan</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>No Invoice</th>
                        <th>Tanggal Invoice</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($customer->invoices as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_invoice }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                          <a class="btn btn-success" href="{{ route('print_invoice',$item->id) }}" target="_blank"><span class="fas fa-eye"></span></a>
                          <a class="btn btn-warning" href="{{ route('surat_jalan',$item->id) }}" target="_blank"><span class="fas fa-eye"></span></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                </div>
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
@endsection

@section('js')
    
@endsection