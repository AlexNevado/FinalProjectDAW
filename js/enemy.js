class Enemy {
	constructor() {
    this.x = 800;
    this.y = 200;
    this.img = new Image();
    this.img.src = ;
  }

  draw(ctx) {
      ctx.drawImage(this.img, this.x, 0);
  }

  move(){
    this.x -= 3;
  }
}