<?php
include 'functions.php';
$user = getUser();
$itemList = Entity::findOneBy("miscellaneous", array());
$itemList = $itemList['items'];
$userItemList = $user->get('items');
// Compare itemList with user item ID list
foreach ($itemList as $item) {
  foreach ($userItemList as $key => $userItem) {
    if ($userItem['id'] == $item['id']) {
      $userItemList[$key] = array_merge($userItem, $item);
    }
  }
}
$div="";
foreach ($userItemList as $item) {
  $div .='<div class="row">
    <img src="' . $item["img"] . '" class="col-xs-2 img-responsive itemPic"/>
    <div class="col-xs-4">
      <h4>' . $item["name"] . '</h4>
    </div>
    <div class="col-xs-4">
      <p>Uds x' . $item["amount"] . '</p>
    </div>
  </div>';
}
echo $div;
