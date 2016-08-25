<?php
if(!isset($_COOKIE["dados"]) and !isset($_SESSION["dados"])){
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../login.php?pag=login&erro=1'>";
	die();
}

?>