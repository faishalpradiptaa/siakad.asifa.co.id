
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Detail <?php echo $this->title; ?></h4>
</div>
<div class="modal-body">
	<div class="tab-container">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_form_main" data-toggle="tab">Data Predikat</a></li>
		</ul>
		<div class="tab-content">
		
			<div class="tab-pane active" id="tab_form_main">
				<div class="scroll-content">	
					<table class="table table-striped">
						<tr>
							<th width="30%">Nama Predikat</th>
							<td><?php if($data) echo $data->nama_predikat; ?></td>
						</tr>
					</table>
					
					<table class="table table-striped" id="grade-container">
						<thead>
							<tr>
								<th width="20%">&gt;=</th>
								<th width="20%">&lt;</th>
								<th>Grade</th>
								<th>Deskriptif &nbsp;<i class="fa fa-info-circle" data-original-title="Untuk digunakan di deskripsi mata pelajaran" rel="tooltip"></i></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($data->detail)) foreach($data->detail as $row) {?>
							<tr>
								<td class><?php echo $row->minimal; ?></td>
								<td><?php echo $row->maksimal; ?></td>
								<td><?php echo $row->grade; ?></td>
								<td><?php echo $row->deskriptif; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>	

			
		</div>
	</div>
</div><!-- /.modal-body -->
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
