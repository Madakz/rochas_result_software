<?php
	include "../class_lib/functions.php";
	 $rochas_inst= new Rochas;
	$terms = $rochas_inst->viewTermz();
	// print_r($terms);

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
	            <th>Class Name</th>
	            <th>Added by</th>          
	            <!-- <th>Edit Action</th>
	            <th>Delete Action</th> -->
	        </thead>
	        <tfoot>
	            <tr>
	                <th>S/no</th>
	                <th>Class Name</th>
	                <th>Added by</th>
	                <!-- <th>Edit Action</th>
	            	<th>Delete Action</th> -->
	            </tr>
	        </tfoot>
	        <tbody>
	        	<?php
	            	foreach($terms as $term){
	            ?>                                                   
	                <tr>
	                    <td><?php echo $sn; ?></td>
	                    <td><?php echo $term['name'].' TERM'; ?></td>

	                    <?php 
	                    	$admin_id=$term['admin_id'];
	                    	$admin=$rochas_inst->findById($admin_id, 'admin'); 
	                    ?>
	                    <td><?php echo $admin['name'] ?></td> 
  
	                    
	                    <!-- <td>
	                    	<a href="edit_term.php?term=<?php //echo $term['id']; ?>">
	                            <i class="fa fa-folder-open"></i> Edit
	                        </a>
	                    </td>                                                          
	                    <td>
	                       <a href="../delete.php?term=<?php //echo $term['id']; ?>">
	                            <i class="fa fa-folder-open"></i> Delete
	                        </a>
	                    </td> -->
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