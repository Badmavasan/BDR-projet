<?php
/**
  * DESCRIPTION OF THE BACKEND FILE : this is a backend file that contains 2 function : header function that displays the header of every possible page in this SI
  * Then the footer function which is practically always there
  * The header changes according to the user info, if the user if user then the header is different, if user is organisateur then he has more features
  * if its no one then they have less features this is handled using sessions this are created in the login stage, if there are no sessions created then the user has the basic site
  * This file is added in most of the web pages in order to have the header and footer
  * Using such a file avoids duplicating the same code again and again 
  **/

  function template_header($title,$user_logged_in,$user_type) {
  echo <<<EOT
  <!DOCTYPE html>
  <html>
  	<head>
  		<meta charset="utf-8">
  		<title>$title</title>
  		<link href="styling.css" rel="stylesheet" type="text/css">
  		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  	</head>
  	<body>
          <nav class="navbar navbar-custom">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="./index.php">Universite Lille</a>
              </div>
              <ul class="nav navbar-nav">
                <li class="active"><a href="./index.php"><b>Home</b></a></li>
              </ul>
  EOT;
  if(!$user_logged_in){
    echo <<<EOT
              <ul class="nav navbar-nav navbar-right">
                <li><a href="./signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="./assistance.php"><i class="bi bi-question-circle" style="font-size: 1.75rem;"></i> Assistance</a></li>
              </ul>
            </div>
          </nav>
          <main>
    EOT;
  }
  elseif($user_logged_in) {
    echo <<<EOT
              <ul class="nav navbar-nav navbar-right">
    EOT;
    if($user_type == 'organisateur'){
      echo <<<EOT
                  <li><a href="./membreValidation.php">Membre Validation</a></li>
                  <li><a href="./goodiesFourniValidation.php">Fourniture des Goodies</a></li>
      EOT;
    }
    if($user_type =='sportif'){
      echo <<<EOT
                  <li><a href="./registeredEvents.php">Mes Inscriptions</a></li>
      EOT;
    }
    echo <<<EOT
                <li><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <li><a href="./assistance.php"><i class="bi bi-question-circle" style="font-size: 1.75rem;"></i> Assistance</a></li>
              </ul>
            </div>
          </nav>
          <main>
    EOT;
  }

}


  // Template footer
  function template_footer() {
  echo <<<EOT
          </main>
          <footer>
              <div class="content-wrapper">
                  <p>&copy; Rim | Badmavasan Universite de Lille</p>
              </div>
          </footer>
      </body>
  </html>
  EOT;
  }
?>
