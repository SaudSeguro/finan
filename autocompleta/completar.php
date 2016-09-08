<?php
header("Content-Type: text/html; charset=UTF-8",true);
$q = strtolower(  $_GET["q"] );
if( strlen ($q) >= 2  ) {
	require_once dirname( __DIR__ ) .'/config.php';
	$sql = "SELECT SQL_CACHE * FROM `sacado` WHERE `sac_nome` like '" . $q . "%'";
	$query = mysqli_query(db_connect(),$sql);

	while($reg = mysqli_fetch_array($query)){
		echo sprintf( "%s|%s\n", strtoupper( $reg["sac_nome"] ), $reg["sac_id"]  );
	}
	mysqli_free_result( $query );
}