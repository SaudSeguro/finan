﻿<?php
define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("SENHA", "123456");
define("BANCO", "saudfinan");
$conexao = mysqli_connect(SERVIDOR, USUARIO, SENHA, BANCO) or die(mysqli_error());


setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

//@ini_set("error_reporting", E_ALL);
//@ini_set("display_errors", true);
@ini_set('html_errors', false);
@ini_set("log_errors", true);