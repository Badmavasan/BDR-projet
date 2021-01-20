<?php
/**
  * DESCRIPTION OF THE FILE :  the file displays all the rehgistrations to which the organizer should provide goodies
  * each inscription comes with a valider button that validates the goodies_fourni using validationGoodies.php
  * As there is display, this function uses functions.php to display the header and footer
  * Also user DBManger.php to extract values of registration and goodies status 
  **/
include('./functions.php');
require('./DBManager.php');

session_start();
  if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='organisateur'){
    template_header('Validation des membres',$_SESSION['user_logged_in'],$_SESSION['type']);
    echo <<<EOT
      <div class="col-6">
        <h1 id="goodiesFourni" > Liste des Goodies à fournir</h1>
    EOT;
    $goodiesMembres = listeGoodies();
    echo <<<EOT
      <table class="table table-bordered table-striped">
        <thead class="thead-dark"><tr><th>Nom</th><th>Prenom</th><th>Evenement</th><th>Etat</th></tr></thead>
        <tbody>
    EOT;
    if(!$goodiesMembres){
      echo "Tous les goodies ont été validé";
    }
    else{
      foreach($goodiesMembres as $goodiesMembre)
        echo "<tr><td>".$goodiesMembre["nom"]."</td><td>".$goodiesMembre["prenom"].
            "</td><td>".$goodiesMembre["nomevenement"]."</td>"."<td><form action='./validationGoodies.php' method='POST'>
            <input type='hidden' name='goodies_fourni_sportif_id' value=".$goodiesMembre['email'].">
            <input type='hidden' name='goodies_fourni_event_id' value=".$goodiesMembre['idevenement'].">
            <input style='background-color: #000000;color: white;padding: 5px 5px;margin: 5px 0;border: none;cursor: pointer;width: 100%;opacity: 0.9;' type='submit' value='Valider'></form></td></tr>" ;
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





 ?>
