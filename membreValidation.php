<?php
include('./functions.php');
require('./DBManager.php');

session_start();
  if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='organisateur'){
    template_header('Validation des membres',$_SESSION['user_logged_in'],$_SESSION['type']);
    echo <<<EOT
      <div class="col-6">
        <h1 id="membresToValidate" > Liste des membres à Valider</h1>
    EOT;
    $membersToValidate=membreNonValide();
    echo <<<EOT
      <table class="table table-bordered table-striped">
        <thead class="thead-dark"><tr><th>Nom</th><th>Prenom</th><th>Association</th><th>Valider</th></tr></thead>
        <tbody>
    EOT;
    if(!$membersToValidate){
      echo "Aucun Sportif à valider";
    }
    else{
      $memberValidations = loadmemberValidation();
      foreach($membersToValidate as $memberToValidate){
        echo "<tr><td>".$memberToValidate["nom"]."</td><td>".$memberToValidate["prenom"].
            "</td><td>".$memberToValidate["libelle"]."</td>"."<td><form action='./ValidatedMemebre.php' method='POST'>
            <input type='hidden' name='validate_email_id' value=".$memberToValidate['email'].">
            <label for='validation'>Choisir un état :</label>
            <select id='answer' name='validationAnswer'>";
        foreach ($memberValidations as $memberValidation) {
          echo "<option value='".$memberValidation['id']."'>".$memberValidation['libelle']."</option>";
        }
        echo "</select>
            <br>
            <input style='background-color: #000000;color: white;padding: 5px 5px;margin: 5px 0;border: none;cursor: pointer;width: 100%;opacity: 0.9;' type='submit' value='Valider'></form></td></tr>" ;
      }
      echo <<<EOT
            </tbody>
          </table>
        </div>
      EOT;
      template_footer();
    }

  }
  else{
    header("Location: login.php");
  }



 ?>
