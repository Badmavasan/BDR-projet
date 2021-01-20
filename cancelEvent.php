<?php
/**
  * DESCRIPTION OF THE BACKEND FILE : the file is responsible of cancelling an Inscription. This page is accessible to users
  * from registeredEvents.php where they choose an event to cancel. This function cancels the event using a function from the DBManager.php and redirects the suer to
  * registeredEvents.php. This happens only if the user is registered and logged in. this page is not available to anyone other than the user once he is logged in 
  **/
  require('./DBManager.php');

  session_start();
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventID = $_POST['cancel_event_id'];
    if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='sportif'){
      if(eventExists($eventID)){
        cancelEvent($eventID,$_SESSION['login_user']);
      }
      header("Location: ./registeredEvents.php");
    }
    else{
      header("Location: ./login.php");
    }
  }

?>
