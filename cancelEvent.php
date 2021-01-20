<?php
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
