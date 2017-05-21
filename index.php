<?php
/*
Monstruos' Bizarre Adventure
Copyright (C) 2017

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

session_start();
include 'functions.php';

if (isset($_SESSION["Authenticated"]) && $_SESSION["Authenticated"] == 1) {
  header("Location: home.php");
}
// Añadir a la base de datos
/*
 db.miscellaneous.insert({skills:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}],
items:[{id:0, name:"Poción", power:6, type:'cure', img:'image/items/potion_xs.png', price:10},
{id:1, name:"Poción L.", power:12 , type:"cure", img:'image/items/potion_s.png', price:50},
{id:2, name:"Bomba", power:5, type:"damage", img:'image/items/bomb.png', price:100},
{id:3, name:"Revivir", power:2, type:"cure", img:'image/items/feather.png', price:1000}]})
*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="theme-color" content="#7C7C7C">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monstruos' Bizarre Adventure 2</title>
  <script src="js/cookies.js"></script>
  <script src="js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
if (isset($_GET['cookies'])) {
  ?>
  <div class="cookies">
    <h1>Política de Cookies</h1><br>
    <h2>Cookies</h2>
    <p>Utilizamos cookies para facilitar el uso de nuestra página web. Las cookies son pequeños ficheros de información
      que nos permiten comparar y entender cómo nuestros usuarios navegan a través de nuestra página web, y de esta
      manera poder mejorar consecuentemente el proceso de navegación.<br>Las cookies que utilizamos no almacenan dato
      personal alguno, ni ningún tipo de información que pueda identificarle. En caso de no querer recibir cookies, por
      favor configure su navegador de Internet para que las borre del disco duro de su ordenador, las bloquee o le avise
      en caso de
      instalación de las mismas. Para continuar sin cambios en la configuración de las cookies, simplemente continúe en
      la página web.</p>
    <p>Puedes obtener más información sobre las cookies y su uso en www.aboutcookies.org.
      Los tipos de cookies que utilizamos</p>
    <h3>Cookies estrictamente necesarias:</h3>
    <p>Estas cookies son necesarias para el correcto uso de la página web, permitiendo el acceso a secciones que cuentan
      con filtros de seguridad. Sin estas cookies, muchos de los servicios disponibles no estarían operativos.</p>
    <h3>Cookies de Navegación:</h3>
    <p>Estas cookies recogen información sobre el uso que las visitas hacen de la web, por ejemplo páginas vistas,
      errores de carga... Es información genérica y anónima, donde no se incluyen datos personales, ni se recoge
      información que identifique a los visitantes; siendo el objetivo último
      mejorar el funcionamiento de la web. Al visitar nuestra página web, acepta la instalación de estas cookies en su
      dispositivo.</p>
    <h3>Cookies Funcionales:</h3>
    <p>Estas cookies permiten recordar información (como su nombre de usuario, idioma o la región en la que se
      encuentra) y características más personales. Por ejemplo, la posibilidad de ofrecer contenido personalizado basado
      en la información y criterios que hayas proporcionado voluntariamente. Estas cookies también pueden utilizarse
      para recordar los cambios realizados en el tamaño del texto, fuentes y otras partes personalizables de la página
      web. También se utilizan para ofrecer algunos servicios solicitados, como ver un video o comentar en un blog. La
      información que recopilan estas cookies puede ser anónima y no podrá ser seguida su actividad en otras páginas
      web.<br> Al visitar nuestra página web, aceptas la instalación de estas cookies en tu dispositivo.</p>
    <h3>Cómo administrar las cookies en los ordenadores</h3>
    <p>Si quieres permitir el uso de cookies de nuestro site, por favor sigue las siguientes instrucciones.<br>Google
      Chrome<br>1. Al abrir el navegador, pincha “herramientas” en la parte superior y selecciona la pestaña de
      “opciones”.<br>2. Dentro de opciones, pincha “privacidad”.<br>
      3. Marca “permitir la administración de cookies”. <br> Microsoft Internet Explorer 6.0, 7.0, 8.0, 9.0 1. Al abrir
      el navegador, pincha “herramientas” en la parte superior y selecciona la pestaña de “opciones”.<br> 2. Revisa la
      pestaña de “Privacidad” asegurándote está configurada con un nivel de seguridad medio o inferior.<br> 3. Si la
      configuración de Internet no es media se estarán bloqueando las cookies.<br> Mozilla Firefox<br> 1. Al abrir el
      navegador, pincha “herramientas” en la parte superior y selecciona la pestaña de “opciones”.<br> 2. Selecciona el
      icono de Privacidad<br> 3. Pincha en cookies, y marca: “permitir la instalación de cookies”.<br> Safari<br> 1. Al
      abrir el navegador, pincha “herramientas” en la parte superior y selecciona la pestaña de “opciones”.<br> 2.
      Pincha en la pestaña de “Seguridad” y revisa si la opción “Bloquear el acceso de cookies de terceros” está marcada
      o no.<br> 3. Pincha en “guardar”.</p>
    <h3>La instalación de cookies en Mac</h3>
    <p>Si tienes un Mac y quieres permitir el acceso de nuestras cookies en tu ordenador, por favor sigue las siguientes
      instrucciones:<br> Microsoft Internet Explorer 5.0 en OSX<br> 1. Entra en “Explorer” y selecciona “Preferencias”
      en la barra de navegación.<br> 2. Haz scroll hacia abajo hasta que veas “Cookies” justo debajo de archivos
      recibidos.<br> 3. Marca “No volver a preguntar”.<br> Safari en OSX<br> 1. Entra en Safari y selecciona
      “Preferencias” en la barra de navegación.<br> 2.Pincha en la pestaña de “Seguridad” y marcae la opción “aceptar
      cookies”<br> 3. Selecciona la opción: “Sólo desde el site actual en que estoy navegando”<br> Mozilla y Netscape en
      OSX<br> 1. Entra en “Mozilla” o “Netscape” y en la parte superior de tu navegador, marca la opción de
      “Preferencias”<br> 2. Haz scroll hacia abajo hasta que veas “Cookies” justo debajo de “Privacidad y
      Seguridad”.<br> 3. Marca la opción “Permitir el acceso de cookies sólo desde el site actual” <br>Opera<br> 1.
      Entra en “Opera” y selecciona “Menu” y “Ajustes” en la barra de navegación.<br> 2. Selecciona “Preferencias” y
      pincha en la pestaña de “Avanzado”.<br> 3. Marca la opción “Aceptar cookies”</p>
    <a href="index.php" name="back" class="back-button">Volver</a>
  </div>
  <?php
} else {
  if (!isset($_COOKIE['cookieagree'])) {
    ?>
    <!--//BLOQUE COOKIES-->
    <div id="barraaceptacion">
      <div class="inner">
        Utilizamos cookies de terceros para realizar an&aacute;lisis de uso y de medici&oacute;n de nuestra web para
        mejorar nuestros servicios. Si contin&uacute;a navegando consideramos que acepta el uso de cookies.
        </br>
        <button name="ok" class="ok" onclick="PonerCookie();">OK</button>
        |
        <a href="index.php?cookies" name="cookies-info" class="info">M&aacute;s informaci&oacute;n</a>
      </div>
    </div>
    <!--//FIN BLOQUE COOKIES-->
    <?php
  }
  ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12" role="main">
        <div class="row">
          <img src="image/login_image1.jpg" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <h2> Monstruos' Bizarre Adventure <img src="image/number2.png" width="50" height="50" alt="image number 2">
            </h2>
          </div>
          <fieldset class="form-group col-sm-4 col-sm-offset-4 col-xs-12 ">
            <legend>
              <a href="index.php" <?php if (!isset($_GET["register"])) {
                print 'class="activeSection"';
              } ?>>Login</a>
              /
              <a href="index.php?register" <?php if (isset($_GET["register"])) {
                print 'class="activeSection"';
              } ?>>Registro</a>
            </legend>
            <?php
            if (isset($_GET["register"])) {
              register();
            } else {
              login();
            }
            ?>
          </fieldset>
        </div>
      </div>
    </div>
    <?php footer() ?>
  </div>
  <?php
}
?>
</body>
</html>
