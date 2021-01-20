<?php

require('./DBManager.php');
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    validationMembre($_POST['validate_email_id'],$_POST['validationAnswer']);
    header("location: ./membreValidation.php");
}
?>
