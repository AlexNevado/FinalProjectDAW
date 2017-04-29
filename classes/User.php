<?php

class User extends Entity {
  // User's ID
  private $_id;
  // Username
  private $username;
  // User's facebookID
  private $facebookID;
  //User's monstruos
  private $monstruos = array();

  const DDBB_NAME = "mba";

  const USERS_COLLECTION = "users";

  function __construct() {
  }

  public static function fromArray($array) {
    $user = new User();
    $user->set('_id', $array['_id']);
    $user->set('username', $array['username']);
    $user->set('facebookID', $array['facebookID']);
    $user->set('monstruos', $array['monstruos']);

    return $user;
  }

  function toArray($value) {
    $user = array(
        "_id" => $this->_id,
        "username" => $this->username,
        "facebookID" => $this->facebookID,
        "monstruos" => $this->monstruos);
    $user['password'] = $value;
    return $user;
  }

  function save() {
    return parent::save(self::USERS_COLLECTION, $this->toArray());
  }

  function create($password) {
    return parent::save(self::USERS_COLLECTION, $this->toArray($password));
  }



  public function findById() {
    return parent::findById(self::USERS_COLLECTION, $this->_id);
  }
  public function addMonstruo($monstruoID) {
    $newData = array('monstruos' => array('monstruoID' => $monstruoID));
    return parent::push(self::USERS_COLLECTION,$newData);
  }

  public function findByField($field) {
    $db = self::DDBB_NAME;
    $collectionName = self::USERS_COLLECTION;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array($field => $this->$field), array('password' => 0));
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