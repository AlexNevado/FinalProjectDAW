<?php

class User extends Entity {
  // User's ID
  private $_id;
  // Username
  private $username;
  // User's facebookID
  private $facebookID;
  //User's monstruos
  private $monstruos;

  //Ddbb name
  const DDBB_NAME = "mba";
  //Ddbb collection
  const USERS_COLLECTION = "users";

  function __construct() {
  }

  /**
   * Create an User from an array
   *
   * @param $array
   * @return User
   */
  public static function fromArray($array) {
    $user = new User();
    $user->set('_id', $array['_id']);
    $user->set('username', $array['username']);
    $user->set('facebookID', $array['facebookID']);
    $user->set('monstruos', $array['monstruos']);

    return $user;
  }

  /**
   * Convert an User into an array
   *
   * @param $value
   * @return array
   */
  function toArray($value) {
    $user = array(
        "_id" => $this->get('_id'),
        "username" => $this->get('username'),
        "facebookID" => $this->get('facebookID'),
        "monstruos" => $this->get('monstruos')
    );
    $user['password'] = $value;
    return $user;
  }

  /**
   * Inherit method
   *
   * @return array
   */
  function save() {
    return parent::save(self::USERS_COLLECTION, $this->toArray());
  }

  /**
   * Create an User with password
   *
   * @param $password
   * @return array
   */
  function create($password) {
    return parent::save(self::USERS_COLLECTION, $this->toArray($password));
  }

  /**
   * Inherit method
   *
   * @return array|null
   */
  public function findById() {
    return parent::findById(self::USERS_COLLECTION, $this->get('_id'));
  }

  /**
   * Add monstruo tu user
   *
   * @param $monstruoID
   * @return array
   */
  public function addMonstruo($monstruoID) {
    $newData = array('monstruos' => array('monstruoID' => $monstruoID));
    return parent::push(self::USERS_COLLECTION, $newData);
  }

  /**
   * Find this User by their properties
   *
   * @param $field
   * @return array|null
   */
  public function findByField($field) {
    $db = self::DDBB_NAME;
    $collectionName = self::USERS_COLLECTION;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array($field => $this->get($field)), array('password' => 0));
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