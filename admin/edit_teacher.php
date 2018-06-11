<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst= new Rochas;
	 $id=$_GET['teacher'];
	 $table='teacher';
	$teacher = $rochas_inst->findById($id, $table);

	if (isset($_POST['update'])) {
		$id=trim($_POST['teacher']);
		$name=trim($_POST['full_name']);
		$address=trim($_POST['address']);		
		$username=trim($_POST['username']);
		
		$insert=$rochas_inst->updateTeacher($id, $name, $username, $address);
		if ($insert) {
?>
			<script>
				alert("record updated successful");
				window.location.href='view_teacher.php';
			</script>
<?php		
		}else{
?>
			<script>
				alert("record updated failed");
			</script>
<?php
		}		
	}

?>

	<a href="register_teacher.php">register teacher</a>
	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a>

	<h2>Edit Teacher</h2>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST" enctype="multipart/form-data">
		<label>Full name:</label>
		<input type="text" name="full_name" value="<?php echo $teacher['name'];?>" placeholder="<?php echo $teacher['name'];?>" class="form-control" required="">
		<br/>
		<label>Address:</label>
		<textarea cols="20" rows="6" name="address" required="" value="<?php echo $teacher['address'];?>" placeholder="address"><?php echo $teacher['address']; ?></textarea><br/>
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $teacher['username']; ?>" placeholder="<?php $teacher['name'];?>" class="form-control" required="">
		<input type="hidden" name="teacher" value="<?php echo $id;?>">
		<br/>
	    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="update" value="Submit">
	</form>