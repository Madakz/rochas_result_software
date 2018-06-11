<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	 $logged_in_user = $_SESSION['logged_user_id'];


	 //coding when the attendance form is filled
	 if (isset($_POST['attendance'])) {
		$student=trim($_POST['student']);
		$total_time_school_open=trim($_POST['total_time_school_open']);
		$no_of_times_present=trim($_POST['no_of_times_present']);
		$no_of_times_absent=trim($_POST['no_of_times_absent']);
		$no_of_student_in_class=trim($_POST['no_of_student_in_class']);
		$term=trim($_POST['term']);
		$session=trim($_POST['session']);
		$teacher=trim($_POST['teacher']);
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);

		$result=$rochas_inst->checkIfStudentAttendance($class, $class_type, $class_arm, $session, $term, $student);
		if ($result != 0) {
	?>
			<script>
				alert("Student's attendance record for this term Already exist!");
			</script>
	<?php
			echo "<script>window.location.href='student.php?student=".$student."'</script>";
		}else{

			$response=$rochas_inst->insertAttendance($total_time_school_open, $no_of_times_present, $no_of_times_absent, $term, $session, $student, $no_of_student_in_class, $teacher, $class, $class_type, $class_arm);
			if ($response) {
		?>

				<script>alert("Student's attendance record is successfully saved")</script>
		<?php
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}else{
				echo "<script>alert('Student attendance record saving failed')</script>";
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}
		}
	}
	//coding when the attendance form is filled
	 

	 // coding for when the pschomotor skill form is filled
	if (isset($_POST['pyschomotor'])) {
		$student=trim($_POST['student']);
		$instruments=trim($_POST['instruments']);
		$dancing=trim($_POST['dancing']);
		$hurdles=trim($_POST['hurdles']);
		$jumps=trim($_POST['jumps']);
		$sprints=trim($_POST['sprints']);
		$other_games=trim($_POST['other_games']);
		$volleyball=trim($_POST['volley_ball']);
		$basketball=trim($_POST['basket_ball']);
		$football=trim($_POST['football']);
		$painting=trim($_POST['painting']);
		$drawing=trim($_POST['drawing']);
		$tools_handling=trim($_POST['tools_handling']);
		$public_speaking=trim($_POST['public_speaking']);
		$hand_writing=trim($_POST['hand_writing']);
		$term_id=trim($_POST['term']);
		$session_id=trim($_POST['session']);
		$teacher_id=trim($_POST['teacher']);
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);
		// die($class_type);

		$result=$rochas_inst->checkIfStudentPsychomotorAdded($class, $class_type, $class_arm, $session_id, $term_id, $student);
		if ($result != 0) {
	?>
			<script>
				alert("Student's psychomotor record for this term Already exist!");
			</script>
	<?php
			echo "<script>window.location.href='student.php?student=".$student."'</script>";
		}else{

			$response=$rochas_inst->insertPsychomotor($instruments, $dancing, $hurdles, $jumps, $sprints, $other_games, $volleyball, $basketball, $football, $painting, $drawing, $tools_handling, $public_speaking, $hand_writing, $student, $class, $class_type, $class_arm, $session_id, $term_id, $teacher_id);
			if ($response) {
	?>
				
				<script>alert("Student's psychomotor record is successfully saved");</script>
	<?php
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}else{
				echo "<script>alert('Student psychomotor record saving failed')</script>";
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}
		}
	}
	// coding for when the pyschomotor skill form is filled



	// coding for Affecting Domain Grading
	if (isset($_POST['observed_traits'])) {
		$student=trim($_POST['student']);
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);
		$session_id=trim($_POST['session']);
		$cooperation_spirit=trim($_POST['cooperation_spirit']);
		$organisational_ability=trim($_POST['organisational_ability']);
		$self_control=trim($_POST['self_control']);
		$sense_of_responsibility=trim($_POST['sense_of_responsibility']);
		$obedience=trim($_POST['obedience']);
		$relationship_with_others=trim($_POST['relationship_with_others']);
		$attentiveness=trim($_POST['attentiveness']);
		$perseverance=trim($_POST['perseverance']);
		$initiative=trim($_POST['initiative']);
		$honesty=trim($_POST['honesty']);
		$politeness=trim($_POST['politeness']);
		$neatness=trim($_POST['neatness']);
		$reliability=trim($_POST['reliability']);
		$class_attendance=trim($_POST['class_attendance']);
		$punctuality=trim($_POST['punctuality']);
		$term_id=trim($_POST['term']);
		$teacher_id=trim($_POST['teacher']);

		$result=$rochas_inst->checkIfStudentAffectiveDomainAdded($class, $class_type, $class_arm, $session_id, $term_id, $student);
		if ($result != 0) {
	?>
			<script>alert('Student Affective Domain record for this term Already exist!');</script>
	<?php
			echo "<script>window.location.href='student.php?student=".$student."'</script>";
		}else{

			$response=$rochas_inst->insertDomainTraits($cooperation_spirit, $organisational_ability, $self_control, $sense_of_responsibility, $obedience, $relationship_with_others, $attentiveness, $perseverance, $initiative, $honesty, $politeness, $neatness, $reliability, $class_attendance, $punctuality, $class, $class_type, $class_arm, $teacher_id, $term_id, $session_id,  $student);
			if ($response) {
?>
				<script>alert("Student's Affective Domain record is successfully saved");</script>
<?php
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}else{
				echo "<script>alert('Student attendance record saving failed')</script>";
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}
		}
	}
	// coding for Affecting Domain Grading


	
	// coding for Score Sheet
	$error="";
	if (isset($_POST['score_sheet'])) {
		$student=trim($_POST['student']);
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);
		$session_id=trim($_POST['session']);
		$subject=trim($_POST['subject']);
		$term_commenced=trim($_POST['term_commenced']);
		$term_ended=trim($_POST['term_ended']);

		if ($_POST['assignment1'] > 5 || $_POST['assignment2'] > 5 || $_POST['classwork1'] > 5 || $_POST['classwork2'] > 5 || $_POST['test1'] > 10 || $_POST['test2'] > 10 || $_POST['exam'] > 60) {
	?>
			<script>alert("The entry value for assignment 1 and 2 or Classwork 1 and 2 should not exceed 5!\nThe entry value for test 1 and 2 should not exceed 10!\nThe entry value for exam should not exceed 60!");</script>
	<?php
			echo "<script>window.location.href='student.php?student=".$student."'</script>";
			$error='The entry value for assignment 1 and 2 or Classwork 1 and 2 should not exceed 5!';
		}elseif (empty($error)) {
			$assignment1=trim($_POST['assignment1']);
			$assignment2=trim($_POST['assignment2']);
			$classwork1=trim($_POST['classwork1']);
			$classwork2=trim($_POST['classwork2']);
			$test1=trim($_POST['test1']);
			$test2=trim($_POST['test2']);
			$exam=trim($_POST['exam']);

			$term_id=trim($_POST['term']);
			$teacher_id=trim($_POST['teacher']);


			$subject_total=$rochas_inst->subjectTotal($assignment1, $assignment2, $classwork1, $classwork2, $test1, $test2, $exam);

			$subject_grade=$rochas_inst->subjectGrade($subject_total);

			$remark=$rochas_inst->subjectRemark($subject_grade);

			

			$result=$rochas_inst->checkIfStudentTermScoreSheetAdded($class, $class_type, $class_arm, $session_id, $term_id, $student, $subject);
			if ($result != 0) {
	?>
				<script>alert("Student's term score sheet record for this term Already exist!");</script>
	<?php
				echo "<script>window.location.href='student.php?student=".$student."'</script>";
			}else{

				$response=$rochas_inst->insertStudentTermRecord($student, $teacher_id, $term_id, $session_id, $class, $class_type, $class_arm, $subject, $term_commenced, $term_ended, $assignment1, $assignment2, $classwork1, $classwork2, $test1, $test2, $exam, $subject_total, $subject_grade, $remark);
				if ($response) {
	?>
					<script>alert("Student's term score sheet record is successfully saved");</script>
	<?php
					echo "<script>window.location.href='student.php?student=".$student."'</script>";
				}else{
					echo "<script>alert('Student term score sheet record saving failed')</script>";
					echo "<script>window.location.href='student.php?student=".$student."'</script>";
				}
			}


		}
		
	}
	// coding for Score Sheet


	// if (!isset($_GET['student'])) {
	//  	header("location:view_students.php");
	//  }
	 $id=$_GET['student'];
	 $_SESSION['student_id']=$id;
	 $table='student';
	$student = $rochas_inst->findById($id, $table);

	?>


	<script type="text/javascript" src="../js/jquery.js"></script>
	<script language="JavaScript" src="../js/functionsforcascadingdropdown.js"></script>
    <script type="text/javascript" src="../js/dropdown.js"></script>


	<a href="index.php">Home</a>
	<a href="teacher_profile.php">Profile</a>
	<a href="../student/index.php">view students</a>
	<a href="../student/score_sheet.php">Enter score sheet</a>
	<a href="../student/term_result.php">Print result</a>

	<br/><strong>Passport:</strong><p><img src="../uploads/<?php echo $student['picture'];?>"  width="130px" height="120px"></p>

	<?php

	echo "Surname: ".$student['surname']."<br/>";
	echo "Firstname: ".$student['firstname']."<br/>";
	echo "Other name: ".$student['othername']."<br/>";
	$class_id=$student['clazz_id'];
	$class_table='clazz';
	$class=$rochas_inst->findById($class_id, $class_table);
	echo "Class: ".$class['name']."<br/>";
	$class_arm_id=$student['class_arm_id'];
	$class_arm_table='class_arm';
	$class_arm=$rochas_inst->findById($class_arm_id, $class_arm_table);
	echo "Class Arm: ".strtoupper($class_arm['name'])."<br/>";
	$class_type_id=$student['clazz_type_id'];
	$class_type_table='clazz_type';
	$class_type=$rochas_inst->findById($class_type_id, $class_type_table);
	echo "Class Type: ".$class_type['name']."<br/>";

	// echo "Repeating Record: ";

	// //Do coding for repeating
	// $repeatings=$rochas_inst->retrieveRepeating($id);
	// if (empty($repeatings)) {
	// 	echo "<i>No repeating record.</i>";
	// }else{
	// 	foreach ($repeatings as $repeating) {
	// 		$repeat_class_id=$repeating['clazz_id'];
	// 		$repeat_class=$rochas_inst->findById($repeat_class_id, 'clazz');
	// 		echo $repeating['session']." ".$repeat_class['name']."<br/>";
	// 	}
		
	// }
	

	if ($student['status']==1) {
	?>
		<br/>
		

		<!-- ======== ATTENDANCE FLIP RECORD ======== -->
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="attendace_flip" class="btn btn-warning form-control"><a href="#attendace_flip">Enter Attendance Record</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="attendance_panel">
				<h2 class="text-center features-text" style="color">Attendance Form</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
					<label>Total Time School Opened:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="total_time_school_open" value="<?php echo !empty($_POST['total_time_school_open']) ? $_POST['total_time_school_open'] : ""; ?>" Placeholder="e.g 56" class="form-control" required="">
					<label>Number of Time(s) Present:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="no_of_times_present" value="<?php echo !empty($_POST['no_of_times_present']) ? $_POST['no_of_times_present'] : ""; ?>" Placeholder="e.g 50" class="form-control" required="">
					<label>Number of Time(s) Absent:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="no_of_times_absent" value="<?php echo !empty($_POST['no_of_times_absent']) ? $_POST['no_of_times_absent'] : ""; ?>" Placeholder="e.g 6" class="form-control" required="">
					<label>Number of Student(s) in Class:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="no_of_student_in_class" value="<?php echo !empty($_POST['no_of_student_in_class']) ? $_POST['no_of_student_in_class'] : ""; ?>" Placeholder="e.g 45" class="form-control" required="">
					<?php
						$terms=$rochas_inst->viewTermz();
					?>
					<label>Term:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="term"  required="">
			        	<option value="">-- select term --</option>
			        <?php
			        	foreach ($terms as $term) {
			        ?>
			        	<option value="<?php echo $term['id'];?>"><?php echo strtolower($term['name'])	;?> term</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

			     	 <?php
						$sessions=$rochas_inst->viewSession();
					?>
					<label>Session:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="session"  required="">
			        	<option value="">-- select session --</option>
			        <?php
			        	foreach ($sessions as $session) {
			        ?>
			        	<option value="<?php echo $session['id'];?>"><?php echo $session['name'];?> session</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

				     <br/><br/>
										
					<input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">
					<input type="hidden" name="teacher" value="<?php echo $logged_in_user;?>">	
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">	
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">	
					<input type="submit" name="attendance" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#attendace_flip").click(function(){
				        $("#attendance_panel").fadeToggle(1500);
				    });
				    
				});
			</script>
				 
			<style> 
				 #attendace_flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#attendace_flip:hover{color:	#E67E00;}

				#attendance_panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#attendance_panel label{
				    color: #ffffff;
				}
			</style>
		</div>

		<!-- ========= ATTENDANCE FLIP RECORD ========= -->





		<!-- ======== EXTRA-CURRICULAR FLIP RECORD ======== -->
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="extra_cur_flip" class="btn btn-warning form-control"><a href="#extra_cur_flip">Enter Psychomotor Skill Record</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="extra_cur_panel">
				<h2 class="text-center features-text" style="color">Psychomotor Skill Grading Form</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
					<label>Instruments Handling:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="instruments"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	<label>Dancing:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="dancing"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	<label>Hurdles:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="hurdles"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	<label>Jumps:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="jumps"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Sprints:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="sprints"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Other games:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="other_games"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>VolleyBall:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="volley_ball"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>BasketBall:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="basket_ball"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Football:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="football"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Painting:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="painting"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Drawing:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="drawing"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Tools Handling:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="tools_handling"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Public Speaking:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="public_speaking"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Hand Writing:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="hand_writing"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

				     <?php
						$terms=$rochas_inst->viewTermz();
					?>
					<label>Term:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="term"  required="">
			        	<option value="">-- select term --</option>
			        <?php
			        	foreach ($terms as $term) {
			        ?>
			        	<option value="<?php echo $term['id'];?>"><?php echo strtolower($term['name'])	;?> term</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

			     	 <?php
						$sessions=$rochas_inst->viewSession();
					?>
					<label>Session:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="session"  required="">
			        	<option value="">-- select session --</option>
			        <?php
			        	foreach ($sessions as $session) {
			        ?>
			        	<option value="<?php echo $session['id'];?>"><?php echo $session['name'];?> session</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>
				     <br/><br/>

				    <input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">
					<input type="hidden" name="teacher" value="<?php echo $logged_in_user;?>">	
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">	
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">			
					
					<input type="submit" name="pyschomotor" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#extra_cur_flip").click(function(){
				        $("#extra_cur_panel").fadeToggle(1500);
				    });
				    
				});
			</script>
				 
			<style> 
				 #extra_cur_flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#extra_cur_flip:hover{color:	#E67E00;}

				#extra_cur_panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#extra_cur_panel label{
				    color: #ffffff;
				}
			</style>
		</div>

		<!-- ========= EXTRA-CURRICULAR FLIP RECORD ========= -->




		<!-- ======== OBSERVABLE TRAIT FLIP RECORD ======== -->
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="observetraits_flip" class="btn btn-warning form-control"><a href="#observetraits_flip">Enter Affective Domain Record</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="observetraits_panel">
				<h2 class="text-center features-text" style="color">Affective Domain Grading Form</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
					<label>Spirit of Cooperation:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="cooperation_spirit"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Organisational Ability:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="organisational_ability"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Self Control:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="self_control"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Sense of Responsibility:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="sense_of_responsibility"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Obedience:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="obedience"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Relationship with Others:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="relationship_with_others"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Attentiveness:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="attentiveness"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Perseverance:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="perseverance"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Initiative:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="initiative"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Honesty:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="honesty"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Politeness:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="politeness"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Neatness:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="neatness"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Reliability:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="reliability"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

			     	 <label>Class attendance:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="class_attendance"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

				     <label>Punctuality:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="punctuality"  required="">
			        	<option value="">-- select rating --</option>
			        	<?php
			        		$rating=1;
			        		while ($rating <=5 ) {
			        	?>
			        			<option value="<?php echo $rating;?>"><?php echo $rating;?></option>
			        	<?php
			        		$rating++;
			        		}
			        	?>
			        
			     	 </select>

				     <?php
						$terms=$rochas_inst->viewTermz();
					?>
					<label>Term:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="term"  required="">
			        	<option value="">-- select term --</option>
			        <?php
			        	foreach ($terms as $term) {
			        ?>
			        	<option value="<?php echo $term['id'];?>"><?php echo strtolower($term['name'])	;?> term</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

			     	 <?php
						$sessions=$rochas_inst->viewSession();
					?>
					<label>Session:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="session"  required="">
			        	<option value="">-- select session --</option>
			        <?php
			        	foreach ($sessions as $session) {
			        ?>
			        	<option value="<?php echo $session['id'];?>"><?php echo $session['name'];?> session</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>
				     <br/><br/>

				    <input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">
					<input type="hidden" name="teacher" value="<?php echo $logged_in_user;?>">	
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">
					<input type="submit" name="observed_traits" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#observetraits_flip").click(function(){
				        $("#observetraits_panel").fadeToggle(1500);
				    });
				    
				});
			</script>
				 
			<style> 
				 #observetraits_flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#observetraits_flip:hover{color:	#E67E00;}

				#observetraits_panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#observetraits_panel label{
				    color: #ffffff;
				}
			</style>
		</div>

		<!-- ========= OBSERVABLE TRAIT FLIP RECORD ========= -->




		<!-- ======== SCORE SHEET FLIP RECORD ======== -->
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="score_sheet_flip" class="btn btn-warning form-control"><a href="#score_sheet_flip">Enter Score Sheet Record</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="score_sheet_panel">
				<h2 class="text-center features-text" style="color">Student's Score Sheet</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
					<p style="color:red;"><?php echo $error; ?></p>
					<input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">
					<input type="hidden" name="teacher" value="<?php echo $logged_in_user;?>">	
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">

					<?php
						$terms=$rochas_inst->viewTermz();
					?>
					<label>Term:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="term"  required="">
			        	<option value="">-- select term --</option>
			        <?php
			        	foreach ($terms as $term) {
			        ?>
			        	<option value="<?php echo $term['id'];?>"><?php echo strtolower($term['name'])	;?> term</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

			     	 <?php
						$sessions=$rochas_inst->viewSession();
					?>
					<label>Session:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="session"  required="">
			        	<option value="">-- select session --</option>
			        <?php
			        	foreach ($sessions as $session) {
			        ?>
			        	<option value="<?php echo $session['id'];?>"><?php echo $session['name'];?> session</option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>

			     	 <?php
						$subjects=$rochas_inst->viewSubjects();
					?>
					<label>Subject:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="subject"  required="">
			        	<option value="">-- select subject --</option>
			        <?php
			        	foreach ($subjects as $subject) {
			        ?>
			        	<option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?> </option>
			        <?php
			        	}
			       	?>
			        
			     	 </select>
			     	 <br/>
			     	 <label>Term commencement Date:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="term_commenced" value="<?php echo !empty($_POST['term_commenced']) ? $_POST['term_commenced'] : ""; ?>" Placeholder="e.g 19/09/2012" class="form-control" required="">
					<br/>
					<label>Term Ending Date:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="term_ended" value="<?php echo !empty($_POST['term_ended']) ? $_POST['term_ended'] : ""; ?>" Placeholder="e.g 19/12/2012" class="form-control" required="">
					<br/>
					<label>1st Assignment Score (max.=5):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="assignment1" value="<?php echo !empty($_POST['assignment1']) ? $_POST['assignment1'] : ""; ?>" Placeholder="e.g 4" class="form-control" required="">
					
					<label>2nd Assignment Score (max.=5):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="assignment2" value="<?php echo !empty($_POST['assignment2']) ? $_POST['assignment2'] : ""; ?>" Placeholder="e.g 5" class="form-control" required="">
					<br/>
					<label>1st Classwork Score (max.=5):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="classwork1" value="<?php echo !empty($_POST['classwork1']) ? $_POST['classwork1'] : ""; ?>" Placeholder="e.g 5" class="form-control" required="">
					
					<label>2nd Classwork Score (max.=5):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="classwork2" value="<?php echo !empty($_POST['classwork2']) ? $_POST['classwork2'] : ""; ?>" Placeholder="e.g 4" class="form-control" required="">
					<br/>
					<label>1st Test Score (max.=10):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="test1" value="<?php echo !empty($_POST['test1']) ? $_POST['test1'] : ""; ?>" Placeholder="e.g 10" class="form-control" required="">
					
					<label>2nd Test Score (max.=10):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="test2" value="<?php echo !empty($_POST['test2']) ? $_POST['test2'] : ""; ?>" Placeholder="e.g 8" class="form-control" required="">
					<br/>
					<label>Exam Score (max.=60):&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="text" name="exam" value="<?php echo !empty($_POST['exam']) ? $_POST['exam'] : ""; ?>" Placeholder="e.g 55" class="form-control" required="">
					<br/>
					
				     <br/><br/>
										
					
					<input type="submit" name="score_sheet" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#score_sheet_flip").click(function(){
				        $("#score_sheet_panel").fadeToggle(1500);
				    });
				    
				});
			</script>
				 
			<style> 
				 #score_sheet_flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#score_sheet_flip:hover{color:	#E67E00;}

				#score_sheet_panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#score_sheet_panel label{
				    color: #ffffff;
				}
			</style>
		</div>

		<!-- ========= SCORE SHEET FLIP RECORD ========= -->

		<!-- <form method="post" action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<input type="hidden" name="student" value="<?php //echo $_SESSION['student_id'];?>">

			<input type="hidden" name="class" value="<?php //echo $student['clazz_id'];?>">		this is added for the repeating student
			<?php 
				//$session=$rochas_inst->viewCurrentSession();
			?>
			<input type="hidden" name="session" value="<?php //echo $session['nam'];?>">
			<input type="submit" name="repeat" value="Repeat">
			<input type="submit" name="withdraw" value="Withdraw"><br/>
		</form>	 -->	
		
	<?php	
	}else{
		echo "<h3 style='color:red;'>NOT LONGER A STUDENT</h3>";
	}
	?>

	<!-- <h1>Remember to work on view student Result based selection for a terms <em style="color:red;">AND</em> session </h1> -->
