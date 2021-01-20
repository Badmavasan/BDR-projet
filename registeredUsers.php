<?php

include('./functions.php');
require('./DBManager.php');

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventID = $_POST['event_id'];
    if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='organisateur'){
      template_header('Sportis inscrit',$_SESSION['user_logged_in'],$_SESSION['type']);
      echo <<<EOT
        <div class="col-6">
          <h1 id="listeEvenementsInscrit" > Liste des inscription à l'événement</h1>
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
