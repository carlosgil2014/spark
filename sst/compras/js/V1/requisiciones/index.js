$(function () {
	variable = $("#div_alert");
    $("#tblRequisiciones").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});
