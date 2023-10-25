@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Profil Perusahaan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profil</li>
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
                <h3 class="card-title">Ubah Profil Perusahaan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('perusahaan.update',$company->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Perusahaan</label>
                    <input type="text" name="name" value="{{ $company->name }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Logo Perusahaan</label>
                    <p>
                        <img src="{{ asset($company->image_company) }}" alt="" style="height: 150px;">
                    </p>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="image_company" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Ganti foto</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Tentang perusahaan</label>
                    <textarea id="about" name="about" class="form-control" rows="3" placeholder="Enter ...">{{ $company->about }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alamat Perusahaan</label>
                    <input type="text" name="address" value="{{ $company->address }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Telp Perusahaan</label>
                    <input type="text" name="telp" value="{{ $company->telp }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Perusahaan</label>
                    <input type="email" name="email" value="{{ $company->email }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Latitude</label>
                    <input type="text" name="lat" value="{{ $company->lat }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Longitude</label>
                    <input type="text" name="lng" value="{{ $company->lng }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-success">Ubah</button>
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
@endsection