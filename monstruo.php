<?php

class Monstruo {
  public $_id;
  public $userID;
  public $name;
  public $img;
  public $characteristics = array();
  public $abilites = array();

  function toArray() {
    $monstruo = array(
        "_id"=> new MongoId($this->_id),
        "userID" => new MongoId($this->userID),
        "name" => $this->name,
        "characteristics" => $this->characteristics,
        "abilities" => $this->abilites);
    return $monstruo;
  }

  function toJSON() {

  }

}