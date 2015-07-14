Meses: 
<select name="resp" id="resp">

<option value=""></option>
        <?php
		for($i=1;$i<=60;$i++){
		?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
		}
		?>
      </select>