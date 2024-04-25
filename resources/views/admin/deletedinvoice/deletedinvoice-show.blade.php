<head>
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
    </style>
</head>
<div class="container">
    <div class="invoice">
      <div class="row">
        <div class="col-7">
          <img src="{{ asset($company->image_company) }}" class="logo">
          <p>
            <strong>{{ $company->name }}</strong><br>
            {{$company->address}}<br>
            Phone : {{ $company->telp}}
          </p>
        </div>
        <div class="col-5">
          <h1 class="document-type display-4">INVOICE</h1>
          <p class="text-end"><strong>No: {{ $invoice->no_invoice }}</strong></p>
        </div>
      </div>
      <div class="row">
        <div class="col-7">
          <p>
            <strong>Bill to</strong><br>
            {{  $invoice->name_customer}}<br>
            {{  $invoice->address_customer}}<br>
            {{  $invoice->phone_customer}}
          </p>
        </div>
        {{-- <div class="col-5">
          <p>
            <strong>Energies54</strong><br>
            Réf. Client <em>C00022</em><br>
            12 Rue de Verdun<br>
            54250 JARNY
          </p>
        </div> --}}
      </div>
      <br>
      {{-- <h6>Audits et rapports mensuels (1er Novembre 2016 - 30 Novembre 2016)</h6> --}}
      <br>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Item Price</th>
            <th>Total amount</th>
          </tr>
        </thead>
        <tbody>
          <?php $subtotal = 0; ?>
          @foreach($invoice->items as $item)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->qty }}</td>
                <td class="text-right">@rupiah($item->item_price)</td>
                <td class="text-right">@rupiah($item->item_price * $item->qty)</td>
            </tr>
            <?php $subtotal += $item->item_price * $item->qty; ?>
          @endforeach
        </tbody>
      </table>
      <div class="row">
        <div class="col-8">
        </div>
        <div class="col-4">
          <table class="table table-sm text-right">
            <tr>
              <td><strong>Subtotal</strong></td>
              <td class="text-right">@rupiah($subtotal)</td>
            </tr>
            <tr>
              <td>Diskon</td>
              <td class="text-right">@rupiah($subtotal*$invoice->diskon_rate) ({{ $invoice->diskon_rate }}%)</td>
            </tr>
            <tr>
              <td><strong>Total</strong></td>
              <td class="text-right">@rupiah($subtotal-($subtotal*$invoice->diskon_rate))</td>
            </tr>
          </table>
        </div>
      </div>
      
      <p class="conditions">
        <strong>Catatan Tambahan :</strong><br>
        {{ $invoice->comment }}
      </p>
      
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