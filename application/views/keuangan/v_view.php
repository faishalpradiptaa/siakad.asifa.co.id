<div class="admin-panels mn pn">
	<div class="col-sm-12 admin-grid">
		<!-- Panel with All Options -->
		<div class="row">
		<div class="col-md-12 admin-grid">
			<div class="panel sort-disable panel-info" data-panel-color="false" data-panel-title="false" data-panel-remove="false" data-panel-collapse="false">
			<div class="panel-heading">
				<span class="panel-icon"><i class="fa fa-money"></i>
				</span>
				<span class="panel-title"><?php echo PAGE_TITLE; ?></span>
			</div>
			<div class="panel-body">
				<div class="panel sort-disable">
					<div class="panel-heading">
						<ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
							<li class="active"><a href="#tab-tanggungan" data-toggle="tab">Tanggungan</a></li>
							<li><a href="#tab-pembayaran" data-toggle="tab">Riwayat Pembayaran </a></li>
						</ul>
					</div>
					<div class="panel-body">   
						<div class="tab-content pn br-n">
							<div id="tab-tanggungan" class="tab-pane active">
								<div class="row">
									<table class="table table-responsive table-striped table-hover">
										<thead>
											<tr class="dark">
												<th width="5%" class="text-center">No.</th>
												<th width="20%" class="text-center">Kode</th>
												<th>Jenis</th>
												<th width="15%" class="text-center">Periode</th>
												<th width="18%" class="text-right">Nominal</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$i=0; 
											$total = 0;
											$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
											foreach($tagihan as $row) if(strtolower($row->status_tagihan) <> 'lunas' || $row->tanggungan) 
											{ 
												$total += $row->tanggungan;
										?>
										<tr class="danger">
											<td class="text-center"><?php echo ++$i; ?></td>
											<td class="text-center"><?php echo $row->kode_tagihan; ?></td>
											<td><?php echo $row->nama_jenis; ?></td>
											<td class="text-center"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
											<td class="text-right">Rp. <?php echo number_format($row->tanggungan,0,',','.'); ?></td>
										</tr>
										<?php } ?>	
										</tbody>
										<tfoot>
											<tr>
												<th class="text-right" colspan="4"><b>Total</b></th>
												<th class="text-right"><b>Rp. <?php echo number_format($total,0,',','.'); ?></b></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div id="tab-pembayaran" class="tab-pane">
								<div class="row">
									<table class="table table-responsive table-striped table-hover">
										<thead>
											<tr class="dark">
												<th width="5%" class="text-center">No.</th>
												<th width="20%" class="text-center">Kode</th>
												<th>Jenis</th>
												<th width="15%" class="text-center">Periode</th>
												<th width="13%" class="text-center">Transaksi</th>
												<th width="13%" class="text-center">Tgl bayar</th>
												<th width="15%" class="text-right">Nominal</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$i=0; 
											$total = 0;
											foreach($pembayaran as $row)
											{ 
												$total += $row->bayar;
										?>
										<tr>
											<td class="text-center"><?php echo ++$i; ?></td>
											<td class="text-center"><?php echo $row->kode_pembayaran; ?></td>
											<td><?php echo $row->nama_jenis; ?></td>
											<td class="text-center"><?php echo $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode; ?></td>
											<td class="text-center"><?php echo ucwords($row->jenis_transaksi); ?></td>
											<td class="text-center"><?php echo date('d/m/Y', strtotime($row->tgl_bayar)); ?></td>
											<td class="text-right">Rp. <?php echo number_format($row->bayar,0,',','.'); ?></td>
										</tr>
										<?php } ?>	
										</tbody>
										<tfoot>
											<tr>
												<th class="text-right" colspan="6"><b>Total</b></th>
												<th class="text-right"><b>Rp. <?php echo number_format($total,0,',','.'); ?></b></th>
											</tr>
										</tfoot>
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/custom/plugin/datatable_new/mytable.css"/>
[/section]

[section name="css"]
[/section]

[section name="plugin-js"]
[/section]

[section name="js"]
<script>
</script>
[/section]

