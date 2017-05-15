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
  this.skills = [];
  this.layer;
  this.pos;

  this.draw = function (opacity = 1, name ='monstruo', img = this.img, x = 0, y = 0, width = 300, height = 300,index = 9,groups = "battle", canvas = '#battleCanvas') {
    this.layer = name;
    $(document).ready(function () {
        $(canvas).drawImage({
          layer: true,
          name : name,
          groups: [groups],
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
  this.move = function ( x = 0, y = 0, opacity = 1,width = 0, height = 0, delay = 0,layer = this.layer, canvas = '#battleCanvas') {
    $(document).ready(function () {
      $(canvas).delay(delay).animateLayer(layer, {
        x: '+=' + x,
        y: '+=' + y,
        opacity: opacity,
        width: '+=' + width,
        height: '+=' + height,
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
    this.skills = jsonObject.skills;
    this.pos = jsonObject.pos;
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
      case "skills":
        this.skills = value;
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
    hp = hp >= this.characteristics.maxHp? this.characteristics.maxHp : hp;
    hp = hp <= 0? 0 : hp;
    this.characteristics.hp = hp;
  };
  this.setMAXHP = function(value) {
    this.characteristics.maxHp = value;
  };
  this.addskill = function (value) {
    this.skills.push(value);
  }

}