<?php
/**
  * DESCRITPION OF THE FILE : DBManager.php
  * This file is used to do all the connection towards the database
  * Every insertion, cancellation, extraction is done through this file
  * This file is not intelligent, it doesnt do any verification.
  * Connection to the datbase is done inside every function and closed inside every function.
  **/

  require('./participant.php');
  require('./eventcs.php');

/**
  * The following function connects to a given database that's constant throught the SI
  * @param doesnt take any parametres
  * @return the connection to the base
  **/
function connexionBase() {
  $server="serveur-etu.polytech-lille.fr";
  $user="bkirouch" ;
  $password="postgres" ;
  $base="sportsbat" ;

  $base=pg_connect("host=$server dbname=$base user=$user password=$password")
        or die('Connexion impossible: '.pg_last_error()) ;
  return $base ;

}
//TODO TO USE THE FOLLOWING TEMPLATE FOR THE METHOD DOCUMENTATION :
/**
  * Method description
  * @param1 Description of param1
  * @param2 Description of param2
  * @return Description of return value if it exists
  **/

  /**
    * In the sign up form the new user has to choose which campus he belongs to
    * @param doesnt take any parameter
    * @return This function returns all the existing campus from siteuniversitaires as an associative array
    **/
  function loadCampuses(){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM siteuniversitaire";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL existence sites universitaires !") ;
    pg_close($conn);
    return  pg_fetch_all($result);
  }

  /**
    * In the sign up form the new user has to choose which association he belongs to
    * @param doesnt take any parameter
    * @return This function returns all the existing campus from siteuniversitaires as an associative array
    **/
  function loadAssociation(){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM assosportive";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL existence associations !") ;
    pg_close($conn);
    return  pg_fetch_all($result);
  }

  /**
    * The following function fetches all the possible answer to the member validation process
    * according to the database there are 3 values and all the 3 values will be fetched
    * @param No paramteres
    * @return associative array of all possible status of the membres who registered for the first time
    **/

  function loadmemberValidation(){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM verifasso";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL existence associations !") ;
    pg_close($conn);
    return  pg_fetch_all($result);
  }

  /**
    * The following function is used to greet the user who has logged in
    * the function gets the name of an user
    * @param1 mail id of the user's name we are searching
    * @return name of the user passed in parameter
    **/

  function getUserName($email){
    $conn = connexionBase();
    $sql_query = "SELECT CONCAT(nom,' ',prenom) as Name from sportif WHERE email='$email'";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL existence sites universitaires !") ;
    pg_close($conn);
    return  pg_fetch_assoc($result);
  }

  /**
    * This function verifies if the new user already exists in the database
    * This avoid duplicate values
    * @param1 user mail id is taken as parameter
    * @return True if the user exists
    * @return False if the user doesnt exist
    **/

  function personExists($mail_id){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM sportif WHERE email='$mail_id'";
    $result = pg_query($conn, $sql_query);
    pg_close($conn);
    if(pg_num_rows($result)>0){
      return True;
    }else{
      return False;
    }
  }

  /**
    * The following function inserts a new sportif into the database
    * Participant is a class which contains all the attributs of a Sportif
    * Usage of class and private variables masks the values
    * @param1 participant (of class participant [sportif])
    * @return void this function inserts into DB.
    * As this function is called for only after verifying ll the obvious errors, there will be no error at this point
    * Hence this function returns void
    **/

  function InsertSportifIntoDB(Participant $participant){
    $conn = connexionBase();
    $first_name=$participant->get_participant_first_name();
    $last_name=$participant->get_participant_last_name();
    $mail_id=$participant->get_participant_email();
    $password=$participant->get_participant_password();
    $campus=$participant->get_participant_campus();
    $association=$participant->get_participant_association();
    $association_validation_status;
    $sql_query = "INSERT INTO sportif(email,password,nom,prenom,refcategorie,refsiteuniversitaire) VALUES ('$mail_id','$password','$last_name','$first_name',$association,$campus)";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL ajout nouveau sportif!");
    pg_close($conn);
  }

  /**
    * The following function verifies the credentials(login information) of a login attempt
    * @param1 user email
    * @param2 user password
    * @param3 table which is the role of the user (Organisateur or Sportif)
    * @return True if the credentials locale_filter_matches
    * @return False if the crendentials don't match
    **/

  function CredentialsVerification($email,$password,$table){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM $table WHERE email = '$email' AND password = '$password'";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL verify credentials");
    pg_close($conn);
    if(pg_num_rows($result)==1){
      return True;
    }else{
      return False;
    }
  }

  /**
    * The following function takes user data as parameter and verifies if the data is not a code in order to avoid clashing with the executing code.
    * @param1 user entered data
    * @return data after verifying ands removing possible errors
    **/

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
    * The following function adds an event into Database
    * @param1 event (of type event as parameter)
    * event is a class that contains all the attributs of an evenementsportif
    * Usage of class and private variables masks the values
    * @return void as this is an insertion function
    * All the necessary verifications are done before ans this function simply inserts
    * a given event into the database
    **/

  function AddEvenementSportif(Event $event){
    $conn = connexionBase();
    $dateEv = $event->get_dateEv();
    $siteWeb = $event->get_siteWeb();
    $infos = $event->get_infos();
    $goodies = $event->get_goodies();
    $nomEvenement = $event->get_nomEvenement();
    $sql_query = "INSERT INTO evenementsportif(nomevenement,dateev,siteweb,infos,goodies) VALUES ('$nomEvenement',CAST('".$dateEv ."' AS DATE),'$siteWeb','$infos',CAST('".$goodies ."' AS BOOLEAN))";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL add event");
    pg_close($conn);
  }

  /**
    * The following function gets the number of events
    * @param doesnt take any parameters
    * @return Int which is the number of events [have to chnage it to upcoming events]
    **/

  function  get_number_of_events(){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM evenementsportif WHERE dateev> CURRENT_DATE";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
    pg_close($conn);
    return pg_num_rows($result);
  }

  /**
    * The following function extracts all the events
    * @param Doesn't take any paramters
    * @return an associative array of all the events [have to chnage to upcoming events]
    **/

  function  get_all_events(){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM evenementsportif WHERE dateev> CURRENT_DATE";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
    pg_close($conn);
    return pg_fetch_all($result);
  }

  /**
    * The following function gets one event base on event id
    * @param1 idevenement fo the evet that we want to extract
    * @param2 evenement exists this function verifies if the event exists in the first place
    * the parameter is passed by reference because we need 2 outputs
    * the second value is just in case to male sure but normally there won't be any error of type : event not found from this function
    * @return associative array of the event (so its easy to extract specific values)
    **/

  function getEventByID($eventID,&$event_exists){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM evenementsportif WHERE idevenement=$eventID";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
    pg_close($conn);
    if(pg_num_rows($result)==1){
      $event_exists = true;
      return pg_fetch_assoc($result);
    }
    else{
      $event_exists = false;
    }
  }

  /**
    * The following function extracts the total number of participants in an event
    * @param1 idevenement fo the event the user chooses
    * @return Int value of the number of participants
    **/

  function getTotalparticipants(){
    $conn = connexionBase();
    $sql_query = "SELECT DISTINCT refsportif FROM inscription JOIN evenementsportif ON inscription.refevenement = evenementsportif.idevenement WHERE dateev>DATEADD(YEAR(GETDATE()),DATEDIFF(YEAR(GETDATE()),0,getdate())-1.0) AND dateev<=DATEADD(YEAR(GETDATE()),DATEDIFF(YEAR(GETDATE()),0,getdate())+1.0)";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
    $res = pg_num_rows($result);
    pg_close($conn);
    return $res;
  }

  /**
    * Fot the bilan statistique we need the number of students participating and number of personnel participating
    * WE SUPPOSE THAT THERE ARE ONLY 2 POSIBILITIES GIVEN THE DB : etudiant, personnel
    * @param1 idevenement of the event we are trying to extract information
    * @param2 categorie : etudiant or peronnel
    * @return Int number of partiicpants in a given event and a given $categorie
    * This function is generalized in order to use the same function for etudinats and personnels
    **/

  function getTotalparticipantBycategorieByEvent($eventID,$categorie){
    $conn = connexionBase();
    $sql_query = "SELECT * FROM inscription JOIN sportif on inscription.refsportif=sportif.email WHERE refevenement=$eventID AND sportif.refcategorie=$categorie";
    $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
    pg_close($conn);
    return pg_num_rows($result);
  }

  /**
    * The following function registered a given user to a given event
    * There aren't any checks available because we suppose that the user only sees the upcoming events
    * @param1 idevenement of the event that the user wishes to register
    * @param2 mail id of the participant
    * @return Insertion function so void return
    **/

  function inscription($eve_id, $mail_id){
      $conn=connexionBase();
      $sql_query="INSERT INTO inscription(refevenement,refsportif) values ($eve_id, '$mail_id')";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
      pg_close($conn);
  }

  /**
    * The following function extracts all the event details that the user has registered to (Evenements aux quelles l'utilisateur s'est inscrit)
    * @param mail id of the user
    * @return associative array of all the events that the given user has registered to
    **/

  function getRegisteredEvents($mail_id){
      $conn=connexionBase();
      $sql_query="SELECT idevenement,nomevenement,dateev,siteweb FROM sportif join inscription on sportif.email = inscription.refsportif join evenementsportif on inscription.refevenement = evenementsportif.idevenement  WHERE sportif.email='$mail_id'";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
      pg_close($conn);
      return pg_fetch_all($result);
  }

  /**
    * The following function verifies if a given user is registered to a given event
    * This function is used to avoid duplicate entries in the inscription table
    * @param1 idevenement of the event we are trying to find coherence
    * @param2 mail id of the participant of whom we are trying to find the coherence
    * @return true if the user is alredy registered to the given event
    * @return false if the user is not registered to the given event
    * This also avoids SQL ERROR during the inscription function
    **/

  function verificationInscriptionExiste($eventID,$user){
      $conn=connexionBase();
      $sql_query="SELECT * FROM inscription WHERE refevenement=$eventID AND refsportif='$user'";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
      pg_close($conn);
      if(pg_num_rows($result)!=0){
        return true;
      }
      else{
        return false;
      }
  }

  /**
    * The following function cancels an inscription (registration)
    * @param1 idevenement of the event is taken in as parameter
    * @param2 mail id of the user is taken in as parameter
    * @return void as this function just removes a value.
    * the verifications are done before so when this function is called for, it does the job.
    **/

  function cancelEvent($eve_id, $mail_id){
      $conn=connexionBase();
      $sql_query="DELETE FROM inscription WHERE refsportif='$mail_id' AND refevenement=$eve_id";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
      pg_close($conn);
  }

  /**
    * Context: This function is used to get all the sportif who's association is not validated yet
    * The following function extracts all the non verified users in order to display it in the organizer's page
    * So that the organizer can validate it
    * @param now paramteres taken
    * @return associative array of values which is used to display for the association validation
    * so the name and the association, id is also collected in order to validate the user
    **/

  function membreNonValide(){
      $conn=connexionBase();
      $sql_query="SELECT sportif.email,sportif.nom, sportif.prenom, assosportive.libelle from sportif join verifasso on sportif.etatmembre=verifasso.id join assosportive on sportif.refcategorie=assosportive.idcategorie where verifasso.id=1";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
        pg_close($conn);
        return pg_fetch_all($result);
  }

  /**
    * Context: the organizer has to validate if goodies have been sent to registration or not
    * @param doesnt take any paramteres
    * @return associative array of all the registrations that havent recieved their goodies yet
    * Only to the events where goodies are given
    **/

  function listeGoodies(){
      $conn=connexionBase();
      $sql_query="SELECT sportif.email,evenementsportif.idevenement,sportif.nom, sportif.prenom ,evenementsportif.nomevenement from sportif join inscription on sportif.email=inscription.refsportif join evenementsportif on inscription.refevenement = evenementsportif.idevenement where inscription.goodies_fourni=false AND evenementsportif.goodies=true";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
        pg_close($conn);
        return pg_fetch_all($result);
  }
  /**
    * The following function veriofies if an event exists with a given event id
    * @param1 idevenement passed in parameter
    * @return True if the given event id exists in the evenementsportif table
    * @return false if it does not exist
    **/
    function eventExists($event_id){
      $conn=connexionBase();
      $sql_query="SELECT * FROM evenementsportif WHERE idevenement=$event_id";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
      pg_close($conn);
      if(pg_num_rows($result)==1){
        return true;
      }
      else{
        return false;
      }
    }
    /**
      * The fiollowing function gets all the registered users to a selected event
      * @param1 idevenement of the event
      * @return name and association of all the users registered to the event passed in parameter
      **/
    function getRegisteredUsers ($eve){
        $conn=connexionBase();
        $sql_query="SELECT nom, prenom, assosportive.libelle from sportif join assosportive on sportif.refcategorie=assosportive.idcategorie join inscription on inscription.refsportif = sportif.email join evenementsportif on inscription.refevenement =evenementsportif.idevenement  where evenementsportif.idevenement=$eve";
        $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
        pg_close($conn);
        return pg_fetch_all($result);
    }
    /**
      * The following function changes the value of the goodies fourni once the goodies are given to the sportif
      * @param1 event id of the registered event
      * @param2 mail id of the sportif who registered to the event
      * @return void the function just updates the database, nothing to verify or return
      **/
    function goodiesFourni($eve, $mail_id){
      $conn=connexionBase();
      $sql_query="UPDATE inscription set goodies_fourni=true where refevenement= $eve and refsportif='$mail_id'";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
        pg_close($conn);
        return pg_fetch_all($result);
    }

    /**
      * The following function changes the value of the member status in the database
      * @param1 user mail id who's member status has been changed
      * @param2 value that is to be replaced. there arent many values possible vbecause the option is given as a dropdown
      * @return This function directly updates the database so nothing to return
      **/

    function validationMembre($mail_id,$value){
      $conn=connexionBase();
      $sql_query="UPDATE sportif set etatmembre=$value WHERE email='$mail_id'";
      $result = pg_query($conn, $sql_query) or die("Erreur SQL count event");
        pg_close($conn);
        return pg_fetch_all($result);
    }
  ?>
