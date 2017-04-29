<?php

abstract class Entity {
  // DDBB's name
  const DDBB_NAME = "mba";

  /**
   * Entity constructor.
   */
  function __construct() {
  }

  /**
   * Save an array into DDBB
   *
   * @param $collectionName
   * @param $array
   *
   * @return array
   */
  public function save($collectionName, $properties) {
    $db = self::DDBB_NAME;
    // This is only for avoid problems with ids, because the id always have to be passed as property
    $properties['_id'] = $properties['_id'] == NULL ? new MongoId() : $properties['_id'];
    // Remove properties with NULL values
    $properties = array_filter($properties, function($var){return !is_null($var);});
    $newData = array('$set' => $properties);
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    // We can save the result in a variable, maybe in the future can be useful
    $collection->update(array("_id" => $properties['_id']), $newData, array('upsert' => TRUE));

    return $newData;
  }

  /**
   * Update an array by push
   *
   * @param $collectionName
   * @param $properties
   * @return array
   */
  public function push($collectionName, $properties) {
    $db = self::DDBB_NAME;

    $properties = array_filter($properties, function($var){return !is_null($var);});
    $newData = array('$push' => $properties);
    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    $collection->update(array("_id" => $this->get('_id')), $newData, array('upsert' => TRUE));
    return $newData;
  }

  /**
   * Find by ID
   *
   * @param $collectionName
   * @param $id
   * @return array|null
   */
  public function findById($collectionName, $id) {
    $db = self::DDBB_NAME;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne(array("_id" => $id), array('password' => 0));
  }

  /**
   * Find method by field and value
   *
   * @param $collectionName
   * @param $arraySearch
   * @return array|null
   */
  static function findOneBy($collectionName, $arraySearch) {
    $db = self::DDBB_NAME;

    $connection = new MongoClient();
    $collection = $connection->$db->$collectionName;
    return $collection->findOne($arraySearch, array('password' => 0));
  }

  /**
   * Get properties
   *
   * @param $field
   * @return mixed
   */
  abstract function get($field);
  /**
   * Set properties
   *
   * @param $field
   * @param $value
   * @return mixed
   */
  abstract function set($field, $value);
  abstract function toArray($value);
  abstract static function fromArray($array);

  /**
   * Convert this object to JSON
   *
   * @return string
   */
  abstract function toJSON();

}