var infos = $("#app-infos");
var LINK = infos.data('link');
var PAGE = infos.data('page');


var app = {
	init: function(){

		$('[data-toggle="tooltip"]').tooltip();

		$(window).on('load', function(){
			$('.loader').fadeOut('slow');
		});

		$(window).on('scroll', function(){
			if($(this).scrollTop() > 0 && $(this).width()>768){
				$('header').addClass('scroll');
			} else {
				$('header').removeClass('scroll');
			}
		});

		$('#btn_toggle_menu').on('click', function(event){
			event.preventDefault();
			$('header,aside,.content').toggleClass('menu_min');
			localStorage.setItem('menu_min', $('aside').hasClass('menu_min'));
		});

		$("form").on('submit', function(event) {
			event.preventDefault();
			$('.loader').fadeIn();
			var form = $(this);
			if(form.find('[data-valid].error').length==0){
				var formData = new FormData(this);
				$.ajax({
					url: LINK+'inc/ajaxRequest.php',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data) {
						console.log(data);
						if(jQuery.parseJSON(data)) {
							var data = jQuery.parseJSON(data);
							if(data.app){
								if(data.app.location) location.href = data.app.location;
							}
							notificacao(data.alert);
							if(data.success) {
								form.find('.form-control').removeClass('valided').val('');;
							}
						} else {
							console.log(data);
						}
					}
				});
			}
		});

		function notificacao (config) {
			var modal = $('#notificacao');
			var title = modal.find('h3');
			var text = modal.find('p');

			title.text(config.title);
			text.text(config.text);
			modal.addClass('modal_'+config.type);

			$('.loader').fadeOut('slow');

			modal.modal('show');

			console.log(config);

			modal.on('hide.bs.modal', function () {
				modal.removeClass('modal_'+config.type);
			})
		}
	},
	home: function(){
		
	},
	listar: function(){
		var datatable = $('table').DataTable({
			"language": {
				"sEmptyTable": "Nenhum registro encontrado",
				"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
				"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
				"sInfoFiltered": "(Filtrados de _MAX_ registros)",
				"sInfoPostFix": "",
				"sInfoThousands": ".",
				"sLengthMenu": "_MENU_ resultados por página",
				"sLoadingRecords": "Carregando...",
				"sProcessing": "Processando...",
				"sZeroRecords": "Nenhum registro encontrado",
				"sSearch": "Pesquisar",
				"oPaginate": {
					"sNext": "Próximo",
					"sPrevious": "Anterior",
					"sFirst": "Primeiro",
					"sLast": "Último"
				},
				"oAria": {
					"sSortAscending": ": Ordenar colunas de forma ascendente",
					"sSortDescending": ": Ordenar colunas de forma descendente"
				}
			}
		});

		$('.btn_excluir').on('click', function(event){
			event.preventDefault();
			var t = $(this);
			var id = t.data('id');
			var table = t.data('table');

			var modalDelete = $('#modalDelete');
			modalDelete.modal('show');

			modalDelete.find('.btn-primary').on('click', function(e){
				e.preventDefault();
				$.ajax({
					url: LINK+'inc/ajaxRequest.php',
					type: 'POST',
					data: { action: 'delete', id: id, table: table },
					success: function(data){
						var data = jQuery.parseJSON(data);
						if(data.success){
							datatable.row(t.parents('tr')).remove().draw()
						}
						console.log(data);
					}
				});
				modalDelete.modal('hide');
			});
		});
	},
	form: function(){
		var input_image = $('input[name="image_id"]');

		input_image.each(function(index,el){
			$(el).attr('id','image_'+index);
			$(el).addClass('d-none');
			$(el).before('<label class="image_label" for="image_'+index+'"><img src=""/><span>Selecione uma imagem</span></label>');

			$(el).on('change', function(){
				var input = this;
				var preview = $('label.image_label[for="image_'+index+'"]');
				console.log(input.files);
				if (input.files && input.files[0]) {
					preview.addClass('active');
					var reader = new FileReader();
					reader.onload = function (e) {
						$(preview).find('img').attr('src',e.target.result);
						$(preview).find('span').text(input.files[0].name);
					}
					reader.readAsDataURL(input.files[0]);
				}
			});
		});
	}
}

app.init();
PAGE=='' ? app.home() : PAGE = PAGE.replace(/[-]/g, '');
try { eval('app.'+PAGE+'()'); } catch(err){ console.log(err.message); }