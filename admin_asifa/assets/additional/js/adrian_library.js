function validation(id){
    var frm = document.getElementsByClassName('frm_validation');
    var passed=true;
    
    for(i=0;i<frm.length;i++){
        if(frm[i].getAttribute('id')==id){
            var elm=frm[i].getElementsByTagName('INPUT');
            
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                if(elm[j].getAttribute('required')=='required'){
                    if($("#"+elmId).val()=='' || $("#"+elmId).val().length==0){
                        $("#name-error-"+elmId).remove();
                        //$("#"+elmId).parent().after('<div class="col-md-3 val-help-block"><p class="help-block"><i class="fa fa-times-circle"></i> Oops!</p></div>');
                        
                        $("#form-group-"+elmId).addClass('has-error');
                        //var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group has-error');
                        $("#"+elmId).after('<span id="name-error-'+elmId+'" class="help-block help-block-error">This field is required.</span>');
                        passed=false;
                    }else{
                        $("#name-error-"+elmId).remove();
                        $("#form-group-"+elmId).removeClass('has-error');
                        //$("#"+elmId).parent().next().remove();
                        //$("#"+elmId).parent().after('<div class="col-md-3 val-help-block"><p class="help-block"><i class="fa fa-check"></i> Great success!</p></div>');
                        //var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group has-success');
                    }
                }   
            }
            var elm=frm[i].getElementsByTagName('SELECT');
            
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                //alert(elmId);
                if(elm[j].getAttribute('required')=='required'){
                    if($("#"+elmId).val()=='' || $("#"+elmId).val()==null){
                        $("#name-error-"+elmId).remove();
                        //$("#"+elmId).parent().next().remove();
                        //$("#"+elmId).parent().after('<div class="col-md-3 val-help-block"><p class="help-block"><i class="fa fa-times-circle"></i> Oops!</p></div>');
                        $("#"+elmId).after('<span id="name-error-'+elmId+'" class="help-block help-block-error">This field is required.</span>');
                        var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group has-error');
                        passed=false;
                    }else{
                        $("#name-error-"+elmId).remove();
                        //$("#"+elmId).parent().next().remove();
                        //$("#"+elmId).parent().after('<div class="col-md-3 val-help-block"><p class="help-block"><i class="fa fa-check"></i> Great success!</p></div>');
                        //var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group has-success');
                    }
                }   
            }
            
            var elm=frm[i].getElementsByTagName('TEXTAREA');
            
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                //alert(elmId);
                if(elm[j].getAttribute('required')=='required'){
                    if($("#"+elmId).val()=='' || $("#"+elmId).val().length==0){
                        var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group has-error');
                        $("#"+elmId).after('<span id="name-error-'+elmId+'" class="help-block help-block-error">This field is required.</span>');
                        passed=false;
                    }else{
                        var par=$("#"+elmId).parent().parent().get(0).setAttribute('class','form-group');
                        $("#name-error-"+elmId).remove();
                    }
                }   
            }
        }
        //alert(frm[i].getAttribute('id'));
    }
    return passed;
}

function isValid(classname){
    var isOk=true;
    reset_validation();
    $("."+classname).each(function(i){
        if($(this).attr('required')=='required' && $(this).val()==''){
            $(this).parent().addClass('has-error');
            $(this).after('<p class="text-help text-danger">This field is required.</p>')
            $(".has-error > .control-label").attr('for','inputError');
            isOk=false;
        }else{
            var attr=$(this).attr("data-range");
            if(typeof attr !== typeof undefined && attr!==false){
                var lim=attr.split('-');
                var bot=lim[0];
                var up=lim[1];
                var val=$(this).val();
                
                console.log(lim);
                
                if(parseInt(val)<parseInt(bot) || parseInt(val) > parseInt(up)){
                    $(this).parent().addClass('has-error');
                    $(this).after('<p class="text-help text-danger">Value must between '+attr+'</p>')
                    $(".has-error > .control-label").attr('for','inputError');
                    isOk=false;   
                }else{
                    if($(this).attr('required')=='required'){
                        $(this).parent().addClass('has-success');
                        $(".has-success > .control-label").attr('for','success');    
                    }   
                }
            }else{
                if($(this).attr('required')=='required'){
                    $(this).parent().addClass('has-success');
                    $(".has-success > .control-label").attr('for','success');    
                }
                   
            }
        }
    });
    return isOk;
}


function reset_validation(){
    $(".help-block").remove();
    $(".form-group").removeClass('has-error');
    $(".form-group").removeClass('has-success');
    
    return false;
}

function clear_form(id){
    var frm = document.getElementsByClassName('frm_validation');
    
    for(i=0;i<frm.length;i++){
        if(frm[i].getAttribute('id')==id){
            var elm=frm[i].getElementsByTagName('INPUT');
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                var type=elm[j].getAttribute('type');
                if($("."+id+"#"+elmId).hasClass('timepicker')){
                    $("."+id+"#"+elmId).timepicker('setTime', '08:00 AM');
                }else
                if(type=='checkbox'){
                    $("."+id+"#"+elmId).prop('checked',false);
                }else
                $("."+id+"#"+elmId).val('');
            }
            
            var elm=frm[i].getElementsByTagName('SELECT');
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                $("."+id+"#"+elmId).val('');   
            }
            
            var elm=frm[i].getElementsByTagName('TEXTAREA');
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                $("."+id+"#"+elmId).val('');   
            }
        }
    }
    if($(".summernote").length>0) $(".summernote").code('');
    return false;
}

function clear_form_below(id,idTh){
    var isBelow=false;
    $("."+id).each(function(i){
        elmId=$(this).attr('id');
        if(isBelow)$("."+id+"#"+elmId).val('');
        if(elmId==idTh) isBelow=true;
    });
    return false;
}

function clear_detail(id){
    $("."+id).each(function(i){
        elmId=$(this).attr('id');
        if(elmId.substring(0,7)=='detail_')
             $("."+id+"#"+elmId).html('');
    });
    return false;
}

function generateDataString(id){
    var frm = document.getElementsByClassName('frm_validation');
    var res="";
    
    for(i=0;i<frm.length;i++){
        if(frm[i].getAttribute('id')==id){
            var elm=frm[i].getElementsByTagName('INPUT');
            for(j=0;j<elm.length;j++){ 
                var elmId=elm[j].getAttribute('id');
                var type=elm[j].getAttribute('type');
                if(type=='checkbox'){
                    if($("."+id+"#"+elmId).is(":checked"))
                        res+=("&"+elmId+"="+($("."+id+"#"+elmId).val())); 
                    else{
                        if($("."+id+"#"+elmId).val()=='NO')
                            res+=("&"+elmId+"=YES"); else res+=("&"+elmId+"=NO");   
                    }
                }else
                res+=("&"+elmId+"="+$("."+id+"#"+elmId).val());
            }
            
            var elm=frm[i].getElementsByTagName('SELECT');
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                res+=("&"+elmId+"="+$("."+id+"#"+elmId).val());   
            }
            
            var elm=frm[i].getElementsByTagName('TEXTAREA');
            for(j=0;j<elm.length;j++){
                var elmId=elm[j].getAttribute('id');
                res+=("&"+elmId+"="+$("."+id+"#"+elmId).val());   
            }
        }
    }
    res=res.substr(1,res.length);
    return res;
}
function genDataStringByClass(className){
    var res='';
    $("."+className).each(function(i){
        var type=$(this).attr('type');
        var id=$(this).attr('id');
        var htmlTag=$(this).prop('tagName');
        
        if(htmlTag=='INPUT'){
            if(type=='text' || type=='hidden' ) res+=('&'+id+'='+$(this).val())
        }else
        if(htmlTag=='SELECT' || htmlTag=='TEXTAREA'){
            res+=('&'+id+'='+$(this).val())
        }
    });
    res=res.substr(1,res.length);
    return res;
}
function fill_form(formId,data){
    $.each(data, function(index,value){
        if($("."+formId+"#"+index).prop('type')=='checkbox'){
            if($("."+formId+"#"+index).val()==value)
                $("."+formId+"#"+index).prop('checked',true);
            else    $("."+formId+"#"+index).prop('checked',false);
        }else
        if($('#'+index).hasClass('statictext')){
            $('#'+index).html(value);
        }else
        if($('#'+index).hasClass('timepicker')){
             $('#'+index).timepicker('setTime', value);
        }else
        $("."+formId+"#"+index).val(value);
    })
}

function fill_detail(formId,data){
    $.each(data, function(index,value){
        $("."+formId+"#detail_"+index).html(value);
    })
}