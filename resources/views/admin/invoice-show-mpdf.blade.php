<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Invoice {{$invoice->no_invoice}} {{$company->name}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            body {  font-size: 14px;}
			.tbl-bordered { border: 1px solid #000; border-top: none; border-left: none; }
			.tbl-bordered td, .tbl-bordered th { border: 1px solid #000; border-right: none; border-bottom: none; }
			.tbl-bordered th { text-align: center; font-weight: bold; }
			.tbl-bordered td table td { border: none; }
			h1 { font-size: 16px; }
            h1.page-title {
                font-size: 28px;
                padding: 15px;
                border: 2px solid #333;
                text-transform: uppercase;
            }
			/* Apply page break if tbl-tandatangan exceeds A4 size */
			.tbl-tandatangan {
				page-break-before: always;
			}
        </style>
    </head>
	<body>
		<table width="750" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="17%" valign="middle" align="center">
					<img src="{{ asset($company->image_company) }}" height="80px" />
				</td>
				<td align="left">
					<h1>&nbsp;&nbsp;{{ $company->name }}</h1>
					<!-- <p style="font-size: 11px;">&nbsp;&nbsp;Jalan Semarang 104 A No. 23</p> -->
					<p style="font-size: 12px;">&nbsp;&nbsp;{{$company->address}}</p>
					<p style="font-size: 12px;">&nbsp;&nbsp;Phone : {{ $company->telp}}</p>
				</td>
				<td width="40%" valign="middle" align="center">
					<h1 class="page-title">&nbsp;&nbsp;Invoice&nbsp;&nbsp;</h1>
				</td>
			</tr>
		</table>
		<hr style="height: 3px; margin-bottom: 2px;" />
		<hr style="margin-top: 0px; margin-bottom: 0px;" /><br/><br/>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="155"><b>Kepada</b></td>
                <td width="10"></td>
                <td width="210"></td>
                <td width="100"><b>No Invoice</b></td>
                <td width="10">:</td>
                <td>{{ $invoice->no_invoice }}</td>
            </tr>
            <tr valign="top">
                <td colspan="3">{{$invoice->name_customer}}</td>
                <td width="100"><b>Tanggal</b></td>
                <td width="10">:</td>
                <td>{{ $date_inv }}</td>
            </tr>
			<tr valign="top">
                <td colspan="3">{{  $invoice->address_customer}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
			<tr valign="top">
                <td colspan="3">{{  $invoice->phone_customer}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
		<br/>
		<table class="tbl-bordered" border="0" cellpadding="3" cellspacing="0">
			<thead>
				<tr>
					<th width="40">NO.</th>
					<th width="220">NAMA BARANG</th>
					<th width="90">JUMLAH</th>
					<th width="160">HARGA</th>
					<th width="160">TOTAL</th>
				</tr>
			</thead>
			<tbody>
			<?php $nomer = 0; $total = 0;$subtotal = 0; foreach($invoice->items as $item) { $nomer++; $total += floatval($item->total);$subtotal += floatval($item->total); ?>
				<tr valign="top">
					<td style="text-align: right;"><?php echo $nomer; ?></td>
					<td>{{ $item->description }}</td>
					<td align="center">{{ $item->qty }}</td>
					<td align="right" style="text-align: right;">@rupiah($item->item_price)</td>
					<td align="right" style="text-align: right;">@rupiah($item->total)</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" style="text-align: right;">Sub Total</th>
					<th style="text-align: right;">@rupiah($subtotal)</th>
				</tr>
				<tr>
					<th colspan="4" style="text-align: right;">Diskon</th>
					<th style="text-align: right;">@rupiah($invoice->diskon_rate) ({{ number_format(($invoice->diskon_rate/$subtotal)*100,1) }}%)</th>
				</tr>
				<tr>
					<th colspan="4" style="text-align: right;">Total</th>
					<th style="text-align: right;">@rupiah($subtotal-($invoice->diskon_rate))</th>
				</tr>
				<tr>
					<th colspan="4" style="text-align: right;">DP</th>
					<th style="text-align: right;">@rupiah($invoice->dp)</th>
				</tr>
				<tr>
					<th colspan="4" style="text-align: right;">Sisa Pembayaran</th>
					<th style="text-align: right;">@rupiah(($subtotal-($invoice->diskon_rate))-$invoice->dp)</th>
				</tr>
				
			</tfoot>
		</table>
        <br>
		<table class="tbl-tandatangan" width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="750"><b><u>Catatan:</u></b></td>
            </tr>
            <tr valign="top">
                <td>{!! nl2br($invoice->comment) !!}</td>
            </tr>
        </table>
		<br />
		<br />
        <table width="750" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
              <td width="250" align="center" style="border: none;"></td>
				      <td width="250" align="center" style="border: none;"></td>
				      <td width="250" align="center" style="border: none;"><strong>Hormat Kami</strong></td>
			      </tr>
            <tr valign="top" style="border: none;">
            	<td height="120" align="center" style="border: none;">
				</td>
				<td height="120" align="center" style="border: none;">
              	</td>
              	<td height="120" align="center" style="border: none;">
                	<!-- <img src="{{ asset($company->image_company) }}" width="100" /> -->
              	</td>
			</tr>
            <tr valign="top">
              <td align="center" style="border: none;"></td>
              <td align="center" style="border: none;"></td>
              <td align="center" style="border: none;"><strong>{{ $company->name }}</strong></td>
            </tr>
		</table>
	</body>
</html>
