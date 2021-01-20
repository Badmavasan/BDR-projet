<?php

require('DBManager.php');

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventID = $_POST['event_id'];
    if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && $_SESSION['type']=='sportif'){
      //verification s'il est deja inscrit ou pas
      // s'il est deja inscrit redirection vers registeredEvents
      if(!verificationInscriptionExiste($eventID,$_SESSION['login_user'])){
        inscription($eventID,$_SESSION['login_user']);
        header("Location: ./registeredEvents.php");
      }else{
        //Message using session saying existe deja
        header("Location: ./registeredEvents.php");
      }

    }
    else{
      header("Location: ./login.php");
    }
  }

?>
