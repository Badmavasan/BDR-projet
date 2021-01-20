<?php

class participant {
  private $first_name;
  private $last_name;
  private $mail_id;
  private $password;
  private $campus;
  private $association;
  private $association_validation_status;

  function __construct(){
    $this->first_name = NULL;
    $this->last_name = NULL;
    $this->mail_id = NULL;
    $this->password = NULL;
    $this->campus = -1; //-1 because the list value starts from 1
    $this->association = -1;
    $this->association_validation_status = 1;
  }

  public function set_participant_first_name($f_name) :void
  {
    $this->first_name = $f_name;
  }
  public function set_participant_last_name($l_name) :void
  {
    $this->last_name = $l_name;
  }
  public function set_participant_email($mail) :void
  {
    $this->mail_id = $mail;
  }
  public function set_participant_password($pass) :void
  {
    $this->password = $pass;
  }
  public function set_participant_campus($campus) :void
  {
    $this->campus = $campus;
  }
  public function set_participant_association($association) :void
  {
    $this->association = $association;
  }
  public function set_participant_association_confirmation($association_validation_status) :void
  {
    $this->$association_validation_status = $association_validation_status;
  }
  public function get_participant_first_name()
  {
    return $this->first_name;
  }
  public function get_participant_last_name()
  {
    return $this->last_name;
  }
  public function get_participant_email()
  {
    return $this->mail_id;
  }
  public function get_participant_password()
  {
    return $this->password;
  }
  public function get_participant_campus()
  {
    return $this->campus;
  }
  public function get_participant_association()
  {
    return $this->association;
  }
  public function get_participant_association_confirmation()
  {
    return $this->$association_validation_status;
  }
}

 ?>
