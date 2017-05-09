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

  this.draw = function (opacity = 1, name ='monstruo', img = this.img, x = 0, y = 0, width = 300, height = 300,index = 9, canvas = '#battleCanvas') {
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
          shadowBlur: 2,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        });
      });
    };
  this.move = function ( x = 0, y = 0, opacity = 1, canvas = '#battleCanvas') {
    $(document).ready(function () {
      $(canvas).animateLayer('monstruo', {
        x:'+=' + x, opacity: opacity
      }, 1500);
    });
  };
  this.attackAnimation = function (layer = 'monstruo', canvas = '#battleCanvas') {
    $(document).ready(function () {
      $(canvas).animateLayer(layer, {
        x:'-=10'
      }, 'fast').animateLayer(layer, {
        x:'+=20'
      }, 'fast').animateLayer(layer, {
        x:'-=10'
      }, 'fast');
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
    var hp = this.characteristics.hp + value;
    hp = hp > this.maxHp? maxHp : hp;
    hp = hp < 0? 0 : hp;
    this.characteristics.hp = hp;
  };
  this.setMAXHP = function(value) {
    this.characteristics.maxHp = value;
  };
  this.addAbility = function (value) {
    this.abilities.push(value);
  }

}