<?php
/**
  * DESCRIPTION OF THE FILE : this file displays all the events that the user has registered to, only participants (sportif) can register to events
  * this page will be accessible only to sportif where they can consult the events they registered to. if condition verifies if the user is logged in, if the user if not logged in
  * then the user is redirected to login page, but normal users dont usually have the graphic possibility to access this page
  * if they try to access it using the url then they are redirected to the login page
  * This pages uses DBManager.php in order to fetch all the even the user havs registered to using his mail id which is available in the SESSION array
  * The output is done via table which is not ideal as they are not dyanmic when the page is accessed from a mobile phone
  * This page uses functions.php in order to get the header and the function of the page as this page contains a display 
  **/
  include('./functions.php');
  require('./DBManager.php');

  session_start();
  if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='sportif'){
    template_header('Evenement inscrit',$_SESSION['user_logged_in'],$_SESSION['type']);
    echo <<<EOT
      <div class="col-6">
        <h1 id="listeEvenementsInscrit">Mes Inscriptions</h1>
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
