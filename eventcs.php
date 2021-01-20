<?php
/**
  * DESCRIPTION OF THE FILE : this file is a class file for the evenement sportif
  * All the attributs of an event is initialized as private variables in order to hash the information and to use object oriented programming to render the site understandable 
  **/
class Event {

  private $idEvenement;
  private $dateEv;
  private $siteWeb;
  private $infos;
  private $goodies;
  private $nomEvenement;

  function __construct(){
    $this->dateEv = NULL;
    $this->siteWeb = NULL;
    $this->infos = NULL;
    $this->goodies = NULL;
    $this->nomEvenement = FALSE;
  }

  public function set_serial_id($serial):void
  {
    $this->idEvenement = $serial;
  }
  public function set_dateEv($date) :void
  {
    $this->dateEv = $date;
  }

  public function set_siteWeb($site) :void
  {
    $this->siteWeb = $site;
  }

  public function set_infos($infos) :void
  {
    $this->infos = $infos;
  }

  public function set_goodies($goody) :void
  {
    $this->goodies = $goody;
  }

  public function set_nomEvenement($nom) :void
  {
    $this->nomEvenement = $nom;
  }

  public function get_eventId(){
    return $this->idEvenement;
  }

  public function get_dateEv()
  {
    return $this->dateEv;
  }

  public function get_siteWeb()
  {
    return $this->siteWeb;
  }

  public function get_infos()
  {
    return $this->infos;
  }

  public function get_goodies()
  {
    return $this->goodies;
  }

  public function get_nomEvenement()
  {
    return $this->nomEvenement;
  }

  public function get_idEvenement()
  {
    return $this->idEvenement;
  }
}

 ?>
