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
  public function save($collectionName, $array) {
    $db = DDBB_NAME;
    $id = $array['_id'] == NULL ? new MongoId() : $array['_id'];
    
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    $collection->update(array("_id" => $id), array('$set' => $array), array('upsert' => TRUE));

    return $array;
  }

  public function findById($collectionName, $id) {
    $db = DDBB_NAME;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array("_id" => $id), array('password' => 0));
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