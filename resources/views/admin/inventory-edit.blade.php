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
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Inventory Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('inventories.update', $inventory->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PATCH")
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SKU</label>
                                        <input type="text" name="sku" class="form-control" id="exampleInputEmail1" value="{{ $inventory->sku }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" value="{{ $inventory->name }}" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter the name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Qty</label>
                                        <input type="number" value="{{ $inventory->qty }}" name="qty" class="form-control" id="exampleInputEmail1" placeholder="Enter the quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <input type="text" value="{{ $inventory->description }}" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter the description">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Lokasi</label>
                                        <input type="text" value="{{ $inventory->lokasi }}" name="lokasi" class="form-control" id="exampleInputEmail1" placeholder="Enter the location">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload/Ganti Foto Produk Baru</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-group lst input-group" style="margin-top:10px">
                                            @foreach($inventory->images as $item)
                                            <div class="input-group-btn"> 
                                            <img src="{{ asset($item->image_inventory) }}" width="200" alt="">
                                            <button class="btn btn-danger" type="button" onclick="modaldelete({{ $item->id }})"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                            @endforeach
                                        </div>
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
                                            <button class="btn btn-danger btn-hapus" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-success">Update</button>
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
          <form action="{{ route('delete_image_inventory', ':id') }}" method="POST" class="delete-form">
              @csrf
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
<script type="text/javascript">
  function modaldelete(id){
        // alert(id);
        var url = $('.delete-form').attr('action');
        $('.delete-form').attr('action',url.replace(':id',id));
        $('#modal-default').modal('show');
  }
  $(document).ready(function() {
    $(".btn-add-image").click(function(){ 
        var lsthmtl = $(".clone").html();
        $(".increment").after(lsthmtl);
    });
    $("body").on("click",".btn-hapus",function(){ 
        $(this).parents(".hdtuto").remove();
    });
  });
</script>
@endsection
