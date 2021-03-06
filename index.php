<?php
session_start();
include_once 'dbconnect.php';

$loginError = false;

if(isset($_SESSION['user']))
{
	header("Location: homepage.php");
}

if(isset($_POST['btn-login']))
{
	$input = $_POST['email'];
	$pass = $_POST['pass'];

  $stmt = $conn->prepare("SELECT * FROM accounts WHERE email=:input OR name=:input");
  $stmt->bindValue(':input',$input);
  $stmt->execute();

  if($users=$stmt->fetch(PDO::FETCH_OBJ)) {
     if (password_verify($pass, $users->password)) {
      $_SESSION['user'] = $users->user_id;
      header("Location: homepage.php");
    }
  }

  $loginError = true;
}
?>

<!DOCTYPE html>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
 <link rel="stylesheet" type="text/css" href="css/style.css">

 <title>Log In</title>

</head>
<body>
  <div class="container text-center">
    <div class="row">
      <img src="images/logo.png"/>
    </div>
    <div class="row">
        <form method="POST">
          <div>
            <i class="fa fa-user fa-2x"></i><input id="loginTextBoxes" type="text" name="email" placeholder="Your Email" required />
          </div>

          <div>
            <i class="fa fa-lock fa-2x"></i><input id="loginTextBoxes" type="password" name="pass" placeholder="Your Password" required />
          </div>

          <?php 
          if ($loginError) {
            echo"<div><span class='error'>Incorrect email or password, please try again</span></div>";
          } ?>

          <button id="sign_in" type="submit" name="btn-login" class="btn btn-primary">Sign In</button>
          </form>
          <p>Or create an account</p>
          <a href="register.php" class="btn btn-primary">Register</a>
    </div>
  </div>
</body>
</html>