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
    enemy1.draw(0);
    enemy1.draw(0, 'mDamage1', enemy1.img.substr(0, enemy1.img.length - 4) + "2.png", 300);
    drawPanels(canvasID);
    enemy1.move(300);
    yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 10);
    if (yourMonster.characteristics.luk > enemy1.characteristics.luk) {
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
      if (yourMonster.characteristics.hp > enemy1.characteristics.hp) {
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
    $('#menuAbi').delay(1000).fadeIn(600);
  });
}

/**
 * Draw the panels
 */
function drawPanels(canvasID) {
  $(document).ready(function () {
    drawImage();
    drawImage("image/empty-bar.png", 50, 50, 300, 20, "empty-bar1", 1);
    drawImage("image/bar.png", 50, 50, 300 * percentageHp(enemy1), 20, "bar1", 2);
    drawImage("image/empty-bar.png", 10, 320, 200, 20, "empty-bar2", 3);
    drawImage("image/bar.png", 10, 320, 200 * percentageHp(yourMonster), 20, "bar2", 4);
    drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 20, 0);

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
  var level = mode == "easy"? 1 : mode == "middle"? 2 : 5;
  var enemy1 = new Monstruo();
  enemy1.set("_id", "0");
  enemy1.set("userID", "CPU");
  enemy1.set("name", "enemyXYZ");
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
  var maxHp = randomInt(20 , 50) * level;
  enemy1.set("img", img);
  enemy1.setSTR(randomInt(1, 5) * level);
  enemy1.setDEF(randomInt(1, 5) * level);
  enemy1.setLUK(randomInt(1, 5) * level);
  enemy1.setMAXHP(maxHp);
  enemy1.setHP(maxHp);
  enemy1.addAbility(1);
  enemy1.addAbility(3);
  return enemy1;
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
 * Get an ability by their id
 */
function getAbility(id) {
  var ability;
  abilitiesList.forEach(function (object) {
    if (object.id == id) {
      ability = object;
    }
  });
  return ability;
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
    case "ability":
      abilitiesList.forEach(function (ability) {
        if (ability.name === string) {
          attack(yourMonster, enemy1, ability);
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
      drawImage('image/panel2.jpg',0,0,640,480,"panel2",50,0);
      createMenuList();
      break;
  }
}

/**
 * Attack an enemy
 */
function attack(attacker, defender, ability) {
  //Critical double the attack power if you have enough luk
  //and can make you miss an attack
  var random = randomInt(attacker.characteristics.luk, 40);
  var critical = random > 30 ? 2 : random < 5 ? 0 : 1;
  var newHp = (defender.characteristics.def - attacker.characteristics.str - ability.power) * critical;
  if (newHp < 0) {
    defender.setHP(newHp);
    var animation = attacker == yourMonster ? "playerAttack" : "enemyAttack";
    if (ability.id == 0) {
      fireball();
      fireball(2);
      fireball(3);
      fireball(4);
    }
    doAnimations(animation, ability.id);
  } else {
    var animation = attacker == yourMonster ? "playerMiss" : "enemyMiss";
    doAnimations(animation);
  }

  //Maybe in a future had to be types in abilities parameters for this but for now
  //it's ok this way
  if (ability.id == 2) {
    yourMonster.setHP(ability.power);
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
      enemy1.setHP(newHp);
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
    $(canvasID).animateLayer("panel2", {opacity:1},1200);
  });
}
function nextMove(who) {
  if (yourMonster.characteristics.hp == 0 || enemy1.characteristics.hp == 0) {
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
        enemy1.attackAnimation();
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
        $(canvasID).animateLayer("bar1", {width: 300 * percentageHp(enemy1)}, 1000)
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
  if (yourMonster.characteristics.hp == 0 || enemy1.characteristics.hp == 0) {
    endBattle();
  } else {
    showMenu();
  }
}

function randomAction() {
  var random = randomInt(0, enemy1.abilities.length - 1);
  abilitiesList.forEach(function (ability) {
    if (ability.id == enemy1.abilities[random]) {
      attack(enemy1, yourMonster, ability);
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
  $('h3[id^=btn-abi-]').mouseenter(function () {
    var signNumber = $(this).attr('id').slice(-1);
    $('#sign' + signNumber).fadeIn(200);
  });
  $('h3[id^=btn-abi-]').mouseleave(function () {
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
  $('#btn-abi').click(function () {
    $('#menuBattle').hide();
    $('#menuAbi').fadeIn(300);
    for (var i = 0; i < yourMonster.abilities.length; i++) {
      var ability = getAbility(yourMonster.abilities[i]);
      $('#btn-abi-' + i).html(ability.name);
      $('#btn-abi-' + i).val(ability.id);
      $('#btn-abi-' + i).show();
    }
  });
  $('#btn-item').click(function () {
    $('#menuBattle').hide();
    $('#menuItems').fadeIn(300);
    checkItems();
    for (var i = 0; i < 17; i++) {
      $('#btn-item-' + i).hide();
    }
    for (var i = 0; i < user.items.length; i++) {
      var item = getItem(user.items[i].id);
      if (item != null) {
        $('#btn-item-' + i).html("-" + item.name);
        $('#btn-item-' + i).show();
        $('#btn-item-' + i).parent().show();
      }
    }
  });
  $('#btn-change').click(function () {
    $('#menuBattle').hide();
    doAction("change");
  });
  $('h3[id^=btn-abi-]').click(function () {
    $('#menuAbi').hide();
    doAction("ability", $(this).html());
  });
  $('h3[id^=btn-item-]').click(function () {
    var itemName = $(this).html();
    itemName = itemName.substring(1, itemName.length);
    $('#menuItems').hide();
    doAction("item", itemName);
  });
  $('.backButton').click(function () {
    for (var i = 0; i < 17; i++) {
      $('#btn-abi-' + i).hide();
      $('#btn-item-' + i).hide();
    }
    $('#menuAbi').hide();
    $('#menuItems').hide();
    $('#menuBattle').fadeIn(300);
  });
});