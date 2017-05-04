function Monstruo() {
  this._id;
  this.userID;
  this.name;
  this.img;
  this.characteristics = {
      str  : 0,
      def  : 0,
      luk  : 0,
      maxHp: 0,
      hp   : 0
  };
  this.abilities = [];
  this.x = 0;
  this.y = 0;

  this.draw = function ( x = this.x, y = this.y, canvas = '#battleCanvas', img = this.img) {
      $(document).ready(function () {
        $(canvas).drawImage({
          layer: true,
          name : 'monstruo',
          draggable: true,
          source: img,
          x: x, y: y,
          width: 300,
          height: 300,
          fromCenter: false,
          opacity:0.2,
          shadowX: 10, shadowY: 10,
          shadowBlur: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        });
      });
    };
  this.move = function ( x = this.x, y = this.y, canvas = '#battleCanvas') {
    $(document).ready(function () {
      $(canvas).animateLayer('monstruo', {
        x:'+=' + x, opacity: 1
      }, 1500, function(layer) {});
    });
  };
  this.buildWithJson = function (jsonObject) {
    this.id = jsonObject._id;
    this.userID = jsonObject.userID;
    this.name = jsonObject.name;
    this.img = jsonObject.img;
    this.characteristics = jsonObject.characteristics;
    this.abilities = jsonObject.abilities;
  };
  this.set = function (field, value) {
    switch (field) {
      case "_id":
        this._id = value;
        break;
      case "userID":
        this.userID = value;
        break;
      case "name":
        this.name = value;
        break;
      case "img":
        this.img = value;
        break;
      case "characteristics":
        this.characteristics = value;
        break;
      case "abilities":
        this.abilities = value;
        break;
    }
  };
  this.setSTR = function(value) {
    this.characteristics.str = value;
  };
  this.setDEF = function(value) {
    this.characteristics.def = value;
  };
  this.setLUK = function(value) {
    this.characteristics.luk = value;
  };
  this.setHP = function(value) {
    this.characteristics.hp = value;
  };
  this.setMAXHP = function(value) {
    this.characteristics.maxHp = value;
  };
  this.addAbility = function (value) {
    this.abilities.push({abi1 : value});
  }

}