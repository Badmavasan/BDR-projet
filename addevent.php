<?php
/**
  * DESCRIPTION OF THE BACKEND FILE : this file is called for when an event is to be added from index.php (which only organizers can do)
  * this page is accessible only from the index.php page because of the if server requestion method condition
  * This script uses DBManager.php functions in order to insert values into Database as well as fetch information from database
  * This function uses event class in order to keep the attributs private and use public class functions to retrieve the values
  **/
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

    if(get_number_of_events() > $number_of_events){ // if the number of events inscreased then the event has been added this only works because you cant cancel an event
      header("location: ./index.php");              // if you were able to cancel an event simeltenously as an insertion then this wouldn't work
    }
    else{ // if there was an error, the block shows the user that there has been an error and gives the possibility to get back to home page but this doesnt show the error : so contact assistance to know why because the posibility of having an error here is low
      echo "Error occured during insertion recheck and retry" ;
      echo <<<EOT
        <div>
          <a href="./index.php"><u>Retourner a l'acceuil</u></a>
        </div>
      EOT;
    }
  }

?>
