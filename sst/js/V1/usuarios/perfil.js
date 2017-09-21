$(function () {
	variable = $("#div_alert");
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
	}
});

function cargarFoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#foto')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}