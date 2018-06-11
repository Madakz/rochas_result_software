
	<h2>Grading</h2>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		
		<label>Score:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="score" value="<?php echo !empty($_POST['score']) ? $_POST['score'] : ""; ?>" placeholder="score" class="form-control" required="">
	    	
	    <br/><br/>
		<input type="submit" class="btn btn-primary" name="register" value="Submit">
	</form>
<?php

	if (isset($_POST['register'])) {
		$subject_total=trim($_POST['score']);
		print_r($_POST);

		// if ($subject_total <= 39) {
		// 	$grade='F';
		// }elseif ($subject_total <= 44) {
		// 	$grade='E';
		// }elseif ($subject_total <= 49) {
		// 	$grade='D';
		// }elseif ($subject_total <= 59) {
		// 	$grade='C';
		// }elseif ($subject_total <= 69) {
		// 	$grade='B';
		// }elseif ($subject_total <= 100) {
		// 	$grade='A';
		// }

			// die($grade);
			// echo $grade;

			$pass_grade_array=array('A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e');
			if (in_array($subject_total, $pass_grade_array)) {
				$remark='pass';
			}else{
				$remark='fail';
			}
			die($remark);
			echo $remark;
	}


?>