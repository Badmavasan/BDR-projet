<?php
/**
  * DESCRIPTION OF THE FILE : the file logs out the user
  * destrosy the session and resets the value of SESSION array to null 
  **/
  session_start();

  if(session_destroy()){
    session_unset();
    header("location: ./index.php");
  }


 ?>
