<?php
  include "class_lib/functions.php";

  if(isset($_POST['sub']))    //checks if the submit button has been click
  {
    $username = trim(strtolower($_POST['username']));   //initialize the username with username collected from the form input
    $password =$_POST['password'];    //initialize the password with password collected from the form input
    $table = $_POST['role'];
    $login = new Rochas;    //creating an object of the class
    
      
        $login_err=$login->login($username, $password, $table); 
        echo "<script>alert('".$login_err."')</script>";
  }
?>        
   
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Rochas foundation College</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>

  <section id="contact">
    <div id="contact-us" class="parallax">
      <div class="container">
        <div class="row">
          <div class="col-sm-12"><h1 style="text-align: center; padding-bottom: 5px; margin-bottom: 5px; font-weight: bold;"><img src="./images/rfc.jpg" style="width: 50px; height: 50px;"> Rochas Foundation College, Jos</h1></div>
          <div class="col-sm-5"></div>
          <div class="heading text-center col-sm-2">
            <h2 style="border-bottom-style:solid; padding-bottom: 0.4em; border-bottom-width: 4px; border-bottom-color: #ddd; text-transform: uppercase; margin-top: 0px;">Login</h2>
          </div>
          <div class="col-sm-5"></div>
        </div>
        <div class="contact-form">
          <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
              <form id="main-contact-form" name="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">                
                <div class="form-group">
                  <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <select  name="role" class="form-control">
                  <option value="">-- select role --</option>
                      <option value="admin">School Admin</option>
                      <option value="teacher">Teacher</option>
                </select>
                </div>                        
                <div class="form-group">
                  <button type="submit" name="sub" class="btn-submit">Login</button>
                </div>
              </form>   
            </div>
            <div class="col-sm-4"></div>              
          </div>
        </div>
      </div>
    </div>        
  </section><!--/#contact-->
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
</body>
</html>