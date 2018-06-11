<?php
	 include "../class_lib/functions.php";
	 $rochas_inst = new Rochas;
	 $id = $_POST['class_id'];		//uncomment later
	 // $id = '5';		//remove this line when the above line is to be uncommented
	 $class = $rochas_inst->findById($id, 'clazz');
	 $class_name=$class['name'];
	 // echo $class_name;
	 $class_name_array = array('jss 1', 'jss 2', 'jss 3');		//all the items in this array are of the general class_type

	header("Content-type: text/xml");			//uncomment later
	echo "<?xml version=\"1.0\" ?>\n";
	echo "<clazz_types>\n";

	 if (in_array($class_name, $class_name_array)) {		//thiscondition checks if the class chosen ranges from jss1,.., sss1
	 	$class_type = $rochas_inst->findMoreById('1', 'clazz_type');	//this returns the general class type
	 	
	 	foreach ($class_type as $a_row_record) {
			echo "<clazz_type>\n\t<id>".$a_row_record['id']."</id>\n\t<name>".$a_row_record['name']."</name>\n</clazz_type>\n";
		}
	 }else{
	 	$class_types = $rochas_inst->findNotThisId('1', 'clazz_type');
	 	foreach ($class_types as $a_row_record) {
			echo "<clazz_type>\n\t<id>".$a_row_record['id']."</id>\n\t<name>".$a_row_record['name']."</name>\n</clazz_type>\n";
		}
	 }	
	

	echo "</clazz_types>";
?>