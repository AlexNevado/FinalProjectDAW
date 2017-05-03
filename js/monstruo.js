function Monstruo(_id, userID, name, img, characteristics, abilities) {
  this._id = _id;
  this.userID = userID;
  this.name = name;
  this.img = img;
  this.characteristics = characteristics;
  this.abilities = abilities;
  this.x = 214;
  this.y = 240;

  this.draw = function (ctx) {
    var monstruo = new Image();
    monstruo.src = this.img;
    monstruo.onload = function () {
      ctx.drawImage(monstruo, 0, 20, tWidth, tHeight, 300, 0, tWidth, tHeight);

    }
  }

  this.move = function () {
    this.x -= 3;
  }
}