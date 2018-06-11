<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst= new Rochas;

	 $error='';
	if (isset($_POST['register'])) {
		$name=trim($_POST['full_name']);
		$address=trim($_POST['address']);
		$subject=trim($_POST['subject']);		
		$username=trim(strtolower($_POST['username']));
		$password=$_POST['password'];
		$con_password=$_POST['con_password'];

		$role=trim($_POST['role']);
		$admin = trim($_POST['admin']);

		$picture = $rochas_inst->imageUploadFunction($_FILES);
		
		$insert=$rochas_inst->registerTeacher($name, $subject, $username, $password, $con_password, $picture, $address, $role, $admin);
		if ($insert) {
?>
			<script>
				alert("teacher registered successful");
				window.location.href='index.php';
			</script>
<?php		
		}else{
			$error='Password Mismatch';
?>
			<script>
				alert("teacher's registration failed");
			</script>
<?php
		}		
	}

?>

	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a>

	<h2>Registration Form</h2>
	<h5>Provide your details below</h5>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST" enctype="multipart/form-data">
		<h5 style="color:red;"><?php echo $error;?></h5>
		<label>Image:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="file" name="picture" required="" /><br/>
		<label>Full name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="full_name" value="<?php echo !empty($_POST['full_name']) ? $_POST['full_name'] : ""; ?>" placeholder="full name" class="form-control" required="">
		<br/>
		<label>Address:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<textarea cols="20" rows="6" name="address" required="" placeholder="address"><?php echo !empty($_POST['address']) ? $_POST['address'] : ""; ?></textarea><br/>
		<label>Teaching Subject:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
			<select name="subject"  required="">
	        <option value="">-- select subject --</option>
	        <?php
	        	$subjects=$rochas_inst->viewSubjects();
	        	foreach ($subjects as $subject) {
	        ?>
	        		<option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?></option>
	        <?php
	        	}
	        ?>
	        
	     </select><br/>
		<label>Username:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="username" value="<?php echo !empty($_POST['username']) ? $_POST['username'] : ""; ?>" placeholder="username" class="form-control" required="">
		<br/>
		<label>Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
	    <input type="text" name="password"  placeholder="password" class="form-control" required=""><br/>
	    <label>Confirm Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
	    <input type="text" name="con_password"  placeholder="confirm password" class="form-control" required="">
	    <input type="hidden" name="role" value="teacher">
	    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
	    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="register" value="Register">
	</form>