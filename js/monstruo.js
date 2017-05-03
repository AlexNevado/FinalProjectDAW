function Monstruo() {
  this._id;
  this.userID;
  this.name;
  this.img;
  this.characteristics;
  this.abilities;
  this.x = 0;
  this.y = 0;

  this.draw = function (canvas = '#battleCanvas',img = this.img, x = this.x, y = this.y) {
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
          shadowX: 20, shadowY: 5,
          shadowBlur: 5,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        });
      });
    };
  this.move = function (canvas = '#battleCanvas',img = this.img, x = this.x, y = this.y) {
    $(document).ready(function () {
      var $canvas= $(canvas);
      var layer0 = $canvas.getLayer("monstruo");
      layer0.animateLayer()
      $canvas.animateLayer('monstruo', {
        x:'+=200',y: 300,
      }, 1000, function(layer) { // Callback function
        $(this).animateLayer(layer, {
          x: 500,
          opacity: 0.6
        }, 'slow', 'ease-in-out');
      });
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

}