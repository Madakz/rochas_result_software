<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	$teachers = $rochas_inst->viewTeachers();
	// print_r($teachers);

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
	<a href="view_students.php">view student</a>

	<div class="table-responsive">
	    <table id="myTable" class="table">
	        <thead>
	            <?php
	                $sn=1;
	            ?>
	            <th>S/no</th>
	            <th>Name</th>
	            <th>Username</th>	           
	            <th>Action</th>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>S/no</th>
	                <th>Name</th>
	                <th>Username</th>
	                <th>Action</th>
	            </tr>
	        </tfoot>
	        <tbody>
	        	<?php
	            	foreach($teachers as $teacher){
	            ?>                                                   
	                <tr>
	                    <td><?php echo $sn; ?></td>
	                    <td><?php echo $teacher['name']; ?></td>
	                    <td><?php echo $teacher['username'] ?></td>                                                             
	                    <td>
	                       <a href="single_teacher.php?teacher=<?php echo $teacher['id']; ?>">
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