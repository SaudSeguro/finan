function iniciaAjax() {
	var objetoAjax = false;
		if (window.XMLHttpRequest) {
			objetoAjax = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {		
		objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
			objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");			
		} catch(ex) {	
		objetoAjax = false;
       }
		}
	}
	return objetoAjax;
}
		
function requisitar (arquivo) {
			var requisicaoAjax = iniciaAjax(); 
				if(requisicaoAjax) {
					requisicaoAjax.onreadystatechange = function () {	
					mostraResposta(requisicaoAjax);	
					};
		requisicaoAjax.open("GET", arquivo, true);
		requisicaoAjax.send(null);
				}
}

function mostraResposta(requisicaoAjax) {
	if(requisicaoAjax.readyState == 4) {
	if(requisicaoAjax.status == 200 || requisicaoAjax.status == 304) {
	var insere_aqui = document.getElementById("insere_aqui");
	insere_aqui.innerHTML = requisicaoAjax.responseText;
	} else {
	alert("Problema na comunicação com o servidor");
	}
	}	
}
