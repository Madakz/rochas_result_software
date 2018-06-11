<?php
	 include "../class_lib/functions.php";
	 $rochas_inst = new Rochas;
	 $clazzes = $rochas_inst->fetchClazz();

	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" ?>\n";
	echo "<clazzes>\n";
	
	foreach ($clazzes as $a_row_record) {
	
		echo "<clazz>\n\t<id>".$a_row_record['id']."</id>\n\t<name>".$a_row_record['name']."</name>\n</clazz>\n";
	}

	echo "</clazzes>";
?>