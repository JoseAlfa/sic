<div class="header">
    <h2>
        EMPRESA
    </h2>
</div>
<div class="body" style="border-bottom: 1px solid #ddd">
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
<div class="header">
    <h2>
        CEO
    </h2>
</div>
<div class="body">
	<div class="row">
		<form id="ceo_form">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
			        <div class="form-line">
			            <input type="text" class="form-control" id="ceo_titulo" value="<?php echo $ceo['titulo']; ?>" />
			            <label class="form-label">Título</label>
			        </div>
			    </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
			        <div class="form-line">
			            <input type="text" class="form-control" required id="ceo_name" value="<?php echo $ceo['nombre']; ?>" />
			            <label class="form-label">Nombre</label>
			        </div>
			    </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
			        <div class="form-line">
			            <input type="text" class="form-control" required id="ceo_apellidos" value="<?php echo $ceo['apellidos']; ?>" />
			            <label class="form-label">Apellidos</label>
			        </div>
			    </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
			        <div class="form-line">
			            <input type="text" class="form-control" required id="ceo_correo" value="<?php echo $ceo['correo']; ?>" />
			            <label class="form-label">Correo electrónico</label>
			        </div>
			    </div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group form-float">
			        <div class="form-line">
			            <input type="text" class="form-control" required id="ceo_telefono" value="<?php echo $ceo['telefono']; ?>" />
			            <label class="form-label">Telefono</label>
			        </div>
			    </div>
			</div>
			<div class="col-xs-12">
				<button type="submit" id="saveceoBT" class="btn theme waves-effect" style="float: right;">GUARDAR</button>
			</div>
		</form>
		
	</div>
</div>
<script>
	$.sic.ceo='<?php echo $ceo['ref']; ?>';
	$(document).ready(function() {
		$("#ceo_form").submit(function(event) {
			event.preventDefault();
			params={
				nombre:$("#ceo_name").val(),
				apellidos:$("#ceo_apellidos").val(),
				telefono:$("#ceo_telefono").val(),
				titulo:$("#ceo_titulo").val(),
				correo:$("#ceo_correo").val(),
				ref:$.sic.ceo
			};
			bt=$("#saveceoBT");
			bt.attr('disabled', true);
			datos={
				url:'./Inicio/saveCEOData',
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
		});
	});
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