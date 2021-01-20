<?php
require('./DBManager.php');
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $mail = $_POST['goodies_fourni_sportif_id'];
    $event = $_POST['goodies_fourni_event_id'];
    goodiesFourni($event, $mail);
    header("location: ./goodiesFourniValidation.php");
  }

 ?>
