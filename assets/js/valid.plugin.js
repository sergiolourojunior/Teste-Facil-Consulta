$(document).ready(function(){
	$('[data-valid]').on('change paste keyup', function(event){
		var elemento = $(this);
		validar(elemento);
	});

	function validar(elemento){
		var parent = elemento.parent('.input-control').length>0 ? elemento.parent('.input-control') : elemento;
		var type = elemento.data("valid");
		switch(type) {
			case 'text':
				if(elemento.val().length < 6 || elemento.val().length > 112) {
					parent.removeClass('is-valid');
					parent.addClass('is-invalid');
				} else {
					parent.addClass('is-valid');
					parent.removeClass('is-invalid');
				}
				break;
			case 'email':
				if(elemento.val().length<6 || elemento.val().length>112 || elemento.val().indexOf('@')==-1 || elemento.val().indexOf('.')==-1) {
					parent.removeClass('is-valid');
					parent.addClass('is-invalid');
				} else {
					parent.addClass('is-valid');
					parent.removeClass('is-invalid');
				}
				break;
			case 'equals':
				var eqOrigin = elemento.data("eq-for");
				if(elemento.val()==$('#'+eqOrigin).val() && elemento.val().length>=6 && elemento.val().length<=112) {
					parent.addClass('is-valid');
					parent.removeClass('is-invalid');
				} else {
					parent.removeClass('is-valid');
					parent.addClass('is-invalid');
				}
				break;
		}
	}

	$('form').on('submit', function(event){
		var form = $(this);
		form.find('[data-valid]').each(function(index,el){
			validar($(el));
		});
		if(form.find('.valided').length<form.find('[data-valid]').length){
			event.preventDefault();
			return false;
		}
	});
});