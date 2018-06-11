<?php
     include "../class_lib/functions.php";
     $logged_in_user = $_SESSION['logged_user_id'];
     $rochas_inst= new Rochas;

     $error='';
    if (isset($_POST['register'])) {
        $name=trim($_POST['full_name']);
        $address=trim($_POST['address']);
        $subject=trim($_POST['subject']);       
        $username=trim(strtolower($_POST['username']));
        $password=$_POST['password'];
        $con_password=$_POST['con_password'];

        $role=trim($_POST['role']);
        $admin = trim($_POST['admin']);

        $picture = $rochas_inst->imageUploadFunction($_FILES);
        
        $insert=$rochas_inst->registerTeacher($name, $subject, $username, $password, $con_password, $picture, $address, $role, $admin);
        if ($insert) {
?>
            <script>
                alert("teacher registered successful");
                window.location.href='index.php';
            </script>
<?php       
        }else{
            $error='Password Mismatch';
?>
            <script>
                alert("teacher's registration failed");
            </script>
<?php
        }       
    }

?>

<?php
    include 'headers.php';
?>

        <!-- Navigation
    ================================================== -->
        <div class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">                            
                            <li><a href="index.php"><i class="fa fa-home"><span></span></i> Home</a></li>

                            <li class="active"><a href="#">Teacher</a>
                                <ul class="dropdown-menu">
                                    <li class="active"><a href="register_teacher.php">Register Teacher</a></li>
                                    <li><a href="view_teachers.php">View Teachers</a></li>
                                </ul>
                            </li>

                            <li><a href="#">Student</a>
                                <ul class="dropdown-menu">
                                    <li><a href="register_student.php">Register Student</a></li>
                                    <li><a href="view_students.php">View Students</a></li>
                                </ul>
                            </li>

                            <li><a href="#">Subject</a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_subject.php">Add subject</a></li>
                                    <li><a href="view_subjects.php">View subjects</a></li>
                                    <!-- <li><a href="edit_subject.php">Edit subjects</a></li> 
                                    <li><a href="../delete.php">Delete subjects</a></li> -->                                 
                                </ul>
                            </li>
                            <li><a href="#">Session</a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_session.php">Add session</a></li>
                                    <li><a href="view_sessions.php">View sessions</a></li>
                                    <!-- <li><a href="portfolio_3.html">Edit session</a></li> 
                                    <li><a href="portfolio_3.html">Delete session</a></li> -->                              
                                </ul>
                            </li>                               
                            <li><a href="#">Others</a>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="add_ter">Add term</a></li> -->
                                    <li><a href="view_terms.php">View terms</a></li>
                                    <li><a href="view_classes.php">View classes</a></li>
                                    <li><a href="view_students.php">Print Student Result</a></li>
                                </ul>
                            </li>

                            <li><a href="../teacher/teacher_profile.php"><i class="fa fa-user"></i>&nbsp;<?php echo $admin_details['name'];?></a></li>
                            <li><a href="../logout.php"><i class="fa fa-sign-out"><span> sign out</span></i></a></li>
                        </ul>
                    </div>
                </div><!--/.row -->
            </div><!--/.container -->
        </div>
    </header>
    <!--End Header-->
	
	<!--start wrapper-->
	<section class="wrapper">
		<section class="page_head">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h2>Register Teacher Form</h2>
						<nav id="breadcrumbs">
							<ul>
								<li>You are an admin here:</li>
                                <li><a href="index.php">Teacher&nbsp;<i class="fa fa-angle-right"></i></a></li>
                                <li><a href="index.php">Register teacher</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</section>

		<section class="content contact">
			<div class="container">
				<div class="row sub_content">
                    <div class="col-lg-2 col-md-2 col-sm-2"></div>
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="dividerHeading">
							<h4><span><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></span></h4>
						</div>
						<form id="contactForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-6 ">
                                        <label>Image:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <input type="file" name="picture" class="form-control" placeholder="choose picture" required="" />
                                    </div>
                                    <div class="col-lg-6 ">
                                        <label>Full name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <input type="text" id="name" name="full_name" value="<?php echo !empty($_POST['full_name']) ? $_POST['full_name'] : ""; ?>" placeholder="Full name" class="form-control" maxlength="100" required="">                                        
                                    </div>                                    
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Address:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <textarea cols="50" rows="10" class="form-control" name="address" required="" maxlength="5000" placeholder="Address"><?php echo !empty($_POST['address']) ? $_POST['address'] : ""; ?></textarea>

                                    </div>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-6 ">
                                        <label>Teaching Subject:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <select name="subject" class="form-control" required="">
                                            <option value="">-- select subject --</option>
                                            <?php
                                                $subjects=$rochas_inst->viewSubjects();
                                                foreach ($subjects as $subject) {
                                            ?>
                                                    <option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                         </select>
                                    </div>
                                    <div class="col-lg-6 ">
                                        <label>Username:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <input type="email" name="username" value="<?php echo !empty($_POST['username']) ? $_POST['username'] : ""; ?>" placeholder="e.g madaki@gmail.com" class="form-control" required="">                                                                               
                                    </div>                                    
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-6 ">
                                        <label>Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <input type="password" name="password"  placeholder="password" class="form-control" required="">
                                    </div>
                                    <div class="col-lg-6 ">
                                        <label>Confirm Password:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
                                        <input type="password" name="con_password"  placeholder="confirm password" class="form-control" required="">                                              
                                    </div>  
                                    <input type="hidden" name="role" value="teacher">
                                    <input type="hidden" name="admin" value="<?php echo $logged_in_user;?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="form-control btn btn-primary btn-lg" name="register"  value="Submit">
                                </div>
                            </div>
						</form>
					</div>
                    <div class="col-lg-2 col-md-2 col-sm-2"></div>					
				</div>
			</div>
		</section>
	</section>
	<!--end wrapper-->

	
	
	<?php
    include 'footers.php';
?>
