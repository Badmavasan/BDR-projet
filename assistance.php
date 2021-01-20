<?php
require('functions.php');
require('DBManager.php');
session_start();

if(!isset($_SESSION['user_logged_in'])){
  $_SESSION['user_logged_in'] = False;
}
if(!isset($_SESSION['type'])){
  $_SESSION['type'] = "";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $email = $_POST['email'];
  $name = $_POST['first_name'] . $_POST['last_name'];
  $des = $_POST['des'];

  $to = 'sunshinevasan@gmail.com';
  $subject = 'Assistance Technique';
  $message = $des . '<br>' . $email .'<br>'.$name;

  mail($to,$subject,$message);
}
?>
<?=template_header('Evenement inscrit',$_SESSION['user_logged_in'],$_SESSION['type'])?>
<?php
  echo <<<EOT
      <form class="modal-content" action="./assistance.php" method="post">
        <div class="container">
          <h1>Contact Assistance</h1>
          <p>Remplissez ce formumlaire si vous avez des difficultes techinique</p>
          <hr>
          <label for="first_name"><b>Nom</b></label>
          <input type="text" placeholder="Taper votre nom" name="first_name" required>

          <label for="last_name"><b>Prenom</b></label>
          <input type="text" placeholder="Taper votre prenom" name="last_name" required>

          <label for="email"><b>Adresse mail</b></label>
          <input type="email" placeholder="Taper votre adresse mail" name="email" required>
          <br>
          <label for="description"><b>Description du problème technique</b></label>
          <input type="text" placeholder="Description du problème" name="des" required>
          <div class="clearfix">
            <input type="submit" class="signupbtn" Value="Envoyer">
          </div>
          </div>
        </form>

  EOT;
 ?>

<?=template_footer()?>
