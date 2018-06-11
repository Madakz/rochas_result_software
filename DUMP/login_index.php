<?php
  include "class_lib/functions.php";
?>

<?php
  if(isset($_POST['sub']))    //checks if the submit button has been click
  {
    $username = $_POST['username'];   //initialize the username with username collected from the form input
    $password =$_POST['password'];    //initialize the password with password collected from the form input
    $table = $_POST['role'];
    $login = new Rochas;    //creating an object of the class
?>
    <!-- use the object to call the Login function with arguments as username and password -->
    
  <p style="color:red; text-align: center; font-size: 20px;"><?php echo $login->login($username, $password, $table);  }?></p>
  <h2>Login</h2> 
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"  id="main-contact-form" >
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" class="form-control" placeholder="Username" required="required">
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" name="password" class="form-control" placeholder="Password" required="required">
    </div>
    <div class="form-group">
      <label>Role:</label>
      <select name="role">
        <option value="">-- select role --</option>
        <option value="admin">School Admin</option>
        <option value="teacher">Teacher</option>
      </select>
    </div>                         
    <div class="form-group">
      <input type="submit" name="sub" value="Login" class="form-control btn-submit" />
      <!-- <button type="submit" class="btn-submit">Send Now</button> -->
    </div>
  </form> 