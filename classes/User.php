<?php

class User extends Entity {
  // User's ID
  public $_id;
  // Username
  public $username;
  // User's facebookID
  public $facebookID;
  //User's monstruos
  public $monstruos = array();

  const DDBB_NAME = "mba";

  const USERS_COLLECTION = "users";

  function __construct() {
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
    return parent::Save();
  }

  public function findByField($field) {
    $db = self::DDBB_NAME;
    $collectionName = self::USERS_COLLECTION;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array($field => $this->$field), array('password' => 0));
  }
}