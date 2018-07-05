<style>
	table.myTable>tbody>tr>td{
		vertical-align:middle;
	}
</style>
<script>
	var TAKE_OVER = true; // take over init my_table
	
	var curr_switch = false;
	var swich_pause = false;
	var my_table = $("#datatable-main").myTable({
		extraButtons : [{text: "<i class='glyphicon glyphicon-plus'></i>&nbsp; Tambah", action: function ( e, dt, node, config ) {$('#crud-add-link').click()} }, ],
		fnDrawCallback: function ( oSettings ) 
		{
			$('.main-switch').bootstrapSwitch({
				onSwitchChange : function(event, state)
				{
					if (swich_pause == true) return false;
					
					curr_switch = event.target.name;
					$.ajax({
						url : '<?php echo site_url(PAGE_ID.'/state'); ?>/'+curr_switch+'/'+state,
						method : 'GET',
						success: function (data){
							if(data != 'ok') $.pnotify({ title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error' });
							else 
							{
								swich_pause = true;
								$('.main-switch:not([name="'+curr_switch+'"])').removeAttr('checked').change();
								swich_pause = false;
							}
						},
						error : function(event){
							$.pnotify({ title: '<?php echo $this->title; ?>', text: 'Terjadi kesalahan : Error 500 ', type: 'error' });
						}
					});
				}
			});
		},
	});	
</script>