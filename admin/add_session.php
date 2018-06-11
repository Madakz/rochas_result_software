<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst= new Rochas;

	if (isset($_POST['register'])) {
		$name=trim($_POST['item_name']);
		$admin = trim($_POST['admin']);

		$result = $rochas_inst->checkIfSessionExist($name);

		if ($result != 0) {
	?>
			<script>
				alert("Session Already exist!");
			</script>
	<?php
		}else{
			$insert=$rochas_inst->addSession($name, $admin);
			if ($insert) {
	?>
				<script>
					alert("Session is added successfully");
					window.location.href='index.php';
				</script>
	<?php		
			}else{
?>
				<script>
					alert("Session's addition failed");
				</script>
<?php
			}
		}

	}
?>




	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a>

	<h2>Add Session</h2>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		
		<label>School Session:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="item_name" value="<?php echo !empty($_POST['item_name']) ? $_POST['item_name'] : ""; ?>" placeholder="e.g 2016/2017" class="form-control" required="">
		<br/>
	    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
	    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="register" value="Submit">
	</form>