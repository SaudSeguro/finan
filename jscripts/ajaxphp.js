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

// Captura o link clicado
function linkClicado() {
	var clink = document.getElementById("clink");
		clink.onclick = function() {
		var query = this.getAttribute("href").split("?")[1];
		var arquivo = "requisicao-php.php?"+(query);
		return !requisitar(arquivo);
		};
	}

function carregando(container) {
	while (container.hasChildNodes()) {
	container.removeChild(container.lastChild);
	}
	
	var imagem = document.createElement("img");
	imagem.setAttribute("src", "../images/ajax-loader.gif");
	imagem.setAttribute("alt", "Carregando...");
	imagem.style.cssText = 'display:block; width:128px; height:15px; margin:30px auto;'; 
	container.appendChild(imagem);
}

function requisitar(arquivo) {
			var requisicaoAjax = iniciaAjax(); 
				if(requisicaoAjax) {
					carregando(document.getElementById("insere_aqui"));     
					requisicaoAjax.onreadystatechange = function () {	
					trataResposta(requisicaoAjax);	
					};
  requisicaoAjax.open("GET", arquivo, true);
  requisicaoAjax.send(null);
    return true;
  } else {
    return false;
  }
}

function trataResposta(requisicaoAjax) {                 
	if(requisicaoAjax.readyState == 4) {
	if(requisicaoAjax.status == 200 || requisicaoAjax.status == 304) {         
	document.getElementById("insere_aqui").innerHTML = requisicaoAjax.responseText;
} 
}
}
window.onload = linkClicado;
