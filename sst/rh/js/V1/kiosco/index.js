//onKeyUp="this.value = this.value.toUpperCase();"

$(document).ready(function(){
    $("#rfc").keyup(function(){
    	this.value = this.value.toUpperCase();
    	//alert("asdsad");
    	//$("env_rfc").removeAttr( "disabled" );
    	$("#env_rfc").prop('disabled', false);
    	//$("#env_rfc").attr('disabled','false');
    });
});