<div class="row">
	<div class="col-md-3 pl5-md animated fadeIn">
		<button type="button" class="btn bg-primary light btn-block compose-btn"><?php echo NAMA_LENGKAP; ?></button>
		<div class="panel">
		<div class="panel-body p10">

			<div class="text-center" id="crop-avatar" style="margin-bottom: 20px;">

				<div class="table-layout">
					<div class="avatar-view" style="width: 100%; height: auto;border-radius:0px;border:4px solid #fff;">
					<a href="#" data-ip-modal="#avatarModal">
						<img width="100%" id="profile_picture" src="<?php echo base_url(); ?>/assets/img/avatars/placeholder.png" alt="Avatar" data-toggle="tooltip" data-placement="bottom" title="Profile picture"/>
					</a>
					</div>
				</div>
			</div>


			<h4 class="ph10 mv15 text-center"> Pengumuman </h4>
			<hr class="mn br-light">
			<ul id="list-kategori-pengumuman" class="nav nav-messages p5" role="menu">
				<li class="active">
					<a href="#"  class="text-dark fw600 p8 animated animated-short fadeInUp">
					<span class="fa fa-bullhorn pr5"></span>
					<span class="submenupengumuman">Semua</span>
					<span class="pull-right lh20 h-20 label label-success label-sm"><?php echo count($pengumuman); ?></span>
					</a>
				</li>
				<?php
				$total = array();
				foreach($pengumuman as $row)
				{
					if(!isset($total[$row->id_kategori])) $total[$row->id_kategori] = 0;
					$total[$row->id_kategori]++;
				}

				foreach($kat_pengumuman as $row) {
				?>
				<li kategori="<?php echo $row->id_kategori ?>">
					<a href="#" class="text-dark fw600 p8 animated animated-short fadeInUp">
					<span class="<?php echo $row->icon ?> fs14 mr5"></span>
					<span class="submenupengumuman"><?php echo $row->nama_kategori ?></span>
					<span class="pull-right lh20 h-20 label label-success label-sm"><?php echo isset($total[$row->id_kategori]) ? $total[$row->id_kategori]  : 0 ?></span>
					</a>
				</li>
				<?php } ?>

			</ul>

		</div>
		</div>
	</div>

	<div class="col-md-9 prn-md animated fadeIn">
		<div class="panel">
		<div class="bg-light pv8 pl15 pr10 br-a br-light">
			<div class="row">
			<div class="hidden-xs hidden-sm col-md-3 va-m">
				<div class="btn-group admin-form hidden">
				<button type="button" class="btn btn-default light lh25">
					<label class="option block mn">
					<input type="checkbox" name="mobileos" value="FR">
					<span class="checkbox va-t"></span> Select All
					</label>

				</button>
				</div>
				<div id="btnKembali" class="btn-group hide">
				<button type="button" class="btn btn-default light"><i class="fa fa-level-up" style="transform: rotate(-90deg);"></i>
				</button>
				</div>
			</div>
			<div class="col-md-9 text-right">
				<span id="jmltotpengumuman" class="va-m text-muted mr15"> Menampilkan <strong id="jml_aktif"><?php echo count($pengumuman); ?></strong> pengumuman terbaru</span>
			</div>
			</div>
		</div>
		<div id="konten" class="panel-body pn br-t-n">
			<table id="tabel_pengumuman" class="table admin-form theme-warning tc-checkbox-1 br-t-n">
			<tbody>
				<?php foreach($pengumuman as $row) { ?>
				<tr class="message-unread clickable" kategori="<?php echo $row->id_kategori; ?>" id_pengumuman="<?php echo $row->id_pengumuman; ?>">
					<td width="5%"><i class="mr5 <?php echo $row->icon; ?> fs14 visible-md visible-lg "></i></td>
					<td width="15%"><?php echo $row->nama_kategori; ?></td>
					<td width="15%"><span class="badge badge-info mr10 fs11 visible-md visible-lg"> <?php echo datetime2History($row->publish_date); ?> lalu </span></td>
					<td><?php echo $row->judul; ?></td>
					<td width="15%" class="text-center fw600 pr15"><?php echo date('d M Y', strtotime($row->publish_date)); ?></td>
				</tr>
				<?php } ?>
			</tbody>
			</table>

			<a id="link-popup" class="hide" data-toggle="modal" data-target="#main-modal-lg" href="#"></a>

			<div class="panel-body" id="isi_konten" style="display:none"><p>
			<div class="panel-heading mr10 title"></div>
			<div class="panel-body mr10 content"> </div>
			<span class="unit" style="visibility:hidden;"></span>
			</p></div>
		</div>
		</div>
	</div>
</div>


[section name="plugin-css"]
[/section]

[section name="plugin-js"]
[/section]

[section name="css"]
<style>
	#tabel_pengumuman tbody tr td{
		cursor:pointer;
	}
	#tabel_pengumuman tbody tr:hover td{
		background:#f7f7f7;
	}
	#list-kategori-pengumuman li.active {
		background-color: #eeeeee;
	}
	#list-kategori-pengumuman li.active .label{
		background-color: #4a89dc;
	}
</style>
[/section]

[section name="js"]
<script>
	$('#tabel_pengumuman tbody tr td').click(function(){
		$('#link-popup').attr('href','<?php echo site_url('pengumuman'); ?>/'+$(this).parents('tr').attr('id_pengumuman')).click();
	})

	$('#list-kategori-pengumuman li a').click(function(){
		var kategori = $(this).parent('li').attr('kategori');
		if(!kategori)
		{
			$('#tabel_pengumuman tbody tr').show()
		} else {
			$('#tabel_pengumuman tbody tr[kategori="'+kategori+'"]').show()
			$('#tabel_pengumuman tbody tr:not([kategori="'+kategori+'"])').hide()
		}
		$(this).parent('li').addClass('active').siblings().removeClass('active');
	})
</script>
[/section]
