<?php
  include('./functions.php');
  require('./DBManager.php');

  session_start();
  if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='sportif'){
    template_header('Evenement inscrit',$_SESSION['user_logged_in'],$_SESSION['type']);
    echo <<<EOT
      <div class="col-6">
        <h1 id="listeEvenementsInscrit" > Liste Evenement inscrit</h1>
    EOT;
    $registeredEvents=getRegisteredEvents($_SESSION['login_user']);
    echo <<<EOT
      <table class="table table-bordered table-striped">
        <thead class="thead-dark"><tr><th>Nom Evenement</th><th>Date</th><th>Site Web</th><th>Annulation</th></tr></thead>
        <tbody>
    EOT;
    if(!$registeredEvents){
      echo "Aucun événement inscrit";
    }
    else{
      foreach($registeredEvents as $registeredEvent)
        echo "<tr><td>".$registeredEvent["nomevenement"]."</td><td>".$registeredEvent["dateev"].
            "</td><td>".$registeredEvent["siteweb"]."</td>"."<td>".
            "<form action='./cancelEvent.php' method='post'>
            <input type='hidden' name='cancel_event_id' value=".$registeredEvent["idevenement"].">
            <input style='background-color: #000000;color: white;padding: 5px 5px;margin: 5px 0;border: none;cursor: pointer;width: 100%;opacity: 0.9;' type='submit' value='Annuler'>
            </form></td>
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

?>
