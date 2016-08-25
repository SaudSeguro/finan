<?php
$_SESSION["dados"] = null;
session_destroy();
setcookie("dados", "", time()-60*60*24*365);
echo '<script type="text/JavaScript">window.close();</script>';
?>