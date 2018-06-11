<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	$sessionz = $rochas_inst->viewSession();
	// print_r($sessionz);

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
	            <th>Session Name</th>
	            <th>Added by</th>          
	            <th>Edit Action</th>
	            <th>Delete Action</th>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>S/no</th>
	                <th>Session Name</th>
	                <th>Added by</th>
	                <th>Edit Action</th>
	            	<th>Delete Action</th>
	            </tr>
	        </tfoot>
	        <tbody>
	        	<?php
	            	foreach($sessionz as $session){
	            ?>                                                   
	                <tr>
	                    <td><?php echo $sn; ?></td>
	                    <td><?php echo $session['name'].' Session'; ?></td>

	                    <?php 
	                    	$admin_id=$session['admin_id'];
	                    	$admin=$rochas_inst->findById($admin_id, 'admin'); 
	                    ?>
	                    <td><?php echo $admin['name'] ?></td> 
  
	                    
	                    <td>
	                    	<a href="edit_session.php?session=<?php echo $session['id']; ?>">
	                            <i class="fa fa-folder-open"></i> Edit
	                        </a>
	                    </td>                                                          
	                    <td>
	                       <a href="../delete.php?session=<?php echo $session['id']; ?>">
	                            <i class="fa fa-folder-open"></i> Delete
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