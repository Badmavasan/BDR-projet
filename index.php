<?php
// Get all the events
//$events = getAllevents();
//include('./login.php');
// Get the total number of events
//$total_events = getNumberofEvents();
require('functions.php');
require('DBManager.php');
session_start();

if(!isset($_SESSION['user_logged_in'])){
  $_SESSION['user_logged_in'] = False;
}
if(!isset($_SESSION['type'])){
  $_SESSION['type'] = "";
}
?>

<?=template_header('Evenements',$_SESSION['user_logged_in'],$_SESSION['type'])?>
<?php


  if($_SESSION['user_logged_in']){
    echo <<<EOT
      <center>
        <h3>Hello !
    EOT;
    echo $_SESSION['user_name'];
    echo <<<EOT
        </h3>
      </center>
    EOT;
  }

 ?>
<div class="events content-wrapper">
    <h1>Evenements à venir</h1>
    <p><?=get_number_of_events()?> Evenements</p>
    <div class="events-wrapper">
        <?php
          $events = get_all_events();
          if(!$events){
            echo "Aucun Evenement";
          }
          else{
            foreach ($events as $event):
        ?>
        <a href="./event.php?id=<?=$event['idevenement']?>" class="event">
            <img src="./img/default.jpg?>" width="200" height="200" alt="<?=$event['nomevenement']?>">
            <span class="name"><?=$event['nomevenement']?></span>
            <span class="name"><?=$event['dateev']?></span>
        </a>
      <?php endforeach; } ?>
    </div>
</div>

<?php
  if(isset($_SESSION["type"]) && $_SESSION["type"]=='organisateur'){
    echo <<<EOT
      <button onclick="document.getElementById('id01').style.display='block'" class="btnp effect01 floatingp" target="_blank" style="width:auto;"><span>Ajouter un evenement</span></button>

        <div id="id01" class="modal">

          <form class="modal-content animate" action="./addevent.php" method="post">
            <div class="imgcontainer">
              <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
              <label for="event_name"><b>Nom de l'evenement</b></label>
              <input type="text" placeholder="Nom de l'evenement" name="event_name" required>

              <label for="date"><b>Date</b></label>
              <input type="date" name="date" required>
              <br>
              <label for="description"><b>Description de l'evenement</b></label>
              <input type="text" placeholder="description" name="description" required>

              <label for="siteWeb"><b>Lien du Site Web de l'evenement</b></label>
              <input type="text" placeholder="Site web" name="siteWeb" required>

              <input class="form-check-input" type="checkbox" id="goodies" name="goodies">
                <label class="form-check-label" for="defaultCheck1">
                  Goodies
                </label>
              <input type="submit" class ="btnp" value = "Creer l'evenement">
            </div>
          </form>
        </div>
      EOT;
    }
?>

<?=template_footer()?>
