<form onsubmit="$.sic.nuevoSave();return false;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title"><?php if (isset($nuevo)) {echo "Nueva Marca";}else{echo "Editar Marca";}?></h3>
    </div>
    <div class="modal-body">
        <input type="hidden" id="referencia" <?php if(isset($id))echo 'value="'.$id.'"'; ?> >
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
                            <input type="text" id="clave" class="form-control" required <?php if(isset($cve))echo 'value="'.$cve.'"'; ?> />
                            <label class="form-label">Clave</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="detalles" class="form-control" <?php if(isset($det))echo 'value="'.$det.'"'; ?> />
                            <label class="form-label">Detalles</label>
                        </div>
                    </div>               
                </div>
                <?php if(isset($id)){?>
                <div class="col-xs-12">
                    <button type="button" class="btn btn-block theme remove" data-ref="<?php echo $id; ?>"><i class="fas fa-trash"></i> ELIMINAR MARCA</button>
                </div>
                <?php } ?>
                <!--div class="col-xs-12">
                    <div class="row filesel">
                        <div class="col-xs-2">
                            <img src="./images/productos/producto.png" class="iconsic" id="imgPrev">
                        </div>
                        <div class="col-xs-10">
                            <input type="file" id="inputImg" class="inputImg" accept="image/jpeg">
                            <button type="button" class="inputReplace btn theme">SELECCIONE IMAGEN</button>
                            <br><div id="fileMSG"></div>
                        </div>
                    </div>
                </div-->
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
    /**$('.inputReplace').click(function(event) {
        $("#inputImg").click();
    });
    $('#inputImg').on('change', function(e) {
      div="#fileMSG";
      var Lector, 
          oFileInput = this; 
    console.log(oFileInput.files[0]);
      if (oFileInput.files.length === 0||oFileInput.files[0].type!='image/jpeg') {
        //console.log('Tipo de archivo no permitido');
        app.alert('Tipo de archivo no permitido','red',div);
        return false;
      }; 
      Lector = new FileReader();
      Lector.onloadend = function(e) {
        $('#imgPrev').attr('src', e.target.result);
        $(div).html(oFileInput.files[0].name);
        //console.log(e.target.result);          
      };
      Lector.readAsDataURL(oFileInput.files[0]);
    });**/
    $.sic.nuevoSave=function () {
        nom=$("#nombre");
        cve=$("#clave");
        det=$("#detalles");
        datos={
            url:'./Inicio/accionMarca',type:'post',
            data:{nom:nom.val(),det:det.val(),cve:cve.val(),act:'nuevo'},
            success:function (req) {
                try{
                    js=$.parseJSON(req);
                    swal(js.t, js.m, js.sw);
                    if (js.o==1) {
                        $.sic.nuevo('marca');
                        $.sic.load('marcas',$.sic.tituloSave);
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
    $('.remove').click(function(event) {
        ref=$(this).data('ref');
        swal({
            title: "Alerta",
            text: "La marca será eliminada de la base de datos",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText:'Eliminar',
            cancelButtonText:'Cancelar'
        }, function () {
            datos={
                url:'Inicio/remMarca',
                type:'post',
                data:{ref:ref},
                success:function (data) {
                    try{
                        js=$.parseJSON(data);
                        swal(js.t, js.m, js.sw);
                        if (js.o==1) {
                            $.sic.load('marcas',$.sic.tituloSave);
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
    });
    $.sic.nuevoSave=function () {
        ref=$("#referencia");
        nom=$("#nombre");
        cve=$("#clave");
        det=$("#detalles");
        segmento=$("#segmento").val();
        datos={
            url:'./Inicio/accionMarca',type:'post',
            data:{ref:ref.val(),nom:nom.val(),cve:cve.val(),det:det.val(),act:'update'},
            success:function (req) {
                try{
                    js=$.parseJSON(req);
                    swal(js.t, js.m, js.sw);
                    if (js.o==1) {
                        //$.sic.nuevo('user');
                        $.sic.load('marcas',$.sic.tituloSave);
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
<?php } ?>