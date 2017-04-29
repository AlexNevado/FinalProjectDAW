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
  private $characteristics;
  // Monstruos's abilities
  private $abilites;

  //Ddbb name
  const DDBB_NAME = "mba";
  //Ddbb collection
  const MONSTRUOS_COLLECTION = 'monstruos';

  /**
   * Monstruo constructor.
   */
  function __construct()  {
  }

  /**
   * Create Monstruos from Array
   *
   * @param $array
   * @return Monstruo
   */
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

  /**
   * Convert Monstruo to Array
   *
   * @return array
   */
  function toArray()  {
    $monstruo = array(
        "_id" => $this->get('_id'),
        "userID" => $this->get('userID'),
        "name" => $this->get('name'),
        "img" => $this->get('img'),
        "characteristics" => $this->get('characteristics'),
        "abilities" => $this->get('abilites')
    );
    return $monstruo;
  }

  /**
   * Inherit method
   *
   * @return array
   */
  function save() {
    return parent::save(self::MONSTRUOS_COLLECTION, $this->toArray());
  }

  /**
   * Inherit method
   *
   * @return array|null
   */
  public function findById() {
    return parent::findById(self::USERS_COLLECTION, $this->get('_id'));
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