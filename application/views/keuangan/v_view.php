<head>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/css/table.css'); ?>">
</head>
<div class="admin-panels mn pn">
	<div class="admin-grid">
		<!-- Panel with All Options -->
		<div class="row" >
		<div class="col-xs-12 admin-grid">
			<div class="panel sort-disable panel-info" data-panel-color="false" data-panel-title="false" data-panel-remove="false" data-panel-collapse="false">
			<div class="panel-heading">
				<span class="panel-icon"><i class="fa fa-money"></i>
				</span>
				<span class="panel-title"><?php echo PAGE_TITLE; ?></span>
			</div>
			<div class="panel-body">
				<div class="panel sort-disable">
					
						<ul class="nav nav-tabs nav-justified">
							<li class="active"><a class="fw600" href="#tab-tanggungan" data-toggle="tab">Tanggungan</a></li>
							<li class=""><a class="fw600" href="#tab-pembayaran" data-toggle="tab">Riwayat Pembayaran </a></li>
						</ul>

					<div class="panel-body" style="overflow: auto; height: 500px; width: auto;">
						<div class="tab-content pn br-n">
							<div id="tab-tanggungan" class="tab-pane active">
								<div class="total_tagihan  visible-xs visible-sm">
									<table role="table" id="customers">
										<thead role="rowgroup">
										</thead>
										<tbody role="rowgroup">
												<tr role="row" style="background-color: red">
												<?php foreach($tagihan as $row) if(strtolower($row->status_tagihan) <> 'lunas' || $row->tanggungan)
													{
														$total += $row->tanggungan;
													}?>
													<td role="cell" ><b>Rp<?php echo number_format($total,0,',','.'); ?>,00</b></td>
												</tr>
										</tbody>
									</table>
								</div>
								<div class="panel-heading"><b>Rincian</b></div>
								<div class="tabel_tagihan">
									<table id="customers" role="table">
  									<thead role="rowgroup">
    								<tr role="row">
	      							<th role="columnheader">Kode</th>
	      							<th role="columnheader">Jenis</th>
	      							<th role="columnheader">Periode</th>
	      							<th role="columnheader">Nominal</th>
										  </tr>
										  </thead>
										  <tbody role="rowgroup">
												<?php
													$i=0;
													$total = 0;
												$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
												foreach($tagihan as $row) if(strtolower($row->status_tagihan) <> 'lunas' || $row->tanggungan)
												{
													$total += $row->tanggungan;
											?>
									    <tr role="row">
									      <td role="cell"><?php echo $row->kode_tagihan; ?></td>
									      <td role="cell"><?php echo $row->nama_jenis; ?></td>
									      <td role="cell"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
									      <td role="cell">Rp<?php echo number_format($row->tanggungan,0,',','.'); ?>,00</td>
									    </tr>
											<tr></tr>
									    <?php } ?>
											<tr class="visible-md visible-lg">
												<th>Total Tagihan</th>
												<td colspan="3" class="text-center"><b>Rp<?php echo number_format($total,0,',','.'); ?>,00</b></td>
											</tr>
									  </tbody>
									</table>
								</div>
							</div>
							<div id="tab-pembayaran" class="tab-pane">
								<div  class="total_pembayaran visible-xs visible-sm">
									<table role="table" id="customers">
										<thead role="rowgroup">
											<tr>
											</tr>
										<tr role="row">
											<th role="columnheader">Total</th>
											</tr>
											</thead>
											<tbody role="rowgroup">
												<tr role="row" style="background-color: blue">
												<?php
													$i=0;
													$total = 0;
													foreach($pembayaran as $row)
													{
														$total += $row->bayar;
													}?>
													<td role="cell" ><b>Rp<?php echo number_format($total,0,',','.'); ?>,00</b></td>
												</tr>
											</tbody>
									</table>
								</div>
								<div class="panel-heading"><b>Rincian</b></div>
								<div>
									<table id="customers" class="tabel_pembayaran">
										<thead role="rowgroup">
    								<tr role="row">
	      							<th role="columnheader">Kode</th>
	      							<th role="columnheader">Jenis</th>
	      							<th role="columnheader">Periode</th>
											<th role="columnheader">Transaksi</th>
											<th role="columnheader">Tanggal Bayar</th>
	      							<th role="columnheader">Nominal</th>
										</tr>
										</thead>
										  <tbody role="rowgroup">
												<?php
													$i=0;
													$total = 0;
													foreach($pembayaran as $row)
													{
														$total += $row->bayar;
												?>
									    <tr role="row">
									      <td role="cell"><?php echo $row->kode_pembayaran; ?></td>
									      <td role="cell"><?php echo $row->nama_jenis; ?></td>
									      <td role="cell"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
									      <td role="cell"><?php echo ucwords($row->jenis_transaksi); ?></td>
												<td role="cell"><?php echo date('d/m/Y', strtotime($row->tgl_bayar)); ?></td>
												<td role="cell">Rp<?php echo number_format($row->bayar,0,',','.'); ?>,00</td>
									    </tr>
											<tr></tr>
									    <?php } ?>
											<tr class="visible-md visible-lg">
												<th>Total Pembayaran</th>
												<td colspan="5" class="text-center"><b>Rp<?php echo number_format($total,0,',','.'); ?>,00</b></td>
											</tr>
									  </tbody>
									</table>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>


[section name="plugin-css"]


[/section]

[section name="css"]
<!--
<style>
@media only screen and (max-width: 800px) {
  /* Force table to not be like tables anymore */
  #no-more-tables table, #no-more-tables thead, #no-more-tables tbody, #no-more-tables th, #no-more-tables td, #no-more-tables tr {
    display: block;
  }
  /* Hide table headers (but not display: none;, for accessibility) */
  #no-more-tables thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }
  #no-more-tables tr {
    border: 1px solid #ccc;
  }
  #no-more-tables td {
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 50%;
    white-space: normal;
    text-align: left;
  }
  #no-more-tables td:before {
    /* Now like a table header */
    position: absolute;
    /* Top/left values mimic padding */
    top: 6px;
    left: 6px;
    width: 45%;
    padding-right: 10px;
    white-space: nowrap;
    text-align: left;
    font-weight: bold;
  }
  /*
	Label the data
	*/
  #no-more-tables td:before {
    content: attr(data-title);
  }
}
</style>
-->
[/section]

[section name="plugin-js"]
[/section]

[section name="js"]
<script>
</script>
[/section]
