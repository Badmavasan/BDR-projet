<?php
session_start();
include('./functions.php');
require('DBManager.php');
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    $eventID = $_GET['id'];
    $event_exists=False;
    $event = getEventById($eventID,$event_exists);
    if ($event_exists) {
      $totalParticipant = getTotalparticipantByID($eventID);
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
        <?php if($_SESSION['type']=='organisateur'){ ?>
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
