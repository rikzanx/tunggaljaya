@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Prospect</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Prospect</li>
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
                <h3 class="card-title">Edit Prospect</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('prospect.update',$prospect->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Prospect</label>
                    <input type="text" name="name" value="{{ $prospect->name }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alamat Kategori</label>
                    <input type="text" name="address" value="{{ $prospect->address }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Prospect</label>
                    <input type="text" name="phone" value="{{ $prospect->phone }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Prospect</label>
                    <input type="text" name="email" value="{{ $prospect->email }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status Prospect</label>
                    <input type="text" name="status" value="{{ $prospect->status }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-primary">Ganti</button>
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