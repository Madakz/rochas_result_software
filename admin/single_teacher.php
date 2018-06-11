<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	 if (!isset($_GET['teacher'])) {
	 	header("location:view_teachers.php");
	 }
	 $id=$_GET['teacher'];
	 $table='teacher';
	$teacher = $rochas_inst->findById($id, $table);

	?>

	<a href="register_teacher.php">register teacher</a>
	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a><br/>

	<?php

	echo "Name: ".$teacher['name']."<br/> Role: ".$teacher['role']."<br/>";
	echo "Adress: ".$teacher['address']."<br/>";
	?>
	<strong>Passport:</strong><p><img src="../uploads/<?php echo $teacher['picture'];?>"  width="130px" height="120px"></p>
	<a href="edit_teacher.php?teacher=<?php echo $teacher['id']; ?>"> Edit </a>
	<a href="../delete.php?teacher=<?php echo $teacher['id']; ?>"> Delete </a>
