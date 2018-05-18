$(document).on("click","#agregarFila",function(){
	
	fila='<tr><td><input class="form-control input-sm text-center" name="Datos[fechas][]" type="text" required=""></td><td><input class="form-control input-sm text-center" name="Datos[factura][]" type="text"></td><td><input class="subtotal form-control input-sm text-center" name="Datos[subtotal][]" type="number" step="0.01" required=""></td><td><input class="impuestos form-control input-sm text-center" name="Datos[impuesto][]" type="number" step="0.01"></td><td><a style="cursor:pointer;" data-toggle="tooltip" onclick="eliminarFila(this);"><i class="fa fa-minus text-red"></i></a></td></tr>';
	
	$("#filas").append(fila);

function eliminarFila(elemento){ 
    $(elemento).closest('tr').remove();  
}