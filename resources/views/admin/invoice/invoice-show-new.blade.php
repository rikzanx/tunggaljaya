<head>
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
      height: 2.5cm;
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
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order #{{ $invoice->no_invoice }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
              <div>
                <img src="{{ asset($company->image_company) }}" class="logo">
              </div>
    				<strong>{{ $company->name }}</strong><br>
            {{$company->address}}<br>
            Email : {{ $company->email}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Kepada:</strong><br>
    					{{  $invoice->name_customer}}<br>
              {{  $invoice->address_customer}}<br>
              {{  $invoice->phone_customer}}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			{{-- <div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					Visa ending **** 4242<br>
    					jsmith@email.com
    				</address>
    			</div> --}}
    			<div class="col-xs-6">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ $date_inv }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
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
                        <td class="text-right">@rupiah($item->item_price * $item->qty)</td>
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
    								<td class="no-line text-right">@rupiah($subtotal*$invoice->diskon_rate/100) ({{ $invoice->diskon_rate }}%)</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">@rupiah($subtotal-($subtotal*$invoice->diskon_rate/100))</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>