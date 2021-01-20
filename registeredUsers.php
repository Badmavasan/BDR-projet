<?php
/**
  * DESCRIPTION OF THE FILE : This file is responsible for the display of all the registered partiicipants to a given event
  * the event id is take out of a hidden form from the event.php page
  * This page verifies if the user who has logged in is organisateur or not before displaying.
  * As there is a if condition to verify if there was a submitted form this page is not accessible otherways
  * Moreover the posibility of acessing this page is unavailable because users or normal people don't have the option to redirect towards this site
  * this site is only acessible by organizers.
  * This page uses functions from function.php for the header and footer
  * This page uses functions from DBManager.php in order to fetch data from database.
  * By chance if someone tries to access this site without logging in or if a user tries to access it, the person is redirected towards the login page
  **/
include('./functions.php');
require('./DBManager.php');

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventID = $_POST['event_id']; // input retrieved from hidden type input from event.php page
    if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='organisateur'){ //SESSION values are set during log in
      template_header('Sportis inscrit',$_SESSION['user_logged_in'],$_SESSION['type']);
      echo <<<EOT
        <div class="col-6">
          <h1 id="listeEvenementsInscrit" > Liste des inscriptions </h1>
      EOT;
      $registeredUsers=getRegisteredUsers($eventID);
      if(!$registeredUsers){
        echo "Aucun Inscription";
      }
      else{
        echo <<<EOT
          <table class="table table-bordered table-striped">
            <thead class="thead-dark"><tr><th>Nom</th><th>Prénom</th><th>Association</th></tr></thead>
            <tbody>
        EOT;
        foreach($registeredUsers as $registeredUser)
          echo "<tr><td>".$registeredUser["nom"]."</td><td>".$registeredUser["prenom"].
              "</td><td>".$registeredUser["libelle"]."</td>
              </tr>";
        echo <<<EOT
              </tbody>
            </table>
          </div>
        EOT;
      }
        template_footer();
      }
      else{
        header("Location: login.php");
      }
}

?>
