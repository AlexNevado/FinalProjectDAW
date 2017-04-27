<?php

class Entity {
  // DDBB's name
  const DDBB_NAME = "mba";

  function __construct()  {
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
      if ($key == NULL) {
        unset($properties[$key]);
      }
    }
    array_filter($properties, function($var){return !is_null($var);} );
    $newData =array('$set' => $properties);
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    $error = $collection->update(array("_id" => $properties['_id']), $newData, array('upsert' => TRUE));

    return $properties;
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

  /**
   * Convert this object to JSON
   *
   * @return string
   */
  function toJSON()  {
    return json_encode($this);
  }

}