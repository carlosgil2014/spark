var formOrdendeServicio = $("#formOrdendeServicio"), arrCot, arrCotCon, arrCantidades, arrDescripciones, arrConceptos,arrIdConceptos,arrPrecios,arrComisiones, arrSubtotales, arrTiposPlan, arrTiposServicio, servicio;

var activo;
$(function(){
	$(".loader").fadeOut("fast");
});

$(document).ready(function(){

	activo = "cot";

    $( "#Cotizaciones" ).accordion({heightStyle: "content"});

    $( "ul.cotizaciones" ).each(function() {

    	var tam = $(this).find('li').length;

    		if(tam > 1)

    			$(this).prepend("<li><input type='checkbox' cot='"+$(this).attr("cot")+"' class='selTodo'> Seleccionar todo</li>");

	});



	$( "#Prefacturas" ).accordion({heightStyle: "content"});

    $( "ul.prefacturas" ).each(function() {

    	var tam = $(this).find('li').length;

    		if(tam > 1)

    			$(this).prepend("<li><input type='checkbox' pf='"+$(this).attr("pf")+"' class='selTodoPf'> Seleccionar todo</li>");

	});

});



$(document).on("change", ".listaCotizaciones", function()

{

	formOrdendeServicio.submit();

});



$(document).on("click", ".detalleConceptoCotizacion", function()

{

	$.post( "../controller/crudOrdenes.php?accion=modalDetalleConceptoCotizacion",{idCotConcepto: $(this).attr("value"), idCotizacion: $(this).attr("cot")},function(data)

    {

        $("#datosConcepto").html(data);

    });

});



$(document).on("click", ".detalleConceptoPrefactura", function()

{

	$.post( "../controller/crudOrdenes.php?accion=modalDetalleConceptoPrefactura",{idPfConcepto: $(this).attr("value"), idPrefactura: $(this).attr("pf")},function(data)

    {

        $("#datosConcepto").html(data);

    });

});



$(document).on("click", ".selTodo", function()

{	

	var li = $(this).parent("li");

	var ul = li.parent("ul");

	var idCotizacion =  $(this).attr("cot");

	var txt = $("h2[cot='" + idCotizacion + "']");

		$("small[cot='" + idCotizacion + "']").hide();

		li.remove();

		ul.find("li").each(function (){

			$(this).find("input").remove();

			$("#Ordendeservicio").append("<li>" + $(this).html() + " <img src='../img/imgEliminar.gif' class='eliminarConcepto'></li>");

			$(this).remove();

			if($("#Ordendeservicio").find("li").length == 1){

				servicio = $("small[cot='" + idCotizacion + "']").html();

			}

		});

		txt.append("<label cot='"+idCotizacion+"''>Completado <img src='../img/imgOk.png'/></label>" );



});



$(document).on("click", ".selTodoPf", function()

{	

	var li = $(this).parent("li");

	var ul = li.parent("ul");

	var idPrefactura =  $(this).attr("pf");

	var txt = $("h2[pf='" + idPrefactura + "']");

		$("small[pf='" + idPrefactura + "']").hide();

		li.remove();

		ul.find("li").each(function (){

			$(this).find("input").remove();

			$("#Ordendeservicio").append("<li>" + $(this).html() + " <img src='../img/imgEliminar.gif' class='eliminarConceptoPf'></li>");

			$(this).remove();

			if($("#Ordendeservicio").find("li").length == 1){

				servicio = $("small[pf='" + idPrefactura + "']").html();

			}

		});

		txt.append("<label pf='"+idPrefactura+"''>Completado <img src='../img/imgOk.png'/></label>" );



});



$(document).on("click", ".cotConcepto", function()

{

	var li = $(this).parent("li");

	var ul = li.parent("ul");

	var tam;

	var idCotizacion =  $(this).attr("cot");

	var txt = $("h6[cot='" + idCotizacion + "']");

		$(this).remove();

		$("#Ordendeservicio").append("<li>" + li.html() + " <img src='../img/imgEliminar.gif' class='eliminarConcepto'></li>");

		li.remove();

		tam = ul.find("li").length;

		if(tam == 2)

			ul.find("input.selTodo").parent("li").remove();

		if(tam == 0){

			$("small[cot='" + idCotizacion + "']").hide();

			txt.append("<label cot='"+idCotizacion+"''>Completado <img src='../img/imgOk.png'/></label>" );

		}

		if($("#Ordendeservicio").find("li").length == 1){

			servicio = $("small[cot='" + idCotizacion + "']").html();

		}

		

});



$(document).on("click", ".pfConcepto", function()

{

	var li = $(this).parent("li");

	var ul = li.parent("ul");

	var tam;

	var idPrefactura =  $(this).attr("pf");

	var txt = $("h6[pf='" + idPrefactura + "']");

		$(this).remove();

		$("#Ordendeservicio").append("<li>" + li.html() + " <img src='../img/imgEliminar.gif' class='eliminarConceptoPf'></li>");

		li.remove();

		tam = ul.find("li").length;

		if(tam == 2)

			ul.find("input.selTodoPf").parent("li").remove();

		if(tam == 0){

			$("small[pf='" + idPrefactura + "']").hide();

			txt.append("<label pf='"+idPrefactura+"''>Completado <img src='../img/imgOk.png'/></label>" );

		}

		if($("#Ordendeservicio").find("li").length == 1){

			servicio = $("small[pf='" + idPrefactura + "']").html();

		}

		

});



$(document).on("click", ".eliminarConcepto", function()

{

	var li = $(this).parent("li");

	var idCotizacion = li.find("a").attr("cot");

	var idCotConcepto = li.find("a").attr("value");

	var ul = $("ul[cot='" + idCotizacion + "']");

	var tam;

	var x = li;

		x.find("img").remove();

		li.remove();

		ul.append("<li><input type='checkbox' class = 'cotConcepto' value='"+idCotConcepto+"' cot = '"+idCotizacion+"'>" + x.html() + "</li>");

		tam = ul.find("li").length;

		if(tam == 2)

    		ul.prepend("<li><input type='checkbox' cot='"+idCotizacion+"' class='selTodo'> Seleccionar todo</li>");

    	if(tam == 1){

    		$("small[cot='" + idCotizacion + "']").show();

    		$("label[cot='" + idCotizacion + "']").remove();

    	}

    	if($("#Ordendeservicio").find("li").length == 0)

			servicio = '';



});



$(document).on("click", ".eliminarConceptoPf", function()

{

	var li = $(this).parent("li");

	var idPrefactura = li.find("a").attr("pf");

	var idPfConcepto = li.find("a").attr("value");

	var ul = $("ul[pf='" + idPrefactura + "']");

	var tam;

	var x = li;

		x.find("img").remove();

		li.remove();

		ul.append("<li><input type='checkbox' class = 'pfConcepto' value='"+idPfConcepto+"' pf = '"+idPrefactura+"'>" + x.html() + "</li>");

		tam = ul.find("li").length;

		if(tam == 2)

    		ul.prepend("<li><input type='checkbox' pf='"+idPrefactura+"' class='selTodoPf'> Seleccionar todo</li>");

    	if(tam == 1){

    		$("small[pf='" + idPrefactura + "']").show();

    		$("label[pf='" + idPrefactura + "']").remove();

    	}

    	if($("#Ordendeservicio").find("li").length == 0)

			servicio = '';



});



$(document).on("click", ".reiniciarCot", function()

{

	activo = "pf";

	$(this).attr("class","reiniciarCottmp");

	$(".reiniciarPftmp").attr("class","reiniciarPf");

	$("#modalDetalleOrden").attr("id","modalDetalleOrdenPf");

	$("#Ordendeservicio").find("li").each(function() {

		var li = $(this);

		var idCotizacion = li.find("a").attr("cot");

		var idCotConcepto = li.find("a").attr("value");

		var ul = $("ul[cot='" + idCotizacion + "']");

		var tam;

		var x = li;

			x.find("img").remove();

			li.remove();

			ul.append("<li><input type='checkbox' class = 'cotConcepto' value='"+idCotConcepto+"' cot = '"+idCotizacion+"'>" + x.html() + "</li>");

			tam = ul.find("li").length;

			if(tam == 2)

	    		ul.prepend("<li><input type='checkbox' cot='"+idCotizacion+"' class='selTodo'> Seleccionar todo</li>");

	    	if(tam == 1){

	    		$("small[cot='" + idCotizacion + "']").show();

	    		$("label[cot='" + idCotizacion + "']").remove();

	    	}

	    	if($("#Ordendeservicio").find("li").length == 0)

				servicio = '';

    });

});



$(document).on("click", ".reiniciarPf", function()

{

	activo = "cot";

	$(this).attr("class","reiniciarPftmp");

	$(".reiniciarCottmp").attr("class","reiniciarCot");

	$("#modalDetalleOrdenPf").attr("id","modalDetalleOrden");

	$("#Ordendeservicio").find("li").each(function() {

       	var li = $(this);

		var idPrefactura = li.find("a").attr("pf");

		var idPfConcepto = li.find("a").attr("value");

		var ul = $("ul[pf='" + idPrefactura + "']");

		var tam;

		var x = li;

			x.find("img").remove();

			li.remove();

			ul.append("<li><input type='checkbox' class = 'pfConcepto' value='"+idPfConcepto+"' pf = '"+idPrefactura+"'>" + x.html() + "</li>");

			tam = ul.find("li").length;

			if(tam == 2)

	    		ul.prepend("<li><input type='checkbox' pf='"+idPrefactura+"' class='selTodo'> Seleccionar todo</li>");

	    	if(tam == 1){

	    		$("small[pf='" + idPrefactura + "']").show();

	    		$("label[pf='" + idPrefactura + "']").remove();

	    	}

	    	if($("#Ordendeservicio").find("li").length == 0)

				servicio = '';

    });

});







$(document).on("click", "#modalDetalleOrden", function()

{

	if($("#Ordendeservicio").find("li").length != 0){

		$("#IdmodalDetalleOrden").modal("show");

		arrCot = [];

		arrCotCon = [];

		$("#Ordendeservicio").find("li").each(function (){

			arrCot.push($(this).find("a").attr("cot"));

			arrCotCon.push($(this).find("a").attr("value"));

		});



		$.post( "../controller/crudOrdenes.php?accion=modalDetalleOrden",{arrCot : arrCot, arrCotCon : arrCotCon},function(data)

	    {

	        $("#datosOrden").html(data);

	    	$('[data-toggle="tooltip"]').tooltip(); 

	    });

	}

	else{

    	$( "#aviso" ).dialog({

            resizable: false,

            modal: true,

            buttons: 

            {

	            'OK': function() 

	            {

	                $(this).dialog('close');

	            }

            }

      	});

	}

});



$(document).on("click", "#modalDetalleOrdenPf", function()

{

	if($("#Ordendeservicio").find("li").length != 0){

		$("#IdmodalDetalleOrden").modal("show");

		arrPf = [];

		arrPfCon = [];

		$("#Ordendeservicio").find("li").each(function (){

			arrPf.push($(this).find("a").attr("pf"));

			arrPfCon.push($(this).find("a").attr("value"));

		});



		$.post( "../controller/crudOrdenes.php?accion=modalDetalleOrdenPf",{arrPf : arrPf, arrPfCon : arrPfCon},function(data)

	    {

	        $("#datosOrden").html(data);

	    	$('[data-toggle="tooltip"]').tooltip(); 

	    });

	}

	else{

    	$( "#aviso" ).dialog({

            resizable: false,

            modal: true,

            buttons: 

            {

	            'OK': function() 

	            {

	                $(this).dialog('close');

	            }

            }

      	});

	}

});



$(document).on("keyup change", ".cantidad", function()

{

	var actual = parseFloat($(this).val());

    var precio = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));

    var comision = parseFloat($(this).closest('tr').find('td:eq(4)').find("input.comision").val()/100);

    if(isNaN(comision))

    	comision = parseFloat(($(this).closest('tr').attr('com')/100));

    var subtotal = 1 + comision;

    var max = parseFloat($(this).closest('tr').attr('dis'));

    var i = $(this).closest('tr').attr('i');

    var sumaPT = 0;sumaC = 0; sumaT = 0;

      if(isNaN(precio))

        precio = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();



    if(activo == "cot")

	    if(actual > max || actual <= 0){

	    	$(this).val(max);

	    	actual =  parseFloat($(this).val());

	    }

    	$(this).closest("tr").find("td:eq(3)").html(formatoMoneda(actual * precio ,"$"));

      	$(this).closest("tr").find("td:eq(4)").find("a").html(formatoMoneda(actual * precio * comision,"$"));

      	$(this).closest("tr").find("td:eq(5)").html(formatoMoneda(actual * precio * subtotal,"$"));





	if(activo == "pf"){

		var prueba = 0;

    	$(".rubro_"+i).each(function() {	
    		var comisionTmp =  parseFloat($(this).find('td:eq(4)').find("input.comision").val()/100);
    		var precioTmp = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    		if(isNaN(comisionTmp))
    			comisionTmp = parseFloat(($(this).attr('com')/100));
    		if(isNaN(precioTmp))
        		precioTmp = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    	
    		subtotalTmp = 1 + comisionTmp;

			if(isNaN( precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp))
    			prueba += 0.00;
    		else{

				prueba += precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp;
			}

		});
		
	    if(prueba.toFixed(2) > max){

	    	alert("Saldo disponible: " + formatoMoneda(max,"$"));

	    	$(this).val("");

	    	actual =  parseFloat($(this).val());

    		$(this).closest("tr").find("td:eq(3)").html(formatoMoneda(0,"$"));

      		$(this).closest("tr").find("td:eq(5)").html(formatoMoneda(0,"$"));

	    }

	}



      	$(".editables").each(function() {

	        sumaPT += parseFloat($(this).find("td:eq(3)").html().replace("$","").replace(/,/g,""));

	        if(!isNaN($(this).closest('tr').find('td:eq(4)').find("input.comision").val()))

        		sumaC += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,'')) * parseFloat($(this).closest('tr').find('td:eq(4)').find("input.comision").val() / 100);

    		else

	        	sumaC += parseFloat($(this).find("td:eq(4)").find("a").html().replace("$","").replace(/,/g,""));

        	

	        sumaT += parseFloat($(this).find("td:eq(5)").html().replace("$","").replace(/,/g,""));

      	});



      	$("#sumaPT").html(formatoMoneda(sumaPT,"$"));

      	$("#sumaC").html(formatoMoneda(sumaC,"$"));

      	$("#sumaT").html(formatoMoneda(sumaT,"$"));

});



$(document).on('keyup change', "input.sumaPrecio", function() { 

  

    var actual = parseFloat($(this).val());

    var cantidad = parseFloat($(this).closest('tr').find('td:eq(0)').find("input.cantidad").val());

    var comision = parseFloat($(this).closest('tr').find('td:eq(4)').find("input.comision").val()/100);

    var subtotal;

    var max = parseFloat($(this).closest('tr').attr('dis'));

    var i = $(this).closest('tr').attr('i');

        sumaPT = 0;sumaC = 0; sumaT = 0;

        if(isNaN(comision))

    		comision = parseFloat(($(this).closest('tr').attr('com')/100));

    	subtotal = 1 + comision;

   		$(this).closest('tr').find('td:eq(3)').html(formatoMoneda(actual * cantidad ,"$"));

      	$(this).closest('tr').find('td:eq(4)').find("a").html(formatoMoneda(actual * cantidad * comision,"$"));

      	$(this).closest('tr').find('td:eq(5)').html(formatoMoneda(actual * cantidad * subtotal,"$"));



    if(activo == "pf"){

    	var prueba = 0;

    


    	$(".rubro_"+i).each(function() {	
    		var comisionTmp =  parseFloat($(this).find('td:eq(4)').find("input.comision").val()/100);
    		var precioTmp = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    		if(isNaN(comisionTmp))
    			comisionTmp = parseFloat(($(this).attr('com')/100));
    		if(isNaN(precioTmp))
        		precioTmp = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    	
    		subtotalTmp = 1 + comisionTmp;

			if(isNaN( precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp))
    			prueba += 0.00;
    		else{

				prueba += precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp;
			}

		});

	    if(prueba.toFixed(2) > max){

	    	alert("Saldo disponible: "+ formatoMoneda(max,"$"));

	    	$(this).val("");

	    	actual =  parseFloat($(this).val());

    		$(this).closest("tr").find("td:eq(3)").html(formatoMoneda(0,"$"));

      		$(this).closest("tr").find("td:eq(5)").html(formatoMoneda(0,"$"));

	    }

	}



      	$(".editables").each(function() {

        	sumaPT += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,''));

        	if(!isNaN($(this).closest('tr').find('td:eq(4)').find("input.comision").val()))

        		sumaC += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,'')) * parseFloat($(this).closest('tr').find('td:eq(4)').find("input.comision").val() / 100);

    		else

        		sumaC += parseFloat($(this).find('td:eq(4)').find("a").html().replace("$","").replace(/,/g,''));

        	sumaT += parseFloat($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));

      	});

      	$("#sumaPT").html(formatoMoneda(sumaPT,"$"));

      	$("#sumaC").html(formatoMoneda(sumaC,"$"));

      	$("#sumaT").html(formatoMoneda(sumaT,"$"));

});



$(document).on('keyup change', "input.comision", function() { 

  

    var actual = parseFloat($(this).val());

    var cantidad = parseFloat($(this).closest('tr').find('td:eq(0)').find("input.cantidad").val());

    var precio = parseFloat($(this).closest('tr').find('input.sumaPrecio').val());

    var comision = parseFloat(1 + (actual/100));

    var max = parseFloat($(this).closest('tr').attr('dis'));
    
    var i = $(this).closest('tr').attr('i');

        sumaPT = 0;sumaC = 0; sumaT = 0;

        if(isNaN(precio))

        	precio = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));



      	$(this).closest('tr').find('td:eq(5)').html(formatoMoneda(cantidad * precio * comision,"$"));



    if(activo == "pf"){

    	var prueba = 0;

    	$(".rubro_"+i).each(function() {	
    		var comisionTmp =  parseFloat($(this).find('td:eq(4)').find("input.comision").val()/100);
    		var precioTmp = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    		if(isNaN(comisionTmp))
    			comisionTmp = parseFloat(($(this).attr('com')/100));
    		if(isNaN(precioTmp))
        		precioTmp = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    	
    		subtotalTmp = 1 + comisionTmp;

			if(isNaN( precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp))
    			prueba += 0.00;
    		else{

				prueba += precioTmp * parseFloat($(this).find('td:eq(0)').find("input.cantidad").val()) * subtotalTmp;
			}

		});

	    if(prueba.toFixed(2) > max){

	    	alert("Saldo disponible: "+ formatoMoneda(max,"$"));

	    	$(this).val("");

	    	actual =  parseFloat($(this).val());

      		$(this).closest("tr").find("td:eq(5)").html(formatoMoneda(0,"$"));

	    }

	}

		$(".editables").each(function() {

        	sumaPT += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,''));

        	sumaC += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,'')) *  parseFloat(($(this).find('td:eq(4)').find("input.comision").val()/100));

        	sumaT += parseFloat($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));

      	});

      	$("#sumaPT").html(formatoMoneda(sumaPT,"$"));

      	$("#sumaC").html(formatoMoneda(sumaC,"$"));

      	$("#sumaT").html(formatoMoneda(sumaT,"$"));

});





$(document).on('change', "select.ts", function() { 

  	var tipoServicio = $(this).val();

  	var idCliente = $("[name='Datos[idCliente]']").val();

  	var concepto = $(this).closest("tr").next("tr").next("tr").find('td:eq(1)').find("select.concepto");

 	 	$.post( "../controller/crudConceptos.php?accion=cargarConceptos",{ idCliente : idCliente, tipoServicio : tipoServicio },function(data)

	    {

	    	concepto.attr("class","form-control input-sm concepto");

	    	concepto.html(data);

	    });

});



$(document).on("change", "[name='Datos[fechaInicialOrden]'],[name='Datos[fechaFinalOrden]']", function() { 



	var f = new Date();

	var mes = f.getMonth()+1;

	var dia = f.getDate();

	var hoy = f.getFullYear() + '-' + (mes<10 ? '0' : '') + mes + '-' + (dia<10 ? '0' : '') + dia;

	var fechaMinima;





	if(dia <= '5'){

        	mes = mes - 1;

        	dia = '1';

        	fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;

    }

    else{

        	dia = '1';

        	fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;

    }



    if($("[name='Datos[fechaInicialOrden]']").val() < fechaMinima){

    	$("[name='Datos[fechaInicialOrden]']").val(fechaMinima);

    }



    if($("[name='Datos[fechaFinalOrden]']").val() < fechaMinima){

    	$("[name='Datos[fechaFinalOrden]']").val(fechaMinima);

    }



 	if($("[name='Datos[fechaInicialOrden]']").val() > $("[name='Datos[fechaFinalOrden]']").val())

 		$("[name='Datos[fechaFinalOrden]']").val($("[name='Datos[fechaInicialOrden]']").val());

});



$(document).on("click", "#btnGuardar", function()

{

	var bandera = 1, idCliente, fechaInicial, fechaFinal, Datos = {}, arrCantidades = [], arrDescripciones = [], arrConceptos = [], arrIdConceptos = [], arrIdRubros = [],arrPrecios = [],arrComisiones = [], arrSubtotales = [], arrTiposPlan = [], arrTiposServicio = []; 

		if(!$.trim($("[name='Datos[servicio]']").val()) || !$.trim($("[name='Datos[fechaInicialOrden]']").val()) || !$.trim($("[name='Datos[fechaFinalOrden]']").val()) || !$.trim($("[name='Datos[fechaFinalOrden]']").val()) < !$.trim($("[name='Datos[fechaInicialOrden]']").val()))//Comprobar que todos los datos solicitados sean correctos. 

			bandera = 0;

		$(".editables").each(function() {

			if(activo == "cot"){

				if($(this).closest('tr').find('td:eq(4)').find("input.comision").val() < 0 || $(this).find("input.cantidad").val() == '' || $(this).prev("tr").prev("tr").find("select.ts").val() == '0' || Math.floor($(this).find("input.cantidad").val()) != $(this).find("input.cantidad").val() || !$.isNumeric($(this).find("input.cantidad").val()) || $(this).find("input.sumaPrecio").val() == '' || $(this).find("input.sumaPrecio").val() == "0")

	        	bandera = 0;

  			}

			else{

	        	if(!$.trim($(this).closest('tr').find('td:eq(4)').find("input.comision").val()) || $(this).find("input.cantidad").val() == '' || $(this).prev("tr").prev("tr").find("select.ts").val() == '0' || $(this).find("select.concepto").val() == '0' || Math.floor($(this).find("input.cantidad").val()) != $(this).find("input.cantidad").val() || !$.isNumeric($(this).find("input.cantidad").val()) || $(this).find("input.sumaPrecio").val() == '' || $(this).find("input.sumaPrecio").val() == "0")

	        		bandera = 0;

	        }

      	});

		if(bandera == 0){

			$("#IdmodalDetalleOrden").modal("hide");

			$( "#error" ).dialog({

	            resizable: false,

	            modal: true,

	            buttons: 

	            {

		            'OK': function() {

		                $(this).dialog('close');

						$("#IdmodalDetalleOrden").modal("show");

		            }

		        },

	            close: function(){

	                $(this).dialog('close');

					$("#IdmodalDetalleOrden").modal("show");

	            }

	      	});

		}



		else

			if(bandera == 1)

			{

				idCliente = $("[name='Datos[idCliente]']").val();

				servicio = $("[name='Datos[servicio]']").val();

				fechaInicial = $("[name='Datos[fechaInicialOrden]']").val();

				fechaFinal = $("[name='Datos[fechaFinalOrden]']").val();

				

			$(".editables").each(function() {

				arrCantidades.push($(this).find("input.cantidad").val());

				arrIdRubros.push($(this).attr("id_rubro"));
				
				arrIdConceptos.push($(this).attr("idcon"));

				if(activo ==  "cot"){

					arrConceptos.push($.trim($(this).find('td:eq(1)').html()));

					arrComisiones.push($(this).attr("com"));

					arrTiposPlan.push($(this).attr("tp"));

					arrTiposServicio.push($(this).attr("ts")); 

				}

				else{

					arrConceptos.push($.trim($(this).find('td:eq(1)').find("select.concepto option:selected").text()));

					arrComisiones.push($.trim($(this).find('td:eq(4)').find("input.comision").val()));

					arrTiposPlan.push($(this).prev("tr").prev("tr").find("select.tp").val());

					arrTiposServicio.push($(this).prev("tr").prev("tr").find("select.ts").val()); 

				}

        		precio = $(this).find("td:eq(2)").find("input.sumaPrecio").val();

      			if(precio == undefined)

					precio = $.trim($(this).find('td:eq(2)').html().replace("$","").replace(/,/g,''));

				arrDescripciones.push($.trim($(this).prev("tr").prev("tr").find("textarea.descripcion").val()));

				arrPrecios.push(precio);

				arrSubtotales.push($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));

			});

				

				Datos["tipo"] = activo;

				Datos["idCliente"] = idCliente;

				Datos["servicio"] = servicio; 

				Datos["fechaInicial"] = fechaInicial; 

				Datos["fechaFinal"] = fechaFinal; 

				Datos["idcotconceptos"] = arrIdRubros;

				Datos["cantidad"] = arrCantidades;

				Datos["idconceptos"] = arrIdConceptos; 

				Datos["conceptos"] = arrConceptos; 

				Datos["descripciones"] = arrDescripciones; 

				Datos["precios"] = arrPrecios; 

				Datos["comisiones"] = arrComisiones;

				Datos["subtotales"] = arrSubtotales; 

				Datos["tiposPlan"] = arrTiposPlan; 

				Datos["tiposServicio"] = arrTiposServicio; 

				Datos["importe"] = $("#sumaT").html().replace("$","").replace(/,/g,'');
				$(".loader").fadeIn("slow", function()
  				{
  					$.ajax(
  					{
  						data: {Datos : Datos},
				      	url: "../controller/crudOrdenes.php?accion=guardarOrden",
				      	type: 'post',
				      	success:  function (data) 
      					{
      						$(".loader").fadeOut("fast");
      						$("#folioOrden").html(data); 
							$("#IdmodalDetalleOrden").modal("hide");
      					}
  					});
				});

			}

});



function formatoMoneda(n, simbolo) {

    return simbolo + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");

} 

function clonarFila(elemento) {
	var fila = $(elemento).closest("tr");
	var index =  fila.index();
	var fila_4 = $("#IdtablaOrden tr").eq(index-1).clone();
	var fila_3 = $("#IdtablaOrden tr").eq(index-2).clone();
	var fila_2 = $("#IdtablaOrden tr").eq(index-3).clone();
	var fila_1 = $("#IdtablaOrden tr").eq(index-4).clone();

	parseFloat(fila_4.find("input.cantidad").val("1"));
    parseFloat(fila_4.find("input.sumaPrecio").val("0.00"));
    parseFloat(fila_4.find("input.comision").val("0.00"));
    parseFloat(fila_4.find("td").eq(3).html("$ 0.00"));
    parseFloat(fila_4.find("td").eq(5).html("$ 0.00"));

	fila_4.insertAfter(fila);
	fila_3.insertAfter(fila);
	fila_2.insertAfter(fila);
	fila_1.insertAfter(fila);
} 


