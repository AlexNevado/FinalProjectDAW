function drawImage(imgSrc = 'image/panel1.png', x = 0, y = 300, width = 800, height = 180, name = "panel", index = 0, opacity = 1) {
  $(document).ready(function () {
    $(canvasID).drawImage({
      layer: true,
      name: name,
      draggable: true,
      opacity: opacity,
      source: imgSrc,
      x: x, y: y,
      index: index,
      width: width,
      height: height,
      fromCenter: false
    });
  });
}

function startBattle() {
  $(document).ready(function () {
    enemy.draw(0);
    var enemy0 = new Monstruo();
    enemy0.draw(0, 'mDamage1', enemy.img.substr(0, enemy.img.length - 4) + "2.png", 300, 0, 300, 300, 12);
    drawPanels(canvasID);
    enemy.move(300);
    yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 15);
    if (yourMonster.characteristics.luk > enemy.characteristics.luk) {
      showMenu();
    } else if (first) {
      showMenu();
    } else {
      messages("Esperando al oponente...");
    }
  });
}

function endBattle() {
  $(document).ready(function () {
    setTimeout(function () {
      drawImage("image/background12.jpg", 0, 0, 640, 480, "end", 20, 0.5);
      $('#end-screen').show();
      if (yourMonster.characteristics.hp > enemy.characteristics.hp) {
        $('#end-message').html("¡Has Vencido!");
      } else {
        $('#end-message').html("¡Has Perdido!");
      }
    }, 1000);
  });
}

/**
 *Show menus
 */
function showMenu() {
  $(document).ready(function () {
    $('#menuBattle').delay(1000).fadeIn(600);
  });
}

/**
 * Hide menus
 */
function hideMenu() {
  $(document).ready(function () {
    $('#menuBattle').fadeOut(600);
    $('#menuSkills').delay(1000).fadeIn(600);
  });
}

/**
 * Draw the panels
 */
function drawPanels(canvasID) {
  $(document).ready(function () {
    drawImage();
    drawImage("image/empty-bar.png", 50, 50, 300, 20, "empty-bar1", 1);
    drawImage("image/bar.png", 50, 50, 300 * percentageHp(enemy), 20, "bar1", 2);
    drawImage("image/empty-bar.png", 10, 320, 200, 20, "empty-bar2", 3);
    drawImage("image/bar.png", 10, 320, 200 * percentageHp(yourMonster), 20, "bar2", 4);
    drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 20, 0);
    drawImage('image/panel2.jpg', 0, 0, 640, 480, "panel2", 6, 0);
  });
}

/**
 *Calculate percentage of Hp
 **/
function percentageHp(monstruo) {
  return monstruo.characteristics.hp / monstruo.characteristics.maxHp;
}

/**
 * Create randon enemy
 */
function randomEnemy(mode) {
  var level = mode == "easy" ? 1 : mode == "middle" ? 2 : 5;
  var enemy = new Monstruo();
  enemy.set("_id", "0");
  enemy.set("userID", "CPU");
  enemy.set("name", "enemyXYZ");
  var img;
  switch (randomInt(0, 6)) {
    case 0:
      img = "image/monstersAvatars/DivineGuardian.png";
      break;
    case 1:
      img = "image/monstersAvatars/Dragon.png";
      break;
    case 2:
      img = "image/monstersAvatars/Goblin.png";
      break;
    case 3:
      img = "image/monstersAvatars/Harpy.png";
      break;
    case 4:
      img = "image/monstersAvatars/Lichlord.png";
      break;
    case 5:
      img = "image/monstersAvatars/LordofViolence.png";
      break;
    case 6:
      img = "image/monstersAvatars/Naga.png";
      break;
  }
  var maxHp = randomInt(20, 50) * level;
  enemy.set("img", img);
  enemy.setSTR(randomInt(1, 5) * level);
  enemy.setDEF(randomInt(1, 5) * level);
  enemy.setLUK(randomInt(1, 5) * level);
  enemy.setMAXHP(maxHp);
  enemy.setHP(maxHp);
  enemy.addskill(1);
  enemy.addskill(3);
  return enemy;
}

/**
 * Create random integer
 */
function randomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
}

/**
 * Show messages
 */
/*
 *     function messages(text="", x = 150, y = 150, width = 350, height = 200
 , name = "message", index = 10, opacity = 1,imgSrc = 'image/message.png', canvas = '#battleCanvas') {
 * */
function messages(text = "Has perdido", x = 0, y = 0, width = 640, height = 480
    , name = "message", index = 10, opacity = 0.5, imgSrc = 'image/background12.jpg') {
  $(document).ready(function () {
    $(canvasID).drawImage({
      layer: true,
      name: name,
      draggable: true,
      opacity: opacity,
      source: imgSrc,
      x: x, y: y,
      index: index,
      width: width,
      height: height,
      fromCenter: false,
    });
  });
}

/**
 * Get an skill by their id
 */
function getskill(id) {
  var skill;
  skillsList.forEach(function (object) {
    if (object.id == id) {
      skill = object;
    }
  });
  return skill;
}

/**
 * Get an item by their id
 */
function getItem(id) {
  var item;
  itemsList.forEach(function (object) {
    if (object.id == id) {
      item = object;
    }
  });
  return item;
}

/**
 * Do player action
 */
function doAction(action, string) {
  switch (action) {
    case "skill":
      skillsList.forEach(function (skill) {
        if (skill.name === string) {
          attack(yourMonster, enemy, skill);
        }
      });
      break;
    case "item":
      itemsList.forEach(function (item) {
        if (item.name === string) {
          useItem(item);
        }
      });
      break;
    case "change":
      createMenuList();
      break;
  }
}

/**
 * Attack an enemy
 */
function attack(attacker, defender, skill) {
  //Critical double the attack power if you have enough luk
  //and can make you miss an attack
  var random = randomInt(attacker.characteristics.luk, 40);
  var critical = random > 30 ? 2 : random < 5 ? 0 : 1;
  var newHp = (defender.characteristics.def - attacker.characteristics.str - skill.power) * critical;
  if (newHp < 0) {
    defender.setHP(newHp);
    var animation = attacker == yourMonster ? "playerAttack" : "enemyAttack";
    if (skill.id == 0) {
      fireball();
      fireball(2);
      fireball(3);
      fireball(4);
    }
    doAnimations(animation, skill.id);
  } else {
    var animation = attacker == yourMonster ? "playerMiss" : "enemyMiss";
    doAnimations(animation);
  }

  //Maybe in a future had to be types in skills parameters for this but for now
  //it's ok this way
  if (skill.id == 2) {
    yourMonster.setHP(skill.power);
    doAnimations("playerCure");
  }
  if (attacker == yourMonster) {

  }
  var who = attacker == yourMonster ? "cpu" : "player";
  nextMove(who);
}

/**
 * Use items
 */
function useItem(item) {
  switch (item.type) {
    case 'cure':
      var newHp = (20 * item.power);
      yourMonster.setHP(newHp);
      doAnimations("playerCure");
      break;
    case 'damage':
      var newHp = -(10 * item.power);
      enemy.setHP(newHp);
      doAnimations("playerAttack");
      break;
  }
  user.items.forEach(function (userItem) {
    if (userItem.id == item.id) {
      userItem.amount -= 1;
    }
  });
  nextMove("cpu");
}
/**
 * Create a menu with a list of your monstruos
 */
function createMenuList() {
  $(document).ready(function () {
    $(canvasID).animateLayer("panel2", {opacity: 1}, 1200);
    yourMonster.move(0, -300);
    yourTeam.forEach(function(monster) {
      //if () {}
    });
  });
}
function nextMove(who) {
  if (yourMonster.characteristics.hp == 0 || enemy.characteristics.hp == 0) {
    endBattle();
  } else if (player == "multi") {
    sendJSON();
  } else if (who == "cpu") {
    setTimeout(function () {
      randomAction();
    }, 1000);
  } else {
    setTimeout(function () {
      showMenu();
    }, 1000);
  }

}

/**
 * Do animations and effects for the battle
 */
function doAnimations(animation, animationId) {
  $(document).ready(function () {
    switch (animation) {
      case "enemyAttack":
        enemy.attackAnimation();
        $(canvasID).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
        drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 20);
        $(canvasID).animateLayer("hurt", {opacity: 1}, 300, function (layer) {
          $(this).animateLayer(layer, {opacity: 0}, 1000);
        });
        break;
      case "playerAttack":
        if (animationId == 0) {
          $(canvasID).animateLayer("fireball4", {x: "+=300", y: "-=140"}, {duration: 800, easing: 'swing'});
          $(canvasID).delayLayer("fireball3", 50).animateLayer("fireball3", {x: "+=300", y: "-=140"}, {
            duration: 800,
            easing: 'swing'
          });
          $(canvasID).delayLayer("fireball2", 100).animateLayer("fireball2", {x: "+=300", y: "-=140"}, {
            duration: 800,
            easing: 'swing'
          });
          $(canvasID).delayLayer("fireball1", 150).animateLayer("fireball1", {x: "+=300", y: "-=140"}, {
            duration: 800,
            easing: 'swing'
          });
          $(canvasID).drawRect({
            layer: true,
            name: 'flash',
            fillStyle: 'white',
            x: 320, y: 240,
            width: 640,
            height: 480,
            index: 90,
            opacity: 0,
          }).animateLayer('flash', {opacity: 1}, 800, function (layer) {
            $(this).removeLayerGroup('fireballs');
            $(this).animateLayer(layer, {opacity: 0}, 300);
          });
        } else {
          $(canvasID).animateLayer("mDamage1", {opacity: 0.8}, 200, function (layer) {
            $(this).animateLayer(layer, {opacity: 0}, 200);
          });
        }
        $(canvasID).animateLayer("bar1", {width: 300 * percentageHp(enemy)}, 1000)
        break;
      case "playerCure":
        $(canvasID).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
        break;
      case "playerMiss":
        $(canvasID).drawText({
          layer: true,
          name: 'Text',
          groups: ['Miss'],
          fillStyle: '#B00000',
          strokeStyle: 'darkred',
          strokeWidth: 2,
          x: 450, y: 100,
          fontSize: '36pt',
          fontFamily: 'Verdana, sans-serif',
          text: 'Miss'
        }).drawArc({
          layer: true,
          groups: ['Miss'],
          fillStyle: 'darkred',
          opacity: 0.2,
          x: 450, y: 100,
          radius: $(canvasID).measureText('Text').width / 2
        }).animateLayer('Text', {fontSize: '66pt'}, 500).delayLayer('Text', 500).animateLayer("Text", {opacity: 0}, 1000);
        setTimeout(function () {
          $(canvasID).removeLayerGroup('Miss');
        }, 1500);
        break;
      case "enemyMiss":
        $(canvasID).drawText({
          layer: true,
          name: 'Text',
          groups: ['Miss'],
          fillStyle: '#B00000',
          strokeStyle: 'darkred',
          strokeWidth: 2,
          x: 100, y: 400,
          fontSize: '36pt',
          fontFamily: 'Verdana, sans-serif',
          text: 'Miss'
        }).drawArc({
          layer: true,
          groups: ['Miss'],
          fillStyle: 'darkred',
          opacity: 0.2,
          x: 100, y: 400,
          radius: $(canvasID).measureText('Text').width / 2
        }).animateLayer('Text', {fontSize: '66pt'}, 500).delayLayer('Text', 500).animateLayer("Text", {opacity: 0}, 1000);
        setTimeout(function () {
          $(canvasID).removeLayerGroup('Miss');
        }, 1500);
        break;
    }
  });
}
/**
 * Draw a fireball
 */
function fireball(i = 1) {
  $(document).ready(function () {
    $(canvasID).drawImage({
      layer: true,
      name: "fireball" + i,
      groups: ['fireballs'],
      source: 'image/fireball.png',
      shadowColor: 'red',
      shadowBlur: 10,
      x: 180, y: 250,
      width: 100 * i / 4, height: 100 * i / 4,
    });
  });
}

/**
 * Send JSON to server
 */
function sendJSON() {
  //TODO
}

/**
 * Receive JSON from server
 */
function receiveJSON() {
  //TODO receive JSON and make changes in local
  doAnimations();
  if (yourMonster.characteristics.hp == 0 || enemy.characteristics.hp == 0) {
    endBattle();
  } else {
    showMenu();
  }
}

function randomAction() {
  var random = randomInt(0, enemy.skills.length - 1);
  skillsList.forEach(function (skill) {
    if (skill.id == enemy.skills[random]) {
      attack(enemy, yourMonster, skill);
    }
  });
  //TODO Add items in future
}

function checkItems() {
  for (var i = 0; i < user.items.length; i++) {
    if (user.items[i].amount < 1) {
      user.items.splice(i, 1);
    }
  }
}
//Mouse Functions
$(document).ready(function () {
  // Effects
  $('h3[id^=btn-skill-]').mouseenter(function () {
    var signNumber = $(this).attr('id').slice(-1);
    $('#sign' + signNumber).fadeIn(200);
  });
  $('h3[id^=btn-skill-]').mouseleave(function () {
    var signNumber = $(this).attr('id').slice(-1);
    $('#sign' + signNumber).fadeOut(200);
  });
  $('h3[id^=btn-item-]').mouseenter(function () {
    $(this).css("font-size", "1.2em");
  });
  $('h3[id^=btn-item-]').mouseleave(function () {
    $(this).css("font-size", "0.9em");
  });
  // Click functions
  $('#btn-skill').click(function () {
    $('#menuBattle').hide();
    $('#menuSkills').fadeIn(300);
    for (var i = 0; i < yourMonster.skills.length; i++) {
      var skill = getskill(yourMonster.skills[i]);
      $('#btn-skill-' + i).html(skill.name);
      $('#btn-skill-' + i).val(skill.id);
      $('#btn-skill-' + i).show();
    }
  });
  $('#btn-item').click(function () {
    $('#menuBattle').hide();
    $('#menuItems').fadeIn(300);
    if (user.items != null) {
      checkItems();
      $('#btn-item-' + i).each(function() {
        $(this).hide();
      });
      for (var i = 0; i < user.items.length; i++) {
        var item = getItem(user.items[i].id);
        if (item != null) {
          $('#btn-item-' + i).html("-" + item.name);
          $('#btn-item-' + i).show();
          $('#btn-item-' + i).parent().show();
        }
      }
    }
  });
  $('#btn-change').click(function () {
    $('#menuBattle').hide();
    doAction("change");
  });
  $('h3[id^=btn-skill-]').click(function () {
    $('#menuSkills').hide();
    doAction("skill", $(this).html());
  });
  $('h3[id^=btn-item-]').click(function () {
    var itemName = $(this).html();
    itemName = itemName.substring(1, itemName.length);
    $('#menuItems').hide();
    doAction("item", itemName);
  });
  $('.backButton').click(function () {
    for (var i = 0; i < 17; i++) {
      $('#btn-skill-' + i).hide();
      $('#btn-item-' + i).hide();
    }
    $('#menuSkills').hide();
    $('#menuItems').hide();
    $('#menuBattle').fadeIn(300);
  });
});