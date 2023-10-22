<head>
  <title>Invoice {{$invoice->no_invoice}} {{$company->name}}</title>
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
      border-top: 1px solid black !important;
    }
    </style>
</head>
<div class="container">
    <div class="invoice">
      <div class="row">
        <div class="col-6">
            <h2>Invoice</h2>
        </div>
        <div class="col-6">
            <p class="text-end">Order #{{ $invoice->no_invoice }} <br> Date: {{ $date_inv }}</p>
            {{-- <p class="text-end">Date: {{ $date_inv }}</p> --}}
        </div>
      </div>
        <hr>
      <div class="row">
        <div class="col-6">
          <img src="{{ asset($company->image_company) }}" class="logo">
          <p>
            <strong>{{ $company->name }}</strong><br>
            {{$company->address}}<br>
            Phone : {{ $company->telp}}
          </p>
        </div>
        <div class="col-6">
          <p class="text-end">
	    
            <strong>Kepada</strong><br>
            {{  $invoice->name_customer}}<br>
            {{  $invoice->address_customer}}<br>
            {{  $invoice->phone_customer}}
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
            <strong>Order</strong>
            </div>
            <div class="card-body mx-0 my-0 px-0 py-0">
              <table class="table my-0">
                <thead>
                  <tr>
                      <td><strong>Nama barang</strong></td>
                      <td class="text-center"><strong>Harga</strong></td>
                      <td class="text-center"><strong>Jumlah</strong></td>
                      <td class="text-right"><strong>Total</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <!-- foreach ($order->lineItems as $line) or some such thing here -->
                  <?php $subtotal = 0; ?>
                  @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">@rupiah($item->item_price)</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-right">@rupiah($item->total)</td>
                    </tr>
                    <?php $subtotal += $item->item_price * $item->qty; ?>
                  @endforeach
                  <tr>
                    <td class="thick-line"></td>
                    <td class="thick-line"></td>
                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                    <td class="thick-line text-right">@rupiah($subtotal)</td>
                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>Diskon</strong></td>
                    <td class="no-line text-right">@rupiah($invoice->diskon_rate) ({{ number_format(($invoice->diskon_rate/$subtotal)*100,1) }}%)</td>
                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>Total</strong></td>
                    <td class="no-line text-right">@rupiah($subtotal-($invoice->diskon_rate))</td>
                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>DP</strong></td>
                    <td class="no-line text-right">@rupiah($invoice->dp)</td>
                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>Sisa Pembayaran</strong></td>
                    <td class="no-line text-right">@rupiah(($subtotal-($invoice->diskon_rate))-$invoice->dp)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row my-4">
        <div class="col">
        <p class="conditions">
        <br>
        <strong>Catatan Tambahan :</strong><br>
      {!! nl2br($invoice->comment) !!}
      </p>
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
          <b>{{$company->name}}</b>
        </div>
      </div>
      
      <br>
      <br>
      <br>
      <br>
      
      {{-- <p class="bottom-page text-right">
        90TECH SAS - N° SIRET 80897753200015 RCS METZ<br>
        6B, Rue aux Saussaies des Dames - 57950 MONTIGNY-LES-METZ 03 55 80 42 62 - www.90tech.fr<br>
        Code APE 6201Z - N° TVA Intracom. FR 77 808977532<br>
        IBAN FR76 1470 7034 0031 4211 7882 825 - SWIFT CCBPFRPPMTZ
      </p> --}}
    </div>
  </div>
