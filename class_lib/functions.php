<?php
	session_start();
	/**
	* Title: class
	* Purpose: Rfc result software
	* Author: Madaki Fatsen
	* Created: 13/05/2018
	*/

	
	class Rochas {

		private $username;
		private $password;

		public function connection()
		{
			try {
			    $hostname ="localhost";
				$db_username = "root";
				$passwd = "madivel@";
				$dbname ="rfc_jos";
		        $pdo_obj = new PDO("mysql:host=$hostname;dbname=$dbname", "$db_username", "$passwd");
		        return $pdo_obj;
		     }
		     catch(PDOException $e)
			    {
			    return "Connection failed: " . $e->getMessage();
		    }
		} 


		//defining Login function
		public function login($username, $password, $table){

			$this->username=$username;
			$this->password=$password;

			if (empty($table)) {
				return "select your role";
			}

			$query = $this->connection()->prepare("SELECT * FROM $table WHERE username='$username' AND passwordz ='$password'"); 
    		$query->execute();
			$result = $query->fetch();		//same as mysql_fetch_array

			if($query->rowCount() >= '1') {		//condition to check if a record is gotten from the database
				// print_r($result);
				$logger_id = $result['id'];



				// write code to add to login table
				$login="INSERT INTO login_tracking VALUES (NULL, '$logger_id', NULL)";
				$this->connection()->exec($login);
		    	// uncomment later

		    	if ($result['role']=='admin') {
		    		header('location:admin/index.php');
		    	}elseif($result['role']=='teacher'){
		    		header('location:teacher/index.php');
		    	}
		    	
			
				$_SESSION['logged_user_id'] = $logger_id;
				$_SESSION['name'] = $result['name'];
				$_SESSION['role'] = $result['role'];
			}else{
				return "Invalid login details!!!";
			}
		}
		//end Login Function


		//logout function
		public function logout(){
			$_SESSION = array();
			session_destroy();
			header("location:index.php");
		}
		// end logout function
		


		//Define image upload function
		public function imageUploadFunction($imagefile){
        	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG', '.GIF', '.PNG');
		    // get extension of the uploaded file
		    $fileExtension = strrchr($imagefile['picture']['name'], ".");
		    // get the extension of the file to be uploaded
		    // check if file Extension is on the list of allowed ones
		    if (in_array($fileExtension, $validExtensions)) 
		    {
		        
				$newName = time() . '_' . $imagefile['picture']['name'];
			        $destination = '../uploads/' . $newName;
				if (move_uploaded_file($imagefile['picture']['tmp_name'], $destination))
				{

					if ($imagefile['picture']['size']/1024 > 1024) {
						$source_image = $destination;		//getting the path of the recently uploaded image
						$compressed_image_destination = '../uploads/' . $newName;	//whole path of new image
						$compress_images = $this->compressImage($source_image, $compressed_image_destination);
						
						$get_image_name = explode('/', $compress_images);
						$image_name = $get_image_name[2];
						
						return $image_name;
					
					}else{
						return $newName;	//this is returned when the uploaded image size is small 
					}
			    }
		    }
		}
		//end image upload function


		//create compress image function
		function compressImage($source_image, $compress_image) {
			$image_info = getimagesize($source_image);
			if ($image_info['mime'] == 'image/jpeg') {
				$source_image = imagecreatefromjpeg($source_image);			
			} elseif ($image_info['mime'] == 'image/gif') {
				$source_image = imagecreatefromgif($source_image);
			} elseif ($image_info['mime'] == 'image/png') {
				$source_image = imagecreatefrompng($source_image);
				//imagepng($source_image, $compress_image, 6);
			}
			imagejpeg($source_image, $compress_image, 75);
			return $compress_image;
		}
		//end compressImage function


		//registerTeacher function
		public function registerTeacher($name, $subject, $username, $password, $con_password, $picture, $address, $role, $admin){
			if ($password != $con_password) {				
				return false;
			}else{
				$sql = "INSERT INTO teacher (id, name, username, passwordz, picture, address, subject_id, role, admin_id, created_at, updated_at) VALUES (NULL, '$name', '$username', '$password', '$picture', '$address', '$subject', '$role', '$admin', NULL, NULL)";
				$this->connection()->exec($sql);
				return true;
			}
			
		}
		//end registerTeacher function


		//view teachers function 
		public function viewTeachers(){
			$query = $this->connection()->prepare("SELECT * FROM teacher ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view teachers function



		//define findById function for an item 
		public function findById($id, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE id ='$id' ORDER BY id DESC"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end findById function for an item



		//define findByName function for an item 
		public function findByName($name, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE name ='$name' ORDER BY id DESC"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end findByName function for an item 



		//define findMoreById function for more than item 
		public function findMoreById($id, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE id ='$id' ORDER BY id DESC"); 
    		$query->execute();
    		return $query->fetchAll();
		}
		//end findMoreById function for an item 



		//define findNotThisId function for an item 
		public function findNotThisId($id, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE id !='$id'"); 
    		$query->execute();
    		return $query->fetchAll();
		}
		//end findNotThisId function for an item 



		//update a teacher function
		public function updateTeacher($id, $name, $username, $address){
			$query = $this->connection()->prepare("UPDATE teacher SET name='$name', address='$address', username='$username' WHERE id='$id'");
		    $query->execute();
		    return true;
		}
		//end update teacher function



		//begin delete
		public function delete($tablename, $id){
			$sql = "DELETE FROM $tablename WHERE id='$id'";
    		// use exec() because no results are returned
    		$query=$this->connection()->exec($sql);
			if ($query) {
				return true;				
			}else{
				return false;				
			}
		}
		//end delete



		//register student function
		public function registerStudent($surname, $firstname, $othername, $picture, $address, $birthdate, $admin, $class, $class_type, $class_arm, $status){
			$sql = "INSERT INTO student (id, surname, firstname, othername, birth_date, address, picture, status, clazz_id, clazz_type_id, class_arm_id, admin_id, created_at, updated_at) VALUES(NULL,'$surname', '$firstname', '$othername', '$birthdate', '$address','$picture', '$status', '$class', '$class_type', '$class_arm','$admin', NULL, NULL)";
			$condition_check=$this->connection()->exec($sql);	
			// die($condition_check);

			if ($condition_check) {			//this condition checks if record has been inserted into the database
				$query = $this->connection()->prepare("SELECT * FROM student ORDER BY id DESC");
				$query->execute();
				$last_id_record=$query->fetch();
				$last_id=$last_id_record['id'];	
				return $last_id;	//inserted record id return for a purpose
			}else{
				die('record not inserted, pls contact adminitrator');
			}
			
		}
		//end register student function


		//edit student function
		public function editStudent($surname, $firstname, $othername, $birth_date, $address, $student_id){
			$query = $this->connection()->prepare("UPDATE student SET surname='$surname', firstname='$firstname', othername='$othername', birth_date='$birth_date', address='$address' WHERE id='$student_id'");
		    $query->execute();
		    return true;
		}
		//end edit student function



		//fetchClazz function 
		public function fetchClazz(){
			$query = $this->connection()->prepare("SELECT * FROM clazz");
			$query->execute();
			return $query->fetchAll();
		}
		//end fetchClazz function




		//fetchClassArm function definition
		public function fetchClassArm(){			
			$query = $this->connection()->prepare("SELECT * FROM class_arm");
			$query->execute();
			return $query->fetchAll();
		}
		//end fetchClassArm function definition



		//retrieve all student function
		public function retrieveAllStudent(){
			$query = $this->connection()->prepare("SELECT * FROM student ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end retrieve all student function



		//add subject function
		public function addSubject($name, $admin_id){
			$sql = "INSERT INTO subject (id, name, admin_id, created_at, updated_at) VALUES (NULL, '$name', '$admin_id', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end addSubject function



		//check if subject exist function
		public function checkIfsubjectExist($subject_name){
			$query = $this->connection()->prepare("SELECT name FROM subject WHERE name='$subject_name'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if subject exist


		//edit subject function
		public function editSubject($subject_name, $subject_id, $update_time){
			$query = $this->connection()->prepare("UPDATE subject SET name='$subject_name', updated_at='$update_time' WHERE id='$subject_id'");
		    $query->execute();
		    return true;
		}
		//end edit subject function


		//view subjects function 
		public function viewSubjects(){
			$query = $this->connection()->prepare("SELECT * FROM subject ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view subjects function



		//add class function
		public function addClass($name, $admin_id){
			$sql = "INSERT INTO clazz (id, name, admin_id, created_at) VALUES (NULL, '$name', '$admin_id', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end addClass function

		

		//check if class exist function
		public function checkIfClassExist($class_name){
			$query = $this->connection()->prepare("SELECT name FROM clazz WHERE name='$class_name'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if class exist


		//edit class function
		public function editClass($class_name, $class_id){
			$query = $this->connection()->prepare("UPDATE clazz SET name='$class_name' WHERE id='$class_id'");
		    $query->execute();
		    return true;
		}
		//end edit class function


		//view class function 
		public function viewClass(){
			$query = $this->connection()->prepare("SELECT * FROM clazz ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view class function



		//view class_type function 
		public function viewClassType(){
			$query = $this->connection()->prepare("SELECT * FROM clazz_type ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view class_type function



		//add term function
		public function addTerm($name, $admin_id){
			$sql = "INSERT INTO termz (id, name, admin_id, created_at) VALUES (NULL, '$name', '$admin_id', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end addClass function

		

		//check if term exist function
		public function checkIfTermExist($term_name){
			$query = $this->connection()->prepare("SELECT name FROM termz WHERE name='$term_name'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if term exist


		//edit term function
		public function editTerm($term_name, $term_id){
			$query = $this->connection()->prepare("UPDATE termz SET name='$term_name' WHERE id='$term_id'");
		    $query->execute();
		    return true;
		}
		//end edit term function


		//view term function 
		public function viewTermz(){
			$query = $this->connection()->prepare("SELECT * FROM termz ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view term function



		//add session function
		public function addSession($name, $admin_id){
			$sql = "INSERT INTO sessionz (id, name, admin_id, created_at, updated_at) VALUES (NULL, '$name', '$admin_id', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end addSession function

		

		//check if Session exist function
		public function checkIfSessionExist($session_name){
			$query = $this->connection()->prepare("SELECT name FROM sessionz WHERE name='$session_name'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if Session exist


		//edit session function
		public function editSession($session_name, $session_id){
			$query = $this->connection()->prepare("UPDATE sessionz SET name='$session_name' WHERE id='$session_id'");
		    $query->execute();
		    return true;
		}
		//end edit session function


		//view session function 
		public function viewSession(){
			$query = $this->connection()->prepare("SELECT * FROM sessionz ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view session function


		//viewCurrentSession function 
		public function viewCurrentSession(){
			$query = $this->connection()->prepare("SELECT MAX(name) as nam FROM sessionz");
			$query->execute();
			return $query->fetch();
		}
		//end viewCurrentSession function


		//updateAColumn function
		public function updateAColumn($table, $column, $value, $where_column, $where_column_value){
			$query = $this->connection()->prepare("UPDATE $table SET $column='$value' WHERE $where_column='$where_column_value'");
		    $query->execute();
		    return true;
		}
		//end updateAColumn function


		//updateTwoColumn function
		public function updateTwoColumn($table, $column1, $column2, $value1, $value2, $where_column, $where_column_value){
			$query = $this->connection()->prepare("UPDATE $table SET $column1='$value1', $column2='$value2' WHERE $where_column='$where_column_value'");
		    $query->execute();
		    return true;
		}
		//end updateTwoColumn function


		//addToRepeatingStudent function
		public function addToRepeatingStudent($student, $class, $session){
			$sql = "INSERT INTO repeating_student (id, student_id, clazz_id, session, created_at, updated_at) VALUES (NULL, '$student', '$class', '$session', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end addToRepeatingStudent function



		//checkIfStudentRepeated function
		public function checkIfStudentRepeated($class_id, $session, $student_id){
			$query = $this->connection()->prepare("SELECT * FROM repeating_student WHERE student_id='$student_id' AND clazz_id='$class_id' AND session='$session'");
			$query->execute();
			return $query->rowCount();
		}
		//end checkIfStudentRepeated



		//retrieve repeating records
		public function retrieveRepeating($student){
			$query = $this->connection()->prepare("SELECT * FROM repeating_student WHERE student_id='$student' ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end retrieve repeating records



		//define findItemByClassIdAndClassTypeId function 
		public function findItemByClassIdClassArmAndClassTypeId($class_id, $clazz_type_id, $class_arm, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE clazz_id ='$class_id' AND clazz_type_id='$clazz_type_id' AND class_arm_id='$class_arm' ORDER BY surname ASC"); 
    		$query->execute();
    		return $query->fetchAll();
		}
		//end findItemByClassIdAndClassTypeId function for an item 



		//insertAttendance function
		public function insertAttendance($total_time_school_opened, $no_of_times_present, $no_of_times_absent, $term_id, $session_id, $student_id, $clazz_no_of_student, $teacher_id, $clazz_id, $clazz_type_id, $class_arm){
			$sql = "INSERT INTO attendance (id, total_time_school_opened, no_of_times_present, no_of_times_absent, term_id, session_id, student_id, clazz_no_of_student, teacher_id, clazz_id, clazz_type_id, class_arm_id, created_at) VALUES (NULL, '$total_time_school_opened', '$no_of_times_present', '$no_of_times_absent', '$term_id', '$session_id', '$student_id', '$clazz_no_of_student', '$teacher_id', '$clazz_id', '$clazz_type_id', '$class_arm', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end insertAttendance function



		//checkIfStudentAttendance function
		public function checkIfStudentAttendance($class_id, $class_type,  $class_arm, $session_id, $term_id, $student_id){
			$query = $this->connection()->prepare("SELECT * FROM attendance WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND session_id='$session_id' AND term_id='$term_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end checkIfStudentAttendance function


		
		//retrieveStudentAttendance function
		public function retrieveStudentAttendance($class_id, $class_type,  $class_arm, $session_id, $term_id, $student_id){
			$query = $this->connection()->prepare("SELECT * FROM attendance WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND session_id='$session_id' AND term_id='$term_id'");
			$query->execute();
			return $query->fetch();
		}
		//end retrieveStudentAttendance function		



		//insertAttendance function
		public function insertPsychomotor($instruments, $dancing, $hurdles, $jumps, $sprints, $other_games, $volleyball, $basketball, $football, $painting, $drawing, $tools_handling, $public_speaking, $hand_writing, $student_id, $clazz_id, $clazz_type_id, $class_arm, $session_id, $term_id, $teacher_id){
			$sql = "INSERT INTO psychomotor_skill (id, instruments, dancing, hurdles, jumps, sprints, other_games, volleyball, basketball, football, painting, drawing, tools_handling, public_speaking, hand_writing, student_id, clazz_id, clazz_type_id, class_arm_id, session_id, term_id, teacher_id, created_at) VALUES (NULL, '$instruments', '$dancing', '$hurdles', '$jumps', '$sprints', '$other_games', '$volleyball', '$basketball', '$football', '$painting', '$drawing', '$tools_handling', '$public_speaking', '$hand_writing', '$student_id', '$clazz_id', '$clazz_type_id', '$class_arm','$session_id', '$term_id', '$teacher_id', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end insertAttendance function



		//checkIfStudentPsychomotorAdded function
		public function checkIfStudentPsychomotorAdded($class_id, $clazz_type_id, $class_arm, $session_id, $term_id, $student_id){
			$query = $this->connection()->prepare("SELECT * FROM psychomotor_skill WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$clazz_type_id' AND class_arm_id='$class_arm' AND session_id='$session_id' AND term_id='$term_id'");
			$query->execute();
			return $query->rowCount();
		}
		//checkIfStudentPsychomotorAdded function




		//insertDomainTraits function
		public function insertDomainTraits($spirit_of_cooperation, $organisation_ability, $self_control, $responsibilty, $obedience, $relationship_with_others, $attentiveness, $perseverance, $initiative, $honesty, $politeness, $neatness, $reliability, $class_attendance, $punctuality, $clazz_id, $clazz_type_id, $class_arm, $teacher_id, $term_id, $session_id,  $student_id){
			$sql = "INSERT INTO observable_domain_traits (id, spirit_of_cooperation, organisation_ability, self_control, responsibilty, obedience, relationship_with_others, attentiveness, perseverance, initiative, honesty, politeness, neatness, reliability, class_attendance, punctuality, clazz_id, clazz_type_id, class_arm_id, teacher_id, term_id, sessionz_id,  student_id, created_at) VALUES (NULL, '$spirit_of_cooperation', '$organisation_ability', '$self_control', '$responsibilty', '$obedience', '$relationship_with_others', '$attentiveness', '$perseverance', '$initiative', '$honesty', '$politeness', '$neatness', '$reliability', '$class_attendance', '$punctuality', '$clazz_id', '$clazz_type_id', '$class_arm', '$teacher_id', '$term_id', '$session_id',  '$student_id', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end insertDomainTraits function



		
		//checkIfStudentAffectiveDomainAdded function
		public function checkIfStudentAffectiveDomainAdded($class_id, $clazz_type_id, $class_arm, $session_id, $term_id, $student_id){
			$query = $this->connection()->prepare("SELECT * FROM observable_domain_traits WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$clazz_type_id' AND class_arm_id='$class_arm' AND sessionz_id='$session_id' AND term_id='$term_id'");
			$query->execute();
			return $query->rowCount();
		}
		//checkIfStudentAffectiveDomainAdded function




		//subjectTotal function definition
		public function subjectTotal($assignment1, $assignment2, $classwork1, $classwork2, $test1, $test2, $exam){
			$total=$assignment1 + $assignment2 + $classwork1 + $classwork2 + $test1 + $test2 + $exam;
			return $total;
		}
		//end subjectTotal function definition




		//subjectGrade function
		public function subjectGrade($subject_total){
			if ($subject_total <= 39) {
				$grade='F';
			}elseif ($subject_total <= 44) {
				$grade='E';
			}elseif ($subject_total <= 49) {
				$grade='D';
			}elseif ($subject_total <= 59) {
				$grade='C';
			}elseif ($subject_total <= 69) {
				$grade='B';
			}elseif ($subject_total <= 100) {
				$grade='A';
			}
			return $grade;
		}
		//end subjectGrade function



		//define subjectRemark function
		public function subjectRemark($subject_grade){
			$pass_grade_array=array('A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e');
			if (in_array($subject_grade, $pass_grade_array)) {
				$remark='pass';
			}else{
				$remark='fail';
			}
			return $remark;
		}
		//end subjectRemark function



		//
		//insertStudentTermRecord function
		public function insertStudentTermRecord($student_id, $teacher_id, $term_id, $sessionz_id, $clazz_id, $clazz_type_id, $class_arm, $subject_id, $term_commenced, $term_ended, $stu_ca_assignment1, $stu_ca_assignment2, $stu_ca_classwork1, $stu_ca_classwork2, $stu_ca_test1, $stu_ca_test2, $stu_subj_exam_score, $stu_each_subject_total, $term_subj_grade, $stu_subj_status){
			$sql = "INSERT INTO student_term_record (id, student_id, teacher_id, term_id, sessionz_id, clazz_id, clazz_type_id, class_arm_id, subject_id, term_commenced, term_ended, stu_ca_assignment1, stu_ca_assignment2, stu_ca_classwork1, stu_ca_classwork2, stu_ca_test1, stu_ca_test2, stu_subj_exam_score, stu_each_subject_total, stu_subject_position, term_subj_average, term_subj_grade, stu_subj_status, created_at) VALUES (NULL, '$student_id', '$teacher_id', '$term_id', '$sessionz_id', '$clazz_id', '$clazz_type_id', '$class_arm', '$subject_id', '$term_commenced', '$term_ended', '$stu_ca_assignment1', '$stu_ca_assignment2', '$stu_ca_classwork1', '$stu_ca_classwork2', '$stu_ca_test1', '$stu_ca_test2', '$stu_subj_exam_score', '$stu_each_subject_total', NULL, NULL, '$term_subj_grade', '$stu_subj_status', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end insertStudentTermRecord function



		//checkIfStudentTermScoreSheetAdded function
		public function checkIfStudentTermScoreSheetAdded($class_id, $clazz_type_id, $class_arm, $session_id, $term_id, $student_id, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$clazz_type_id' AND class_arm_id='$class_arm' AND sessionz_id='$session_id' AND term_id='$term_id' AND subject_id='$subject_id'");
			$query->execute();
			return $query->rowCount();
		}
		//checkIfStudentTermScoreSheetAdded function



		//retrieveStudentTermScoreSheet function definition
		public function retrieveStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND class_arm_id='$class_arm'"); 
    		$query->execute();
    		return $query->fetchAll();
		}
		//end retrieveStudentTermScoreSheet function definition



		//retrieveASingleRecordStudentTermScoreSheet function definition
		public function retrieveASingleRecordStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id, $class_arm){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND term_id='$term_id' AND sessionz_id='$session_id' AND class_arm_id='$class_arm'"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end retrieveASingleRecordStudentTermScoreSheet function definition



		//studentAllSubjectsGrandTotal function definition
		public function studentAllSubjectsGrandTotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			// $grand_total='';
			$query = $this->connection()->prepare("SELECT SUM(stu_each_subject_total) AS grand_total FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			// $term_score_sheets=$this->retrieveStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id);
			// foreach ($term_score_sheets as $term_score_sheet) {
			// 	$grand_total+=$term_score_sheet['stu_each_subject_total'];
			// }

			return $grand_total['grand_total'];
		}
		//end studentAllSubjectsGrandTotal function definition



		//numberOfSubjectsStudentTook function definition
		public function  numberOfSubjectsStudentTook($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id'"); 
    		$query->execute();
    		return $query->rowCount();
		}
		//numberOfSubjectsStudentTook function definition




		//studentAverageCalculation function definition
		public function studentAverageCalculation($sum_total, $no_of_items){
			$average=$sum_total/$no_of_items;
			return $average;
		}
		//studentAverageCalculation function definition




		//saveStudentTermReport function definition
		public function saveStudentTermReport($student_id, $termz_id, $sessionz_id, $clazz_id, $class_type, $class_arm_id, $stu_term_all_subjects_grand_total, $no_of_subjects_taken, $stu_term_average){
			$sql = "INSERT INTO student_term_final_report (id, student_id, termz_id, sessionz_id, clazz_id, clazz_type_id, class_arm_id, stu_term_all_subjects_grand_total, no_of_subjects_taken, stu_term_average, stu_term_position, created_at) VALUES (NULL, '$student_id', '$termz_id', '$sessionz_id', '$clazz_id', '$class_type', '$class_arm_id', '$stu_term_all_subjects_grand_total', '$no_of_subjects_taken', '$stu_term_average', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end saveStudentTermReport function definition




		//checkIfStudentTermReportAdded function definition
		public function checkIfStudentTermReportAdded($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_final_report WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND termz_id='$term_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end checkIfStudentTermReportAdded function definition




		//retrieveStudentfinalTermReport function definition
		public function retrieveStudentfinalTermReport($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_final_report WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND termz_id='$term_id'");
			$query->execute();
			return $query->fetch();
		}
		//end retrieveStudentfinalTermReport function definition




		//updateStudentTermReport function
		public function updateStudentTermReport($student_id, $term_id, $session_id, $class_id, $class_type, $class_arm_id, $grand_total, $number_of_subjects, $average){
			$query = $this->connection()->prepare("UPDATE student_term_final_report SET stu_term_all_subjects_grand_total='$grand_total', no_of_subjects_taken='$number_of_subjects', stu_term_average='$average' WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND termz_id='$term_id'");
		    $query->execute();
		    return true;
		}
		//updateStudentTermReport function



		//doPositioning function definition
		public function doPositioning($class_id, $class_type, $class_arm, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT DISTINCT stu_term_average AS average FROM student_term_final_report WHERE clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND termz_id='$term_id' AND sessionz_id='$session_id' ORDER BY average DESC");
			$query->execute();
			$averages=$query->fetchAll();

			$position=1;
			foreach ($averages as $average) {
				$average_on=$average['average'];
				$query = $this->connection()->prepare("UPDATE student_term_final_report SET stu_term_position='$position' WHERE stu_term_average='$average_on'");
		    $query->execute();
		    $position++;
			}
			return true;

		}
		//doPositioning function definition



		//retrieveTermRecordsForSubjectPositioning function definition
		public function retrieveTermRecordsForSubjectPositioning($class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id' AND sessionz_id='$session_id'");
			$query->execute();
			return $query->fetchAll();
		}
		//end retrieveTermRecordsForSubjectPositioning function definition



		//subjectPositioning() function definition
		public function subjectPositioning($subject_id, $class_id, $class_type, $class_arm, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT DISTINCT stu_each_subject_total AS total FROM student_term_record WHERE subject_id='$subject_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND term_id='$term_id' AND sessionz_id='$session_id' ORDER BY total DESC");
			$query->execute();
			$subj_totals=$query->fetchAll();

			$position=1;
			foreach ($subj_totals as $subj_total) {
				$subj_total_on=$subj_total['total'];
				$query = $this->connection()->prepare("UPDATE student_term_record SET stu_subject_position='$position' WHERE stu_each_subject_total='$subj_total_on'");
		    $query->execute();
		    $position++;
			}
			return true;
		}
		//end subjectPositioning function



		//retrieveTermFinalReport function definition
		public function retrieveTermRecords($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'");
			$query->execute();
			return $query->fetchAll();
		}
		//end retrieveTermFinalReport function definition



		//retrieveSumofSubjectTotalInASession function
		public function retrieveSumofSubjectTotalInASession($student_id, $class_id, $class_type, $class_arm_id, $subject_id, $session_id){
			$query = $this->connection()->prepare("SELECT SUM(stu_each_subject_total) AS grand_total FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND subject_id='$subject_id'AND sessionz_id='$session_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			// $term_score_sheets=$this->retrieveStudentTermScoreSheet($student_id, $class_id, $term_id, $session_id);
			// foreach ($term_score_sheets as $term_score_sheet) {
			// 	$grand_total+=$term_score_sheet['stu_each_subject_total'];
			// }

			return $grand_total['grand_total'];
		}
		//end studentAllSubjectsGrandTotal function definition



		//sessionalSubjectAverage function definition
		public function sessionalSubjectAverage($sum_total, $no_of_terms){
			$average=$sum_total/$no_of_terms;
			return $average;
		}
		//sessionalSubjectAverage function definition




		//checkIfTermRecordExistInSessionRecordTable function definiton
		public function checkIfTermRecordExistInSessionRecordTable($student_id, $subject, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_session_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND subject_id='$subject'");
			$query->execute();
			return $query->rowCount();
		}
		//end checkIfTermRecordExistInSessionRecordTable function definition



		//saveStudentSessionRecord function definition
		public function saveStudentSessionRecord($student_id, $sessionz_id, $clazz_id, $class_type, $class_arm_id, $subject_id, $subject_total_score, $subject_average_score, $subject_session_grade, $student_subject_status){
			$sql = "INSERT INTO student_session_record (id, student_id, sessionz_id, clazz_id, clazz_type_id, class_arm_id, subject_id, subject_total_score, subject_average_score, subject_session_grade, subject_session_position, student_subject_status, created_at) VALUES (NULL, '$student_id', '$sessionz_id', '$clazz_id', '$class_type', '$class_arm_id', '$subject_id', '$subject_total_score', '$subject_average_score', '$subject_session_grade', NULL, '$student_subject_status', NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end checkIfTermRecordExistInSessionRecordTable function definition



		//updateStudentSessionRecord function definition
		public function updateStudentSessionRecord($student_id, $session_id, $class_id, $class_type, $class_arm, $subject, $subject_total_score, $subject_average_score, $subject_session_grade, $student_subject_status){
			$query = $this->connection()->prepare("UPDATE student_session_record SET subject_total_score='$subject_total_score', subject_average_score='$subject_average_score', subject_session_grade='$subject_session_grade', student_subject_status='$student_subject_status' WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND sessionz_id='$session_id' AND subject_id='$subject'");
		    $query->execute();
		    return true;

		}
		//end updateStudentSessionRecord function definition



		//retrieveStudentSessionRecord function definition
		public function retrieveStudentSessionRecord($class_id, $class_type, $class_arm, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_term_record WHERE clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND sessionz_id='$session_id'");
			$query->execute();
			return $query->fetchAll();
		}
		//end retrieveStudentSessionRecord function definition



		//sessionalSubjectPositioning() function definition
		public function sessionalSubjectPositioning($subject_id, $class_id, $class_type, $class_arm, $session_id){
			$query = $this->connection()->prepare("SELECT DISTINCT subject_average_score AS average FROM student_session_record WHERE subject_id='$subject_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND sessionz_id='$session_id' ORDER BY average DESC");
			$query->execute();
			$subj_totals=$query->fetchAll();
			// print_r($subj_totals);
			// die();

			$position=1;
			foreach ($subj_totals as $subj_total) {
				$subj_total_on=$subj_total['average'];
				$query = $this->connection()->prepare("UPDATE student_session_record SET subject_session_position='$position' WHERE subject_average_score='$subj_total_on'");
		    $query->execute();
		    $position++;
			}
			return true;
		}
		//end sessionalSubjectPositioning function



		//retrieveSumOfSessionSubjectAverages function
		public function retrieveSumOfSessionSubjectAverages($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT SUM(subject_average_score) AS average_total FROM student_session_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['average_total'];
		}
		//end retrieveSumOfSessionSubjectAverages function definition



		//retrieveSessionalGrandTotal function
		public function retrieveSessionalGrandTotal($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT SUM(subject_total_score) AS subject_total FROM student_session_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['subject_total'];
		}
		//end retrieveSessionalGrandTotal function definition



		//numberOfSessionalRecordSubjects function definiton
		public function numberOfSessionalRecordSubjects($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_session_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end numberOfSessionalRecordSubjects function definition



		//checkIfTermRecordExistInSessionFinalReportTable function
		public function checkIfTermRecordExistInSessionFinalReportTable($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_session_final_report WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end checkIfTermRecordExistInSessionFinalReportTable function



		//updateStudentSessionFinalReport function
		public function updateStudentSessionFinalReport($student_id, $session_id, $class_id, $class_type, $class_arm, $session_total_score, $session_average_score, $session_grade){
			$query = $this->connection()->prepare("UPDATE student_session_final_report SET session_total_score='$session_total_score', session_average_score='$session_average_score', session_grade='$session_grade' WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND sessionz_id='$session_id'");
		    $query->execute();
		    return true;

		}
		//end updateStudentSessionFinalReport function



		//saveStudentSessionFinalReport function
		public function saveStudentSessionFinalReport($student_id, $sessionz_id, $clazz_id, $class_type, $class_arm_id, $session_total_score, $session_average_score, $session_grade){
			$sql = "INSERT INTO student_session_final_report (id, student_id, sessionz_id, clazz_id, clazz_type_id, class_arm_id, session_total_score, session_average_score, session_grade, session_position, created_at) VALUES (NULL, '$student_id', '$sessionz_id', '$clazz_id', '$class_type', '$class_arm_id', '$session_total_score', '$session_average_score', '$session_grade', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end saveStudentSessionFinalReport function



		//doSessionalPositioning function definition
		public function doSessionalPositioning($class_id, $class_type, $class_arm, $session_id){
			$query = $this->connection()->prepare("SELECT DISTINCT session_average_score AS average FROM student_session_final_report WHERE clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm' AND sessionz_id='$session_id' ORDER BY average DESC");
			$query->execute();
			$averages=$query->fetchAll();

			$position=1;
			foreach ($averages as $average) {
				$average_on=$average['average'];
				$query = $this->connection()->prepare("UPDATE student_session_final_report SET session_position='$position' WHERE session_average_score='$average_on'");
			    $query->execute();
			    $position++;
			}
			return true;

		}
		//doSessionalPositioning function definition


		//calculateAge function
		public function calculateAge($student_id){
			$table='student';
			$student=$this->findById($student_id, $table);
			$birth_date=$student['birth_date'];
			$get_birth_year=explode('/', $birth_date);
			$birth_year=$get_birth_year['2'];
			$current_year=date('Y');
			$age=$current_year - $birth_year;
			return $age;
		}
		//end calculateAge function


		//changePassword function
		public function changePassword($user_id, $password){
			$query = $this->connection()->prepare("UPDATE teacher SET passwordz='$password' WHERE id='$user_id'");
		    $query->execute();
		    return true;
		}
		//end changePassword function



		//formatPosition function
		public function formatPosition($position){
			if ($position == 1) {
				$position='1ST';
			}elseif ($position == 2) {
				$position='2ND';
			}elseif ($position <= 3) {
				$position='3RD';
			}elseif ($position >= 4) {
				$position=$position.'TH';
			}
			return $position;
		}
		// end formatPosition function



		//checkIfClassIsJuniorOrSecondary function
		public function checkIfClassIsJuniorOrSeniorSecondary($class){
			$junior_class_name_array = array('jss 1', 'jss 2', 'jss 3', 'JSS 1', 'JSS 2', 'JSS 3', 'jss1', 'jss2', 'jss3', 'JSS1', 'JSS2', 'JSS3');
			$senior_class_name_array = array('sss 1', 'sss 2', 'sss 3', 'SSS 1', 'SSS 2', 'SSS 3', 'sss1', 'sss2', 'sss3', 'SSS1', 'SSS2', 'SSS3');
			if (in_array($class, $junior_class_name_array)) {
				$class='Junior';
			}elseif(in_array($class, $senior_class_name_array)) {
				$class='Senior';
			}
			return $class;
		}
		//end checkIfClassIsJuniorOrSecondary function



		//studentTermlyAssignmentTotal function definition
		public function studentTermlyAssignmentTotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT SUM(stu_ca_assignment1 + stu_ca_assignment2) AS assignment FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['assignment'];
		}
		//end studentTermlyAssignmentTotal function definition



		//studentTermlyClassworkTotal function definition
		public function studentTermlyClassworkTotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT SUM(stu_ca_classwork1 + stu_ca_classwork2) AS classwork FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['classwork'];
		}
		//end studentTermlyClassworkTotal function definition



		//studentTermlyTestTotal function definition
		public function studentTermlyTestTotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT SUM(stu_ca_test1 + stu_ca_test2) AS test FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['test'];
		}
		//end studentTermlyTestTotal function definition




		//countNoOfSubjectsStudentPassed function definition
		public function countNoOfSubjectsStudentPassed($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT subject_id FROM student_term_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND term_id='$term_id' AND stu_subj_status='pass'");
			$query->execute();
			return $query->rowCount();
		}
		//end countNoOfSubjectsStudentPassed function definition



		//countNoOfSubjectsStudentFailed function definition
		public function countNoOfSubjectsStudentFailed($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id){
			$query = $this->connection()->prepare("SELECT subject_id FROM student_term_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND term_id='$term_id' AND stu_subj_status='fail'");
			$query->execute();
			return $query->rowCount();
		}
		//end countNoOfSubjectsStudentFailed function definition



		//studentTermlyCATotal function definition
		public function studentTermlyCATotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT SUM(stu_ca_assignment1 + stu_ca_assignment2 + stu_ca_classwork1 + stu_ca_classwork2 + stu_ca_test1 + stu_ca_test2) AS continious_access FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['continious_access'];
		}
		//end studentTermlyCATotal function definition




		//secondTermPerSubjectTotal function definition
		public function termPerSubjectTotal($student_id, $class_id, $class_type, $class_arm_id, $term_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT stu_each_subject_total FROM student_term_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND term_id='$term_id'AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		$grand_total=$query->fetch();
			return $grand_total['stu_each_subject_total'];
		}
		//end secondTermPerSubjectTotal function definition



		//getStudentSessionRecord function definition
		public function getStudentSessionRecord($student_id, $class_id, $class_type, $class_arm_id, $session_id, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM student_session_record WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND subject_id='$subject_id'"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end getStudentSessionRecord function definition




		//getStudentSessionReport function definition
		public function getStudentSessionReport($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT * FROM student_session_final_report WHERE student_id='$student_id' AND clazz_id ='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id'"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end getStudentSessionReport function definition


		
		//countNoOfSessionalSubjectsStudentPassed function definition
		public function countNoOfSessionalSubjectsStudentPassed($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT subject_id FROM student_session_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND student_subject_status='pass'");
			$query->execute();
			return $query->rowCount();
		}
		//end countNoOfSessionalSubjectsStudentPassed function definition



		//countNoOfSessionalSubjectsStudentPassed function definition
		public function countNoOfSessionalSubjectsStudentFailed($student_id, $class_id, $class_type, $class_arm_id, $session_id){
			$query = $this->connection()->prepare("SELECT subject_id FROM student_session_record WHERE student_id='$student_id' AND clazz_id='$class_id' AND clazz_type_id='$class_type' AND class_arm_id='$class_arm_id' AND sessionz_id='$session_id' AND student_subject_status='fail'");
			$query->execute();
			return $query->rowCount();
		}
		//end countNoOfSessionalSubjectsStudentPassed function definition









		//trialdoPositioning function definition
		// public function trialdoPositioning(){
		// 	$query = $this->connection()->prepare("SELECT DISTINCT subj_total AS total FROM trial ORDER BY total DESC");
		// 	$query->execute();
		// 	$subj_totals=$query->fetchAll();
		// 	$position=1;
		// 	foreach ($subj_totals as $subj_total) {
		// 		$subj_total=$subj_total['total'];
		// 		$query = $this->connection()->prepare("UPDATE trial SET position='$position' WHERE subj_total='$subj_total'");
		//     $query->execute();
		//     $position++;
		// 	}
		// 	return $subj_totals;

		// }
		//trialdoPositioning function definition		




	}

?>