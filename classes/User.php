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
  //User's items
  private $items;
  //User's coins;
  private $coins;

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
    if (isset($array['facebookID'])) {
      $user->set('facebookID', $array['facebookID']);
    }
    $user->set('monstruos', $array['monstruos']);
    $user->set('items', $array['items']);
    $user->set('coins', $array['coins']);

    return $user;
  }

  /**
   * Convert an User into an array
   *
   * @param $value
   * @return array
   */
  function toArray($value = NULL) {
    $user = array(
        "_id" => $this->get('_id'),
        "username" => $this->get('username'),
        "facebookID" => $this->get('facebookID'),
        "monstruos" => $this->get('monstruos'),
        "items" => $this->get('items'),
        "coins" => $this->get('coins')
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
    $user = Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id'])));
    if(!empty($user)) {
      $user['monstruos'][] = array("_id" => new MongoId($monstruoID), "pos" => count($user['monstruos']));
      $user = User::fromArray($user);
      return $user->save();
    }
    return NULL;
  }

  /**
   * Add items tu user
   *
   * @param $monstruoID
   * @return array
   */
  public function addItems($itemsID, $amount) {
    $exist = FALSE;
    $user = Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id'])));
    if(!empty($user) && isset($user['items'])) {
      foreach ($user['items'] as &$item) {
        if ($item['id'] == $itemsID) {
          $item['amount'] += $amount;
          $exist = TRUE;
          break;
        }
      }
    }

    if (!$exist) {
      $user['items'][] = array(
          "id" => (int)$itemsID,
          "amount" => (int)$amount,
      );
    }
    $user = User::fromArray($user);
    return $user->save();
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

  public function toJSON() {
    $array = $this->toArray();
    $array['_id'] = (string)$array['_id'];
    foreach ($array['monstruos'] as $key => &$monstruoID) {
      $monstruoID = (string)$monstruoID;
    }
    $array = array_filter($array, function($var){return !is_null($var);});
    return json_encode($array);
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
   * Update user data after a battle
   *
   * @param $object
   */
  public function updateData($object) {
    $this->set('coins', $object->coins);
    $items = array();
    foreach ($object->items as $item) {
      if($item->amount > 0){
        $items[]= array(
            'id' => $item->id,
            'amount' => $item->amount
        );
      }
    }
    $this->set('items', $items);
    $this->save();

    $monstruos = getMonstruos();
    foreach ($monstruos as $key => $yourMonstruo){
      $monstruos[$key] = Monstruo::fromArray($yourMonstruo);
    }
    foreach ($object->monstruos as $monstruo) {
      foreach ($monstruos as $key => $yourMonstruo){
        if ($monstruo->id  == (string)$yourMonstruo->get('_id')){
          $monstruos[$key]->setStats('hp', $monstruo->characteristics->hp);
          $monstruos[$key]->save();
        }
      }
    }
  }

}