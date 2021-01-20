<?php

  require('./DBManager.php');

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $table = "";
    if(isset($_POST['organizer']) && $_POST['organizer']!=""){
      $table = 'organisateur';
    }
    else {
      $table = 'sportif';
    }
    $verifCredentials = CredentialsVerification($email,$pass,$table);
    if($verifCredentials){
      session_start();
      $_SESSION["login_user"] = $email;
      $_SESSION["type"] = $table;
      $_SESSION['user_name'] = getuserName($email)['name'];
      $_SESSION["user_logged_in"] = true;
      header("location: ./index.php");
    }else{
      $error = " Username and password doesn't match";
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="signin.css">
  </head>
  <body>
    <div id="id02" class="modal">
      <form class="modal-content" action="./login.php" method="post">
        <div class="container">
          <h1>Login</h1>
          <hr>
          <label for="email"><b>Adresse mail</b></label>
          <input type="email" placeholder="Taper votre adresse mail" name="email" required>

          <label for="pass"><b>Mot de passe</b></label>
          <input type="password" placeholder="Taper votre mot de passe" name="pass" required>

          <label class="form-switch">

            <input type="checkbox" name = 'organizer'>
            <i></i>
            <b style = "font-size: 17px">Organisateur </b>
          </label>

          <div class="clearfix">
            <input type="submit" class="signupbtn" Value="Log in">
          </div>

          <div style= " color:#cc0000;">
            <?php
              if(isset($error)){
                echo $error;
              }
            ?>
          </div>

          <div>
            <a href="./signup.php"><u>Not a member yet ? Sign UP</u></a>
          </div>
          <div>
            <a href="./index.php"><u>Retourner a l'acceuil</u></a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
