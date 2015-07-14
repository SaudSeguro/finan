function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}


function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}


function AddLoad(id){
	el = document.getElementById(id);
	el.innerHTML += '<img src="../images/img_loading.gif" alt="Transferindo imagens!"/>';
}

function Limpar(valor, validos) {
	// retira caracteres invalidos da string
	var result = "";
	var aux;
	for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0) {
			result += aux;
		}
	}
	return result;
}

//Formata n�mero tipo moeda usando o evento onKeyDown

function Formata(campo,tammax,teclapres,decimal) {
	var tecla = teclapres.keyCode;
	vr = Limpar(campo.value,"0123456789");
	tam = vr.length;
	dec=decimal

	if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

	if (tecla == 8 )
	{ tam = tam - 1 ; }

	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
	{

	if ( tam <= dec )
	{ campo.value = vr ; }

	if ( (tam > dec) && (tam <= 5) ){
	campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
	if ( (tam >= 6) && (tam <= 8) ){
	campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
	}
	if ( (tam >= 9) && (tam <= 11) ){
	campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
	if ( (tam >= 12) && (tam <= 14) ){
	campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
	if ( (tam >= 15) && (tam <= 17) ){
	campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
	} 
}
 
function AddCampo(id){
	el = document.getElementById(id);
	el.innerHTML = '<br /><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Cadastrar Novo" />';
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}

var input = 0;
function addImputFotos() 
{
	var onde = document.getElementById('addImput');
	onde.innerHTML += '<input type="file" name="arquivo[]" value="" /><br />';

	input++;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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

//FUN��O CHECA CAPS LOCK
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

function mouseOver(op) {
	if (op == 1) {
		document.getElementById("texto").innerHTML="<a href=\"?pag=novoSacado\" class=\"LinkCarrega\" title=\"Novo Cliente\">Novo Cliente</a>&nbsp; | &nbsp;<a href=\"?pag=novoTitulo\" class=\"LinkCarrega\" title=\"Novo Procedimento\">Novo Procedimento / Promissória</a>&nbsp; | &nbsp;<a href=\"?pag=novoUsuario\" class=\"LinkCarrega\" title=\"Novo Usuário\">Novo Usuário</a>&nbsp; | &nbsp;<a href=\"?pag=novaManutencao\" class=\"LinkCarrega\" title=\"Manutenção\">Manutenção</a>";
	}else if (op == 2) {
		document.getElementById("texto").innerHTML="<a href=\"?pag=consultaSacado\" class=\"LinkCarrega\" title=\"Consulta sacado\">Consulta de Cliente</a>&nbsp; | &nbsp;<a href=\"?pag=consultaTitulo\" class=\"LinkCarrega\" title=\"Consulta de Procedimentos Realizados\">Consulta de Procedimentos</a>&nbsp; | &nbsp;<a href=\"?pag=consultaParcelas\" class=\"LinkCarrega\" title=\"Consulta de Promissórias\">Consulta de Promissórias</a>&nbsp; | &nbsp;<a href=\"?pag=consultaAparelho\" class=\"LinkCarrega\" title=\"Consulta de Aparelho\">Consulta de Aparelho</a>&nbsp; | &nbsp;<a href=\"?pag=consultaManutencao\" class=\"LinkCarrega\" title=\"Consulta de Manutenção\">Consulta de Manutenção</a>&nbsp; | &nbsp;<a href=\"?pag=consultaUsuario\" class=\"LinkCarrega\" title=\"Consulta de Usuário\">Consulta de Usuário</a>";
	}
}

function mouseOut() {


}



