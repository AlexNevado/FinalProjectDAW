function User() {
  this.id;
  this.username;
  this.coins;
  this.items;
  this.monstruos;

  this.buildWithJson = function (jsonObject) {
    this.id = jsonObject.id;
    this.username = jsonObject.username;
    this.coins = jsonObject.coins;
    this.items = jsonObject.items;
    this.monstruos = jsonObject.monstruos;
  };
  this.addCoins = function (coins) {
    this.coins += coins;
  }
}