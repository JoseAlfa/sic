<div class="header" style="border-bottom: 0px;">
                            <?php if (isset($onlyView)){ ?>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown mybtnmore">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span>Más</span>
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right" style="min-width: 190px;">
                                        <?php if(!isset($plantilla)){ if (isset($onlyView)) {?>
                                            <li><a href="./Report/generar?ref=<?php if(isset($ref)){echo $ref;} ?>" target="_blank" onclick="void(0);"><i class="material-icons">remove_red_eye</i>Vista previa en pdf</a></li>
                                            <li id="cerrarPreSure"><a href="javascript:void(0);"><i class="material-icons">beenhere</i> Cerrar presupuesto</a></li>
                                            <li id="deletePreSure"><a href="javascript:void(0);"><i class="material-icons">delete</i> Eliminar presupuesto</a></li>
                                        <?php } }else{ ?>
                                            <?php if (isset($onlyView)) { ?>
                                            <li id="generarPreSure"><a href="javascript:void(0);"><i class="material-icons">settings_backup_restore</i> Generar presupuesto</a></li>
                                            <li id="deletePreSure"><a href="javascript:void(0);"><i class="material-icons">delete</i> Eliminar plantilla</a></li>
                                            <?php
                                            } 
                                        }?>
                                        
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>
</div>

<!-- Tabs With Icon Title -->
<div class="body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tab-col-theme" role="tablist">
        <li role="presentation" class="active">
            <a href="#genraralData" data-toggle="tab">
                <i class="fas fa-clipboard-list"></i> Datos generales
            </a>
        </li>
        <li role="presentation">
            <a href="#product_cot" data-toggle="tab">
                <i class="fas fa-th-list"></i> Cotización
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane animated fadeIn active" id="genraralData">
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <b>Cliente</b>
                </div>
                <div class="col-sm-12">
                    <select name="clientePre" id="clientePre" <?php if (isset($onlyView)){ ?> onchange="$.sic.updateClient($(this).val());" <?php }else{ ?> disabled <?php } ?>>
                        <?php if(isset($clientes))echo $clientes; ?>
                    </select>
                </div>
            </div>
            <br>
            <form onsubmit="<?php if (isset($onlyView)){ ?> $.sic.saveDetallesEdit();<?php } ?>return false;">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" id="detallesPreData" class="form-control" required <?php if(isset($detalle))echo 'value="'.$detalle.'"'; if (!isset($onlyView)) {echo "disabled";} ?> />
                        <label class="form-label">Detalles de presupuesto</label>
                    </div>
                </div>

            <?php if (isset($onlyView)){ ?> 
                <button class="btn bg-blue" type="submit">Guardar</button>
            <?php } ?>

            </form><br>
            <form onsubmit="<?php if (isset($onlyView)){ ?> $.sic.saveOtrosPreData();<?php } ?>return false;">
                <div class="row">
                    <div class="col-xs-12">
                        <h3>Otros datos</h3>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="detallesPagoData" class="form-control" required <?php if(isset($pago))echo 'value="'.$pago.'"'; if(!isset($onlyView)){echo "disabled";}?> />
                                <label class="form-label">Forma de pago</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="vencimientoData" class="form-control" required <?php if(isset($vencimiento))echo 'value="'.$vencimiento.'"'; if(!isset($onlyView)){echo "disabled";}?> />
                                <label class="form-label">Vencimiento</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="otrosDetallesData" class="form-control" <?php if(isset($otros)){echo 'value="'.$otros.'"';}if(!isset($onlyView)){echo "disabled";} ?>>
                                <label class="form-label">Otros datos</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                <?php if (isset($onlyView)){ ?><button class="btn bg-blue" type="submit">Guardar</button><?php } ?>
                    </div>
                
                </div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="product_cot">
            <?php if (isset($onlyView)){ ?>
            <form onsubmit="$.sic.saveProductosInPre();return false;" id="addProform">
                <div class="row">
                    <div class="col-xs-12">
                        <b>Unidad</b>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <select name="productPre" id="productPre" onchange="$.sic.loadProdata($(this).val());">
                            <?php if(isset($productos))echo $productos; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="number" id="precioPre" name="precioPre" class="form-control" required />
                                <label class="form-label">Prec.</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="number" id="cantPre" name="cantPre" class="form-control" required />
                                <label class="form-label" id="medidaShow">Cant.</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <button class="btn brn-sm theme" type="submit">AGREGAR</button>
                    </div>
                </div>
            </form>
        <?php } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6"></div>
                <div class="col-xs-12 col-sm-6">
                    Subtotal: <b id="subtotalPre">$ <?php if(isset($totalfin)){echo $totalfin;} else {echo 0;} ?></b> 
                    + IVA <b class="detail" id="ivash"><?php if(isset($iva)){echo $iva;}else{echo 16;} ?>%</b> 
                    Total: <b id="totalfin">$ <?php if(isset($totalfin)){echo $totalfin;} else {echo 0;} ?></b>
                </div>
            </div>
            <hr>
            <div class="body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody id="presupuestoList">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- #END# Tabs With Icon Title -->
<!-- Small Size -->
<div class="modal fade" id="detailpreModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="smallModalLabel">Antes de empezar <small>Ingrese los siguientes datos</small></h3>
            </div>
            <div class="modal-body">
                <form onsubmit="$.sic.nuevopredet();return false;">
                    <div class="">
                        <b>Guardar como:</b>
                        <select name="productPre" id="saveAsPre">
                            <option value="0" selected>Presupuesto</option>
                            <option value="1">Plantilla para resupuesto</option>
                        </select><br><br>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="detallesnewpre" class="form-control" required/>
                            <label class="form-label">Detalles de presupuesto</label>
                        </div>
                    </div>
                    <button type="submit" hidden id="nuevopredetsavebtn">save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-red waves-effect" onclick="$.sic.cancelNP();" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn bg-blue waves-effect" onclick="$('#nuevopredetsavebtn').click();">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        <?php if (isset($nuevo)){ ?>
            $('#detailpreModal').modal('show');
        <?php }?>
        $.sic.json=<?php echo $json; ?>;
        $.sic.iva=<?php if(isset($iva)){echo $iva;}else{echo 16;} ?>;
        $.sic.totalfin=<?php if(isset($totalfin)){echo $totalfin;} else {echo 0;} ?>;
        $.sic.idpreinwindow=<?php if(isset($idpre)){echo $idpre;} else {echo 0;} ?>;
        $("#deletePreSure").click(function(event) {
            texto=<?php if(isset($plantilla)){echo '"a plantilla será eliminada"';}else{ echo '"e presupuesto será eliminado"';} ?>;
            swal({
                title: "Alerta",
                text: "Est"+texto+" completamente y esta acción no puede ser deshecha, ¿aún asi desea continuar?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonText:'Continuar',
                cancelButtonText:'Cancelar'
            }, function () {
                datos={
                    url:'./Inicio/deletePre',
                    type:'post',
                    data:{ref:$.sic.idpreinwindow},
                    success:function (data) {
                        try{
                            js=$.parseJSON(data);
                            swal(js.t, js.m, js.sw);
                            if (js.o==1) {
                                $.sic.load('getPresupuestoClose','Presupuestos cerrados');
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
        $("#cerrarPreSure").click(function(event) {
            swal({
                title: "¡IMPORTANTE!",
                text: "Una vez cerrado este presupuesto, no podrá ser editado, ¿aún asi desea continuar?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonText:'Continuar',
                cancelButtonText:'Cancelar'
            }, function () {
                datos={
                    url:'./Inicio/closePre',
                    type:'post',
                    data:{ref:$.sic.idpreinwindow},
                    success:function (data) {
                        try{
                            js=$.parseJSON(data);
                            swal(js.t, js.m, js.sw);
                            if (js.o==1) {
                                $.sic.load('getPresupuestoClose','Presupuestos cerrados');
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
        <?php if (isset($onlyView)){ ?>
        $("#generarPreSure").click(function(event) {
            swal({
                title: "¡IMPORTANTE!",
                text: "Al hacer click en continuar un nuevo presupuesto será generado a base de esta plantilla, ¿aún asi desea continuar?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonText:'Continuar',
                cancelButtonText:'Cancelar'
            }, function () {
                datos={
                    url:'./Inicio/generarPre',
                    type:'post',
                    data:{ref:$.sic.idpreinwindow},
                    success:function (data) {
                        try{
                            js=$.parseJSON(data);
                            swal(js.t, js.m, js.sw);
                            if (js.o==1) {
                                $.sic.load('getPresupuestoClose','Presupuestos cerrados');
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
        $("#ivash").click(function(event) {
            swal({
                title: "Editar IVA",
                text: "Ingrese el valor:",
                type: "input",
                inputValue: $.sic.iva,
                inputType: 'number',
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "IVA",
                showLoaderOnConfirm: true,
                confirmButtonText:'Aceptar',
                cancelButtonText:'Cancelar'
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Porfavor ingresa el valor del IVA"); return false
                }
                datos={
                    url:'./Inicio/uddategeneralInPre',
                    type:'post',
                    data:{ref:$.sic.idpreinwindow,iva:inputValue},
                    success:function (res) {
                        try{
                            r=$.parseJSON(res);
                            $.sic.iva=inputValue;
                            $("#ivash").html(inputValue+'%');
                            $("#subtotalPre").html('$ '+$.sic.totalfin);
                            $("#totalfin").html('$ '+$.sic.calculeFinal());
                            if (r.error) {swal(r.t,r.m,'error');}else{swal(r.t,r.m,'success');}
                                                         
                        }catch(e){
                            swal("El servidor no respondió como se esperaba, es posible que los datos no se hayan guardado.", "error");
                        }
                    },
                    error:function (ggg,gg,gggg) {
                        $.sic.alert('error inesperado','red');
                    }
                }
            $.sic.server(datos);
                swal("Nice!", "You wrote: " + inputValue, "success");
            });
        });
    <?php } ?>

        $.sic.nuevopredet=function () {
            detalles=$("#detallesnewpre").val();
            if (detalles) {
                if (detalles.length>10) {
                    datos={
                        url:'./Inicio/nuevoPresupuesto',
                        data:{detalle:detalles,as:$("#saveAsPre").val()},
                        type:'post',
                        success:function (res) {
                            try{
                                r=$.parseJSON(res);
                                swal(r.t,r.m,r.sw);
                                if (r.error==false) {
                                    $('#detailpreModal').modal('hide');
                                    $('#detallesPreData').val(detalles);
                                    $.sic.idpreinwindow=r.ref;
                                }                                
                            }catch(e){
                                swal("Error", "El servidor no respondió como se esperaba, es posible que los datos no se hayan guardado.", "error");
                            }
                        },
                        error:function (ww,rr,tt) {
                            $.sic.alert('Error inesperado, intente más tarde');
                        }

                    };
                    $.sic.server(datos);
                }else{
                    $.sic.alert('Por favor, sea mas específico','org');
                }
            }else{
                $.sic.alert('Error, recarga la página');
            }
        }

        $.sic.cancelNP=function () {
            setTimeout(function() {
                $.sic.load('getPresupuestos','Recientes');
            }, 700);
        }


        //funciones globales
        $.sic.updateClient=function (valor) {
            if(valor=="undefined"){
                return false;
            }
            $.sic.saveGeneral({cliente:valor,ref:$.sic.idpreinwindow});
        }
        $.sic.saveDetallesEdit=function () {
            detalles=$("#detallesPreData").val();
            if (detalles) {
                if (detalles.length>10) {
                    $.sic.saveGeneral({detalle:detalles,ref:$.sic.idpreinwindow});
                }else{$.sic.alert('Por favor, sea mas específico','org');}
            }
            
        }
        $.sic.saveOtrosPreData=function () {
            pago=$("#detallesPagoData").val();
            vencimiento=$("#vencimientoData").val();
            mas=$("#otrosDetallesData").val();
            idpre=$.sic.idpreinwindow;
            $.sic.saveGeneral({pago:pago,vencimiento:vencimiento,ref:idpre,mas:mas});
        }
        $.sic.saveGeneral=function (params) {
            datos={
                url:'./Inicio/uddategeneralInPre',
                type:'post',
                data:params,
                success:function (res) {
                    try{
                        r=$.parseJSON(res);
                        $.sic.alert(r.m,r.sw);                              
                    }catch(e){
                        $.sic.alert("El servidor no respondió como se esperaba, es posible que los datos no se hayan guardado.", "red");
                    }
                },
                error:function (ggg,gg,gggg) {
                    $.sic.alert('error inesperado','red');
                }
            }
            $.sic.server(datos);
        }
        $.sic.calculeFinal=function () {
            retorno=$.sic.totalfin/100;
            retorno=retorno*$.sic.iva;
            return retorno+$.sic.totalfin;

        }
        $.sic.saveProductosInPre=function () {
            idpro=$('#productPre').val();
            idpre=$.sic.idpreinwindow;
            if (idpro && idpre) {
                precio=$('#precioPre').val();
                cantidad=$('#cantPre').val();
                nombre=$("#productoSel"+idpro).html();
                total=precio*cantidad;
                totalfin=$.sic.totalfin;
                datos={
                    url:'./Inicio/saveProductosInPre',
                    type:'post',
                    data:{pro:idpro,pre:idpre,precio:precio,cantidad:cantidad},
                    success:function (req) {
                        try{
                            r=$.parseJSON(req);
                            $.sic.alert(r.m,r.sw);
                            if (r.error==false) {
                                document.getElementById('addProform').reset();
                                $("#presupuestoList").append('<tr class="detail" onclick="($(this));" data-id="'+r.ref+'"><td>'+nombre+'</td><td>'+precio+'</td><td>'+cantidad+'</td><td>'+total+'</td></tr>');
                                $.sic.totalfin=$.sic.totalfin+total;
                                $("#subtotalPre").html('$ '+$.sic.totalfin);
                                $("#totalfin").html('$ '+$.sic.calculeFinal());
                            }
                        }catch(e){
                            $.sic.alert('Error inesperado, porfavor intente más tarde','red');
                        }
                    }
                }
                $.sic.server(datos);
            }else{
                $.sic.alert('Algo va mal, porfavor recargue la página');
            }                        
        }
        $.sic.loadProdata=function (sel) {
            if (sel=="undefined") {
                $("#precioPre").val("");
                $("#cantPre").val("");
                $("#medidaShow").html("Cant.");
                return false;
            }
            datos=$.sic.finId(sel);
            console.log(datos);
            if (datos) {
                $("#precioPre").val(datos.prec);
                $("#cantPre").val(1);
                if (datos.med) {
                    $("#medidaShow").html(datos.med);
                }else{
                   $("#medidaShow").html("Cant."); 
                }                
            }
            
        }

        $.sic.finId=function (id) {
            ret=false;
            for (var i = 0; i < $.sic.json.length; i++) {
                if ($.sic.json[i].id==id) {
                    ret=$.sic.json[i];
                }                
            }
            return ret;
        }
        $.sic.editProinPre=function (elem) {
            
        }
    });
</script>