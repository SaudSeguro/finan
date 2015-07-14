<?php
if (basename($_SERVER["PHP_SELF"]) == "init.php") {
	die("Este arquivo não pode ser acessado diretamente.");
}	

if(get_magic_quotes_runtime()){
	set_magic_quotes_runtime(0);
}

function remove_mq(&$var) {
	return is_array($var) ? array_map("remove_mq", $var) : stripslashes($var);
}

if (get_magic_quotes_gpc()) {
	$_GET    = array_map("remove_mq", $_GET);
	$_POST   = array_map("remove_mq", $_POST);
	$_COOKIE = array_map("remove_mq", $_COOKIE);
}

if (function_exists("ini_get")) {
	if(!ini_get("display_errors")){
		ini_set("display_errors", 1);
	}	
	
	if(ini_get("magic_quotes_sybase")){
		ini_set("magic_quotes_sybase", 0);
	}	
	
	if (ini_get("register_globals")) {	
		foreach($GLOBALS as $s_variable_name => $m_variable_value) {
			if (!in_array($s_variable_name, array("GLOBALS", "argv", "argc", "_FILES", "_COOKIE", "_POST", "_GET", "_SERVER", "_ENV", "_SESSION", "s_variable_name", "m_variable_value"))){
				unset($GLOBALS[$s_variable_name]);
			}
		}
		unset($GLOBALS["s_variable_name"]);
		unset($GLOBALS["m_variable_value"]);
	}  
}

error_reporting(E_ALL);

define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("BASEPATH", getcwd()."/");

set_include_path('.' . PATH_SEPARATOR . BASEPATH . 'includes'
	. PATH_SEPARATOR . BASEPATH . 'classes'
	. PATH_SEPARATOR . get_include_path());

function __autoload($classe){
	require_once $classe.".php";	
}

if (file_exists(BASEPATH . "config.php")){
	require_once BASEPATH . "config.php";
} else {
	die("Erro: Arquivo config.php nao localizado");
}


clearstatcache();
?>