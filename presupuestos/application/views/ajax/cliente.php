
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title"><?php if (isset($nuevo)) {echo "Nuevo Cliente";}else{echo "Editar Cliente";}?></h3>
    </div>
    <div class="modal-body">
        <form onsubmit="$.sic.nuevoSave();return false;" id="nuevoformPro">
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
                <div class="col-xs-12">
                    <button type="submit" class="btn bg-blue waves-effect btn-block">GUARDAR DATOS</button>
                </div>
            </div>
        </form>
        <?php if(!isset($nuevo)){ ?>
        <div class="row">
            <div class="col-xs-12">
                <h5>Cambiar imagen de producto</h5>
            </div>
            <form id="cambiarImagen">
                <input type="hidden" id="referencia1" name="referencia1" <?php if(isset($id))echo 'value="'.$id.'"'; ?> >
                <div class="col-xs-12">
                    <div class="row filesel">
                        <div class="col-xs-3 col-md-2">
                            <img src="./images/clientes/<?php if(isset($img))echo $img; ?>" class="iconsic" id="imgPrev">
                        </div>
                        <div class="col-xs-9">
                            <input type="file" id="inputImg" name="inputImg" class="inputImg" accept="image/jpeg,image/png">
                            <button type="button" class="inputReplace btn theme">SELECCIONE IMAGEN</button>
                            <br><div id="fileMSG"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <button type="submit" class="btn theme btn-block">GUARDAR IMAGEN</button>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CERRAR</button>
        
    </div>

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
    $(document).ready(function() {
        $('.inputReplace').click(function(event) {
            $("#inputImg").click();
        });
        $('#inputImg').on('change', function(e) {
          div="#fileMSG";
          var Lector, 
              oFileInput = this; 
        //console.log(oFileInput.files[0]);
        if (oFileInput.files.length) {
            if (!$.sic.imgFormat(oFileInput.files[0].type)) {
                //console.log('Tipo de archivo no permitido');
                $.sic.alert('Tipo de archivo no permitido','red');
                $(oFileInput).val('');
                return false;
            }
        }; 
          Lector = new FileReader();
          Lector.onloadend = function(e) {
            $('#imgPrev').attr('src', e.target.result);
            $(div).html(oFileInput.files[0].name);
            //console.log(e.target.result);          
          };
          Lector.readAsDataURL(oFileInput.files[0]);
        });
        $("#cambiarImagen").submit(function(event) {
            event.preventDefault();
            if ($("#inputImg").val()=='') {
                $.sic.alert('Selecciona una imagen para continuar','red');
                return false;
            }
            $('.nuevo_load').fadeIn();
            var formData = new FormData($("#cambiarImagen")[0]);
            datos={
                url:'./Inicio/updateimgCliente',
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
                            //$.sic.load('clientes',$.sic.tituloSave);
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
        });
    });
    
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