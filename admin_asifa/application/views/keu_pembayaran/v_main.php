<div class="page-content">
	
	<div class="page-head">
		<div class="page-title"><h1><?php echo PAGE_TITLE; ?></h1></div>
	</div>

	<ul class="page-breadcrumb breadcrumb">
	</ul>
	
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Pembayaran </span>
					</div>
				</div>
				<div class="portlet-body">
					
				
					<form action="<?php echo site_url(PAGE_ID);?>" method="POST" class="form-horizontal row-border main-form">
					<div class="row">
						<div class="col-md-6">
						
							<div class="form-group">
								<label class="col-sm-3 control-label text-left">No.Induk</label>
								<div class="col-sm-6">
									<input type="text" id="in_ac_siswa" name="in_no_induk">
								</div>
								<div class="col-sm-3" need-data>
									<button type="button" id="btn-det-sw" class="btn btn-primary full-width" disabled> <i class="fa fa-user"></i> &nbsp;Detail</button>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label text-left">Nama</label>
								<div class="col-sm-9">
									<input type="text" id="in_nama" class="form-control" disabled>
								</div>
							</div>
							
							<div class="form-group" need-data>
								<label class="col-sm-3 control-label text-left">Transaksi</label>
								<div class="col-sm-9">
									<div class="radio-list">
										<label class="radio-inline"><input name="in_jenis_transaksi" type="radio" disabled value="pembayaran" checked> Pembayaran</label>
										<label class="radio-inline"><input name="in_jenis_transaksi" type="radio" disabled value="potongan"> Potongan</label>
									</div>
								</div>
							</div>
							
							<div class="form-group" need-data>
								<label class="col-sm-3 control-label">Tgl Trans</label>
								<div class="col-sm-5">
									<div class="input-group">
										<input type="text" name="in_tgl_transaksi" class="form-control datepicker" disabled value="<?php echo date('d/m/Y');?>">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							
							<div class="form-group" need-data>
								<label class="col-sm-3 control-label">Bank</label>
								<div class="col-sm-5">
									<select class="form-control" name="in_bank" disabled>
										<option>Tunai</option>
										<option>BRI</option>
										<option>BCA</option>
										<option>BNI</option>
										<option>Mandiri</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="well">
								<div class="form-group" need-data>
									<label class="col-sm-3 control-label">Catatan</label>
									<div class="col-sm-9">
										<textarea name="in_catatan" class="form-control" rows="6" disabled></textarea>
									</div>
								</div>
						
							</div>
						</div>
						
						<div class="col-md-12">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="table-pembayaran">
								<thead>
									<tr>
										<th width="13%" class="text-center">Periode</th>
										<th>Kategori</th>
										<th width="15%" class="text-right">Tanggungan</th>
										<th width="20%">Bayar (Rp)</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<th class="text-right" colspan="2">Total</th>
										<th class="text-right" id="tfoot-tot-tanggungan">-</th>
										<th class="text-right" id="tfoot-tot-bayar">-</th>
									</tr>
								</tfoot>
							</table>
					
						</div>
					</div>
					<div class="row ">
							<div class="col-md-9 text-right">
							</div>
							<div class="col-md-3 text-right" need-data>
								<button type="submit" class="btn btn-success" disabled > <i class="fa fa-floppy-o"></i> &nbsp;Simpan Transaksi</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>

[section name="plugin-css"]
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
[/section]

[section name="css"]
<style>
	.portlet-body{
		position: relative;
	}
	.portlet-loading{
		background: rgba(255,255,255,0.7);
    position: absolute;
    width: 100%;
    z-index: 99999;
    top: 0;
    bottom: 0;
	}
	.portlet-loading .loading-bg{
		margin-top: 80px;
		text-align: center;
		font-size: 18px;
	}
	.modal-open .datepicker {
    z-index: 9999 !important;
	}
</style>
[/section]

[section name="plugin-js"]
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/autoNumeric-min.js"></script>
[/section]

[section name="js"]
<script>
	var PAGE_URL = '<?php echo site_url(PAGE_ID);?>';
	var encoded_no_induk = false;
	
	$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
	});
	
	$("#in_ac_siswa").select2({
		placeholder: "Cari No Induk atau Nama Siswa",
		minimumInputLength: 3,
		width: '100%',
		allowClear : true,
		ajax: {
			url: "<?php echo site_url('rf_siswa/autocomplete'); ?>",
			dataType: 'json',
			delay: 250,
			data: function (term, page) { return {q: term};	},
			results: function (data, page) { return {results: data.items}; },
			cache: true
		},
		formatResult: function(m) { return '<b>'+m.id+'</b> '+ m.text; },
		escapeMarkup: function (m) { return m; } ,
		formatSelection: function(m) 
		{ 
			encoded_no_induk = m.encoded_id;
			$('#in_nama').val(m.text)
			prosesSiswa(m.id);
			return '<b>'+m.id +'</b>'; 
		},
	});
	
	
	// proses siswa
	function prosesSiswa(no_induk)
	{
		$('.portlet-body').first().prepend('<div class="portlet-loading"><div class="loading-bg"><i class="fa fa-refresh fa-spin margin-r-5"></i> Memproses Data....</div></div>');
		
		$.ajax({
			url : '<?php echo site_url(PAGE_ID.'/get_data_tanggungan'); ?>/'+no_induk,
			method : 'GET',
			dataType : 'JSON',
			success : function(data){
				$('.portlet-loading').remove();
				if(!data)
				{
					$.pnotify({title:'Pembayaran', text:'Data tidak ditemukan.', type:'error'});
					return false;
				}
				$('[need-data] [disabled]').removeAttr('disabled');
				var cek = $('[name="in_jenis_transaksi"]').prop('checked', false).first().click();
				$.uniform.update(cek);
				$('[name="in_catatan"]').text(data.catatan.catatan)
				
				var html = '';
				var tot_tanggungan = 0;
				for(var i=0; i<data.tanggungan.length; i++)
				{
					var val = data.tanggungan[i];
					html += '<tr>';
					html += '	<td class="text-center">'+val.periode+'</td>';
					html += '	<td>'+val.kategori+'</td>';
					html += '	<td class="text-right">'+int2rupiah(val.tanggungan)+'</td>';
					html += '	<td><input type="text" class="form-control currency text-right" name="in_bayar['+val.kode_tagihan+']" value="0" data-v-min="0" data-v-max="'+val.tanggungan+'" ></td>';
					html += '</tr>';
					tot_tanggungan += parseInt(val.tanggungan);
				}
				
				$('#table-pembayaran tbody').html(html).find('input');
				$('#tfoot-tot-tanggungan').html(int2rupiah(tot_tanggungan));
				$('#tfoot-tot-bayar').html('-');
				$('.currency').autoNumeric("init",{aSep: '.',aDec: ',', aSign: '', mDec: 0});
				
			},
			error : function(error){
				$('.portlet-loading').remove();
				$.pnotify({title: 'Pembayaran', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			},
		});
		
	}

	// batalkan transaksi
	$('#in_ac_siswa').change(function()
	{
		$("#in_tgl_transaksi").datepicker("setDate", new Date());
		if (!$(this).val()) 
		{
			$('[need-data]').find('input,textare,button').attr('disabled','true');
			$('[need-data] textarea').val('').text('').html('');
			var cek = $('[name="in_jenis_transaksi"]').prop('checked', false).first().click();
			$.uniform.update(cek);
			$('#in_nama').val('');
			$('#table-pembayaran tbody, #tfoot-tot-tanggungan, #tfoot-tot-bayar, textarea').html('');
		}
	})
	
	// hitung total pembayaran
	$('#table-pembayaran tbody').on('change, keyup', '.currency', function()
	{
		var total = 0;
		$('#table-pembayaran .currency').each(function(){
			total += $(this).autoNumeric('get') ? parseInt($(this).autoNumeric('get')) : 0;
		})
		$('#tfoot-tot-bayar').html(int2rupiah(total));
	});	
	
	// simpan data
	$('.main-form').submit(function(){
		$(this).parents('.portlet-body').prepend('<div class="portlet-loading"><div class="loading-bg"><i class="fa fa-refresh fa-spin margin-r-5"></i> Memproses Data....</div></div>');
		$.ajax({
			url : $(this).attr('action'),
			method : 'POST',
			data : $(this).serialize(),
			dataType : 'JSON',
			success: function (data)
			{
				$('.portlet-loading').remove();
				if (data.status == true)
				{
					prosesSiswa($("#in_ac_siswa").val());
					$.pnotify({title: 'Pembayaran', text: data.text, type: 'success'});
				}
				else 
				{
					$.pnotify({title: 'Pembayaran', text: data.text, type: 'error'});
				}
			},
			error : function (error){
				$('.portlet-loading').remove();
				$.pnotify({title: 'Pembayaran', text: 'Terjadi kesalahan : Error 500 ', type: 'error'});
			}
		});
		return false;
		
	})
	
	$('#btn-det-sw').click(function(){
		$('#master_no_induk').val(encoded_no_induk);
		$('#sw-main-modal').modal('show');		
	})
	
	
	// Page Property	
	$('.page-sidebar-menu a').each(function()
	{
		var href = $(this).attr('href');
		if (window.location.href.indexOf(href) > -1) $('.caption i').addClass($(this).find('i').attr('class'));
	});

	$('.caption .fa').addClass($('.page-sidebar-menu li.active a').attr('class'));
	
</script>
[/section]

