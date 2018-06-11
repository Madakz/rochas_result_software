<?php
	include "./class_lib/functions.php";
	 $rochas_inst= new Rochas;
	

	if (isset($_GET['teacher'])) {			//add isset($_GET['teacher']) when error kips coming up
		$id = $_GET['teacher'];
		$response = $rochas_inst->delete("teacher", $id);			//making use of the object to call the delete function by passing the table name and id
		if ($response) {
			 echo "<script>alert('Teacher Record is successfully deleted!'); window.location.href='admin/view_teachers.php';</script>";
		}else{
			echo "<script>alert('Deletion of teacher record Failed!'); window.location.href='admin/single_teacher.php?teacher='".$id.";</script>";
		}
	}if (isset($_GET['subject'])) {
		$id = $_GET['subject'];
		$response = $rochas_inst->delete("subject", $id);			//making use of the object to call the delete function by passing the table name and id
		if ($response) {
			 echo "<script>alert('subject is successfully deleted!'); window.location.href='admin/view_subjects.php';</script>";
		}else{
			echo "<script>alert('Deletion of subject record Failed!'); window.location.href='admin/view_subjects.php';</script>";
		}
	}if (isset($_GET['session'])) {
		$id = $_GET['session'];
		$response = $rochas_inst->delete("sessionz", $id);			//making use of the object to call the delete function by passing the table name and id
		if ($response) {
			 echo "<script>alert('session is successfully deleted!'); window.location.href='admin/view_sessions.php';</script>";
		}else{
			echo "<script>alert('Deletion of session record Failed!'); window.location.href='admin/view_sessions.php';</script>";
		}
	}if (isset($_GET['student'])) {
		$id = $_GET['student'];
		$response = $rochas_inst->delete("student", $id);			//making use of the object to call the delete function by passing the table name and id
		if ($response) {
			 echo "<script>alert('student is successfully deleted!'); window.location.href='admin/view_students.php';</script>";
		}else{
			echo "<script>alert('Deletion of student record Failed!'); window.location.href='admin/view_students.php';</script>";
		}
	}
?>