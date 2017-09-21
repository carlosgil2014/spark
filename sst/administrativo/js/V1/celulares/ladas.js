
function buscar(){

	var lada1 = $("#lada").val().substring(0,3);
	var lada2 = $("#lada").val().substring(0,2);

	$.ajax({

	type: "POST",
    url: "../controller/crudCelulares.php?accion=buscarEstados",
    data: {lada1: lada1, lada2: lada2},
    	success:  function (data) {
		//alert(data);
		$("#estado").html(data);
		//alert($("#estado").val());
		cargarMunicipios();
    	}
	});
	


}


function cargarMunicipios(){

var estado = $("#estado").val();

$.ajax({

	type: "POST",
    url: "../controller/crudCelulares.php?accion=buscarMunicipio",
    data: {estado: estado},
    	success:  function (data) {
		//alert(data);
		$("#municipio").html(data);

		cargarLocalidades();
    	}
	});


}


function cargarLocalidades(){

var municipio = $("#municipio").val();

$.ajax({

	type: "POST",
    url: "../controller/crudCelulares.php?accion=buscarLocalidad",
    data: {municipio: municipio},
    	success:  function (data) {
		//alert(data);
		$("#localidad").html(data);
    	}
	});


}





	
