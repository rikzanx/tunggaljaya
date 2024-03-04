<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Surat Jalan {{$company->name}} {{$invoice->no_invoice}}</title>
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
					<h1 class="page-title">&nbsp;&nbsp;Surat Jalan&nbsp;&nbsp;</h1>
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
                <td>{{  $tanggal_pengiriman }}</td>
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
		<table class="tbl-bordered" border="0" cellpadding="4" cellspacing="0">
			<thead>
				<tr>
					<th width="40">NO.</th>
					<th width="540">NAMA BARANG</th>
					<th width="90">JUMLAH</th>
				</tr>
			</thead>
			<tbody>
			<?php $nomer = 0; $total = 0;$subtotal = 0; foreach($invoice->items as $item) { $nomer++; $total += floatval($item->total);$subtotal += floatval($item->total); ?>
				<tr>
					<td style="text-align: right;"><?php echo $nomer; ?></td>
					<td>{{ $item->description }}</td>
					<td align="center">{{ $item->qty }}</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align: left;">
                    <p>
                        PERHATIAN<br>
                        1. Surat jalan merupakan bukti resmi penerimaan barang<br>
                        2. Surat jalan ini bukan bukti penjualan
                    </p>
                    </th>
				</tr>
			</tfoot>
		</table>
        <br>
		<br>
		<table class="tbl-tandatangan" width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="750"><b><u>Catatan:</u></b></td>
            </tr>
            <tr valign="top">
                <td></td>
            </tr>
        </table>
		<br />
        <table width="750" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
              <td width="250" align="center" style="border: none;">Penerima</td>
				      <td width="250" align="center" style="border: none;"></td>
				      <td width="250" align="center" style="border: none;">Pengirim</td>
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
              <td align="center" style="border: none;"><hr></td>
              <td align="center" style="border: none;"></td>
              <td align="center" style="border: none;"><hr></td>
            </tr>
		</table>
	</body>
</html>
