<?php
  require('./DBManager.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(test_input($_POST["pass"]) == test_input($_POST["pass-repeat"])){
      if(!personExists(test_input($_POST["email"]))){
        $participant = new participant();
        $participant->set_participant_first_name(test_input($_POST["first_name"]));
        $participant->set_participant_last_name(test_input($_POST["last_name"]));
        $participant->set_participant_email(test_input($_POST["email"]));
        $participant->set_participant_password(test_input($_POST["pass"]));
        $participant->set_participant_association(test_input($_POST["association"]));
        $participant->set_participant_campus(test_input($_POST["campus"]));
        InsertSportifIntoDB($participant);
        header ("location: ./login.php");


      }
      else{
        $error = "Sportif exist deja";
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="signin.css">
<body>

<div id="id01" class="modal">
  <form class="modal-content" action="./signup.php" method="post">
    <div class="container">
      <h1>Sign Up as Participant</h1>
      <p>Remplissez le formulaire pour vous inscrire en tant qu'un participant</p>
      <hr>
      <label for="first_name"><b>Nom</b></label>
      <input type="text" placeholder="Taper votre nom" name="last_name" required>

      <label for="last_name"><b>Prenom</b></label>
      <input type="text" placeholder="Taper votre prenom" name="first_name" required>

      <label for="email"><b>Adresse mail</b></label>
      <input type="email" placeholder="Taper votre adresse mail" name="email" required>

      <label for="pass"><b>Mot de passe</b></label>
      <input type="password" placeholder="chossisez un mot de passe" name="pass" required>

      <label for="pass-repeat"><b>Confirmer votre mot de passe</b></label>
      <input type="password" placeholder="Re-taper votre mot de passe" name="pass-repeat" required>
      <p>
        <label for="campus"><b>A quel campus appartenez-vous ?</b></label>
        <select name="campus" id="campus">
          <option value = "" selected="">Choisir Site Universitaire</option>
          <?php
            $campuses = loadCampuses();
            foreach ($campuses as $campus) {
              echo "<option value='".$campus['idsite']."'>".$campus['nom']."</option>";
            }
          ?>
        </select>
      </p>

      <label for="association"><b>A quelle association appartenez-vous ?</b></label>
      <select name="association" id="association">
        <option value = "" selected="">Choisir votre association</option>
        <?php
            $associations = loadAssociation();
            foreach ($associations as $association) {
              echo "<option value='".$association['idcategorie']."'>".$association['libelle']."</option>";
            }
        ?>
      </select>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
      <div style= "fonct-size:11px color:#cc0000; margin-top:10px">
        <?php
          if(isset($error)){
            echo $error;
          }
        ?>
      </div>
      <div class="clearfix">
        <input type="submit" class="signupbtn" Value="Sign Up">
      </div>
      <div>
        <a href="./login.php"><u>Already a memeber? Log In</u></a>
      </div>
      <div>
        <a href="./index.php"><u>Retourner a l'acceuil</u></a>
      </div>
    </div>
  </form>
</div>
