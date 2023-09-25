<head>
  <title>Surat Penawaran {{$company->name}} {{$suratpenawaran->no_surat}}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
      background: #ccc;
      padding: 30px;
    }
    
    .container {
      width: 21cm;
      min-height: 29.7cm;
    }
    
    .invoice {
      background: #fff;
      width: 100%;
      padding: 50px;
    }
    
    .logo {
      width: 2.5cm;
    }
    
    .document-type {
      text-align: right;
      color: #444;
    }
    
    .conditions {
      font-size: 0.7em;
      color: #666;
    }
    
    .bottom-page {
      font-size: 0.7em;
    }
    hr{
      background-color: black !important;
      color: black !important;  
      opacity: 1;
      border-top: 1px solid black !important;
    }
    </style>
</head>
<div class="container">
    <div class="invoice">
      <div class="row">
        <div class="col-8">
          <div class="row">
            <div class="col-3">
              <img src="{{ asset($company->image_company) }}" class="logo">
            </div>
            <div class="col-9">
              <p>
                <strong>{{ $company->name }}</strong><br>
                {{$company->address}}<br>
                Phone : {{ $company->telp}}
              </p>
            </div>
          </div>
          
        </div>
        <div class="col-4">
        </div>
      </div>
        <hr>
      <p class="text-center">
        <u><b>Surat Penawaran Harga</b></u>
      </p>
      <div class="row">
        <div class="col-6">
          <p>
            <strong>Kepada</strong><br>
            {{  $suratpenawaran->name_customer}}<br>
            {{  $suratpenawaran->address_customer}}<br>
            {{  $suratpenawaran->phone_customer}}
          </p>
        </div>
        <div class="col-6">
          <p class="text-end">
            Surabaya, {{  $suratpenawaran->duedate}}<br>
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
            <p>Kami dari {{$company->name}} bermaksud memberikan penawaran harga barang dibawah ini:</p>
              <table class="table table-bordered my-0">
                <thead>
                  <tr>

                      <td><strong>No</strong></td>
                      <td><strong>Nama barang</strong></td>
                      <td><strong>Jumlah</strong></td>
                      <td><strong>Harga</strong></td>
                      <td><strong>Total</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <!-- foreach ($order->lineItems as $line) or some such thing here -->
                  <?php $subtotal = 0; ?>
                  @foreach($suratpenawaran->items as $item)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                        <td>{!! nl2br($item->description) !!}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="">@rupiah($item->item_price)</td>
                        <td class="">@rupiah($item->item_price * $item->qty)</td>
                    </tr>
                    <?php $subtotal += $item->item_price * $item->qty; ?>
                  @endforeach
            <tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td>@rupiah($subtotal)</td>
</tr>


                        </tbody>
              </table>
      </div>
      <br>
      <br>
      <p>
        Catatan Tambahan :<br>
        {!! nl2br($suratpenawaran->comment) !!}
      </p>
      <br>
      
      <div class="row my-4">
        <div class="col text-center">
        </div>
        <div class="col-6">
        </div>
        <div class="col text-center">
          Hormat kami,
          <br>
          <br>
          <br>
          <br>
          <br>
          <b>{{ $company->name }}</b>
        </div>
      </div>
      
      <br>
      <br>
      <br>
      <br>
    </div>
  </div>