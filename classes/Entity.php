<?php

abstract class Entity {
  // DDBB's name
  const DDBB_NAME = "mba";

  function __construct() {
  }

  /**
   * @param $collectionName
   * @param $array
   *
   * @return array
   */
  public function save($collectionName, $properties) {
    $db = self::DDBB_NAME;
    $properties['_id'] = $properties['_id'] == NULL ? new MongoId() : $properties['_id'];
    foreach ($properties as $key => $value) {
      if ($value == NULL) {
        unset($properties[$key]);
      }
    }
    //array_filter($properties, function($var){return !is_null($var);} );
    $newData = array('$set' => $properties);
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    $error = $collection->update(array("_id" => $properties['_id']), $newData, array('upsert' => TRUE));

    return $properties;
  }

  public function push($collectionName, $properties) {
    $db = self::DDBB_NAME;

    $newData = array('$push' => $properties);
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    $error = $collection->update(array("_id" => $properties['_id']), $newData, array('upsert' => TRUE));
  }

  public function findById($collectionName, $id) {
    $db = self::DDBB_NAME;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array("_id" => $id), array('password' => 0));
  }

  static function findOneBy($collectionName, $arraySearch) {
    $db = self::DDBB_NAME;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne($arraySearch, array('password' => 0));
  }


  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  abstract function set($field, $value);

  /**
   * @param $field
   * @return mixed
   */
  abstract function get($field);

  /**
   * Convert this object to JSON
   *
   * @return string
   */
  function toJSON() {
    return json_encode($this);
  }

}