<?php
	 include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;

	
	if (isset($_POST['submit'])) {
		$subject_name=$_POST['subject'];
		$subject_id = $_POST['subject_id'];
		
		$update_time=date('Y-m-d h:i:s');

			$insert=$rochas_inst->editSubject($subject_name, $subject_id, $update_time);
			if ($insert) {
	?>
				<script>
					alert("Subject updated successful");
					window.location.href='view_subjects.php';
				</script>
	<?php
			}else{
	?>
				<script>
					alert("Subject update failed");
				</script>
	<?php
			}
	}


	if(!$_GET['subject']){
	?>
		<script>
			window.location.href='viewsubjects.php';
		</script>
	<?php
	}else{
		$subject_id=$_GET['subject'];
		$subject=$rochas_inst->findById($subject_id, 'subject');
	}

?>


<h1>Edit Subject </h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  		<label>Subject Name:</label>
    	<input type="text" name="subject" placeholder="<?php echo $subject['name'];?>" value="<?php echo $subject['name'];?>" required>
    	<input type="hidden" name="subject_id" value="<?php echo $subject_id;?>">
    	<br/>
		<input type="submit" name="submit" value="Submit">
</form>

