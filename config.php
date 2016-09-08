<?php
define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("SENHA", "123456");
define("BANCO", "saudseguro_finan");

function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once 
    static $conexao;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($conexao)) {

         // Load configuration as an array. Use the actual location of your configuration file
        $conexao = mysqli_init();
		if (!$conexao) {
		    die('mysqli_init failed');
		}

		if (!mysqli_options($conexao, MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
		    die('Setting MYSQLI_INIT_COMMAND failed');
		}

		if (!mysqli_options($conexao, MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
		    die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
		}

		if (!@mysqli_real_connect($conexao, SERVIDOR, USUARIO, SENHA, BANCO)) {
		    die('Connect Error (' . mysqli_connect_errno() . ') '
		            . mysqli_connect_error());
		}
    }

    return $conexao;
}

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

//@ini_set("error_reporting", E_ALL);
//@ini_set("display_errors", true);
@ini_set('html_errors', false);
@ini_set("log_errors", true);