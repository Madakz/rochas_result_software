<?php
    include "../class_lib/functions.php";
    $logged_in_user = $_SESSION['logged_user_id'];
     $rochas_inst= new Rochas;
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
                            <li class="active"><a href="index.php"><i class="fa fa-home"><span></span></i> Home</a></li>

                            <li><a href="#">Teacher</a>
                                <ul class="dropdown-menu">
                                    <li><a href="register_teacher.php">Register Teacher</a></li>
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
                                    <li class="active"><a href="add_subject.php">Add subject</a></li>
                                    <li><a href="view_subjects.php">View subjects</a></li>
                                    <!-- <li><a href="edit_subject.php">Edit subjects</a></li> 
                                    <li><a href="../delete.php">Delete subjects</a></li> -->                                 
                                </ul>
                            </li>
                            <li><a href="#">Session</a>
                                <ul class="dropdown-menu">
                                    <li class="active"><a href="add_session.php">Add session</a></li>
                                    <li><a href="view_sessions.php">View sessions</a></li>
                                    <!-- <li><a href="portfolio_3.html">Edit session</a></li> 
                                    <li><a href="portfolio_3.html">Delete session</a></li> -->                              
                                </ul>
                            </li>                               
                            <li><a href="#">Others</a>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="add_ter">Add term</a></li> -->
                                    <li class="active"><a href="view_terms.php">View terms</a></li>
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
                        <h2>Admin Dashboard</h2>
                        <nav id="breadcrumbs">
                            <ul>
                                <li>You are an admin here:</li>
                                <li><a href="index.php">Home&nbsp;<i class="fa fa-angle-right"></i></a></li>
                                <li><a href="index.php">Dashboard</a></li>
                            </ul>   
                            <!-- use the above to show the user where he has ventured into -->
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="col-sm-12">            
            <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_teachers.php">View Teachers</a></h4>                    
                </div>
                <!-- end blog categories -->
            </div>
             <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_students.php">View Students</a></h4>                    
                </div>
                <!-- end blog categories -->
            </div>
             <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_subjects.php">View Subjects</a></h4>
                </div>
                <!-- end blog categories -->
            </div>
            <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_sessions.php">View Session</a></h4>                    
                </div>
                <!-- end blog categories -->
            </div>
             <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_classes.php">View Classes</a></h4>                    
                </div>
                <!-- end blog categories -->
            </div>
             <div class="col-sm-4">
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a href="view_students.php">Print Student Result</a></h4> 
                </div>
                <!-- end blog categories -->
            </div>            
        </div>
        

<?php
    include 'footers.php';
?>