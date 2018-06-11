<?php
	 include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;

	
	if (isset($_POST['submit'])) {
		$session_name=$_POST['item_name'];
		$session_id = $_POST['session_id'];
		
		$update_time=date('Y-m-d h:i:s');

			$insert=$rochas_inst->editSession($session_name, $session_id, $update_time);
			if ($insert) {
	?>
				<script>
					alert("session updated successful");
					window.location.href='view_sessions.php';
				</script>
	<?php
			}else{
	?>
				<script>
					alert("session update failed");
				</script>
	<?php
			}
	}


	if(!$_GET['session']){
	?>
		<script>
			window.location.href='view_sessions.php';
		</script>
	<?php
	}else{
		$session_id=$_GET['session'];
		$session=$rochas_inst->findById($session_id, 'sessionz');
	}

?>


<h1>Edit Session </h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  		<label>Session Name:</label>
    	<input type="text" name="item_name" placeholder="<?php echo $session['name'];?>" value="<?php echo $session['name'];?>" required>
    	<input type="hidden" name="session_id" value="<?php echo $session_id;?>">
    	<br/>
		<input type="submit" name="submit" value="Submit">
</form>

