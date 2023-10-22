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
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-add-image").click(function(){ 
            var lsthmtl = `<div class="hdtuto control-group lst input-group" style="margin-top:10px">
                <textarea name="description[]" placeholder="Product Name" cols="30" rows="4" class="myfrm form-control"></textarea>
                <input type="number" name="qty[]" placeholder="Quantity" class="myfrm form-control">
                <input type="number" name="item_price[]" placeholder="Item Price" min="1000" class="myfrm form-control">
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
