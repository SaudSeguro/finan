<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once '../config.php';

$q = mb_strtolower( strip_tags( $_GET["q"] ));
$sql = "SELECT * FROM `sacado` WHERE `sac_nome` like '%" . $q . "%' GROUP BY (`sac_nome`)";
$query = mysqli_query($conexao,$sql);
while($reg = mysqli_fetch_array($query)){
	echo sprintf( "%s|%s\n", mb_strtoupper( $reg["sac_nome"], 'UTF-8' ), $reg["sac_id"]   );
}

mysqli_free_result( $query );
mysqli_close($conexao);