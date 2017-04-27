<?php

class Monstruo extends Entity {

  // Monstruo's ID
  public $_id;
  // User's ID
  public $userID;
  // Monstruo's name
  public $name;
  // Monstruo's image source
  public $img;
  // Monstruo's characteristics
  public $characteristics = array();
  // Monstruos's abilities
  public $abilites = array();

  const DDBB_NAME = "mba";

  const MONSTRUOS_COLLECTION = 'monstruos';

  function __construct()  {
  }

  function toArray()  {
    $monstruo = array(
        "_id" => $this->_id,
        "userID" => $this->userID,
        "name" => $this->name,
        "img" => $this->img,
        "characteristics" => $this->characteristics,
        "abilities" => $this->abilites);
    return $monstruo;
  }

  function save() {
    return parent::save(self::MONSTRUOS_COLLECTION, $this->toArray());
  }

  public function findById() {
    return parent::findById(self::USERS_COLLECTION, $this->_id);
  }

}