    var base_url = "<?php echo base_url(); ?>";
    
    $("#Warga_Negara").change(function(){
        if($("#Warga_Negara").val()=='WNA')
            $("#form-group-Kewarganegaraan").show(400)
        else
            $("#form-group-Kewarganegaraan").hide(400)
    })
    $("#Is_Terima_KPS").change(function(){
        if($("#Is_Terima_KPS").val()=='YES')
            $("#form-group-No_KPS").show(400)
        else
            $("#form-group-No_KPS").hide(400)
    })
    
    function isiSampleData(){
        $("#Nama_Mhs").val('Ahmad Rianto');
        $("#JK_Mhs").val('L');
        $("#Warga_Negara").val('WNI');
        $("#Anak_ke").val('1');           
        $("#Jumlah_Saudara_Kandung").val('0');
        $("#Prov_Lahir").val('05');
        getKotaByProvinsi("Prov_Lahir","Tempat_Lahir","31");
        $("#Tgl_Lahir").val('04/29/1993');
        $("#Agama_id").val('2');
        $("#No_KTP_Mhs").val('3571032904930006');
        $("#Telp").val('085749809213');
        $("#Tlp_HP").val('085649192014');
        $("#Email").val('rian@stiki.ac.id');
        
        $("#Id_Jenis_Tinggal").val('3');
        $("#Alamat_Jalan_Mhs").val('Jalan Candi 3E No 50');
        $("#Alamat_RT").val('003');
        $("#Alamat_RW").val('003');
        $("#Alamat_Dusun").val('Karang Besuki');
        $("#Alamat_Desa_Kelurahan").val('Sukun');
        $("#Alamat_Kode_Pos").val('64136');
        $("#Alamat_Prov").val('05');
        getKotaByProvinsi("Alamat_Prov","Alamat_Kode_Kota","13");
        $("#Id_Alamat_Transport").val('13');
        
        $("#Alamat_asl").val('Jalan raya bawang 50 Bawang Pesantren');
        $("#Prov_Asal_Mhs").val('05');
        getKotaByProvinsi("Prov_Asal_Mhs","Kode_Kota_asl","31");
        
        $("#Kd_pekerjaan_mhs").val('17');
        $("#Nama_Kantor").val('STIKI Malang');
        $("#Alamat_Kantor").val('Jalan Raya Tidar 100 Malang');
        $("#Telp_Kantor").val('0341 560823');
        
        $("#Is_Terima_KPS").val('YES');
        $("#form-group-No_KPS").show(400);
        $("#No_KPS").val('12345679');
        
        $("#Is_Terima_KPS").val('NO');
        
        $("#Nama_Ayah").val('Edi Sukamto');
        $("#No_KTP_Ayah").val('123456789123');
        $("#Tgl_Lahir_Ayah").val('04/29/1993');
        $("#Id_Jenjang_Pendidikan_Ayah").val('6');
        $("#Kd_Pekerjaan_Ayah").val('1');
        $("#Id_Penghasilan_Ayah").val('2');
        $("#Nama_Ibu").val('Sumarni');
        $("#No_KTP_Ibu").val('123456789123');
        $("#Tgl_Lahir_Ibu").val('04/29/1993');
        $("#Id_Jenjang_Pendidikan_Ibu").val('6');
        $("#Kd_Pekerjaan_Ibu").val('1');
        $("#Id_Penghasilan_Ibu").val('2');
        $("#Alamat_Ortu").val('Jalan Tidar 100 Malang');
        $("#Prov_Ortu").val('05');
        getKotaByProvinsi("Prov_Ortu","Kode_Kota_Ortu","13");
        $("#Telp_Ortu").val('0354698459');
        $("#Telp_HP_Ortu").val('081312319263');
        
        $("#Nama_Wali").val('Walinya Adrian');
        $("#No_KTP_Wali").val('0987654321');
        $("#Tgl_Lahir_Wali").val('04/29/1993');
        $("#Id_Jenjang_Pendidikan_Wali").val('6');
        $("#Kd_Pekerjaan_Wali").val('1');
        $("#Id_Penghasilan_Wali").val('2');
        $("#Alamat_Wali").val('Jalan Tidar 100 Malang');
        $("#Prov_Wali").val('05');
        getKotaByProvinsi("Prov_Wali","Kode_Kota_Wali","13");
        $("#Telp_Wali").val('0354698459');
        $("#Telp_HP_Wali").val('081312319263');
        
        //$("#Prov_SMA").val('05');
//        getKotaByProvinsi("Prov_SMA","Kota_SMA","33");
//        $("#Id_Jurusan").val('1');
//        $("#Total_Nilai_UAN").val('56');
//        getSchList("33","051172");
//        $("#Tgl_Lulus").val('04/29/2015');
//        $("#Status_Masuk").val('Pindahan');
        
        $("#portlet-asalPt").show(400);
        $("#Kode_PT").val('073025');
        $("#Jenjang_PT").val('S1');
        getProdiList_PTAsal('073025','D3','57401');
        $("#NIM_PT_Asal").val('101110254');
        
        $("#Pilihan_Jenjang").val('S1');
        getListOfProdi('S1','DK-S1');
        $("#Kelas").val('R');
        $("#Jalur_Penerimaan").val('5');
        $("#Id_Informasi").val('1');
    }
    
    $(".step").click(function(){
        var tabNum=$(this).find("span.number").html();
        var tab=getActiveTab();
        isValid=true;
        if(parseInt(tabNum)>parseInt(tab)){
            var ind=tab-1;
        
            $("#tab"+tab+" .frm_validation").each(function(){
                if(!validation($(this).attr('id'))){
                    isValid=false;
                    return false;
                }
            })    
        }
        
        if(isValid) handleTitle(tabNum); else return false;
    })
    function getActiveTab(){
        var tab=0;
        $(".step").each(function(i){
            if($(".step").eq(i).parent().attr('class')=='active'){
                tab=i+1;
                return false;
            }              
        });
        return tab;
    }
    function handleTitle(tab){
        var total=$(".step").length;
        
        //wizard title and header
        $(".step").each(function(i){
            $(".step").eq(i).parent().removeClass('active done');
            if(i<(tab-1)) $(".step").eq(i).parent().addClass('done'); else
            if(i==(tab-1)) $(".step").eq(i).parent().addClass('active');            
        });
        $("#form_wizard_1").find(".step-title").html("Step "+tab+" of "+total);
        $(".tab-pane").removeClass('active');
        $(".step").eq(tab-1).parent().addClass('active');
        $(".tab-pane").eq(tab-1).addClass('active');
        
        //progress bar
        var $percent = (tab / total) * 100;
        $('#form_wizard_1').find('.progress-bar').css({
            width: $percent + '%'
        });
        
        //button navigation
        if(tab==1){
            $(".button-previous").hide(400);
            $(".button-submit").hide(400);
            $(".button-next").show(400);
            $(".button-draft").show(400);
            $(".button-save").hide(400);
        }else
        if(tab>1 && tab<total){
            $(".button-previous").show(400);
            $(".button-submit").hide(400);
            $(".button-next").show(400);
            $(".button-draft").show(400);
            $(".button-save").hide(400);
        }else{
            $(".button-previous").show(400);
            $(".button-submit").show(400);
            $(".button-next").hide(400);
            $(".button-draft").hide(400);
            $(".button-save").show(400);
        }
    }
    function onNext(){
        var tab=getActiveTab();
        var ind=tab-1;
        isValid=true;
        $("#tab"+tab+" .frm_validation").each(function(){
            if(!validation($(this).attr('id'))){
                isValid=false;
                return false;
            }
        })
        if(isValid) handleTitle(tab+1);
        $( "body" ).scrollTop( 0 );
    }
    function onPrev(){
        var tab=getActiveTab();
        handleTitle(tab-1);
    }
    function onSubmit(state){
        Metronic.blockUI({ boxed: true });
        $(".btn-nav").attr('disabled','disabled');
        simpan(state);
    }
    $("#Prov_Lahir").change(function(){
        getKotaByProvinsi("Prov_Lahir","Tempat_Lahir","");
    })
    $("#Alamat_Prov").change(function(){
        getKotaByProvinsi("Alamat_Prov","Alamat_Kode_Kota","");
    })
    $("#Prov_Asal_Mhs").change(function(){
        getKotaByProvinsi("Prov_Asal_Mhs","Kode_Kota_asl","");
    })
    $("#Prov_Ortu").change(function(){
        getKotaByProvinsi("Prov_Ortu","Kode_Kota_Ortu","");
    })
    $("#Prov_SMA").change(function(){
        getKotaByProvinsi("Prov_SMA","Kota_SMA","");
    })
    $("#Kota_SMA").change(function(){
        getSchList($("#Kota_SMA").val(),"");
    })
    $("#Kode_PT").change(function(){
        getDaftarProdi();
    })
    $("#Jenjang_PT").change(function(){
        getDaftarProdi();
    })
    $("#Status_Masuk").change(function(){
        if($("#Status_Masuk").val()=='Pindahan'){
            $("#portlet-asalPt").show(400)
        }else{
            $("#portlet-asalPt").hide(400);
        }
    })
    
    $("#Pilihan_Jenjang").change(function(){
        getListOfProdi($("#Pilihan_Jenjang").val(),'');
    })
    $("#Usulan_Jalur_Penerimaan").change(function(){
        getSyaratDaftar($("#Usulan_Jalur_Penerimaan").val());
    })
    function getSyaratDaftar(jalur){
        var string="Id_JalurPenerimaan="+jalur;
        $.ajax({
			type	: 'POST',
			url		: "<?php echo base_url(); ?>index.php/tr_pmb_insert_data/getSyaratDaftar",
			data	: string,
			cache	: true,
			dataType : "json",
			success	: function(data){
                $("#syarat_daftar").html(data.syarat);
                handleiCheck();
                
                //$("#form_prodi").val(prodi);		
				return false;
			}
	   });
    }
    $("#Kelas").change(function(){
        //FormiCheck.init();
        //alert('work');
    })
    function handleiCheck(){
        $('.icheck').each(function() {
            var checkboxClass = $(this).attr('data-checkbox') ? $(this).attr('data-checkbox') : 'icheckbox_minimal-grey';
            var radioClass = $(this).attr('data-radio') ? $(this).attr('data-radio') : 'iradio_minimal-grey';

            if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass,
                    insert: '<div class="icheck_line-icon"></div>' + $(this).attr("data-label")
                });
            } else {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass
                });
            }
        });
    }
    function ekstrakSyaratDaftar(){
        var res='';
        $(".check-syaratdaftar").each(function(){
            if($(this).is(':checked')) var chk='YES'; else var chk='NO'; 
            res+=(','+$(this).val()+'is'+chk);
        })
        res=res.substr(1,res.length);
        return res;
    }
    