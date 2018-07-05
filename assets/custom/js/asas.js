jQuery(function() {
	$('body').tooltip({selector : '[rel="tooltip"]'})
});


function validate(element)
{
	var error = [];
	
	$(element+' [validate]').each(function()
	{
		var title = $(this).attr('title');
		if (title == undefined) title = $(this).parents('.form-group').find('label').first().html();
		if (title == undefined) title = $(this).parents('tr').find('th:first-child').first().html();
		if (title == undefined) title = $(this).attr('name');
		
		title = '<b>' + title + '</title>';
		
		var value = $(this).val().trim();
		var is_error = false;
		var attrs = $(this).attr('validate');
		var attrs = attrs.split(';');
		$(this).parents('.form-group').removeClass('has-error');
		for(var i=0; i<attrs.length; i++)
		{
			var attr = attrs[i];
			if (is_error) break;
			if (attr == '') continue;
			
			switch(attr) {
				
				// required
				case 'required':
					if (value == '' || value == undefined || value == null) is_error = title + ' tidak boleh kosong.';
					break;
				
				// email
				case 'email':
					var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (!re.test(value)) is_error = title + ' harus berisi alamat email yang valid.';
					break;
				
				// number
				case 'number':
					if (isNaN(value)) is_error = title + ' harus berisi angka.';
					break;

				// username
				case 'code':
					if (!value.match(/^[a-zA-Z0-9\_\-\.]{3,50}$/)) is_error = title + ' hanya boleh berisi angka, huruf, - (minus), _ (garis bawah), .(titik)';
					break;
				
				// min
				case regexMatch(/^min\:.*$/, attr) :
					var param = attr.match(/^min\:(.*)$/)[1];
					if (value.length < param ) is_error = title + ' tidak boleh kurang dari '+param+' karakter.';
					break;
				
				// max
				case regexMatch(/^max\:.*$/, attr) :
					var param = attr.match(/^max\:(.*)$/)[1];
					if (value.length > param ) is_error = title + ' tidak boleh lebih dari '+param+' karakter.';
					break;
				
				// match
				case regexMatch(/^match\:.*$/, attr) :
					var param = attr.match(/^match\:(.*)$/)[1];
					var match_value = $(param).val().trim();
					var match_title = $(param).parents('.form-group').find('label').html();
					if (value !== match_value) is_error = title + ' harus sama persis dengan <b>'+match_title+'</b>.';
					break;
					
				// unique
				case regexMatch(/^unique\:.*$/, attr) :
					var param = attr.match(/^unique\:(.*)\|(.*)$/);
					var my_url = param[2]+'/'+param[1]+'/'+value;
					$.ajax({ 
						type: 'GET',
						url: my_url,
						async: false,
						success: function(data)
						{
							if (data !== 'true') is_error = title + ' yg anda masukka telah ada di sistem, harap masukan '+title+' yang berbeda.';
						},
						error: 	function(a,data,textStatus){ 
							is_error = title + ' : terdapat kesalahan pada server.';
						}
					});
					break;
				
				default:
			
			}
			
			if (is_error) 
			{
				$(this).parents('.form-group').addClass('has-error');
				error.push(is_error);
				break;
			}
		}

	})
	
	if (error.length < 1) 
	{
		$(element).find('.validation_msg').fadeOut('slow', function(){
			$(this).remove();
		});
		return true;
	}
	
	var error_html = '<ul>';
	for (var i=0; i < error.length; i++)
	{
		error_html += '<li>'+error[i]+'</li>';
	}
	error_html += '</ul>'
	error_html = '<div class="validation_msg"><div class="alert alert-dismissable alert-danger">Anda tidak bisa melanjutkan ke proses selanjutnya dikarenakan hal berikut : <br><br>'+error_html+'</div><br></div>';
	
	
	if ($(element).find('.validation_msg').length)
	{
		
		$(element).find('.validation_msg').fadeOut('slow', function(){
			$(this).remove();
			$(element).prepend(error_html);
			if($(element).parents('.modal').length) $(element).parents('.modal').animate({ scrollTop: $(".validation_msg").offset().top}, 500);
			else $('html, body').animate({ scrollTop: $(".validation_msg").offset().top }, 500);
			
			$(element).find('.has-error').first().find('.form-control').first().focus()
		});
	}
	else {
		$(element).prepend(error_html);
		if($(element).parents('.modal').length) $(element).parents('.modal').animate({ scrollTop: $(".validation_msg").offset().top}, 500);
		else $('html, body').animate({ scrollTop: $(".validation_msg").offset().top}, 500);
		$(element).find('.has-error').first().find('.form-control').first().focus()
	}
	
	return false;
	
	
	
	function regexMatch(regex, value)
	{
		if (value.match(regex)) return value;
		else return false;
	}
}

function int2rupiah(tes)
{
	if (tes == null || tes == undefined) return '-';
	tes = tes.toString();
	tes = tes.split('').reverse().join('');
	var arr = tes.match(/.{1,3}/g);
	tes = arr.join('.').split('').reverse().join('');
	tes = 'Rp. '+tes+',-';
	return tes;
}

function mysqldate2date(tes)
{
	if (!tes) return '';
	var bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
	var arr = tes.split('-');
	return parseInt(arr[2])+' '+bulan[parseInt(arr[1])]+' '+arr[0];
}

function mysqldate2inddate(tes)
{
	if (!tes) return '';
	var arr = tes.split('-');
	return parseInt(arr[2])+'/'+parseInt(arr[1])+'/'+arr[0];
}


function ucfirst(string)
{
	return string.charAt(0).toUpperCase() + string.slice(1);
}