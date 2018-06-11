<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst= new Rochas;

	if (isset($_POST['register'])) {
		$name=trim($_POST['item_name']);
		$admin = trim($_POST['admin']);

		$result = $rochas_inst->checkIfTermExist($name);

		if ($result != 0) {
	?>
			<script>
				alert("Term Already exist!");
			</script>
	<?php
		}else{
			$insert=$rochas_inst->addTerm($name, $admin);
			if ($insert) {
	?>
				<script>
					alert("term is added successfully");
					window.location.href='index.php';
				</script>
	<?php		
			}else{
?>
				<script>
					alert("term's addition failed");
				</script>
<?php
			}
		}

	}
?>




	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a>

	<h2>Add Term</h2>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		
		<label>Term name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<select name="item_name" class="form-control" required="">
        	<option value="">-- select term --</option>
        	<option value="1ST">1ST TERM</option>
        	<option value="2ND">2ND TERM</option>
        	<option value="3RD">3RD TERM</option>

     	 </select>
		<br/>		
	    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
	    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="register" value="Submit">
	</form>