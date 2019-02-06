var infos = $("#app-infos");
var LINK = infos.data('link');
var PAGE = infos.data('page');


var app = {
	init: function(){

		$(window).on('load', function(){
			$('.loader').fadeOut('slow');
		});

		$("form").on('submit', function(event) {
			event.preventDefault();
			var form = $(this);
			form.find('.form-control, .btn').addClass('disabled');
			var alert = form.find(".alert");
			alert.addClass('hidden');
			if(form.find('[data-valid].is-valid, [data-eq-for].is-valid').length==form.find('[data-valid]').length){
				var formData = new FormData(this);

				$.ajax({
					url: LINK+'inc/ajaxRequest.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data) {
						if(jQuery.parseJSON(data)) {
							var data = jQuery.parseJSON(data);
							if(data.location) location.href = data.location;
							if(data.text) {
								if(data.success) {
									alert.addClass('alert-success');
									alert.removeClass('alert-danger');
								} else {
									alert.removeClass('alert-success');
									alert.addClass('alert-danger');
								}
								alert.text(data.text);
								alert.removeClass('hidden');
							}
							if(data.success) {
								form.find('.form-control').removeClass('is-valid').val('');;
							}
						} else {
							console.log(data);
						}
						form.find('.form-control, .btn').removeClass('disabled');
					}
				});
			}
		});
	},
	home: function(){
		
	},
	logout: function () {
		setTimeout(function () {
			location.href = LINK;
		}, 5000)
	}
}

app.init();
PAGE=='' ? app.home() : PAGE = PAGE.replace(/[-]/g, '');
try { eval('app.'+PAGE+'()'); } catch(err){ console.log(err.message); }