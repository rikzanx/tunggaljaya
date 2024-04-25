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
                <h3 class="card-title">Edit Invoice</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('deletedinvoice.update',$invoice->id) }}" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal</label>
                    <input type="date" name="duedate" class="form-control" id="exampleInputEmail1" value="{{ \Carbon\Carbon::parse($invoice->duedate)->format("Y-m-d") }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Customer</label>
                    <input type="text" value="{{ $invoice->name_customer }}" name="name_customer" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address Customer</label>
                    <input type="text" value="{{ $invoice->address_customer }}" name="address_customer" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Customer</label>
                    <input type="text" value="{{ $invoice->phone_customer }}" name="phone_customer" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Catatan tambahan</label>
                    <input type="text" value="{{ $invoice->comment }}" name="comment" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputFile">Items</label>
                  </div>
                  <div class="input-group control-group lst increment" >
                  @foreach($invoice->items as $item)
                    @if($loop->index == 0)
                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                        <input value="{{ $item->description }}" type="text" name="description[]" placeholder="Nama Barang" class="myfrm form-control">
                        <input value="{{ $item->qty }}" type="number" name="qty[]" placeholder="Jumlah" class="myfrm form-control">
                        <input value="{{ $item->item_price }}" type="number" name="item_price[]" placeholder="Harga Barang" min="1000" class="myfrm form-control">
                        <div class="input-group-btn"> 
                          <button class="btn btn-success btn-add-image" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                        </div>
                      </div>
                    @else
                      <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                        <input value="{{ $item->description }}" type="text" name="description[]" placeholder="Nama Barang" class="myfrm form-control">
                        <input value="{{ $item->qty }}" type="number" name="qty[]" placeholder="Jumlah" class="myfrm form-control">
                        <input value="{{ $item->item_price }}" type="number" name="item_price[]" placeholder="Harga Barang" min="1000" class="myfrm form-control">
                        <div class="input-group-btn"> 
                          <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                        </div>
                      </div>
                    @endif
                  @endforeach
                </div>
                  <br>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Diskon (%)</label>
                    <input type="number" value="{{ $invoice->diskon_rate }}" name="diskon_rate" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Pajak (%)</label>
                    <input type="number" value="{{ $invoice->tax_rate }}" name="tax_rate" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Profit</label>
                    <input type="number" value="{{ $invoice->profit }}" name="profit" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama customer">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
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
@endsection

@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-add-image").click(function(){ 
        var lsthmtl = `<div class="hdtuto control-group lst input-group" style="margin-top:10px">
                      <input type="text" name="description[]" placeholder="Nama Barang" class="myfrm form-control">
                      <input type="number" name="qty[]" placeholder="Jumlah" class="myfrm form-control">
                      <input type="number" name="item_price[]" placeholder="Harga Barang" min="1000" class="myfrm form-control">
                      <div class="input-group-btn"> 
                        <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                      </div>
                    </div>`;
        $(".increment").after(lsthmtl);
    });
    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".hdtuto").remove();
    });
  });
</script>
@endsection