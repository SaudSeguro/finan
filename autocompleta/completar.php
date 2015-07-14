<?php
header("Content-Type: text/html; charset=UTF-8",true);
define('SERVER', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'finan');
$conexao = @mysql_connect(SERVER, USER, PASS);
@mysql_select_db(DB, $conexao);
$q = mb_strtolower( strip_tags( $_GET["q"] ));
$sql = "SELECT * FROM `sacado` WHERE `sac_nome` like '%" . $q . "%' GROUP BY (`sac_nome`)";
$query = @mysql_query($sql);
while($reg = @mysql_fetch_array($query)){
	echo sprintf( "%s|%s\n", mb_strtoupper( $reg["sac_nome"] ), $reg["sac_id"] );
}
@mysql_free_result( $query );
@mysql_close($conexao);
?>