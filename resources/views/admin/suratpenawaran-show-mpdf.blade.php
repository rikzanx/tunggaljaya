<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Surat Penawaran {{$company->name}} {{$suratpenawaran->no_surat}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            body {  font-size: 12px;}
			.tbl-bordered { border: 1px solid #000; border-top: none; border-left: none; }
			.tbl-bordered td, .tbl-bordered th { border: 1px solid #000; border-right: none; border-bottom: none; }
			.tbl-bordered th { text-align: center; font-weight: bold; }
			.tbl-bordered td table td { border: none; }
			h1 { font-size: 14px; }
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
					<p style="font-size: 11px;">&nbsp;&nbsp;{{$company->address}}</p>
					<p style="font-size: 11px;">&nbsp;&nbsp;Phone : {{ $company->telp}}</p>
				</td>
				<td width="40%" valign="middle" align="center">
				</td>
			</tr>
		</table>
		<hr style="height: 3px; margin-bottom: 2px;" />
		<hr style="margin-top: 0px; margin-bottom: 0px;" />
		<br/><br/>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td valign="middle" align="center" style="font-size:16px;"><b>Surat Penawaran</b></td>
			</tr>
		</table>
		<br/>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="155"><b>Kepada</b></td>
                <td width="10"></td>
                <td width="210"></td>
                <td width="100"></td>
                <td width="10"></td>
                <td style="text-align: right;">Surabaya, {{$suratpenawaran->duedate}}</td>
            </tr>
            <tr valign="top">
                <td colspan="3">{{  $suratpenawaran->name_customer}}</td>
                <td width="100"></td>
                <td width="10"></td>
                <td></td>
            </tr>
			<tr valign="top">
                <td colspan="3">{{  $suratpenawaran->address_customer}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
			<tr valign="top">
                <td colspan="3">{{  $suratpenawaran->phone_customer}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
		<br/>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>Kami dari {{$company->name}} bermaksud memberikan penawaran harga barang dibawah ini:</td>
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
			<?php $nomer = 0; $total = 0;$subtotal = 0; foreach($suratpenawaran->items as $item) {
				 $nomer++; $total += floatval($item->item_price * $item->qty);
				 $subtotal += floatval($item->item_price * $item->qty); ?>
				<tr valign="top">
					<td style="text-align: right;"><?php echo $nomer; ?></td>
					<td>{{ $item->description }}</td>
					<td align="center">{{ $item->qty }}</td>
					<td align="right" style="text-align: right;">@rupiah($item->item_price)</td>
					<td align="right" style="text-align: right;">@rupiah($item->item_price * $item->qty)</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" style="text-align: right;">Total</th>
					<th style="text-align: right;">@rupiah($subtotal)</th>
				</tr>
			</tfoot>
		</table>
        <br>
		<table class="tbl-tandatangan" width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="750"><b><u>Catatan Tambahan:</u></b></td>
            </tr>
            <tr valign="top">
                <td>{!! nl2br($suratpenawaran->comment) !!}</td>
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
					<?php if(isset($signature) && $signature == true) { ?>
						<img src="{{ asset($company->signature) }}" width="100" />
					<?php }?>
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
