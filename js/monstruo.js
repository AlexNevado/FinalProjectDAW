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

  this.draw = function (opacity = 1, x = 0, y = 0, width = 300, height = 300,index = 9,name ='monstruo', canvas = '#battleCanvas', img = this.img) {
      $(document).ready(function () {
        $(canvas).drawImage({
          layer: true,
          name : name,
          draggable: true,
          source: img,
          index: index,
          x: x, y: y,
          width: width,
          height: height,
          fromCenter: false,
          opacity: opacity,
          shadowX: 10, shadowY: 10,
          shadowBlur: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        });
      });
    };
  this.move = function ( x = 0, y = 0, opacity = 1, canvas = '#battleCanvas') {
    /*
      Example with callback function
     $(document).ready(function () {
     $(canvas).animateLayer('monstruo', {
     x:'+=' + x, opacity: 1
     }, 1500, function(layer) {//calback function});
     });
     */
    $(document).ready(function () {
      $(canvas).animateLayer('monstruo', {
        x:'+=' + x, opacity: opacity
      }, 1500);
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
    this.abilities.push({abi : value});
  }

}