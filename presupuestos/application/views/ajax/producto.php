    <div class="modal-header">
        <div class="row"></div>
        <h3 class="modal-title"><?php if (isset($nuevo)) {echo "Nuevo Producto";}else{echo "Editar Producto";}?></h3>
    </div>
    <div class="modal-body">
        <form id="nuevoformPro" onsubmit="$.sic.nuevoSave();return false;">
            <input type="hidden" id="referencia" name="referencia" <?php if(isset($id))echo 'value="'.$id.'"'; ?> >
            <div class="row">
                <div class="">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="nombre" id="nombre" class="form-control" required <?php if(isset($nom))echo 'value="'.$nom.'"'; ?> />
                                <label class="form-label">Nombre</label>
                            </div>
                        </div>                
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="clave" name="clave" class="form-control" required <?php if(isset($cve))echo 'value="'.$cve.'"'; ?> />
                                <label class="form-label">Clave</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="detalles" name="detalles" class="form-control" <?php if(isset($det))echo 'value="'.$det.'"'; ?>>
                                <label class="form-label">Detalles</label>
                            </div>
                        </div>               
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <b>Marca</b>
                        <select class="form-control show-tick" id="marca" name="marca">
                            <?php if(isset($marcas)){echo $marcas;} ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <b>Tipo de producto</b>
                        <select class="form-control show-tick" id="tipo" name="tipo">
                            <?php if(isset($tipoPro)){echo $tipoPro;} ?>
                        </select>
                    </div>
                    <?php if(isset($nuevo)){ ?>
                    <div class="col-xs-12">
                        <div class="row filesel">
                            <div class="col-xs-3 col-md-2">
                                <img src="./images/productos/producto.png" class="iconsic" id="imgPrev">
                            </div>
                            <div class="col-xs-10">
                                <input type="file" id="inputImg" name="inputImg" class="inputImg" accept="image/jpeg,image/png">
                                <button type="button" class="inputReplace btn theme">SELECCIONE IMAGEN</button>
                                <br><div id="fileMSG"></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-xs-12">
                        <button type="submit" class="btn bg-blue waves-effect btn-block">GUARDAR</button>
                    </div>
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
                            <img src="./images/productos/<?php if(isset($img))echo $img; ?>" class="iconsic" id="imgPrev">
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
          if (oFileInput.files.length === 0||oFileInput.files[0].type!='image/jpeg') {
            //console.log('Tipo de archivo no permitido');
            $.sic.alert('Tipo de archivo no permitido','red');
            return false;
          }; 
          Lector = new FileReader();
          Lector.onloadend = function(e) {
            $('#imgPrev').attr('src', e.target.result);
            $(div).html(oFileInput.files[0].name);
            //console.log(e.target.result);          
          };
          Lector.readAsDataURL(oFileInput.files[0]);
        });
    <?php if (isset($nuevo)) { ?>   
        $.sic.nuevoSave=function () {
            $('.nuevo_load').fadeIn();
            var formData = new FormData($("#nuevoformPro")[0]);
            datos={
                url:'./Inicio/saveNuevoPro',
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
                            $.sic.nuevo('producto');
                            $.sic.load('productos',$.sic.tituloSave);
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
    <?php }else{ ?>
        $("#cambiarImagen").submit(function(event) {
            event.preventDefault();
            if ($("#inputImg").val()=='') {
                $.sic.alert('Selecciona una imagen para continuar','red');
                return false;
            }
            $('.nuevo_load').fadeIn();
            var formData = new FormData($("#cambiarImagen")[0]);
            datos={
                url:'./Inicio/updateimgPro',
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
                            $.sic.load('productos',$.sic.tituloSave);
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
        $.sic.nuevoSave=function () {
            $('.nuevo_load').fadeIn();
            var formData = new FormData($("#nuevoformPro")[0]);
            datos={
                url:'./Inicio/updatedataPro',
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
                            $.sic.load('productos',$.sic.tituloSave);
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
    <?php } ?>  
    });
</script>
    