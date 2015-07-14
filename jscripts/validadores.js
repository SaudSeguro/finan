function isMail(mailField){
  strMail = mailField.value;
  var re = new RegExp;
  re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var arr = re.exec(strMail);
  if (arr == null)
    return(false);
  else
    return(true);
}

function minLen(txtField, minVal){
  strExp = txtField.value;
  l = strExp.length;
  if (l < minVal)
    return(true);
  else
    return(false);
}

function maxLen(txtField, maxVal){
  strExp = txtField.value;
  l = strExp.length;
  if (l > maxVal)
    return(true);
  else
    return(false);
}

function isBlank(txtField){
  if (txtField.value)
    return (false);
  else
    return(true);
}


function isChecked(checkbox){
  if (checkbox == 0)
    return (false);
  else
    return(true);
}


function isSelectedZero(txtField){
  selected = txtField.selectedIndex;
  if (selected == 0)
    return(true);
  else
    return(false);
}

function isNumber(txtField){
  numExp = txtField.value;
  if (isNaN(numExp) || (numExp.length == 0))
    return (false);
  else
    return(true);
}

function isCPF(txtField){ 

  var i; 
  s = txtField.value;  
  var c = s.substr(0,9); 
  var dv = s.substr(9,2); 
  var d1 = 0; 
  
  for (i = 0; i < 9; i++){ 
    d1 += c.charAt(i)*(10-i); 
  } 
  
  if (d1 == 0) return false;   
  
  d1 = 11 - (d1 % 11); 
  
  if (d1 > 9) d1 = 0; 
  
  if (dv.charAt(0) != d1) return false; 
  
  d1 *= 2; 
  
  for (i = 0; i < 9; i++){ 
    d1 += c.charAt(i)*(11-i);   
  } 
  
  d1 = 11 - (d1 % 11); 
  
  if (d1 > 9) d1 = 0; 
  
  if (dv.charAt(1) != d1) return false; 
  
  return true; 
  
}
//funcao autotab
function autotab(elemento)
{
 if (elemento.value.length < elemento.getAttribute("maxlength")) return;
 var formulario = elemento.form;
 var els = formulario.elements;
 var x, autotab;
 for (var i = 0, len = els.length; i < len; i++)
 {
  x = els[i];
  if (elemento == x && (autotab = els[i+1]))
  {
   if (autotab.focus) autotab.focus();
  }
 }
}

//formata cep mascara
function formatar_mascara(src, mascara) {
	var campo = src.value.length;
	var saida = mascara.substring(0,1);
	var texto = mascara.substring(campo);
	if(texto.substring(0,1) != saida) {
		src.value += texto.substring(0,1);
	}
}

//FUNÇÃO CHECA CAPS LOCK
function checar_caps_lock(ev) {
	var e = ev || window.event;
	codigo_tecla = e.keyCode?e.keyCode:e.which;
	tecla_shift = e.shiftKey?e.shiftKey:((codigo_tecla == 16)?true:false);
	if(((codigo_tecla >= 65 && codigo_tecla <= 90) && !tecla_shift) || ((codigo_tecla >= 97 && codigo_tecla <= 122) && tecla_shift)) {
		document.getElementById('aviso_caps_lock').style.visibility = 'visible';
	}
	else {
		document.getElementById('aviso_caps_lock').style.visibility = 'hidden';
	}
}

function valida_dados (nomeform)
{
    if (nomeform.nome.value=="")
    {
        alert ("\nPor favor, digite seu nome");
        return false;
    }
	
	if (nomeform.mail.value=="" || nomeform.mail.value.indexOf('@', 0) == -1 || nomeform.mail.value.indexOf('.', 0) == -1)
    {
        alert ("E-mail incorreto");
        return false;
    }
	if (nomeform.cidade.value=="")
    {
        alert ("\nPor favor, preencha o campo a CIDADE");
        return false;
    }
	if (nomeform.uf.value=="")
    {
        alert ("\nPor favor, selecione seu ESTADO");
        return false;
    }
	if (nomeform.ddd.value.length<2)
    {
        alert ("\nPor favor, digite o DDD");
        return false;
    }
	if (nomeform.telefone.value.length<8)
    {
        alert ("\nPor favor, digite seu TELEFONE");
        return false;
    }

	if (nomeform.assunto.value=="")
    {
        alert ("\nPor favor, digite o assunto da mensagem");
        return false;
    }
	 if (nomeform.descricao.value=="")
    {
        alert ("\nPor favor, digite sua mensagem");
        return false;
    }   

return true;
}


function valida_dados_indica (nomeform)
{
    if (nomeform.nomeindica.value=="")
    {
        alert ("\nPor favor, digite seu nome");
        return false;
    }
	
	if (nomeform.emailindica.value=="" || nomeform.emailindica.value.indexOf('@', 0) == -1 || nomeform.emailindica.value.indexOf('.', 0) == -1)
    {
        alert ("\nPor favor, digite seu e-mail corretamente!");
        return false;
    }
	if (nomeform.nomeamigo.value=="")
    {
        alert ("\nPor favor, digite o nome do amigo(a).");
        return false;
    }
	
	if (nomeform.emailamigo.value=="" || nomeform.emailamigo.value.indexOf('@', 0) == -1 || nomeform.emailamigo.value.indexOf('.', 0) == -1)
    {
        alert ("\nPor favor, digite o e-mail do amigo(a) corretamente!");
        return false;
    }  

return true;
}