// Sounds
var cursor = new Audio('audio/cursor.ogg');
var bottle = new Audio('audio/bottle.ogg');
var hit = new Audio('audio/hit.ogg');
var fire = new Audio('audio/fire.ogg');
var explosion = new Audio('audio/explodemini.ogg');
var miss = new Audio('audio/miss.ogg');
var error = new Audio('audio/error.ogg');
var arraySounds = [cursor, bottle, hit, fire, explosion, miss, error];

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
    enemy0.draw(0, 'mDamage', enemy.img.substr(0, enemy.img.length - 4) + "2.png", 300, 0, 300, 300, 12);
    drawPanels(canvasID);
    enemy.move(300);
    yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 15, 'yourTeam');
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
    drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 90, 0);
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
function getSkill(id) {
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
  setTimeout(function () {
    nextMove(who);
  }, 1000);
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
      bottle.play();
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
  setTimeout(function () {
    nextMove("cpu");
  }, 1000);
}
/**
 * Create a menu with a list of your monstruos
 */
function createMenuList() {
  $(document).ready(function () {
    $(canvasID).animateLayer("panel2", {opacity: 1}, 1200);
    yourMonster.move(50, -300 / (Math.pow(yourMonster.pos, 5) + 1), 1, -50, -50);
    user.monstruos.forEach(function (monster) {
      showText(monster.name + " " + monster.characteristics.hp + "/" + monster.characteristics.maxHp, 50 + monster.pos * 150);

      if (monster.pos != yourMonster.pos) {
        monster.draw(1, 'yourTeam' + monster.pos, monster.img, 60, 40 + (150 * monster.pos), 100, 100, 9, "yourTeam");
      }
    });
    $(canvasID).getLayers().removeLayers().drawLayers();
  });
}
function showText(stringToShow, y = 100, x = 200) {
  $(document).ready(function () {
    var count = 0;
    var string = stringToShow;
    var index = 0;

    function createString(char, x, y, i) {
      $(canvasID).drawText({
        layer: true,
        name: string + i,
        groups: ['info'],
        fillStyle: 'gray',
        strokeStyle: 'white',
        strokeWidth: 1,
        x: x, y: y,
        fontSize: '26pt',
        opacity: 1,
        fontFamily: 'Verdana, sans-serif',
        text: char,
        scale: 2,
      }).animateLayer(string + i, {opacity: 1, scale: '-=1.5'}, 200);
    }

    var intro = 0;
    var index2 = index;
    var intervals = [];
    intervals[count] = setInterval(function () {
      if (string.substr(index, 1) == " ") {
        intro++;
        index++;
        index2 = 0;
      }
      createString(string.substr(index, 1), x + index2 * 20, y + intro * 40, index);
      index++;
      index2++;
      if (index == string.length) {
        clearInterval(intervals[count]);
      }
    }, 200);
  });

}

function nextMove(who) {
  var end = false;
  if (yourMonster.characteristics.hp == 0) {
    end = true;
    $(canvasID).removeLayerGroup('yourTeam');
    try {
      user.monstruos.forEach(function (monstruo) {
        if (monstruo.characteristics.hp > 0) {
          /*
          yourMonster = monstruo;
          yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 15, 'yourTeam');
          $(canvasID).delay(2000).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
          */
          throw BreakException;
        }
      });
    } catch (e) {
      end = false;
      setTimeout(function () {
        $( "#btn-change" ).trigger( "click" );
      },2000);
    }
  } else if (enemy.characteristics.hp == 0) {
    end = true;
    $(canvasID).removeLayerGroup('battle');
    try {
      enemyMonstruos.forEach(function (monstruo) {
        if (monstruo.characteristics.hp > 0) {
          enemy = monstruo;
          enemy.draw(0);
          enemy0 = new Monstruo();
          enemy0.draw(0, 'mDamage', enemy.img.substr(0, enemy.img.length - 4) + "2.png", 300, 0, 300, 300, 20);
          enemy.move(300, 0, 0);
          enemy.move(0, 0, 1, 0, 0, 1000);
          $(canvasID).delay(2000).animateLayer("bar1", {width: 300 * percentageHp(enemy)}, 1000);
          throw BreakException;
        }
      });
    } catch (e) {
      end = false;
    }
  }

  if (end) {
    endBattle();
  } else if (player == "multi") {
    sendJSON();
  } else if (who == "cpu") {
    setTimeout(function () {
      randomAction();
    }, 2000);
  } else {
    if (yourMonster.characteristics.hp > 0 ) {
      setTimeout(function () {
        showMenu();
      }, 2000);
    }
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
        hit.play();
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
            groups: ['fireballs'],
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
          fire.play();
          setTimeout(function () {
            explosion.play()
          }, 700);
        } else {
          $(canvasID).animateLayer("mDamage", {opacity: 0.8}, 200, function (layer) {
            $(this).animateLayer(layer, {opacity: 0}, 200);
          });
          hit.play();
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
        miss.play();
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
        miss.play();
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
      var skill = getSkill(yourMonster.skills[i]);
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
      $('#btn-item-' + i).each(function () {
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
    enemy.move(0,0,0);
    doAction("change");
    var i = 0;
    $('.monstruosList').each(function () {
      if(i < user.monstruos.length) {
        $(this).delay(3500).fadeIn(1000);
      }
      i++;
    });
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
  $('.monstruosList').click(function () {
    if (user.monstruos[$(this).attr('id').substr(3, 1)].characteristics.hp > 0) {
      $('.monstruosList').delay(500).fadeOut(300);
      $(canvasID).animateLayer('panel2', {opacity: 0}, 1000).removeLayerGroup('info').removeLayerGroup('yourTeam');
      $('#menuBattle').delay(1000).fadeIn(300);
      var pos = $(this).attr('id').substr(3, 1);
      user.monstruos.forEach(function (monstruo) {
        if (monstruo.pos == pos) {
          yourMonster = monstruo;
          yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 15, 'yourTeam');
          $(canvasID).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
        }
      });
      enemy.move(0,0,1);
    } else {
      error.play();
    }
  });
  $('.glyphicon').mousedown(function () {
    $(this).css({"font-size" : "1.5em"});
  });
  $('.glyphicon').mouseup(function () {
    $(this).css({"font-size" : "2em"});
  });
  $('.glyphicon-volume-off').click(function () {
    volume = 0;
    $("#battleSong").prop({'volume': volume});
    arraySounds.forEach(function (sound) {
      sound.volume = volume;
    });
  });
  $('.glyphicon-volume-down').click(function () {
    volume -= 0.2;
    $("#battleSong").prop({'volume': volume});
    arraySounds.forEach(function (sound) {
      sound.volume = volume;
    });
  });
  $('.glyphicon-volume-up').click(function () {
    volume += 0.2;
    $("#battleSong").prop({'volume': volume});
    arraySounds.forEach(function (sound) {
      sound.volume = volume;
    });
  });
  // Sounds
  $('h3[id^=btn-], .backButton, .monstruosList').mouseenter(function () {
    cursor.play();
  });
});