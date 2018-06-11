<?php
    include "../class_lib/functions.php";
    $logged_in_user = $_SESSION['logged_user_id'];
     $rochas_inst= new Rochas;
    $teachers = $rochas_inst->viewTeachers();
    // print_r($teachers);

?>
<?php 
    $admin_details = $rochas_inst->findById($logged_in_user, 'admin');
    

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Rochas Foundation College</title>
    <meta name="description" content="">

    <!-- CSS FILES -->
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" data-name="skins">
    <link href="../css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/switcher.css" media="screen" />

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables_themeroller.css">

    <style>
        .navbar {
            margin-bottom: 0;
            background: #323A45;
            min-height: 35px;
            border: none;
        }
        .navbar-nav > li > a:hover, .navbar-nav > li > a:focus, .navbar-nav > li.active > a, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a, .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
            background: #E74C3C !important;
            color: #fff !important;
        }
        .navbar-default .navbar-nav > li > a {
            padding: 14px 25px;
            color: #fff;
        }
    </style>
    
</head>
<body>
    <!--Start Header-->
    <header id="header">        
        <div id="logo-bar" class="clearfix">
            <!-- Container -->
            <div class="container">
                <div class="row">
                    <!-- Logo / Mobile Menu -->
                    <div class="col-xs-12">
                        <h1><a href="index.html" style="color: #3A3A3A;"><img src="../images/rfc.jpg" alt="Eve" style="float: left; width: 50px; height: 50px;" />Rochas Foundation College, Jos</a></h1>
                        <div id="logo">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container / End -->
        </div>
        <!--LOGO bar / End-->

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
                                    <li><a href="register_teacher.php">Register Teacher</a></li>
                                    <li class="active"><a href="view_teachers.php">View Teachers</a></li>
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
						<h2>All Teachers</h2>
						<nav id="breadcrumbs">
							<ul>
								<li>You are an admin here:</li>
                                <li><a href="index.php">Teacher&nbsp;<i class="fa fa-angle-right"></i></a></li>
                                <li><a href="index.php">view teachers</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</section>

		<section class="content contact">
			<div class="container">
				<div class="row sub_content">
                    <div class="col-lg-1 col-md-1 col-sm-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10">
						<div class="dividerHeading">
							<h4><span><i>Click the <ins style="color: blue;">Show</ins> link to view teacher's profile and perform other operations</i></span></h4>
						</div>
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
                        </div>
					</div>
                    <div class="col-lg-1 col-md-1 col-sm-1"></div>					
				</div>
			</div>
		</section>
	</section>
	<!--end wrapper-->

	
	
  <div class="col-md-12">
      <hr style="border-top: 1px solid #C0C0C0;"/>
  </div>

    </section>
    <!--end wrapper-->
    <footer id="footer">    
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <p> <i class="fa fa-phone"></i> <span> Phone:</span> 08136943343</p>
          </div>
          <div class="col-sm-8">
            <p>&copy; 2018 Madaki Fatsen.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
    

    
    <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- <script src="js/jquery.easing.1.3.js"></script> -->
    <!-- <script src="js/retina-1.1.0.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/jquery.cookie.js"></script>  -->
    <!-- <script type="text/javascript" src="js/styleswitch.js"></script>  -->
    <script type="text/javascript" src="../js/jquery.smartmenus.min.js"></script>
    <script type="text/javascript" src="../js/jquery.smartmenus.bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="js/jquery.jcarousel.js"></script> -->
    <!-- <script type="text/javascript" src="js/jflickrfeed.js"></script> -->
    <!-- <script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/jquery.isotope.min.js"></script> -->

    <script src="../js/main.js"></script>

    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.foundation.min.js"></script> <!-- works -->

    <!-- ============This is for all datatables/ ============-->
    <script type="text/javascript">
        $('#myTable').DataTable();        
    </script>
   <!-- ============This is for all datatables/ ============-->



    
</body>
</html>
