<?php
/**
  * DESCRIPTION OF THE BACKEND FILE : the file just validates the member status by updating the value in the database using a function of the DBManager.php
  * Once the member's status is updated, the page redirects to the membreValidation.php page 
  **/
require('./DBManager.php');
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    validationMembre($_POST['validate_email_id'],$_POST['validationAnswer']);
    header("location: ./membreValidation.php");
}
?>
