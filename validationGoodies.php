<?php
/**
  * DESCRIPTION BACKEND OF THE FILE : this file is backend file that changes the status of the goodies_fourni using a function from DBManager.php
  * Once the update is done, this file redirects to goodiesFourniValidation.php
  * this page is accessed from goodiesFourniValidation once the organizer chooses to validate goodies for an event registration 
  **/
require('./DBManager.php');
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $mail = $_POST['goodies_fourni_sportif_id'];
    $event = $_POST['goodies_fourni_event_id'];
    goodiesFourni($event, $mail);
    header("location: ./goodiesFourniValidation.php");
  }

 ?>
