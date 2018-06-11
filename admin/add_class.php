<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst= new Rochas;

	if (isset($_POST['register'])) {
		$name=trim($_POST['item_name']);
		$admin = trim($_POST['admin']);

		$result = $rochas_inst->checkIfClassExist($name);

		if ($result != 0) {
	?>
			<script>
				alert("Class Already exist!");
			</script>
	<?php
		}else{
			$insert=$rochas_inst->addClass($name, $admin);
			if ($insert) {
	?>
				<script>
					alert("class added successfully");
					window.location.href='index.php';
				</script>
	<?php		
			}else{
?>
				<script>
					alert("class's addition failed");
				</script>
<?php
			}
		}

	}
?>




	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a>

	<h2>Add Class</h2>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		
		<label>Class name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<select name="item_name" class="form-control" required="">
        	<option value="">-- select class --</option>
        	<option value="jss 1">JSS 1</option>
        	<option value="jss 2">JSS 2</option>
        	<option value="jss 3">JSS 3</option>
        	<option value="sss 1">SSS 1</option>
        	<option value="sss 2">SSS 2</option>
        	<option value="sss 3">SSS 3</option>

     	 </select>
		<br/>		
	    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
	    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="register" value="Submit">
	</form>