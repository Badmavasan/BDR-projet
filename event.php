<?php
  /**
    * DESCRIPTION OF THE FILE : this file displays each event specicfically, this function uses a href link from the index.php page that redirects towards a site of the veent based on the event id
    * Once the event id is taken using get method, via the connection to the Database, we get all the necessary information on the event in order to display them
    * This file uses functions from functions.php for the header and template_footer
    * This page uses DBManger.php functions in order to retrieve data from the Database
    * This page also containe the feature to be able in register to an event
    * This page checks if the user is logged in or not, if the user is logged in then the registration to the event is done automatically
    * If the user is not logged in then in order to register to the event, the user is redirected to the login page
    * This feature avoids the registered user to type anything and registers to an event by doing the link by itself.
    **/
  session_start();
  include('./functions.php');
  require('DBManager.php');
  // Check to make sure the id parameter is specified in the URL
  if (isset($_GET['id'])) {
      $eventID = $_GET['id'];
      $event_exists=False;
      $event = getEventById($eventID,$event_exists);
      if ($event_exists) {
        $totalParticipant = getTotalparticipants();
        $totalEtudiant = getTotalparticipantBycategorieByEvent($eventID,2);
        $totalPersonnel = getTotalparticipantBycategorieByEvent($eventID,1);
        if(!isset($_SESSION['user_logged_in'])){
          $_SESSION['user_logged_in'] = False;
        }
        if(!isset($_SESSION['type'])){
          $_SESSION['type'] = "";
        }
      }else{
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Event does not exist!');
      }
  } else {
      // Simple error to display if the id wasn't specified
      exit('Event does not exist 2');
  }
  ?>

  <?=template_header('Event',$_SESSION['user_logged_in'],$_SESSION['type'])?>
  <div class="event content-wrapper">
    <img src="img/default.jpg" width="500" height="500" alt="<?=$event['nomevenement']?>">
      <div class="fixeddivp">
          <h1 class="name"><?=$event["nomevenement"]?></h1>
          <h2 class="name"><?=$event['dateev']?></h2>
          <div class="description">
            <p>
              <?=$event['infos']?>
            </p>
            <p>
              <?=$event['siteweb']?>
            </p>
          <?php if($_SESSION['type']=='organisateur'){ ?>
            <p>
              <b>
                Nombre total de participants :
              <?=$totalParticipant?>
             </b>
            </p>
            <p>
              <b>
                Nombre total d'étudiants :
              <?=$totalEtudiant?>
             </b>
            </p>
            <p>
              <b>
                Nombre total des membres du Personnel :
              <?=$totalPersonnel?>
             </b>
            </p>
            <form action="./registeredUsers.php" method="post">
                <input type="hidden" name="event_id" value="<?=$event['idevenement']?>">
                <input type="submit" value="Consulter les inscriptions">
            </form>
          <?php }else{?>
            <form action="./registerEvent.php" method="post">
                <input type="hidden" name="event_id" value="<?=$event['idevenement']?>">
                <input type="submit" value="S'inscrire a l'evenement">
            </form>
          <?php } ?>
          </div>
      </div>
  </div>

<?=template_footer()?>
