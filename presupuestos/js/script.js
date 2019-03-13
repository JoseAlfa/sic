﻿$.sic={
	server:function (data) {
		try{
			$.ajax(data);
		}catch(e){console.log(e);}
	},
	mjserr:'El servidor no respondió como se esperaba, es posible que los datos no hayan sido guardados',
	mserr:'Error, intente más tarde',
	tituloSave:"",
	vistas:'./Load_view/',
	load:function (url,head,parametros,titulo,panel,load,isModal) {
		if (url==undefined) {
			return false;
		}
		if ( !parametros || typeof parametros != "object" ) {
			parametros={q:""};
		}
		if (panel==undefined|| typeof panel === "string") {
			panel=$('#contenedor_general');
		}
		if (titulo==undefined|| typeof titulo === "string") {
			titulo=$('#titulo_general');
		}
		if (load==undefined|| typeof load === "string") {
			load=$('.page-loader-wrapper');
		}
		load.fadeIn();
		titulo.html(head);
		merr='Error, intente más tarde';
		var ret=false;
		datos={
			url:$.sic.vistas+url,
			data:parametros,
			type:'post',
			success:function (req) {
				panel.html(req);
				setTimeout(function() {load.fadeOut();$.AdminBSB.input.activate();$.AdminBSB.select.activate();}, 200);				
			},
			error:function (qw,er,ty) {
				panel.html('<p>'+merr+'</p>');
				if (isModal) {setTimeout(function() {$("#nuevo_modal").modal('hide');}, 3000); }
				$.sic.alert(merr,'red');
				load.fadeOut();
			}
		};
		$.sic.server(datos);
		return ret;
	},
	nuevo:function (url,ref) {
		if (ref===undefined) {ref=0;}
		if (url && typeof url==='string') {
			$("#nuevo_modal").modal('show');
			$.sic.load('vista_ajax',"",{nuevo:url,ref:ref},$("#niguno"),$("#nuevo_panel"),$(".nuevo_load"),true);
		}
	},
	buscar:function (form,seccion) {
		if (seccion==undefined) {return false;}
		datos=$(form).children('div').children('div').children('div').children('input').val();
		//alert(datos);
		$.sic.load(seccion,"Busqueda en "+$.sic.tituloSave,{q:datos});
	},
	rel:function () {
		window.location.reload();
	},
	changePS:function () {
		$('.pas_lod').fadeIn();
		ps=$("#ps").val();
		ps1=$("#ps1").val();
		ps2=$("#ps2").val();
		datos={url:'./Inicio/cambiarContrasena',type:'post',data:{ps:ps,ps1:ps1,ps2:ps2},
			success:function (req) {
				$('.pas_lod').fadeOut();
				try{
					js=$.parseJSON(req);
					if (js.o==1) {$('#cambiar_C').modal('hide');$("#ps").val('');$("#ps1").val('');$("#ps2").val('');}
					swal(js.t, js.m, js.sw);
				}catch(e){
					swal("Advertencia", "El servidor no respondió como se esperaba, es posible que la cotraseña no haya sido cambiada", "warning");
				}
			},
			error:function (we,rt,ee) {
				$('.pas_lod').fadeOut();
				swal("Error","Ha ocurrido un error,intente más tarde","error");
			}
		};
		$.sic.server(datos);	
	},
	Notify:function (message, position, timeout, theme, icon, closable) {
        toastr.options.positionClass = 'toast-' + position;
        toastr.options.extendedTimeOut = 0; //1000;
        toastr.options.timeOut = timeout;
        toastr.options.closeButton = closable;
        toastr.options.iconClass = ' toast-' + theme;
        //icon='<i class="fas '+icon+' fa-2x"></i> ';
        message='<sapan class="msg-toast">'+message+'</sapan>';
        toastr['custom'](message);
    },
	notificarC:true,
    saveColor:function (tema) {
    	datos={
    		url:'./Inicio/saveColor',type:'post',data:{color:tema},
    		success:function (req) {if($.sic.notificarC){$.sic.alert(req,'green');}},
    		error:function (we,tt,rr) {console.log('Error al guardar color');}
    	};
    	$.sic.server(datos);
    },
    alert:function (msg,color,div) {
      	if (msg==""||msg==undefined) {
        	msg="Algo pasa";
      	}
      	if (div==""||div==undefined) {
        	switch (color) {
          		case 'red':
	            	$.sic.Notify(msg, 'bottom-right', 4000, 'danger', 'fa-times', true);
	            	break;
	          	case 'blue':
		            $.sic.Notify(msg, 'bottom-right', 4000, 'blue', 'fa-info', true);
		            break;
	          	case 'org':
		            $.sic.Notify(msg, 'bottom-right', 4000, 'warning', 'fa-exclamation', true);
		            break;
	          	case 'green':
		            $.sic.Notify(msg, 'bottom-right', 4000, 'success', 'fa-check', true);
		            break;
	          	default:
		            $.sic.Notify(msg, 'bottom-right', 4000, 'magenta', 'fa-question-circle', true);
		            break;
	        }
      	}else{
        	switch (color) {
	          	case 'red':
	            	clase='alert-danger';
	            	break;
	          	case 'blue':
		          	clase='alert-info';
	            	break;
	          	case 'org':
		            clase='alert-warning';
	            	break;
	          	case 'green':
		            clase='alert-success';
	            	break;
	          	default:
		            clase='';
	            	break;
        	}
        	$(div).html('<div class="alert '+clase+' alert-dismissible animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>');
      	}
    }
};
$(document).ready(function() {
	/*panel*/
	$('.ml-menu li').click(function(event) {
		event.preventDefault();
		este=$(this);
		url=este.attr('data-get');
		nom=$(este.children('a')).html();
		if (url!=undefined&&typeof url==="string") {
			$.sic.tituloSave=nom;
			$.sic.load(url,nom);
			$("#cl").click();
		}
	});
	/*fin panel*/
	$(".ajuestes_bt").click(function(event) {
		event.preventDefault();
		setTimeout(function() {$('.js-right-sidebar').click();}, 200);
	});
	$(".notifi_q").change(function(event) {///cancear las notofocaciones de cambio de color
		event.preventDefault();
		if ($.sic.notificarC) {$.sic.notificarC=false;}else{$.sic.notificarC=true;}
	});
	$('.c_pass').click(function(event) {
		event.preventDefault();
		$('#cambiar_C').modal('show');
	});
	$('.chang_P').submit(function(event) {
		event.preventDefault();
		$.sic.changePS();
	});
	$(".salir_bt").click(function(event) {
		swal({
	        title: "¿Salir?",
	        text: "Al hacer click en \"Aceptar\" se cerrará la sesión",
	        type: "warning",
	        showCancelButton: true,
	        closeOnConfirm: false,
	        showLoaderOnConfirm: true,
	        confirmButtonText:'Aceptar',
	        cancelButtonText:'Cancelar'
	    }, function () {
	    	datos={
				url:'Inicio/salir',
				success:function (data) {
					swal("Hecho", "La sesión fue cerrada", "success");
					setTimeout(function () {
				        $.sic.rel();
				    }, 2000);
				},
				error:function (qw,er,th) {
					swal("Ha ocurrido un error", "Porfavor intente más tarde", "error");
				}
			};
			$.sic.server(datos);	        
	    });
		
	});
	$('.right-sidebar .demo-choose-skin a').on('click', function () {
        var $body = $('body');
        var $this = $(this);

        var existTheme = $.sic.theme;
        tema=$this.data('theme');
        $body.removeClass(existTheme);
        $.sic.theme='theme-' +tema;
        setTimeout(function() {$body.addClass('theme-' + tema);}, 100);
        setTimeout(function() {$.sic.saveColor(tema);}, 1000);        
    });
});