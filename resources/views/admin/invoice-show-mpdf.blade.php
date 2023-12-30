<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Invoice {{$invoice->no_invoice}} {{$company->name}}</title>
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
					<h1 class="page-title">&nbsp;&nbsp;Invoice&nbsp;&nbsp;</h1>
				</td>
			</tr>
		</table>
		<hr style="height: 3px; margin-bottom: 2px;" />
		<hr style="margin-top: 0px; margin-bottom: 0px;" /><br/><br/>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="155">Kepada</td>
                <td width="10"></td>
                <td width=""><</td>
                <td width="155">No Invoice:</td>
                <td width="10">:</td>
                <td>{{ $invoice->no_invoice }}</td>
            </tr>
            <tr valign="top">
                <td>{{  $invoice->name_customer}}</td>
                <td></td>
                <td></td>
                <td width="155">Tanggal:</td>
                <td width="10">:</td>
                <td>{{ $date_inv }}</td>
            </tr>
			      <tr valign="top">
                <td>{{  $invoice->address_customer}}</td>
                <td></td>
                <td></td>
            </tr>
			      <tr valign="top">
                <td>{{  $invoice->phone_customer}}</td>
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
			<?php $nomer = 0; $total = 0;$subtotal = 0; foreach($invoice->items as $item) { $nomer++; $total += floatval($dt->harga_total);$subtotal += floatval($dt->harga_total); ?>
				<tr>
					<td style="text-align: right;"><?php echo $nomer; ?></td>
					<td>{{ $item->description }}</td>
					<td align="right" style="text-align: right;">{{ $item->qty }}</td>
					<td align="right" style="text-align: right;">@rupiah($item->item_price)</td>
					<td align="right" style="text-align: right;">@rupiah($item->total)</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6" style="text-align: right;">Grand Total</th>
					<th style="text-align: right;">@rupiah($subtotal)</th>
				</tr>
			</tfoot>
		</table>
        <br>
		<table width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="750"><b><u>Comments</u></b></td>
            </tr>
            <tr valign="top">
                <td>{!! nl2br($invoice->comment) !!}</td>
            </tr>
        </table>
		<br />
		<br />
		<table width="750" border="0" cellpadding="0" cellspacing="3">
            <tr valign="top">
                <td width="750"><b><u>Term and Conditions</u></b></td>
            </tr>
            <tr valign="top">
                <td>No returns will be permitted.</td>
            </tr>
        </table>
		<br/>
        <table width="750" class="tbl-bordered" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
              <td width="210" align="center"><strong>Issued By</strong></td>
				      <td width="210" align="center"><strong>Approved By</strong></td>
				      <td width="210" align="center"><strong>Acknowledged By</strong></td>
			      </tr>
            <tr valign="top">
              <td height="120" align="center">
				      </td>
				      <td align="center">
              </td>
              <td align="center">
              </td>
			      </tr>
            <tr valign="top">
              <td align="center"><strong>End User</strong><br/>end user</span></td>
              <td align="center"><strong>End User</strong><br/>end user</span></td>
              <td align="center"><strong>End User</strong><br/>end user</span></td>
            </tr>
		</table>
	</body>
</html>
