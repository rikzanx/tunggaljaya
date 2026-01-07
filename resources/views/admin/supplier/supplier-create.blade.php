@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - List Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Supplier</li>
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
                <h3 class="card-title">Create Supplier</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Supplier</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama pelanggan">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alamat Supplier</label>
                    <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Masukkan alamat pelanggan">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">No HP Supplier</label>
                    <input type="text" name="phone" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nomor HP pelanggan">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Supplier</label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Masukkan email pelanggan kalo ada">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-success">Tambah</button>
                </div>
              </form>
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