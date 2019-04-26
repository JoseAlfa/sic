<div class="body">
	<div class="row">
		<form onsubmit="$.sic.saveBuildData();return false;">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="nombreEmpresaO" value="<?php echo $nombre; ?>" />
		                <label class="form-label">Nombre empresa</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="direccionEmpresaO" value="<?php echo $direccion; ?>" />
		                <label class="form-label">Dirección</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="telefonoEmpresaO" value="<?php echo $telefono; ?>" />
		                <label class="form-label">Teléfono</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="movilEmpresaO" value="<?php echo $movil; ?>" />
		                <label class="form-label">Móvil</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="correoEmpresaO" value="<?php echo $correo; ?>" />
		                <label class="form-label">Correo</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="firmaEmpresaO" value="<?php echo $firma; ?>" />
		                <label class="form-label">Encargado de firmar presupuestos</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12">
				<div class="form-group form-float">
		            <div class="form-line">
		                <input type="text" class="form-control" required id="detallesEmpre" value="<?php echo $detalles; ?>" />
		                <label class="form-label">Encargado de firmar presupuestos</label>
		            </div>
		        </div>
			</div>
			<div class="col-xs-12">
				<button type="submit" id="saveEmmpresaBT" class="btn theme waves-effect" style="float: right;">GUARDAR</button>
			</div>
		</form>
	</div>
</div>
<script>
	$.sic.saveBuildData=function () {
		params={
			nombre:$("#nombreEmpresaO").val(),
			direccion:$("#direccionEmpresaO").val(),
			telefono:$("#telefonoEmpresaO").val(),
			movil:$("#movilEmpresaO").val(),
			correo:$("#correoEmpresaO").val(),
			firma:$("#firmaEmpresaO").val(),
			detalles:$("#detallesEmpre").val()
		};
		bt=$("#saveEmmpresaBT");
		bt.attr('disabled', true);
		datos={
			url:'./Inicio/saveBuildData',
			type:'post',
			data:params,
			success:function (res) {
				bt.attr('disabled', false);
				try{
                    js=$.parseJSON(res);
                    swal(js.t, js.m, js.sw);
                }catch(e){
                    swal('Error', $.sic.mjserr, 'error');
                    console.log(e);
                }
			},
			error:function (sd,fg,hh) {
				bt.attr('disabled', false);
				swal('Error', $.sic.mserr, 'error');
			}
		}
		$.sic.server(datos);
	}
</script>