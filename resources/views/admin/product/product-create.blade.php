@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.name', 'Laravel') }} - Produk</h1>
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
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Produk</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve">
                  </div>
                  <div class="form-group">
                    <label>Kategori Produk</label>
                    <select class="form-control" name="category_id">
                      @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Material Produk</label> --}}
                    <input type="hidden" name="material" class="form-control" id="exampleInputEmail1" placeholder="Cast Iron,Carbon Steel, Steinless Steel" value="Cast Iron,Carbon Steel, Steinless Steel">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Size Produk</label>
                    <input type="text" name="size" class="form-control" id="exampleInputEmail1" placeholder="2,3,4,5,6,8,10" value="2,3,4,5,6,8,10">
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Rating Produk</label> --}}
                    <input type="hidden" name="rating" class="form-control" id="exampleInputEmail1" placeholder="jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600" value="jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600">
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Connection Produk</label> --}}
                    <input type="hidden" name="connection" class="form-control" id="exampleInputEmail1" placeholder="flange-end, screw" value="flange-end, screw">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Brand Produk</label>
                    <input type="text" name="brand" class="form-control" id="exampleInputEmail1" placeholder="Kitz, GLT, Toyo dll." value="Kitz, GLT, Toyo dll.">
                  </div>
                  <div class="form-group">
                    <label>Deskripsi produk</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Foto Produk</label>
                  </div>
                  <div class="input-group hdtuto control-group lst increment" >
                    <input type="file" name="filenames[]" class="myfrm form-control">
                    <div class="input-group-btn"> 
                      <button class="btn btn-success btn-add-image" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                    </div>
                  </div>
                  <div class="clone hide">
                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                      <input type="file" name="filenames[]" class="myfrm form-control">
                      <div class="input-group-btn"> 
                        <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                      </div>
                    </div>
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
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-add-image").click(function(){ 
        var lsthmtl = $(".clone").html();
        $(".increment").after(lsthmtl);
    });
    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".hdtuto").remove();
    });
  });
</script>
@endsection