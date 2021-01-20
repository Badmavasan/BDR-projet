<?php
  require('./DBManager.php');

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    $event = new Event;
    $event->set_dateEv(test_input($_POST["date"]));
    $event->set_nomEvenement(test_input($_POST["event_name"]));
    $event->set_siteWeb(test_input($_POST["siteWeb"]));
    $event->set_infos(test_input($_POST["description"]));
    if(isset($_POST['goodies']) && $_POST['goodies']!=""){
      $event->set_goodies(1);
    }
    else{
      $event->set_goodies(0);
    }
    $number_of_events = get_number_of_events();
    AddEvenementSportif($event);

    if(get_number_of_events() > $number_of_events){
      header("location: ./index.php");
    }
    else{
      echo "Error occured during insertion recheck and retry" ;
      echo <<<EOT
        <div>
          <a href="./index.php"><u>Retourner a l'acceuil</u></a>
        </div>
      EOT;
    }
  }

?>
