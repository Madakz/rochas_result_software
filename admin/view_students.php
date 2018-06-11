<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	$students = $rochas_inst->retrieveAllStudent();
	// print_r($students);

?>


	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables_themeroller.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../js/dataTables.foundation.min.js"></script> <!-- works -->


	<a href="register_teacher.php">register teacher</a>
	<a href="register_student.php">register student</a>
	<a href="view_student.php">view student</a>

	<div class="table-responsive">
	    <table id="myTable" class="table">
	        <thead>
	            <?php
	                $sn=1;
	            ?>
	            <th>S/no</th>
	            <th>Name</th>
	            <th>Birthday</th>
	            <th>Status</th>
	            <th>Class</th>	           
	            <th>Action</th>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>S/no</th>
	                <th>Name</th>
	                <th>Birthday</th>
		            <th>Status</th>
		            <th>Class</th>
	                <th>Action</th>
	            </tr>
	        </tfoot>
	        <tbody>
	        	<?php
	            	foreach($students as $student){
	            ?>                                                   
	                <tr>
	                    <td><?php echo $sn; ?></td>
	                    <td><?php echo $student['surname'].' '.$student['firstname'].' '.$student['othername']; ?></td>
	                    <td><?php echo $student['birth_date'] ?></td>
	                    <td><?php echo $student['status']==1? 'student':'withdrawn'; ?></td> 
  
	                    <?php 
	                    	$class_id=$student['clazz_id'];
	                    	$class=$rochas_inst->findById($class_id, 'clazz'); 

	                    	$class_type_id=$student['clazz_type_id'];
	                    	$class_type=$rochas_inst->findById($class_type_id, 'clazz_type');

	                    	$class_arm_id=$student['class_arm_id'];
	                    	$class_arm=$rochas_inst->findById($class_arm_id, 'class_arm');

	                    ?>
	                    <td><?php echo $class['name'].''.$class_arm['name'].' '.$class_type['name']; ?></td>                                                          
	                    <td>
	                       <a href="single_student.php?student=<?php echo $student['id']; ?>">
	                            <i class="fa fa-folder-open"></i> Show
	                        </a>
	                    </td>
	                </tr>
	                <?php
	                    $sn++;
	                }
	                ?>
	              
	        </tbody>
	    </table>

	    <script type="text/javascript">
	        $('#myTable').DataTable();
	        
	    </script>
	</div>