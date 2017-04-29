<?php

class Monstruo extends Entity {

  // Monstruo's ID
  private $_id;
  // User's ID
  private $userID;
  // Monstruo's name
  private $name;
  // Monstruo's image source
  private $img;
  // Monstruo's characteristics
  private $characteristics = array();
  // Monstruos's abilities
  private $abilites = array();

  const DDBB_NAME = "mba";

  const MONSTRUOS_COLLECTION = 'monstruos';

  function __construct()  {
  }

  public static function fromArray($array) {
    $monstruo = new Monstruo();
    $monstruo->set('_id', $array['_id']);
    $monstruo->set('userID', $array['userID']);
    $monstruo->set('name', $array['name']);
    $monstruo->set('img', $array['img']);
    $monstruo->set('$characteristics', $array['$characteristics']);
    $monstruo->set('$abilites', $array['$abilites']);

    return $monstruo;
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

  /**** Getters & Setters ****/

  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  public function set($field, $value) {
    return $this->$field = $value;
  }

  /**
   * @param $field
   * @return mixed
   */
  public function get($field) {
    return $this->$field;
  }
}