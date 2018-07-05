<style>
	label.control-label.text-left{text-align:left}
	#table-pembayaran tbody td{vertical-align: middle;}
	.radio-inline{margin-top: 10px;}
	.radio-inline input[type="radio"], .radio-inline input[type="checkbox"]{margin-top: 0px}
	.tipe, .well, .form-button{display:none;}
	.checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline{margin-left:0px; margin-right:3px;}
	
</style>

<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<?php echo $breadcrumb;?>
	
	<div class="row">
	  <div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-money font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase"> Pembayaran Mahasiswa</span>
					</div>
				</div>
				<div class="portlet light body">
					<form class="form-horizontal" id="form-pembayaran">
						<div class="row">
						
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-2 control-label text-left">NRP</label>
									<div class="col-sm-6">
										<input type="text" id="in_nrp" name="nrp" style="width:100%">
									</div>
									<div class="col-sm-4">
										<button type="button" id="btn-det-mhs"  class="btn btn-primary full-width" disabled> <i class="fa fa-user"></i> &nbsp;Detail Mhs </button>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label text-left">Nama</label>
									<div class="col-sm-10">
										<input type="text" id="in_nama" class="form-control" disabled>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label text-left">Transaksi</label>
									<div class="col-sm-9">
										<label class="radio-inline"><input name="jenis_transaksi" type="radio" disabled value="biasa" checked> Pembayaran</label>
										<label class="radio-inline"><input name="jenis_transaksi" type="radio" disabled value="beasiswa"> Beasiswa</label>
										<label class="radio-inline"><input name="jenis_transaksi" type="radio" disabled value="dispensasi"> Dispen</label>
										<label class="radio-inline"><input name="jenis_transaksi" type="radio" disabled value="potongan"> Potongan</label>
									</div>
								</div>
								
								<div class="form-group form-button" >
									<div class="col-sm-6">
										<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-add-bayar"> <i class="fa fa-plus"></i> &nbsp;Tambah Pembayaran </button> &nbsp;&nbsp;
									</div>
									<!--div class="col-sm-6 text-right">
										<button type="button" class="btn btn-success" onclick="saveData()" > <i class="fa fa-floppy-o"></i> &nbsp;Simpan Transaksi</button>
									</div-->
								</div>
								<div class="form-group form-button" >
									<div class="col-sm-12">
										<b>Keterangan Warna : </b> <br>
										<ul class="ul-legend">
											<li><label class="legend legend-tanggungan-2">&nbsp;</label> &nbsp; <label class="legend legend-tanggungan">&nbsp;</label> &nbsp; Tagihan Belum Jatuh Tempo</li>
											<li><label class="legend legend-jatuh_tempo">&nbsp;</label> &nbsp; Tanggungan Sudah Jatuh Tempo</li>
											<li><label class="legend legend-denda">&nbsp;</label> &nbsp; Denda Sudah Jatuh Tempo</li>
										</ul>
									</div>
								</div>
								
							</div>
							
							<div class="col-md-6">
								<div class="well">
									
									<!--div class="row tipe tipe-biasa">
										<div class="form-group">
											<label class="col-sm-3 control-label">Tgl Validasi</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" name="tgl_validasi" class="form-control datepicker" value="<?php echo date('j/n/Y');?>">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
									</div-->
									
									<div class="row tipe tipe-dispensasi">
										<div class="form-group">
											<label class="col-sm-3 control-label">Jatuh Tempo</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" name="tgl_jatuh_tempo" class="form-control datepicker" value="<?php echo date('j/n/Y', strtotime('+3 month'));?>">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row tipe tipe-beasiswa">
										<div class="form-group">
											<label class="col-sm-3 control-label">Jenis Beasiswa</label>
											<div class="col-sm-6">
												<select class="form-control" name="jenis_beasiswa">
													<option value=""> - Pilih Beasiswa - </option>
													<?php foreach($beasiswa as $val) echo '<option value="'.$val->Beasiswa_Id.'">'.$val->Nama_Beasiswa.'</option>'?>
												</select>
											</div>
										</div>
									</div>
									<div class="row tipe tipe-biasa">
										<div class="form-group">
											<label class="col-sm-3 control-label">Atas Nama Rek Pengirim</label>
											<div class="col-sm-9">
												<input type="text" name="rek_pengirim_an" class="form-control">
											</div>
										</div>
									</div>
									<div class="row tipe tipe-biasa">
										<div class="form-group">
											<label class="col-sm-3 control-label">No. Rek Pengirim</label>
											<div class="col-sm-9">
												<input type="text" name="rek_pengirim" class="form-control">
											</div>
										</div>
									</div>								
									<div class="row">
										<div class="form-group">
											<label class="col-sm-3 control-label">Keterangan</label>
											<div class="col-sm-9">
												<textarea name="keterangan" id="main-ket" class="form-control" rows="6"></textarea>
											</div>
										</div>
									</div>
									<div class="row tipe tipe-potongan">
										<div class="form-group">
											<label class="col-sm-3 control-label">Keterangan Potongan</label>
											<div class="col-sm-9">
												<textarea name="keterangan_potongan" class="form-control" rows="6"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<label class="col-sm-3 control-label">Tgl Transaksi</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" name="tgl_transaksi" class="form-control" id="tgl_transaksi" value="<?php echo date('j/n/Y');?>">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
					
						</div>
						<div class="table-scrollable">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="table-pembayaran">
								<thead>
									<tr>
										<th width="13%" class="text-center">Periode</th>
										<th width="17%">Kategori</th>
										<th width="11%" class="text-center">Jatuh Tempo</th>
										<th width="15%" class="text-right">Tanggungan</th>
										<th width="20%">Bayar (Rp)</th>
										<!--th>Keterangan</th-->
										<!--th width="5%" class="text-center">Hapus</th-->
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<th class="text-right" colspan="3">Total</th>
										<th class="text-right" id="tfoot-tot-tanggungan">-</th>
										<th class="text-right" id="tfoot-tot-bayar">-</th>
										<!--th></th-->
									</tr>
								</tfoot>
							</table>
						</div>
						
						<div class="row ">
							<div class="col-md-9 text-right">
								<div class="tipe tipe-biasa">
									<b>Metode Bayar : </b> &nbsp;
									<?php foreach($rekening as $rek) echo '<label class="radio-inline"><input name="metode_bayar" type="radio" value="'.$rek->Kode_Rekening.'" required> '.$rek->Nama_Rekening.'</label>'; ?>
								</div>
							</div>
							<div class="col-md-3 text-right form-button">
								<button type="button" class="btn btn-success" onclick="saveData()" > <i class="fa fa-floppy-o"></i> &nbsp;Simpan Transaksi</button>
							</div>
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</div>

</div>

<div id="modal-add-bayar" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" >Tambah Pembayaran</h4>
			</div>
			<div class="modal-body">
				<div class="tab-container">

					<form action="" class="form-horizontal frm-add-bayar">
					
						<div class="form-group">
							<label class="col-sm-3 control-label">Tahun</label>
							<div class="col-sm-3">
								<input type="number" id="add-tahun"  class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Semester</label>
							<div class="col-sm-6">
								<select id="add-semester" class="form-control">
									<option value="" selected="true"> - Pilih Semester - </option>
									<option value="Ganjil">Ganjil</option>
									<option value="Genap">Genap</option>
									<option value="Pendek_Ganjil">Pendek Ganjil</option>
									<option value="Pendek_Genap">Pendek Genap</option>
									<option value="1_prf">Periode 1</option>
									<option value="2_prf">Periode 2</option>
									<option value="3_prf">Periode 3</option>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Kategori</label>
							<div class="col-sm-6">
								<select id="add-kategori" class="form-control">
									<option value=""> - Pilih Kategori - </option>
									<?php foreach ($kategori as $k) echo '<option value="'.$k->Kode_Kategori.'">'.$k->Kategori.'</option>'?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="add-keterangan"></textarea>
							</div>
						</div>
					</form>
				</div>              
			</div><!-- /.modal-body -->

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary" onclick="addData()">Tambahkan</button>
			</div>


		</div>
	</div>
</div>

<script>

	// menu closed
	if ($(window).width() <= 1030)
	{
		$('body').addClass('page-sidebar-closed-hide-logo page-sidebar-closed');
		$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
	}

	
	var tambah = 0;
	
	$('.datepicker').datepicker({format: 'd/m/yyyy'});
	$('#tgl_transaksi').datepicker({format: 'd/m/yyyy'}).on('changeDate', function(e) {
        loadData($('#in_nrp').val(), $('#tgl_transaksi').val());
    });
	
	$("#in_nrp").select2({
        placeholder: "Masukkan NRP atau Nama Mhs",
        minimumInputLength: 3,
        width: 'resolve',
		allowClear : true,
		ajax: {
			url: "<?php echo site_url('pm/rf_mahasiswa/autocomplete')?>",
			dataType: 'json',
			delay: 250,
			data: function (term, page) { 
                return {q: term};
            },
			results: function (data, page) {
				return {results: data.items};
			},
			cache: true
		},
		formatResult: function(m) { return '<b>'+m.id+'</b> '+ m.text; },
		escapeMarkup: function (m) { return m; } ,
		formatSelection: function(m) { 
			$('#in_nama').val(m.text); 
			$('[name="rek_pengirim_an"]').val(m.alias);
			$('#main-ket').text(m.ket);
			$('#main-ket').html(m.ket);
			$('#main-ket').val(m.ket);
			$('[name="keterangan_potongan"]').val('');
			$('[name="keterangan_potongan"]').html('');
			$('[name="keterangan_potongan"]').text('');
			return m.id; 
		},
    });
	
	$('#btn-det-mhs').click(function()
	{
		if (!$('#in_nrp').val()) return false;
		$('#master_nrp').val( $('#in_nrp').val() );
		$('#mhs-main-modal').modal('show');
	})	
	
	$('#in_nrp').change(function()
	{
		// reset tgl transaksi
		// [bug] double update 
		$("#tgl_transaksi").datepicker("setDate", new Date());
		//$('#tgl_transaksi').datepicker('update');
		
		if (!$(this).val()) 
		{
			$('.tipe, .well, .form-button').slideUp(400);
			$('#btn-det-mhs, [name="jenis_transaksi"]').attr('disabled', 'disabled');
			$('#in_nama').val('');
			$('#table-pembayaran tbody, #tfoot-tot-tanggungan, #tfoot-tot-bayar').html('');
		}
		else
		{
			$('.tipe, .well, .form-button').slideDown(400);
			$('#btn-det-mhs, [name="jenis_transaksi"]').removeAttr('disabled', 'disabled');
			$('[name="jenis_transaksi"][value="biasa"]').click();
		}
	})
	
	$('#table-pembayaran tbody').on('change, keyup', '.currency', function()
	{
		var total = 0;
		$('#table-pembayaran .currency').each(function(){
			total += $(this).autoNumeric('get') ? parseInt($(this).autoNumeric('get')) : 0;
		})
		$('#tfoot-tot-bayar').html(int2rupiah(total));
	});
	
	$('[name="jenis_transaksi"]').click(function()
	{
		var val = $(this).val();
		
		if ($('.tipe.tipe-'+val).length) 
		{
			$('.tipe.tipe-'+val).slideDown(400, function()
			{
				$('.tipe:not(.tipe-'+val+')').slideUp();
			});
		}
		else
		{
			$('.tipe:not(.tipe-'+val+')').slideUp();
		}
		
		if(val == 'dispensasi')
		{
			$('.input-nominal-text').each(function()
			{
				if ( !($(this).attr('name').indexOf('-11-null-') > -1) ) $(this).attr('type', 'checkbox');
				else $(this).addClass('hide');
				$(this).parents('td').addClass('text-center');
			})
			
		} 
		else if(val == 'potongan') 
		{
			$('.input-nominal-text.hide').removeClass('hide');
			$('.input-nominal-text').attr('type', 'text');
			$('.input-nominal').removeClass('text-center');
			
			$('.input-nominal-text').each(function()
			{
				//if ( !($(this).attr('name').indexOf('-11-') > -1) ) $(this).attr('type', 'hidden').addClass('temp');
				//else $(this).attr('type', 'text')
			})
			
		} else {
			$('.input-nominal-text.hide').removeClass('hide');
			$('.input-nominal-text').attr('type', 'text');
			$('.input-nominal').removeClass('text-center');
		}
	})

	
	function loadData(nrp, tgl_transaksi)
	{
		if(!nrp) return false;
		
		$.ajax({
			type	: 'GET',
			data 	: 'tgl_transaksi='+tgl_transaksi,
			url		: '<?php echo site_url(PAGE_ID.'/get_tanggungan'); ?>/'+nrp,
			cache	: false,
			dataType : "json",
			success	: function(data)
			{
				var tot_tanggungan = 0;
				var html = '';
				var today = new Date();
				
				for(var i = 0; i< data.length; i++)
				{
					var row = data[i];
					
					//kode untuk denda generatean
					var kode = row.Kode_Kategori == 11 && row.Kode_Denda ?  row.Tahun_Pembayaran+'-'+row.Periode_Sem+'-'+row.Kode_Kategori+'-'+row.No_Item+'-'+row.Kode_Denda : row.Tahun_Pembayaran+'-'+row.Periode_Sem+'-'+row.Kode_Kategori+'-'+row.No_Item;
					var jatuh_tempo = new Date(row.Jatuh_Tempo);
					
					var tanggungan = row.Tanggungan ? row.Tanggungan : row.Nominal;
					tot_tanggungan += parseInt(tanggungan);
					
					row.Tahun_Pembayaran = row.Tahun_Pembayaran == null ? '' : row.Tahun_Pembayaran;
					row.Periode_Sem = row.Periode_Sem == null ? '' : row.Periode_Sem;
					
					//var is_denda = row.Kode_Kategori == 11 && jatuh_tempo.setHours(0,0,0,0) <= today.setHours(0,0,0,0) ? 'tr_denda' : '';
					//var is_jatuh_tempo = (jatuh_tempo.setHours(0,0,0,0) <= today.setHours(0,0,0,0)) ? 'tr_jatuh_tempo' : '';
					var is_denda = row.Kode_Kategori == 11 && jatuh_tempo.setHours(0,0,0,0) <= $('#tgl_transaksi').datepicker("getDate").setHours(0,0,0,0) ? 'tr_denda' : '';
					var is_jatuh_tempo = (jatuh_tempo.setHours(0,0,0,0) <= $('#tgl_transaksi').datepicker("getDate").setHours(0,0,0,0)) ? 'tr_jatuh_tempo' : '';
					
					html += '<tr class="'+is_jatuh_tempo+' '+is_denda+'">';
					html += '	<td class="text-center">'+row.Tahun_Pembayaran+' '+row.Periode_Sem+'</td>';
					html += '	<td>'+(!row.Kode_Denda && row.Kode_Kategori == 11 ? row.Keterangan : row.Kategori )+'</td>';
					html += '	<td class="text-center">'+mysqldate2date(row.Jatuh_Tempo)+'</td>';
					html += '	<td class="text-right">'+int2rupiah(tanggungan)+'</td>';
					html += '	<td class="input-nominal"><input type="text" class="form-control currency text-right input-nominal-text" name="bayar['+kode+']" value="0" data-v-min="0" data-v-max="'+tanggungan+'" ><input type="hidden" name="tanggungan['+kode+']" value="'+tanggungan+'"></td>';
					
					html += row.Kode_Kategori == 11 ? '<input type="hidden" name="d_ket['+kode+']" value="'+row.Kategori+'">' : '';
					html += row.Kode_Kategori == 11 ? '<input type="hidden" name="d_jt['+kode+']" value="'+row.Jatuh_Tempo+'">' : '';
					html += row.Kode_Kategori == 11 && row.Kode_Parent ? '<input type="hidden" name="d_ref['+kode+']" value="'+row.Tahun_Pembayaran+'-'+row.Periode_Sem+'-'+row.Kode_Parent+'">' : '';
					
					html += '</tr>';
				}
				$('#table-pembayaran tbody').html(html);
				$('#tfoot-tot-tanggungan').html(int2rupiah(tot_tanggungan));
				$('#tfoot-tot-bayar').html('-');
				$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
				
				//reset
				$('.well [name="rek_pengirim"]').val('');
				//$('.well [name="keterangan"]').val('');
				$('.well [name="jenis_beasiswa"]').val('');
				var cek = $('[name="metode_bayar"]').prop('checked', false);
				$.uniform.update(cek);
				
				var cek = $('[name="jenis_transaksi"]').prop('checked', false);
				$.uniform.update(cek);
				cek = $('[name="jenis_transaksi"]').first().click();
				$.uniform.update(cek);
			},
			error : function(error) 
			{
				toastr.error('Koneksi galat : '+error, "Kategori Pembayaran")
			}
		});
	
	}
	
	function addData()
	{
		var tahun = $('#add-tahun').val();
		var semester = $('#add-semester').val();
		var kategori = $('#add-kategori').val();
		var keterangan = $('#add-keterangan').val();
		var kode = tahun+'-'+semester+'-'+kategori+'-0-'+tambah;
		var html = '';
		
		html += '<tr>';
		html += '	<td class="text-center">'+tahun+' '+semester+'</td>';
		html += '	<td>'+$('#add-kategori option[value="'+kategori+'"]').html()+'</td>';
		html += '	<td class="text-center"> - </td>';
		html += '	<td class="text-right"> - </td>';
		html += '	<td><input type="text" class="form-control currency text-right" name="bayar['+kode+']" value="0" data-v-min="0" ><input type="hidden" name="new_ket['+kode+']" value="'+keterangan+'"></td>';
		//html += '	<td>'+keterangan+'</td>';
		//html += '	<td class="center"><button class="btn btn-danger" type="button" do="delete"><i class="fa fa-trash-o"></i></button></td>';
		html += '</tr>';
		$('#table-pembayaran tbody').append(html);
		
		$('#add-tahun, #add-semester, #add-kategori, #add-keterangan').val('');
		$('[data-dismiss="modal"]').click();
		$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
		tambah++;
	}
	
	function saveData()
	{	
		var nrp = $('#in_nrp').val();
		
		// jika metode bayar belum diisi
		if ($('[name="jenis_transaksi"][value="biasa"]:checked').length && !$('[name="metode_bayar"]:checked').length)
		{
			toastr.error('Harap isi <b>Metode Bayar</b> terlebih dahulu', 'Pembayaran');
			return false;
		}

		// jika jenis beasiswa belum diisi
		if ($('[name="jenis_transaksi"][value="beasiswa"]:checked').length && !$('[name="jenis_beasiswa"]').val())
		{
			toastr.error('Harap isi <b>Jenis Beasiswa</b> terlebih dahulu', 'Pembayaran');
			return false;
		}

		// jika keterangan potongan belum diisi
		if ($('[name="jenis_transaksi"][value="potongan"]:checked').length && !$('[name="keterangan_potongan"]').val())
		{
			toastr.error('Harap isi <b>Keterangan Potongan</b> terlebih dahulu', 'Pembayaran');
			return false;
		}
		
		// jika hanya denda saja yang diisi maka tidak boleh disimpan (harus bayar yang lainnya)
		var denda_stage = 0;
		$('#table-pembayaran .currency').each(function()
		{
			if ($(this).val() == '') $(this).val(0);
			if ($(this).attr('name').indexOf('null') > -1 && $(this).val() != '0' && denda_stage == 0) denda_stage = 1;
			else if ($(this).attr('name').indexOf('null') == -1 && ($(this).val() != '0' || $(this).is(':checked')) && denda_stage == 1) denda_stage = 2;
		})
		if(denda_stage == 1)
		{
			toastr.error('Harap bayar tanggungan lainnya terlebih dahulu', 'Pembayaran');
			return false;
		}
		
		$.ajax({
			type	: 'POST',
			data 	: $('#form-pembayaran').serialize(),
			url		: '<?php echo site_url(PAGE_ID.'/save_transaksi'); ?>/'+nrp,
			dataType : "json",
			cache	: false,
			success	: function(data)
			{
				if (data.sukses)
				{
					toastr.success(data.sukses, 'Pembayaran');
					// reset tgl transaksi
					// [bug] double update 
					$("#tgl_transaksi").datepicker("setDate", new Date());
					//$('#tgl_transaksi').datepicker('update');
					//loadData(nrp);
				}
				else if (data.error)
				{
					toastr.error(data.error, 'Pembayaran');
				} 
				else
				{
					toastr.error('Ada Kesalahan', 'Pembayaran');
				}
			},
			error : function(error) 
			{
				toastr.error('Koneksi galat : '+error, 'Pembayaran');
			}
		});
	}
	
	function getFromHash(nrp_a)
	{
		$('#mhs-main-modal').modal('hide');
		var nrp = window.location.hash.replace('#','');
		if (nrp_a) nrp = nrp_a;
		if (nrp)
		{
			$.ajax({
				type	: 'GET',
				data	: {q : nrp},
				url		: '<?php echo site_url('pm/rf_mahasiswa/autocomplete')?>',
				dataType : "json",
				cache	: false,
				success	: function(data)
				{
					$("#in_nrp").select2('data',data.items[0]).trigger('change');
				}
			});
		}
	}
	
	getFromHash();
	
	window.addEventListener("hashchange", getFromHash(), false);
</script>