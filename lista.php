<?php
echo "<pre>";
	print_r( $_POST );
echo "</pre>";

?>
<?php

sleep(2);
echo '<form id="form1" name="form1" method="post" action="">
  <label>
  <input type="text" name="textfield" />
  </label>
  <label>
  <input type="submit" name="Submit" value="Submit" />
  </label>
</form>';
?>