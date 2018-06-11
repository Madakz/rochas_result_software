<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;


	 //code for when the promote button is clicked
	 if (isset($_POST['promote'])) {
		$student=trim($_POST['student']);
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$table='student';
		$column1='clazz_id';
		$column2='clazz_type_id';
		$where_column='id';

		$response=$rochas_inst->updateTwoColumn($table, $column1, $column2, $class, $class_type, $where_column, $student);
		if ($response) {
			echo "<script>alert('student is successfully promoted');</script>";			
		}
		echo "<script>window.location.href='single_student.php?student=".$student."'</script>";
	}
	 //code for when the promote button is clicked
	 

	 // code for when the withdraw student button is clicked
	if (isset($_POST['withdraw'])) {
		$student=trim($_POST['student']);
		$table='student';
		$column='status';
		$value=0;
		$where_column='id';

		$response=$rochas_inst->updateAColumn($table, $column, $value, $where_column, $student);
		if ($response) {
			echo "<script>alert('student is withdrawn from school');</script>";			
		}
		echo "<script>window.location.href='single_student.php?student=".$student."'</script>";

		// header("location:single_student.php?student=$student");
	}
	// code for when the withdraw student button is clicked



	// code for when the repeat student button is clicked
	if (isset($_POST['repeat'])) {
		$student=trim($_POST['student']);
		$class=trim($_POST['class']);
		$session=trim($_POST['session']);

		$result=$rochas_inst->checkIfStudentRepeated($class, $session, $student);
		if ($result != 0) {
	?>
			<script>
				alert("Student repeated record for this session Already exist!");
			</script>
	<?php
			echo "<script>window.location.href='single_student.php?student=".$student."'</script>";
		}else{

			$response=$rochas_inst->addToRepeatingStudent($student, $class, $session);
			if ($response) {

				// echo "<script>window.location.href='single_student.php?student=".$student."'</script>";
				echo "<script>alert('student is repeated')</script>";
				echo "<script>window.location.href='single_student.php?student=".$student."'</script>";
			}		

			// header("location:single_student.php?student=$student");
		}
	}
	// code for when the repeat student button is clicked


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


	<a href="register_teacher.php">register teacher</a>
	<a href="view_teachers.php">view teachers</a>
	<a href="register_student.php">register student</a>
	<a href="view_students.php">view student</a><br/>

	<strong>Passport:</strong><p><img src="../uploads/<?php echo $student['picture'];?>"  width="130px" height="120px"></p>

	<?php

	echo "Name: ".$student['surname']." ".$student['firstname']." ".$student['othername']."<br/>"; 
	echo "Date of Birth: ".$student['birth_date']."<br/>";
	echo "Address: ".$student['address']."<br/>";
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
	echo "Repeating Record: ";

	//Do coding for repeating
	$repeatings=$rochas_inst->retrieveRepeating($id);
	if (empty($repeatings)) {
		echo "<i>No repeating record.</i>";
	}else{
		foreach ($repeatings as $repeating) {
			$repeat_class_id=$repeating['clazz_id'];
			$repeat_class=$rochas_inst->findById($repeat_class_id, 'clazz');
			echo $repeating['session']." ".$repeat_class['name']."<br/>";
		}
		
		// print_r($repeatings);
		// die();
	}
	

	if ($student['status']==1) {
	?>
		<br/>
		<!-- <a href="promote.php?student=<?php //echo $student['id']; ?>"> Promote </a>&nbsp; -->


		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="flip" class="btn btn-warning form-control"><a href="#flip">Promote</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="panel">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="color:red; font-size:15px;"><i>Make sure to Select the Appropriate class and class type</i></div>
					<label>Promote to Class:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
					<select name="class" id="clazz"  required="">
			        	<option value="">-- select class --</option>
			        
			     	 </select>

				     <label>Class Type:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
						<select name="class_type" id="clazz_type" disabled="disabled"  required="">
				        <option value="">-- select class type --</option>
				        
				     </select>
				     <br/><br/>
										
					<input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">
					<input type="submit" name="promote" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#flip").click(function(){
				        $("#panel").fadeToggle(1000);
				    });
				    
				});
			</script>
				 
			<style> 
				 #flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#flip:hover{color:	#E67E00;}

				#panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#panel label{
				    color: #ffffff;
				}
			</style>
		</div>





		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<input type="hidden" name="student" value="<?php echo $_SESSION['student_id'];?>">

			<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">		<!--this is added for the repeating student-->
			<?php 
				$session=$rochas_inst->viewCurrentSession();
			?>
			<input type="hidden" name="session" value="<?php echo $session['nam'];?>">
			<input type="submit" name="repeat" value="Repeat">
			<input type="submit" name="withdraw" value="Withdraw"><br/>
		</form>		
		
	<?php	
	}else{
		echo "<h3 style='color:red;'>NOT LONGER A STUDENT</h3>";
	}
	?>

		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="more-action-flip" class="btn btn-warning form-control"><a href="#more-action-flip">More Actions</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="more-action-panel">
				<a href="edit_student.php?student=<?php echo $student['id']; ?>"> Edit </a>&nbsp;
				<a href="../delete.php?student=<?php echo $student['id']; ?>"> Delete </a>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#more-action-flip").click(function(){
				        $("#more-action-panel").fadeToggle(1000);
				    });
				    
				});
			</script>
				 
			<style> 
				 #more-action-flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#more-action-flip:hover{color:	#E67E00;}

				#more-action-panel {
				    margin-top:15px;
				    display: none;
				    background-color:  grey;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#more-action-panel label{
				    color: #ffffff;
				}
			</style>
		</div>


	<h1>Remember to work on view student Result based selection for a terms <em style="color:red;">AND</em> session </h1>
	<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="view-result-flip" class="btn btn-warning form-control"><a href="#view-result-flip">View/Print Student's Term Result</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="view-result-panel">
				<form action="view_result.php" method="POST">
					<div style="color:red; font-size:15px;"><i>Make sure to Select the Appropriate Term and Session</i></div>
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
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">

					<input type="submit" name="view_result" value="View Result" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#view-result-flip").click(function(){
				        $("#view-result-panel").fadeToggle(1000);
				    });
				    
				});
			</script>
				 
			<style> 
				 #view-result-flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#view-result-flip:hover{color:	#E67E00;}

				#view-result-panel {
				    margin-top:15px;
				    display: none;
				    background-color:  grey;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#view-result-panel label{
				    color: #ffffff;
				}
			</style>
		</div>


		<h2>This is for viewing A session Result based on selection</h2>
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="view-session-result-flip" class="btn btn-warning form-control"><a href="#view-session-result-flip">View/Print Student's Session Result</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="view-session-result-panel">
				<form action="view_session_result.php" method="POST">
					<div style="color:red; font-size:15px;"><i>Make sure to Select the Appropriate Session</i></div>
					<?php
						$table='termz';
						$name='3RD';
						$term=$rochas_inst->findByName($name, $table);
					?>
					<input type="hidden" name="third_term" value="<?php echo $term['id'];?>">
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
					<input type="hidden" name="class" value="<?php echo $student['clazz_id'];?>">
					<input type="hidden" name="class_type" value="<?php echo $student['clazz_type_id'];?>">
					<input type="hidden" name="class_arm" value="<?php echo $student['class_arm_id'];?>">

					<input type="submit" name="view_session_result" value="View Session Result" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#view-session-result-flip").click(function(){
				        $("#view-session-result-panel").fadeToggle(1000);
				    });
				    
				});
			</script>
				 
			<style> 
				 #view-session-result-flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#view-session-result-flip:hover{color:	#E67E00;}

				#view-session-result-panel {
				    margin-top:15px;
				    display: none;
				    background-color:  grey;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#view-session-result-panel label{
				    color: #ffffff;
				}
			</style>
		</div>
