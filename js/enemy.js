function Enemy() {
  this.x = 800;
  this.y = 200;
  this.img = new Image();
  this.img.src = "";

  this.draw = function (ctx) {
    ctx.drawImage(this.img, this.x, 0);
  }

  this.move = function () {
    this.x -= 3;
  }
}