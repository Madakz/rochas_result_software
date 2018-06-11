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

		<?php	$term=$rochas_inst->findById($term_id, 'termz'); ?>

		<?php $term_score_sheet=$rochas_inst->retrieveASingleRecordStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm);
			$attendance=$rochas_inst->retrieveStudentAttendance($class_id, $class_type,  $class_arm, $session_id, $term_id, $student_id);
		 ?>

		<?php $session=$rochas_inst->findById($session_id, 'sessionz'); ?>
		

		<?php $term_final_report=$rochas_inst->retrieveStudentfinalTermReport($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id); 
			$position=$term_final_report['stu_term_position'];
		?>

		<?php $student_class_arm=$rochas_inst->findById($class_arm, 'class_arm'); 
			$student_class=$rochas_inst->findById($class_id, 'clazz');
		?>





		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">





		<div class="col-md-12 col-xs-12 col-sm-12">
			<div class="col-md-1 col-xs-1 col-sm-1"></div>
			<div class="col-md-10 col-xs-10 col-sm-10" style="margin-top: 15px; margin-bottom: 15px;">
				<div class="row" id="result">
					<style>
						#result{
							/*background-image: url(../images/rfc.jpg);*/
							/*background-repeat: no-repeat;*/
							/*background-size: cover;*/
							/*perspective-origin: center;*/
							/*opacity: 0.5;*/
						}
						table{
			    			text-align: center;
			    			border: 2px solid #1E0034;
						}
						#result-table1
						{
						font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
						width:100%;
						border-collapse:collapse;
						}
						#result-table1 td, #result-table1 th 
						{
						padding:3px 7px 2px 7px;
						border-collapse: collapse;
						}
						#result-table1 th 
						{
						font-size:1.4em;
						text-align:left;
						padding-top:10px;
						padding-bottom:4px;
						/*background-color:#5D198E;*/
						color:#000;
						border-color: none;
						}
						#result-table1 tr.alt td 
						{
						color:#000;
						background-color:#DBCCE6;
						}
						
					</style>
					<table id="result-table1">
						<thead style="border-collapse: collapse;">
							<th colspan="1"><center><img src="../images/rfc.jpg" width="50px" height="50px"><h6>Rochas Foundation College, Jos</h6></center></th>
							<th colspan="8">
								<p style="text-align: left; padding-left: 80px; font-size: 30px; font-weight: 50px; font-style: bold; margin-bottom: 0px; padding-bottom: 0px;	">ROCHAS FOUNDATION COLLEGE JOS</p>
								<p style="text-align: left; padding-left: 83px; font-style: bold; margin-top: 5px; padding-top: 0px;	">Old Airport Road, Rayfield, Jos, Plateau, Nigeria</p>
							</th>	
						</thead>
						<!-- <thead>
							<th colspan="1"></th>

							<th style="text-align: center;" colspan="8">
								<p>Old Airport Road, Rayfield, Jos, Plateau, Nigeria</p>
							</th>	
						</thead> -->
						<thead>				
							<th style="width:100%; text-align: center; margin-bottom: 0px; padding-bottom: 0px;" colspan="9"><p><ins>Report Sheet For <?php echo $class_category; ?> Secondary School</ins></p></th>	
						</thead>
						<thead>				
							<th style="width:15%;" colspan="1"><img src="../uploads/<?php echo $student['picture'];?>"  width="110px" height="110px"></th>	
							<th style="width:45%;" colspan="4">
								<p>Name: &nbsp;&nbsp;&nbsp;<?php echo $student['surname'].' '.$student['firstname'].' '.$student['othername']; ?></p>
								<p>Term: &nbsp;&nbsp;&nbsp;<?php echo $term['name'].' TERM';?></p>
								<p>Term Commenced: &nbsp;&nbsp;&nbsp;<?php echo $term_score_sheet['term_commenced'];?></p>
								<p>No. Of Times Present: &nbsp;&nbsp;&nbsp;<?php echo $attendance['no_of_times_present']; ?></p>
								<p>No. Of Times School Opens: &nbsp;&nbsp;&nbsp;<?php echo $attendance['total_time_school_opened']; ?></p>
								<p>Year(Session): <?php echo $session['name']; ?>&nbsp;&nbsp;&nbsp;</p>
								<p>Position:&nbsp;&nbsp;&nbsp;<?php echo $rochas_inst->formatPosition($position); ?>
							</th>
							<!-- <th style="width:%;" >
								<?php //echo $student['surname'].' '.$student['firstname'].' '.$student['othername']; ?> <br/>
								<?php //echo $term['name'].' TERM';?> <br/>
								<?php //echo $term_score_sheet['term_commenced'];?> <br/>
								<?php //echo $attendance['no_of_times_present']; ?> <br/><br/>
								<?php //echo $attendance['total_time_school_opened']; ?> <br/><br/>
								<?php //echo $session['name']; ?> <br/>
								<?php //echo $rochas_inst->formatPosition($position); ?> <br/>
							</th> -->
							<th style="width:40%;" colspan="4">
								<p>Age: &nbsp;&nbsp;&nbsp;<?php echo $rochas_inst->calculateAge($student_id).' years';?></p>
								<p>No. Of Students: &nbsp;&nbsp;&nbsp;<?php echo $attendance['clazz_no_of_student']; ?></p>
								<p>Term Ended: &nbsp;&nbsp;&nbsp;<?php echo $term_score_sheet['term_ended'];?></p>
								<p>No. Of Times Absent: &nbsp;&nbsp;&nbsp;<?php echo $attendance['no_of_times_absent']; ?></p>
								<p>&nbsp;</p>
								<p>Student Class-arm: &nbsp;&nbsp;&nbsp;<?php echo strtoupper($student_class['name']).''. strtoupper($student_class_arm['name']). ' ('.strtoupper($student_class['name']).')'; ?></p>
								
								<p>&nbsp;</p>
								<!-- <p></p> -->
							</th>
							<!-- <th style="width:20%;" colspan="2">
								<?php //echo $rochas_inst->calculateAge($student_id).' years';?> <br/><br/>
								<?php //echo $attendance['clazz_no_of_student']; ?> <br/><br/>
								<?php //echo $term_score_sheet['term_ended'];?> <br/><br/>
								<?php //echo $attendance['no_of_times_absent']; ?> <br/><br/>
								<?php //echo strtoupper($student_class['name']).''. strtoupper($student_class_arm['name']). ' ('.strtoupper($student_class['name']).')'; ?> <br/>
							</th> -->
						</thead>	       
				    </table>



					<style>
						table{
			    			text-align: center;
						}
						#result-table
						{
						font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
						width:100%;
						border-collapse:collapse;
						}
						#result-table td, #result-table th 
						{
						/*font-size:1.2em;*/
						border:1px solid #008080;
						padding:3px 7px 2px 7px;
						}
						#result-table th 
						{
						font-size:1.4em;
						text-align:left;
						padding-top:10px;
						padding-bottom:4px;
						background-color:#5D198E;
						color:#fff;
						}
						#result-table tr.alt td 
						{
						color:#000;
						background-color:#DBCCE6;
						}
						#result-table tr:hover 
						{
						color:#fff;
						background-color:#5D198E;
						}
						
					</style>
					<div class="table-responsive">
					    <table id="result-table">
					        <thead>
					            <?php
					                $sn=1;
					            ?>
					            <th style="width:25%; font-weight: bold;">Subject</th>
					            <th style="font-weight: bold;">Assignment</th>
					            <th style="font-weight: bold;">Class Work</th>
					            <th style="font-weight: bold;">Test</th>	  
					            <th style="font-weight: bold;">Exams</th>
					            <th style="font-weight: bold;"><?php echo $term['name'].' TERM Total Score';?><br/></th>
					            <th style="font-weight: bold;">Grade</th>
					            <th style="font-weight: bold;">Subject Position</th>         
					            <th style="font-weight: bold;">Signature</th>
					        </thead>
					        <tbody>                                                
				                <tr>
				                    <td style="text-align: left; font-weight: bold;">Maximum Score</td>
				                    <td style="font-weight: bold;">10</td>
				                    <td style="font-weight: bold;">10</td>
				                    <td style="font-weight: bold;">20</td>
				                    <td style="font-weight: bold;">60</td>
				                    <td style="font-weight: bold;">100</td>
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
			                		<tr <?php echo $sn%2==0? 'class="alt"' : "";?>>
			                			<td style="text-align: left; font-style: italic;"><?php echo $subject['name']; ?></td>
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
		                			<td colspan="2" style="border-collapse: collapse;"><b>Grand Total:</b> <?php echo $term_final_report['stu_term_all_subjects_grand_total'];?></td>	
		                			<td colspan="4"><b>Average:</b> <?php echo $term_final_report['stu_term_average'];?></td>
		                			<td colspan="3"><b><?php echo $term['name'].' TERM';?> Overall Grade:</b> <?php echo $overall_term_grade;?></td>		                	
				                </tr>
				                <tr style="text-align: left;">		                				
		                			<td colspan="2"><b><?php echo $term['name'].' TERM';?> Position:</b> <?php echo $rochas_inst->formatPosition($position); ?></td>	
		                			<td colspan="4"><b>NUMBER OF SUBJECTS PASSED:</b> <?php echo $no_ofsubjects_passed; ?></td>
		                			<td colspan="3"><b>NUMBER OF SUBJECTS FAILED:</b> <?php echo $no_ofsubjects_failed; ?></td>		                	
				                </tr>
				                <tr style="text-align: center; padding-top: 10px;">		                				
		                			<td colspan="9" style="padding-top: 20px; font-weight: bold;"><ins>GRADING</ins></td>	                					                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3" style="padding-top: 5px; font-weight: bold;">RANGE OF SCORES</td>	
		                			<td colspan="3" style="padding-top: 5px; font-weight: bold;">GRADE</td> 
		                			<td colspan="3" style="padding-top: 5px; font-weight: bold;">REMARK</td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 70 - 100 </td>	
		                			<td colspan="3"> A </td> 
		                			<td colspan="3" style="font-style: italic;"> EXCELLENT </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 60 - 69 </td>	
		                			<td colspan="3"> B </td> 
		                			<td colspan="3" style="font-style: italic;"> VERY GOOD </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 50 - 59 </td>	
		                			<td colspan="3"> C </td> 
		                			<td colspan="3" style="font-style: italic;"> GOOD </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 45 - 49 </td>	
		                			<td colspan="3"> D </td> 
		                			<td colspan="3" style="font-style: italic;"> PASS </td>               						                	
					             </tr>
			                	<tr style="text-align: center;">		                				
		                			<td colspan="3"> 40 - 44 </td>	
		                			<td colspan="3"> E </td> 
		                			<td colspan="3" style="font-style: italic;"> PASS </td> 					                	
				                </tr>
			                	<tr style="text-align: center;">		                				
		                			<td colspan="3"> 0 - 39 </td>	
		                			<td colspan="3"> F </td> 
		                			<td colspan="3" style="font-style: italic;"> FAIL </td>               						                	
				                </tr>        
					                		              
					        </tbody>
					    </table>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6" style="margin-top: 30px; margin-left: 0px; padding-left: 0px;">
						<i><?php echo date('d/m/Y').' '.date("h:ia"); ?></i>
					</div>
					<div class="col-md-6" >
						<button onclick="print()" style="margin-top: 30px; float: right; background-color: #008080; color: #fff;">Print Result</button>
					</div>
					
					<!-- <center><img src="../images/rfc.jpg" style="margin-top: 30px; margin-bottom: 10px;" width="50px" height="50px"></center> -->
					<!-- <center><button onclick="print()" style="margin-top: 30px; width: 50%">Print Result</button></center> -->
					<!-- <i style="width: 50%;"><?php //echo date('d/m/Y').' '.date("h:ia"); ?></i> -->
				</div>
			</div>

			<div class="col-md-1 col-xs-1 col-sm-1"></div>
		</div>

		

		<?php
		// echo '<br/>';

		// print_r($student);


	}

?>