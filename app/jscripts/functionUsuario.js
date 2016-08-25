$(document).ready(function(){
		var iconCarregando = $('<img src="images/mini.gif" class="icon" /> <span class="destaque">Carregando. Por favor aguarde...</span>');
	$('#form1').submit(function(e) {
	e.preventDefault();
	var serializeDados = $('#form1').serialize();
	$('#insere_aqui').css('display', 'block');
	$.ajax({
			url: 'app/phpscripts/setUsuario.php', 
			dataType: 'html',
			type: 'POST',
			timeout: 5000,
			data: serializeDados,
			beforeSend: function(){
			$('#insere_aqui').html(iconCarregando);
			},
			complete: function() {
			$(iconCarregando).remove();
			},
			success: function(data, textStatus) {
			$('#insere_aqui').html('<p>' + data + '</p>');
			},
			error: function(xhr,er) {
				$('#insere_aqui').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
			}		
		});
	});	
})