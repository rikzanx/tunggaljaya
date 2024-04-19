@extends('admin.layouts.app')

@section('css')
    
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ config('app.name', 'Laravel') }} - Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1 - {{ config('app.name', 'Laravel') }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p style="font-size:2vw !important;">{{ count($products) }}</p>
                <p style="font-size:2vw !important;">Jumlah Produk</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('produk.index') }}" class="small-box-footer" style="font-size:2vw !important;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <p style="font-size:2vw !important;">{{ count($categories) }}</p>
                <p style="font-size:2vw !important;">Kategori Product</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a style="font-size:2vw !important;" href="{{ route('kategori.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <p style="font-size:2vw !important;">{{ count($images_slider) }}</p>
                <p style="font-size:2vw !important;">Foto Slider</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a style="font-size:2vw !important;" href="{{ route('slider.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <p style="font-size:2vw !important;">{{ count($images_slider) }}</p>
                <p style="font-size:2vw !important;">Foto Slider</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a style="font-size:2vw !important;" href="{{ route('slider.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- Total Bulan ini -->
          <div class="col-12">
            <h4>Bulan ini</h4>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <p style="font-size:2vw !important;">{{ count($invoicesMonth) }}</p>
                    <p style="font-size:2vw !important;">Orderan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cart"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <p style="font-size:2vw !important;">@rupiah($invoicesMonth->sum("profit"))</p>
                    <p style="font-size:2vw !important;">Profit</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cart"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <p style="font-size:2vw !important;">@rupiah($itemsMonth->sum("total"))</p>
                    <p style="font-size:2vw !important;">Omset</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cash"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <p style="font-size:2vw !important;">{{ $itemsMonth->sum("qty") }}</p>
                    <p style="font-size:2vw !important;">Barang Terjual</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-briefcase"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('item.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <!-- /. End Total bulan ini -->
          <!-- Total Keseluruhan -->
          <div class="col-12">
            <h4>Keseluruhan</h4>
          </div>

          <div class="col-12">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <p style="font-size:2vw !important;">{{ count($invoices) }}</p>
                    <p style="font-size:2vw !important;">Orderan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cart"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <p style="font-size:2vw !important;">@rupiah($invoices->sum("profit"))</p>
                    <p style="font-size:2vw !important;">Profit</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cart"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <p style="font-size:2vw !important;">@rupiah($items->sum("total"))</p>
                    <p style="font-size:2vw !important;">Omset</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-cash"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('invoice.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <p style="font-size:2vw !important;">{{ $items->sum("qty") }}</p>
                    <p style="font-size:2vw !important;">Barang Terjual</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-briefcase"></i>
                  </div>
                  <a style="font-size:2vw !important;" href="{{ route('item.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <!-- /. End Total Keseluruhan -->

          <!-- Chart -->
          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div> 
          </div>
          <!-- ./ EndChart -->
        </div>
      </div><!-- /.container-fluid -->
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
        console.log("status");
    </script>
@endif

<script>
    var areaChartData = {
      labels  : <?php echo $month_js;?>,
      datasets: [
        {
          label               : 'Omset',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo $omset_js;?>,
        },
        {
          label               : 'Profit',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : <?php echo $profit_js;?>
        },
      ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

</script>
    
@endsection