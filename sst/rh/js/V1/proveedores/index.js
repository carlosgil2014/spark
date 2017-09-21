$(function () {
    $("#tblProveedores").DataTable();
	$(".loader").fadeOut("slow");
    setTimeout(function(){cerrar("div_alert");}, 3000);
});
