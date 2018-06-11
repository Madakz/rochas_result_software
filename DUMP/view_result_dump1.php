<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	
	
	if (isset($_POST['view_result'])) {
		$student_id=trim($_POST['student']);
		$term_id=trim($_POST['term']);
		$session_id=trim($_POST['session']);
		$class_id=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);

		$grand_total=$rochas_inst->studentAllSubjectsGrandTotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id);

		// echo "Total: ".$grand_total;
		// echo '<br/>';

		$number_of_subjects=$rochas_inst->numberOfSubjectsStudentTook($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id);

		// echo "Number of subjects: ".$number_of_subjects;
		// echo '<br/>';
		// if ($number_of_subjects == 0 || $grand_total == 0) {
		if ($number_of_subjects == 0) {
			echo "<script>alert('Student result is not ready')</script>";
			echo "<script>window.location.href='single_student.php?student=".$student_id."'</script>";
		}else{
			$average=$rochas_inst->studentAverageCalculation($grand_total, $number_of_subjects);
			//aproximate the average to 2 decimal places
			$average = sprintf("%.2f", $average);
		}		

		// echo "Average: ".$average;
		// echo '<br/>';

		








		$result=$rochas_inst->checkIfStudentTermReportAdded($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id);
		if ($result != 0) {
			$result1=$rochas_inst->updateStudentTermReport($student_id, $term_id, $session_id, $class_id, $class_type, $class_arm, $grand_total, $number_of_subjects, $average);
			// if ($result1) {
			// 	die('yes oh');
			// }
		}else{
			$response=$rochas_inst->saveStudentTermReport($student_id, $term_id, $session_id, $class_id, $class_type, $class_arm, $grand_total, $number_of_subjects, $average);
			// if ($response) {
			// 	echo "<script>alert('displaying results');</script>";				
			// }else{
			// 	echo "<script>alert('results not ready yet');</script>";
			// }
		}

		//do subject positioning here updating the stu_subject_position column of student_term_record table
		// $rochas_inst->subjectPositioning($subject_id, $class_id, $class_type, $class_arm, $term_id, $session_id);		//find a place to execute this function
		//Sessional Subject positioning coding
		$term_records=$rochas_inst->retrieveTermRecordsForSubjectPositioning($class_id, $class_type, $class_arm, $term_id, $session_id);	
		foreach ($term_records as $term_record) {
			$subject_id=$term_record['subject_id'];
			$rochas_inst->subjectPositioning($subject_id, $class_id, $class_type, $class_arm, $term_id, $session_id);
		}


		//do coding for class position here updation the stu_position column
		$rochas_inst->doPositioning($class_id, $class_type, $class_arm, $term_id, $session_id);     
		

		//Coding for displaying of results here
		$student=$rochas_inst->findById($student_id, 'student');     //retrieving students records from student table
		$student_class=$rochas_inst->findById($class_id, 'clazz');
		$class_category=$rochas_inst->checkIfClassIsJuniorOrSeniorSecondary($student_class['name']);

		?>
		<h3>ROCHAS FOUNDATION COLLEGE JOS</h3>
		<h4>Old Airport Road, Rayfield, Jos, Plateau, Nigeria</h4>
		<h4>Report Sheet For <?php echo $class_category; ?> Secondary School</h4>
		Image:	<img src="../uploads/<?php echo $student['picture'];?>"  width="130px" height="120px">
		<br/>
		Name:	<?php echo $student['surname'].' '.$student['firstname'].' '.$student['othername']; ?><br/>
		Age:	<?php echo $rochas_inst->calculateAge($student_id).' years';?><br/>

		<?php	$term=$rochas_inst->findById($term_id, 'termz'); ?>

		Term:	<?php echo $term['name'].' TERM';?><br/>

		<?php $term_score_sheet=$rochas_inst->retrieveASingleRecordStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm);
			$attendance=$rochas_inst->retrieveStudentAttendance($class_id, $class_type,  $class_arm, $session_id, $term_id, $student_id);
		 ?>

		Term Commenced:	<?php echo $term_score_sheet['term_commenced'];?><br/>
		No. Of Students:	<?php echo $attendance['clazz_no_of_student']; ?><br/>
		Term Ended:	<?php echo $term_score_sheet['term_ended'];?><br/>
		No. Of Times Present:	<?php echo $attendance['no_of_times_present']; ?><br/>
		No. Of Times Absent:	<?php echo $attendance['no_of_times_absent']; ?><br/>
		No. Of Times School Opened:	<?php echo $attendance['total_time_school_opened']; ?><br/>

		<?php $session=$rochas_inst->findById($session_id, 'sessionz'); ?>

		Year(Session):	<?php echo $session['name']; ?><br/>

		<?php $term_final_report=$rochas_inst->retrieveStudentfinalTermReport($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id); 
			$position=$term_final_report['stu_term_position'];
		?>

		Position:	<?php echo $rochas_inst->formatPosition($position); ?><br/>

		<?php $student_class_arm=$rochas_inst->findById($class_arm, 'class_arm'); 
			$student_class=$rochas_inst->findById($class_id, 'clazz');
		?>

		Student's Class-arm:	<?php echo strtoupper($student_class['name']).''. strtoupper($student_class_arm['name']). ' ('.strtoupper($student_class['name']).')'; ?><br/>







		<table id="customers">
			<thead>
				<th colspan="2"><img src="../images/rfc.jpg" width="50px" height="50px">Rochas Foundation College, Jos</th>
				<th style="text-align: center;" colspan="7"><h3>ROCHAS FOUNDATION COLLEGE JOS</h3></th>	
			</thead>
			<thead>
				<th colspan="2"></th>

				<th style="text-align: center;" colspan="7">
					<h4>Old Airport Road, Rayfield, Jos, Plateau, Nigeria</h4>
				</th>	
			</thead>
			<thead>				
				<th style="width:100%; text-align: center;" colspan="9"><h4><ins>Report Sheet For <?php echo $class_category; ?> Secondary School</ins></h4></th>	
			</thead>
			<thead>				
				<th style="width:20%;" colspan="1"><img src="../uploads/<?php echo $student['picture'];?>"  width="130px" height="120px"></th>	
				<th style="width:20%;" colspan="2">
					Name: <br/> 
					Term: <br/>
					Term Commenced: <br/>
					No. Of Times Present: <br/>
					No. Of Times School Opens: <br/>
					Year(Session): <br/>
					Position:
				</th>
				<th style="width:20%;" colspan="2">
					<?php echo $student['surname'].' '.$student['firstname'].' '.$student['othername']; ?> <br/> 
					<?php echo $term['name'].' TERM';?> <br/>
					<?php echo $term_score_sheet['term_commenced'];?> <br/>
					<?php echo $attendance['no_of_times_present']; ?> <br/>
					<?php echo $attendance['total_time_school_opened']; ?> <br/><br/>
					<?php echo $session['name']; ?> <br/>
					<?php echo $rochas_inst->formatPosition($position); ?> <br/>
				</th>
				<th style="width:20%;" colspan="2">
					Age: <br/>
					No. Of Students: <br/>
					Term Ended: <br/>
					No. Of Times Absent: <br/>
					Student's Class-arm: <br/>
				</th>
				<th style="width:20%;" colspan="2">
					<?php echo $rochas_inst->calculateAge($student_id).' years';?> <br/>
					<?php echo $attendance['clazz_no_of_student']; ?> <br/>
					<?php echo $term_score_sheet['term_ended'];?> <br/>
					<?php echo $attendance['no_of_times_absent']; ?> <br/>
					<?php echo strtoupper($student_class['name']).''. strtoupper($student_class_arm['name']). ' ('.strtoupper($student_class['name']).')'; ?> <br/>
				</th>


			</thead>
	        <!-- <thead>
	            <?php
	                $sn=1;
	            ?>
	            <th style="width:25%;">Subject</th>
	            <th>Assignment</th>
	            <th>Class Work</th>
	            <th>Test</th>	  
	            <th>Exams</th>
	            <th><?php //echo $term['name'].' TERM Total Score';?>TERM Total Score<br/></th>
	            <th>Grade</th>
	            <th>Position</th>         
	            <th>Signature</th>
	        </thead>
	        <tbody>                                                
                <tr>
                    <td style="text-align: left;">Maximum Score</td>
                    <td>10</td>
                    <td>10</td>
                    <td>20</td>
                    <td>60</td>
                    <td>100</td>
                    <td colspan="3"></td>
                </tr>
	        </tbody> -->
	    </table>



		<style>
			table{
    			text-align: center;
			}
			#customers
			{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:100%;
			border-collapse:collapse;
			}
			#customers td, #customers th 
			{
			/*font-size:1.2em;*/
			border:1px solid #98bf21;
			padding:3px 7px 2px 7px;
			}
			#customers th 
			{
			font-size:1.4em;
			text-align:left;
			padding-top:5px;
			padding-bottom:4px;
			background-color:#A7C942;
			color:#fff;
			}
			#customers tr.alt td 
			{
			color:#000;
			background-color:#EAF2D3;
			}
		</style>
		<div class="table-responsive">
		    <table id="customers">
		        <thead>
		            <?php
		                $sn=1;
		            ?>
		            <th style="width:25%;">Subject</th>
		            <th>Assignment</th>
		            <th>Class Work</th>
		            <th>Test</th>	  
		            <th>Exams</th>
		            <th><?php echo $term['name'].' TERM Total Score';?><br/></th>
		            <th>Grade</th>
		            <th>Position</th>         
		            <th>Signature</th>
		        </thead>
		        <tbody>                                                
		                <tr>
		                    <td style="text-align: left;">Maximum Score</td>
		                    <td>10</td>
		                    <td>10</td>
		                    <td>20</td>
		                    <td>60</td>
		                    <td>100</td>
		                    <td colspan="3"></td>
		                </tr>
		                <?php
		                	$term_score_sheets=$rochas_inst->retrieveStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm);
		                	foreach ($term_score_sheets as $term_score_sheet) {
		                		$subject_id=$term_score_sheet['subject_id'];
		                		$subject=$rochas_inst->findById($subject_id, 'subject');

		                		$assignment=$rochas_inst->studentTermlyAssignmentTotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id, $subject_id);
		                		$assignment = sprintf("%.2f", $assignment);

		                		$classwork=$rochas_inst->studentTermlyClassworkTotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id, $subject_id);
		                		$classwork = sprintf("%.2f", $classwork);

		                		$test=$rochas_inst->studentTermlyTestTotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id, $subject_id);
		                		$test = sprintf("%.2f", $test);

		                		$exam=$term_score_sheet['stu_subj_exam_score'];
		                		$exam = sprintf("%.2f", $exam);

		                		$total=$term_score_sheet['stu_each_subject_total'];
		                		$total = sprintf("%.2f", $total);

		                		$grade=$term_score_sheet['term_subj_grade'];

		                		$stu_subject_position=$term_score_sheet['stu_subject_position'];
		                ?>
		                		<tr>
		                			<td style="text-align: left;"><?php echo $subject['name']; ?></td>
		                			<td><?php echo $assignment; ?></td>
		                			<td><?php echo $classwork; ?></td>
		                			<td><?php echo $test; ?></td>
		                			<td><?php echo $exam; ?></td>
		                			<td><?php echo $total; ?></td>
		                			<td><?php echo $grade; ?></td>
		                			<td><?php echo $stu_subject_position; ?></td>	
		                			<td></td>			                	
				                </tr>
		                <?php	
		                	$sn++;	                	
		                	}

		                	$overall_term_grade=$rochas_inst->subjectGrade($term_final_report['stu_term_average']);

		                	$no_ofsubjects_passed=$rochas_inst->countNoOfSubjectsStudentPassed($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id);
		                	$no_ofsubjects_failed=$rochas_inst->countNoOfSubjectsStudentFailed($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id);
		                ?>
		                <tr style="text-align: left;">		                				
                			<td colspan="2">Grand Total: <?php echo $term_final_report['stu_term_all_subjects_grand_total'];?></td>	
                			<td colspan="4">Average: <?php echo $term_final_report['stu_term_average'];?></td>
                			<td colspan="3"><?php echo $term['name'].' TERM';?> Overall Grade: <?php echo $overall_term_grade;?></td>		                	
		                </tr>
		                <tr style="text-align: left;">		                				
                			<td colspan="2"><?php echo $term['name'].' TERM';?> Position: <?php echo $rochas_inst->formatPosition($position); ?></td>	
                			<td colspan="4">NUMBER OF SUBJECTS PASSED: <?php echo $no_ofsubjects_passed; ?></td>
                			<td colspan="3">NUMBER OF SUBJECTS FAILED: <?php echo $no_ofsubjects_failed; ?></td>		                	
		                </tr>
		                <tr style="text-align: left;">		                				
                			<td colspan="9">GRADING</td>	                					                	
		                </tr>
		                <tr style="text-align: left;">		                				
                			<td colspan="3">RANGE OF SCORES</td>	
                			<td colspan="3">GRADE</td> 
                			<td colspan="3">REMARK</td>               						                	
		                </tr>
		                <tr style="text-align: left;">		                				
                			<td colspan="3"> 70 - 100 </td>	
                			<td colspan="3"> A </td> 
                			<td colspan="3"> EXCELLENT </td>               						                	
		                </tr>
		                <tr style="text-align: left;">		                				
                			<td colspan="3"> 60 - 69 </td>	
                			<td colspan="3"> B </td> 
                			<td colspan="3"> VERY GOOD </td>               						                	
		                </tr>
		                	<tr style="text-align: left;">		                				
                			<td colspan="3"> 50 - 59 </td>	
                			<td colspan="3"> C </td> 
                			<td colspan="3"> GOOD </td>               						                	
		                </tr>
		                </tr>
		                	<tr style="text-align: left;">		                				
                			<td colspan="3"> 45 - 49 </td>	
                			<td colspan="3"> D </td> 
                			<td colspan="3"> PASS </td>               						                	
		                </tr>
		                </tr>
		                	<tr style="text-align: left;">		                				
                			<td colspan="3"> 40 - 44 </td>	
                			<td colspan="3"> E </td> 
                			<td colspan="3"> PASS </td>               						                	
		                </tr>
		                </tr>
		                	<tr style="text-align: left;">		                				
                			<td colspan="3"> 0 - 39 </td>	
                			<td colspan="3"> F </td> 
                			<td colspan="3"> FAIL </td>               						                	
		                </tr>
		                
		                		              
		        </tbody>
		    </table>
		</div>

		<?php
		// echo '<br/>';

		// print_r($student);


	}

?>