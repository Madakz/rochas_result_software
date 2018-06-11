<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	
	
	if (isset($_POST['view_session_result'])) {
		$student_id=trim($_POST['student']);
		$term_id=trim($_POST['third_term']);
		$session_id=trim($_POST['session']);
		$class_id=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);

		

		$reportOfTerms=$rochas_inst->retrieveTermRecords($student_id, $class_id, $class_type, $class_arm, $session_id);
		foreach ($reportOfTerms as $reportOfTerm) {
			$subject=$reportOfTerm['subject_id'];
			$subject_total_score=$rochas_inst->retrieveSumofSubjectTotalInASession($student_id, $class_id, $class_type, $class_arm, $subject, $session_id);
			$no_of_terms=3;

			$subject_average_score=$rochas_inst->sessionalSubjectAverage($subject_total_score, $no_of_terms);		
			//aproximate the average to 2 d.p
			$subject_average_score = sprintf("%.2f", $subject_average_score);
			$subject_session_grade=$rochas_inst->subjectGrade($subject_average_score);
			$student_subject_status=$rochas_inst->subjectRemark($subject_session_grade);

			// echo $subject;
			// print_r($reportOfTerms);
			// echo "<br/><br/>";
			// echo $subject_total_score;
			// print_r($reportOfTerms);
			// echo "<br/><br/>";
			// echo $subject_average_score;
			// print_r($reportOfTerms);
			// echo "<br/><br/>";
			// echo $subject_session_grade;
			// print_r($reportOfTerms);
			// echo "<br/><br/>";
			// echo $student_subject_status;
			// print_r($reportOfTerms);
			// echo "<br/><br/>";


			// die();

			//docheck if it already exists in the database before insertion and update if otherwise
			$result=$rochas_inst->checkIfTermRecordExistInSessionRecordTable($student_id, $subject, $class_id, $class_type, $class_arm, $session_id);

			if ($result != 0) {
				//do update when here
				$result1=$rochas_inst->updateStudentSessionRecord($student_id, $session_id, $class_id, $class_type, $class_arm, $subject, $subject_total_score, $subject_average_score, $subject_session_grade, $student_subject_status);
				// if ($result1) {
				// 	die('yes oh');
				// }
			}else{
				$response=$rochas_inst->saveStudentSessionRecord($student_id, $session_id, $class_id, $class_type, $class_arm, $subject, $subject_total_score, $subject_average_score, $subject_session_grade, $student_subject_status);
				// if ($response) {
				// 	echo "<script>alert('displaying results');</script>";				
				// }else{
				// 	echo "<script>alert('results not ready yet');</script>";
				// }
			}

		}

		//Sessional Subject positioning coding
		$session_records=$rochas_inst->retrieveStudentSessionRecord($class_id, $class_type, $class_arm, $session_id);
		foreach ($session_records as $session_record) {
			// print_r($session_record);
			$subject_id=$session_record['subject_id'];
			// echo "<h1>SUBJECT: </h1>".$subject_id;
			// die();
			$rochas_inst->sessionalSubjectPositioning($subject_id, $class_id, $class_type, $class_arm, $session_id);
		}
		//Sessional Subject positioning coding


		//Coding to insert into student_session_final_report table
		$sum_of_averages=$rochas_inst->retrieveSumOfSessionSubjectAverages($student_id, $class_id, $class_type, $class_arm, $session_id);
		 $sum_of_averages = sprintf("%.2f", $sum_of_averages);
		// echo '<br/>Sum Averages: '.$sum_of_averages.'<br/>';

		$number_of_sessional_subjects=$rochas_inst->numberOfSessionalRecordSubjects($student_id, $class_id, $class_type, $class_arm, $session_id);		
		// echo '<br/>No of subjects: '.$number_of_sessional_subjects.'<br/>';

		$session_average_score=$rochas_inst->sessionalSubjectAverage($sum_of_averages, $number_of_sessional_subjects);
		$session_average_score = sprintf("%.2f", $session_average_score);
		// echo '<br/>Session Averages: '.$session_average_score.'<br/>';

		$session_total_score=$rochas_inst->retrieveSessionalGrandTotal($student_id, $class_id, $class_type, $class_arm, $session_id);
		// echo '<br/>Grand Total: '.$session_total_score.'<br/>';

		$session_grade=$rochas_inst->subjectGrade($session_average_score);
		// echo '<br/>Session Grade: '.$session_grade.'<br/>';


		//docheck if it already exists in the database before insertion and update if otherwise
		$result_check=$rochas_inst->checkIfTermRecordExistInSessionFinalReportTable($student_id, $class_id, $class_type, $class_arm, $session_id);

		if ($result_check != 0) {
			//do update when here
			$result1=$rochas_inst->updateStudentSessionFinalReport($student_id, $session_id, $class_id, $class_type, $class_arm, $session_total_score, $session_average_score, $session_grade);
			// if ($result1) {
			// 	die('yes oh');
			// }
		}else{
			$response=$rochas_inst->saveStudentSessionFinalReport($student_id, $session_id, $class_id, $class_type, $class_arm, $session_total_score, $session_average_score, $session_grade);
			// if ($response) {
			// 	echo "<script>alert('displaying results');</script>";				
			// }else{
			// 	echo "<script>alert('results not ready yet');</script>";
			// }
		}


		//do  sessional positioning here
		$rochas_inst->doSessionalPositioning($class_id, $class_type, $class_arm, $session_id);


		//Start Retrieval of Session Results And display and style here























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
							<th colspan="9">
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
							<th style="width:100%; text-align: center; margin-bottom: 0px; padding-bottom: 0px;" colspan="10"><p><ins>Report Sheet For <?php echo $class_category; ?> Secondary School</ins></p></th>	
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
							<th style="width:40%;" colspan="5">
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
					            <th style="width:25%; font-weight: bold;">SUBJECT</th>
					            <th style="font-weight: bold;">CA</th>					            	  
					            <th style="font-weight: bold;">EXAMS</th>
					            <th style="font-weight: bold;"><?php echo $term['name'].' TERM TOTAL SCORE';?><br/></th>
					            <th style="font-weight: bold;">1ST TERM</th>
					            <th style="font-weight: bold;">2ND TERM</th>
					            <th style="font-weight: bold;">ANNUAL AVERAGE</th>
					            <th style="font-weight: bold;">GRADE</th>
					            <th style="font-weight: bold;">ANNUAL GRADE</th>
					            <!-- <th style="font-weight: bold;">Subject Position</th>          -->
					            <th style="font-weight: bold;">SIGNATURE</th>
					        </thead>
					        <tbody>                                                
				                <tr>
				                    <td style="text-align: left; font-weight: bold;">Maximum Score</td>
				                    <td style="font-weight: bold;">40</td>
				                    <td style="font-weight: bold;">60</td>
				                    <td style="font-weight: bold;">100</td>
				                    <td style="font-weight: bold;">100</td>
				                    <td style="font-weight: bold;">100</td>
				                    <td colspan="4"></td>
				                </tr>
				                <?php
				                	$term_score_sheets=$rochas_inst->retrieveStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm);
				                	foreach ($term_score_sheets as $term_score_sheet) {
				                		$subject_id=$term_score_sheet['subject_id'];
				                		$subject=$rochas_inst->findById($subject_id, 'subject');

				                		$continious_accessment=$rochas_inst->studentTermlyCATotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id, $subject_id);
				                		$continious_accessment = sprintf("%.2f", $continious_accessment);             		

				                		// $test=$rochas_inst->studentTermlyTestTotal($student_id, $class_id, $class_type, $class_arm, $term_id, $session_id, $subject_id);
				                		// $test = sprintf("%.2f", $test);

				                		$exam=$term_score_sheet['stu_subj_exam_score'];
				                		$exam = sprintf("%.2f", $exam);

				                		$total=$term_score_sheet['stu_each_subject_total'];
				                		$total = sprintf("%.2f", $total);

				                		$grade=$term_score_sheet['term_subj_grade'];

				                		// $stu_subject_position=$term_score_sheet['stu_subject_position'];

				                		$second_term_per_subject_total=$rochas_inst->termPerSubjectTotal($student_id, $class_id, $class_type, $class_arm, '2', $session_id, $subject_id);
				                		$second_term_per_subject_total = sprintf("%.2f", $second_term_per_subject_total);

				                		$first_term_per_subject_total=$rochas_inst->termPerSubjectTotal($student_id, $class_id, $class_type, $class_arm, '1', $session_id, $subject_id);
				                		$first_term_per_subject_total = sprintf("%.2f", $first_term_per_subject_total);

				                		$get_student_session_record=$rochas_inst->getStudentSessionRecord($student_id, $class_id, $class_type, $class_arm, $session_id, $subject_id);
				                ?>
			                		<tr <?php echo $sn%2==0? 'class="alt"' : "";?>>
			                			<td style="text-align: left; font-style: italic;"><?php echo $subject['name']; ?></td>
			                			<td><?php echo $continious_accessment; ?></td>
			                			<td><?php echo $exam; ?></td>
			                			<td><?php echo $total; ?></td>
			                			<td><?php echo $first_term_per_subject_total; ?></td>
			                			<td><?php echo $second_term_per_subject_total; ?></td>
			                			<td><?php echo $get_student_session_record['subject_average_score']; ?></td>
			                			<td><?php echo $grade; ?></td>
			                			<td><?php echo $get_student_session_record['subject_session_grade']; ?></td>
			                			<td></td>
					               </tr>
				                <?php	
				                	$sn++;	                	
				                	}

				                	$overall_term_grade=$rochas_inst->subjectGrade($term_final_report['stu_term_average']);

				                	$no_ofsubjects_passed=$rochas_inst->countNoOfSessionalSubjectsStudentPassed($student_id, $class_id, $class_type, $class_arm, $session_id);

				                	$no_ofsubjects_failed=$rochas_inst->countNoOfSessionalSubjectsStudentFailed($student_id, $class_id, $class_type, $class_arm, $session_id);

				                	$student_session_report=$rochas_inst->getStudentSessionReport($student_id, $class_id, $class_type, $class_arm, $session_id);
				                ?>
				                <tr style="text-align: left;">		                				
		                			<td colspan="3" style="border-collapse: collapse;"><b><?php echo $term['name'].' TERM';?> GRAND TOTAL:</b> <?php echo $term_final_report['stu_term_all_subjects_grand_total'];?></td>	
		                			<td colspan="4"><b>STUDENT ANNUAL AVERAGE:</b> <?php echo $student_session_report['session_average_score'];?></td>
		                			<td colspan="3"><b>ANNUAL OVERALL GRADE:</b> <?php echo $student_session_report['session_grade'];?></td>		                	
				                </tr>
				                <tr style="text-align: left;">		                				
		                			<td colspan="3"><b><?php echo $term['name'].' TERM';?> POSITION:</b> <?php echo $rochas_inst->formatPosition($position); ?></td>	
		                			<td colspan="4"><b><?php echo $term['name'].' TERM';?> STUDENT AVERAGE:</b> <?php echo $term_final_report['stu_term_average'];?></td>
		                			<td colspan="3"><b><?php echo $term['name'].' TERM';?> OVERALL GRADE:</b> <?php echo $overall_term_grade;?></td>		                	
				                </tr>
				                <tr style="text-align: left;">  
		                			<td colspan="5"><b>NUMBER OF SUBJECTS PASSED:</b> <?php echo $no_ofsubjects_passed; ?></td>
		                			<td colspan="5"><b>NUMBER OF SUBJECTS FAILED:</b> <?php echo $no_ofsubjects_failed; ?></td>
		                			<!-- <td colspan="2"></td>		                	 -->
				                </tr>
				                <tr style="text-align: center; padding-top: 10px;">		                				
		                			<td colspan="10" style="padding-top: 20px; font-weight: bold;"><ins>GRADING</ins></td>	                					                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3" style="padding-top: 5px; font-weight: bold;">RANGE OF SCORES</td>	
		                			<td colspan="3" style="padding-top: 5px; font-weight: bold;">GRADE</td> 
		                			<td colspan="4" style="padding-top: 5px; font-weight: bold;">REMARK</td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 70 - 100 </td>	
		                			<td colspan="3"> A </td> 
		                			<td colspan="4" style="font-style: italic;"> EXCELLENT </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 60 - 69 </td>	
		                			<td colspan="3"> B </td> 
		                			<td colspan="4" style="font-style: italic;"> VERY GOOD </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 50 - 59 </td>	
		                			<td colspan="3"> C </td> 
		                			<td colspan="4" style="font-style: italic;"> GOOD </td>               						                	
				                </tr>
				                <tr style="text-align: center;">		                				
		                			<td colspan="3"> 45 - 49 </td>	
		                			<td colspan="3"> D </td> 
		                			<td colspan="4" style="font-style: italic;"> PASS </td>               						                	
					             </tr>
			                	<tr style="text-align: center;">		                				
		                			<td colspan="3"> 40 - 44 </td>	
		                			<td colspan="3"> E </td> 
		                			<td colspan="4" style="font-style: italic;"> PASS </td> 					                	
				                </tr>
			                	<tr style="text-align: center;">		                				
		                			<td colspan="3"> 0 - 39 </td>	
		                			<td colspan="3"> F </td> 
		                			<td colspan="4" style="font-style: italic;"> FAIL </td>               						                	
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


	}
	//end for when view session result buttton has been clicked

?>