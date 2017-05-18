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
  // Monstruos's skills
  private $skills;

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
    $monstruo->set('characteristics', $array['characteristics']);
    $monstruo->set('skills', $array['skills']);

    return $monstruo;
  }

  /**
   * Convert Monstruo to Array
   *
   * @return array
   */
  function toArray($value = NULL)  {
    $monstruo = array(
        "_id" => $this->get('_id'),
        "userID" => $this->get('userID'),
        "name" => $this->get('name'),
        "img" => $this->get('img'),
        "characteristics" => $this->get('characteristics'),
        "skills" => $this->get('skills')
    );
    // This is used in javascript functions
    if ($this->get('pos') !== NULL) {
      $monstruo["pos"] = $this->get('pos');
    }
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
   * @return mixed
   */
  public function get($field) {
    return $this->$field;
  }

  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  public function set($field, $value) {
    return $this->$field = $value;
  }

  /**
   * Convert from Monstruo class to JSON
   *
   * @return string
   */
  public function toJSON() {
    $array = $this->toArray();
    $array['_id'] = (string)$array['_id'];
    $array['userID'] = (string)$array['userID'];
    $array = array_filter($array, function($var){return !is_null($var);});
    return json_encode($array, JSON_PRETTY_PRINT);
  }

  public function setStats($stat, $value) {
    $this->characteristics[$stat] = $value;
  }
}