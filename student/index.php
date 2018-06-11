<?php
	include "../class_lib/functions.php";
	$logged_in_user = $_SESSION['logged_user_id'];
	$rochas_inst= new Rochas;
?>


	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables_themeroller.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../js/dataTables.foundation.min.js"></script>


<a href="index.php">Home</a>
<a href="teacher_profile.php">Profile</a>
<a href="index.php">view students</a>
<!-- <a href="score_sheet.php">Enter score sheet</a> -->
<a href="term_result.php">Print result</a>


	<h2 style="color: red;"> *** INSTRUCTIONS *** </h2>
	<ul>
		<li>Make sure to <em style="color: red;">Select the appropriate Class and Class Type</em> To Perform Operations On</li>
		<li>After Selecting the class, click Perform Operation</li>
		<li>A table of the selected class with students' records is displayed. Click on Show Action link of a particular student to enter score sheet records; and to perform other operations.</li>
	</ul>

	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		
		<label>Class name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<!-- <select name="class_name" class="form-control" required=""> -->
		<select name="class_name" required="">
        	<option value="">-- select class --</option>
        	<?php
        		$classes=$rochas_inst->viewClass();
        		foreach ($classes as $class) {
        			
        	?>
        			<option value="<?php echo $class['id'];?>"><?php echo $class['name'];?></option>
        	<?php
        		}

        	?>
     	 </select>

     	 <label>Class Type:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<!-- <select name="class_name" class="form-control" required=""> -->
		<select name="class_type" required="">
        	<option value="">-- select class type --</option>
        	<?php
        		$class_types=$rochas_inst->viewClassType();
        		foreach ($class_types as $class_type) {
        			
        	?>
        			<option value="<?php echo $class_type['id'];?>"><?php echo $class_type['name'];?></option>
        	<?php
        		}

        	?>
     	 </select>

     	 <label>Class Arm:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
			<select name="class_arm"  required="">
				<?php
					$class_arms=$rochas_inst->fetchClassArm();
				?>
		        <option value="">-- select class arm --</option>
		        <?php
		        	foreach ($class_arms as $class_arm) {
		        ?>
		        		<option value="<?php echo $class_arm['id'];?>"><?php echo $class_arm['name'];?></option>
		        <?php
		        	}
		        ?>
		        
		     </select>

	    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
	   

		<input type="submit" class="btn btn-primary" name="operate" value="Perform Operation">
	</form>


<?php 

	if (isset($_POST['operate'])) {
		$class=trim($_POST['class_name']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);
		$table='student';

		$students=$rochas_inst->findItemByClassIdClassArmAndClassTypeId($class, $class_type, $class_arm, $table);
		$class_name=$rochas_inst->findById($class, 'clazz');
		

?>
		<div class="table-responsive">
		<caption><center style="font-size: 50px; font-weight: bold;"> All <?php echo $class_name['name'];?> Students</center></caption>
	    <table id="myTable" class="table">
	        <thead>
	            <?php
	                $sn=1;
	            ?>
	            <th>S/no</th>
	            <th>Name</th>
	            <th>Status</th>
	            <th>Class</th>	           
	            <th>Action</th>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>S/no</th>
	                <th>Name</th>
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
	                       <a href="student.php?student=<?php echo $student['id']; ?>">
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
<?php
	}
?>




	    <script type="text/javascript">
	        $('#myTable').DataTable();
	        
	    </script>
	</div>