<?php
	include "../class_lib/functions.php";
	$logged_in_user = $_SESSION['logged_user_id'];
	$rochas_inst= new Rochas;
?>


<script type="text/javascript" src="../js/jquery.js"></script>


<a href="index.php">Home</a>
<a href="teacher_profile.php">Profile</a>
<a href="../student/index.php">view students</a>
<a href="../student/score_sheet.php">Enter score sheet</a>
<a href="../student/term_result.php">Print result</a>

		<?php
			$error='';
			if (isset($_POST['pass_change'])) {
				$new_pass=$_POST['new_pass'];
				$confirm_pass=$_POST['confirm_pass'];
				$teacher_id=$_POST['teacher'];
				if ($new_pass != $confirm_pass) {
					$error='Password mismatch, try again!';
					echo "<script>alert('Password mismatch, try again!');</script>";
				}else{
					$response=$rochas_inst->changePassword($teacher_id, $new_pass);
					if ($response) {
						echo "<script>alert('Password change successful!');</script>";
					}else{
						echo "<script>alert('Password change not successful!');</script>";
					}
				}
			}


		?>

		<?php
			$table='teacher';
			$teacher=$rochas_inst->findById($logged_in_user, $table);
			print_r($teacher);
		?>

<!-- ======== CHANGE PASSWORD FLIP RECORD ======== -->
		<div class="col-md-4">
			<!-- <div class="col-md-4" style="margin-top:50px;"> -->
			<button id="change_password_flip" class="btn btn-warning form-control"><a href="#change_password_flip">Change Password</a></button>
		</div>
		
		<div class="col-sm-12 col-md-12">
			<div class="row alert-success" id="change_password_panel">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
					<div style="text-align:center; color:#fff; font-size:15px;"><i>Change Password</i></div>
					<div style="color:red;"><?php echo $error; ?></div>
					<label>New Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="password" name="new_pass" value="<?php echo !empty($_POST['new_pass']) ? $_POST['new_pass'] : ""; ?>" class="form-control" required="">
					<label>Confirm Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
								<input type="password" name="confirm_pass" value="<?php echo !empty($_POST['confirm_pass']) ? $_POST['confirm_pass'] : ""; ?>" class="form-control" required="">
				     <br/><br/>
										
					<input type="hidden" name="teacher" value="<?php echo $logged_in_user;?>">
					<input type="submit" name="pass_change" value="Submit" class="btn btn-warning">
				</form>
			</div>
			<script> 
				$(document).ready(function(){
				    $("#change_password_flip").click(function(){
				        $("#change_password_panel").fadeToggle(1500);
				    });
				    
				});
			</script>
				 
			<style> 
				 #change_password_flip a{
				    text-align: center;
				    color:#000;
				    text-decoration: none;
				}
				#change_password_flip:hover{color:	#E67E00;}

				#change_password_panel {
				    margin-top:15px;
				    display: none;
				    background-color:  #8ab839;
				    /*text-align: center;*/
				    /*color: #ffffff;*/
				    padding-bottom: 15px;
				    margin-bottom: 15px;
				    font-size: 10px;

				}
				#change_password_panel label{
				    color: #ffffff;
				}
			</style>
		</div>

		<!-- ========= CHANGE PASSWORD FLIP RECORD ========= -->