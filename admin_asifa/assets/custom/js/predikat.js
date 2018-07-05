 $.fn.grade = function(options) {

	var container = this;
	var i = 0;
	var settings = $.extend({
		name: 'grade_kategori',
		data: [],
	}, options );

	function add(data)
	{
		var data = $.extend({ grade : '', deskriptif : '',  minimal : '', maksimal : ''}, data );
		html = '';
		html += '<tr>';
		html += '	<td><input type="number" class="form-control input-xs" name="'+settings.name+'['+i+'][minimal]" value="'+data.minimal+'"></td>';
		html += '	<td><input type="number" class="form-control input-xs" name="'+settings.name+'['+i+'][maksimal]" value="'+data.maksimal+'"></td>';
		html += '	<td><input type="text" class="form-control input-xs" name="'+settings.name+'['+i+'][grade]" value="'+data.grade+'"></td>';
		html += '	<td><input type="text" class="form-control input-xs" name="'+settings.name+'['+i+'][deskriptif]" value="'+data.deskriptif+'"></td>';
		html += '	<td class="text-center" style="vertical-align:middle"><button class="btn btn-xs btn-danger" type="button" data-type="delete"><i class="fa fa-trash"></i></button></td>';
		html += '</tr>';
		container.find('tbody').append(html);
		i++;
		return container;
	}
	
	function set(data)
	{
		$.each(data, function(i, row){ add(row); });
		return container;
	}
	
	this.add = function(data){return add(data)};
	this.set = function(data){return set(data)};
	
	this.on('click', 'button[data-type="add"]',  function(){
		add();
	})
	
	this.on('click', 'button[data-type="delete"]', this, function(){
		$(this).parents('tr').remove();
	});
	
	if(settings.data)$.each(settings.data, function(key, val){
		add(val)
	})
	
	return this;
};