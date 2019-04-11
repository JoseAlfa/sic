<form onsubmit="$.sic.nuevoSave();return false;" id="nuevoformPro">
    <div class="modal-header">
        <div class="row"></div>
        <h3 class="modal-title"><?php if (isset($nuevo)) {echo "Nuevo Cliente";}else{echo "Editar Cliente";}?></h3>
    </div>
    <div class="modal-body">
        <input type="hidden" id="referencia" name="referencia" <?php if(isset($id))echo 'value="'.$id.'"'; ?> >
        <div class="row">
            <div class="">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="nombre" name="nombre" class="form-control" required <?php if(isset($nom))echo 'value="'.$nom.'"'; ?> />
                            <label class="form-label">Nombre</label>
                        </div>
                    </div>                
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" id="correo" name="correo" class="form-control" required <?php if(isset($cor))echo 'value="'.$cor.'"'; ?> />
                            <label class="form-label">Correo o Email</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="numeric" id="telefono" name="telefono" class="form-control" required <?php if(isset($tel))echo 'value="'.$tel.'"'; ?> />
                            <label class="form-label">Núm. Telefono</label>
                        </div>
                    </div>               
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="direccion" name="direccion" class="form-control" required <?php if(isset($dir))echo 'value="'.$dir.'"'; ?> />
                            <label class="form-label">Dirección</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="cp" name="cp" class="form-control" required <?php if(isset($cp))echo 'value="'.$cp.'"'; ?> />
                            <label class="form-label">Código postal</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="atn" name="atn" class="form-control" <?php if(isset($atn))echo 'value="'.$atn.'"'; ?> />
                            <label class="form-label">AT'N</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <?php if (!isset($nuevo)) { ?><a class="btn waves-effect bg-red btn-block" onclick="$.sic.deleteCliente();">ELIMINAR ESTE CLIENTE</a> <?php } ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <b>Tipo</b>
                    <select class="form-control show-tick" id="tipo" name="tipo">
                        <option value="undefined"> Seleccione una opción</option>
                        <option value="0" <?php if(isset($em)){if($em==0)echo 'selected';} ?> >Persona</option>
                        <option value="1" <?php if(isset($em)){if($em==1)echo 'selected';} ?> >Empresa</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6">
                    <b>En curriculum empresarial</b>
                    <select class="form-control show-tick" id="mostrar" name="mostrar">
                        <option value="undefined"> Seleccione una opción</option>
                        <option value="1" <?php if(isset($show)){if($show==1)echo 'selected';} ?> >Mostrar</option>
                        <option value="0" <?php if(isset($show)){if($show==0)echo 'selected';} ?> >Ocultar</option>
                    </select>
                    <span class="text-danger">**Esto solo aplica para el curriculum empresarial</span>
                </div>
                
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
        $('.nuevo_load').fadeIn();
            var formData = new FormData($("#nuevoformPro")[0]);
            datos={
                url:'./Inicio/nuevoCliente',
                type:'post',
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function (req) {
                    $('.nuevo_load').fadeOut();
                    try{
                        js=$.parseJSON(req);
                        swal(js.t, js.m, js.sw);
                        if (js.o==1) {
                            $.sic.nuevo('cliente');
                            $.sic.load('clientes',$.sic.tituloSave);
                        }
                    }catch(e){
                        swal('Error', $.sic.mjserr, 'error');
                    }
                },
                error:function (as,dff,gg) {
                    $('.nuevo_load').fadeOut();
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
        $('.nuevo_load').fadeIn();
            var formData = new FormData($("#nuevoformPro")[0]);
            datos={
                url:'./Inicio/updateCliente',
                type:'post',
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function (req) {
                    $('.nuevo_load').fadeOut();
                    try{
                        js=$.parseJSON(req);
                        swal(js.t, js.m, js.sw);
                        if (js.o==1) {
                            $.sic.load('clientes',$.sic.tituloSave);
                        }
                    }catch(e){
                        swal('Error', $.sic.mjserr, 'error');
                    }
                },
                error:function (as,dff,gg) {
                    $('.nuevo_load').fadeOut();
                    swal('Error', $.sic.mserr, 'error');
                }
            };
            $.sic.server(datos);
    }
    $.sic.deleteCliente=function () {
        ref=$("#referencia").val();
        swal({
            title: "Alerta",
            text: "El cliente será eliminado de la base de datos",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText:'Eliminar',
            cancelButtonText:'Cancelar'
        }, function () {
            datos={
                url:'./Inicio/remCliente',
                type:'post',
                data:{ref:ref},
                success:function (data) {
                    try{
                        js=$.parseJSON(data);
                        swal(js.t, js.m, js.sw);
                        if (js.o==1) {
                            $.sic.load('clientes',$.sic.tituloSave);
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