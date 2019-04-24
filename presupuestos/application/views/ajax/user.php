<form onsubmit="$.sic.nuevoSave();return false;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title"><?php if (isset($nuevo)) {echo "Nuevo Usuario";}else{echo "Editar Usuario";}?></h3>
    </div>
    <div class="modal-body">
        <input type="hidden" id="referencia" <?php if(isset($idu))echo 'value="'.$idu.'"'; ?> >
        <input type="hidden" id="referencia1" <?php if(isset($idp))echo 'value="'.$idp.'"'; ?> >
        <div class="row">
            <div class="">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="nombre" class="form-control" required <?php if(isset($nom))echo 'value="'.$nom.'"'; ?> />
                            <label class="form-label">Nombre</label>
                        </div>
                    </div>                
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="apellido" class="form-control" required <?php if(isset($ape))echo 'value="'.$ape.'"'; ?> />
                            <label class="form-label">Apellidos</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" id="correo" class="form-control" required <?php if(isset($cor))echo 'value="'.$cor.'"'; ?> />
                            <label class="form-label">Correo o Email</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="numeric" id="telefono" class="form-control" required <?php if(isset($tel))echo 'value="'.$tel.'"'; ?> />
                            <label class="form-label">Núm. Telefono</label>
                        </div>
                    </div>               
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="userN" class="form-control" required <?php if(isset($usr))echo 'value="'.$usr.'"'; ?> />
                            <label class="form-label">Nombre de usuario</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="passwordN" class="form-control" <?php if(!isset($pas))echo 'required'; ?>/>
                            <label class="form-label">Contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <select class="form-control show-tick" id="adminNew">
                        <option value="undefined"> Seleccione una opción</option>
                        <option value="0" <?php if(isset($adm)){if($adm==0)echo 'selected';} ?> >Usuario Normal</option>
                        <option value="1" <?php if(isset($adm)){if($adm==1)echo 'selected';} ?> >Administrador</option>
                    </select>
                </div>
                <?php if (!isset($nuevo)) { ?><a class="btn waves-effect bg-red btn-block" onclick="$.sic.deleteUserAcount();">ELIMINAR ESTE USUARIO</a> <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CERRAR</button>
        <button type="submit" class="btn bg-blue waves-effect">GUARDAR</button>
    </div>
</form>
<?php if (isset($nuevo)) {
?>   
<script>
    $.sic.nuevoSave=function () {
        nom=$("#nombre");
        ape=$("#apellido");
        cor=$("#correo");
        tel=$("#telefono");
        usr=$("#userN");
        pas=$("#passwordN");
        adm=$("#adminNew");
        //if (nom.val()!=undefined&&nom.val().replace(/\s/g,'')=='') {}
        datos={
            url:'./Inicio/accionUsuario',type:'post',
            data:{nom:nom.val(),ape:ape.val(),cor:cor.val(), tel:tel.val(),usr:usr.val(),pas:pas.val(),adm:adm.val(),act:'nuevo'},
            success:function (req) {
                try{
                    js=$.parseJSON(req);
                    swal(js.t, js.m, js.sw);
                    if (js.o==1) {
                        $.sic.nuevo('user');
                        $.sic.load('usuarios',$.sic.tituloSave);
                    }
                }catch(e){
                    swal('Error', $.sic.mjserr, 'error');
                }
            },
            error:function (as,dff,gg) {
                swal('Error', $.sic.mserr, 'error');
            }
        };
        $.sic.server(datos);
    }
</script>
<?php }else{
?>    
<script>
    $.sic.nuevoSave=function () {
        ref1=$("#referencia1");
        ref=$("#referencia");
        nom=$("#nombre");
        ape=$("#apellido");
        cor=$("#correo");
        tel=$("#telefono");
        usr=$("#userN");
        pas=$("#passwordN").val();
        adm=$("#adminNew");
        segmento=$("#segmento").val();
        //if (nom.val()!=undefined&&nom.val().replace(/\s/g,'')=='') {}
        if (pas==undefined||pas.replace(/\s/g,'')=='') {pas='0';}
        datos={
            url:'./Inicio/accionUsuario',type:'post',
            data:{ref1:ref1.val(),ref:ref.val(),nom:nom.val(),ape:ape.val(),cor:cor.val(), tel:tel.val(),usr:usr.val(),pas:pas,adm:adm.val(),act:'update'},
            success:function (req) {
                try{
                    js=$.parseJSON(req);
                    swal(js.t, js.m, js.sw);
                    if (js.o==1) {
                        //$.sic.nuevo('user');
                        $.sic.load('usuarios',$.sic.tituloSave);
                    }
                }catch(e){
                    swal('Error', $.sic.mjserr, 'error');
                }
            },
            error:function (as,dff,gg) {
                swal('Error', $.sic.mserr, 'error');
            }
        };
        $.sic.server(datos);
    }
    $.sic.deleteUserAcount=function () {
        ref=$("#referencia").val();
        swal({
            title: "Alerta",
            text: "El usuario será eliminado de la base de datos",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText:'Eliminar',
            cancelButtonText:'Cancelar'
        }, function () {
            datos={
                url:'./Inicio/remUserAcount',
                type:'post',
                data:{ref:ref},
                success:function (data) {
                    try{
                        js=$.parseJSON(data);
                        swal(js.t, js.m, js.sw);
                        if (js.o==1) {
                            $.sic.load('usuarios',$.sic.tituloSave);
                            $("#nuevo_modal").modal('hide');
                        }
                    }catch(e){
                        swal('Error', $.sic.mjserr, 'error');
                    }
                },
                error:function (qw,er,th) {
                    swal('Error', $.sic.mserr, 'error');
                }
            };
            $.sic.server(datos);            
        });
    }
</script>
<?php } ?>