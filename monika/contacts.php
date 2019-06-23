<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/contacts.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  </head>
  <body>
		<?php
		include 'inc/nav.php';
		?>
		<div class="parent">
			<h1>Контакти</h1>
      <p class="forusp">Тел.1: +359 887-68-91-25</p>
      <p class="forusp">Тел.2: +359 893-88-77-57</p>
      <p class="forusp">Ако искате да се свържете с нас можете да го направите през Онлайн формата по-долу! <br/> Ще Ви отговорим на Имейл възможно най-скоро!</p>
      <div class="maps">
        <div class="parentdivcontact">
          <div class="addrcontdiv">
            <p>Адрес</p>
            <p>4230, Кооперативен пазар, град Асеновград, Област Пловдив</p>
          </div>
          <div class="addrcontdiv">
            <p>Имейл</p>
            <p>boshnakova16@abv.bg</p>
          </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2964.4568391345438!2d24.872245015074185!3d42.01193117921169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14acd8e98acf31f3%3A0x349e9b49bc52a1c0!2z0JrQvtC-0L_QtdGA0LDRgtC40LLQtdC9INC_0LDQt9Cw0YA!5e0!3m2!1sbg!2sbg!4v1560446045007!5m2!1sbg!2sbg" allowfullscreen></iframe>
      </div>
      <p class="formpcontact">Форма за контакти</p>
      <form action="contactverification.php" method="POST">
        <input type="text" name="Name" placeholder="Име">
        <input type="text" name="Fam" placeholder="Фамилия">
        <input type="text" name="Email" placeholder="Имейл">
        <input type="textarea" class="textarea" name="Msg" placeholder="Съобщение">
        <input type="submit" name="submitforcontact" value="Изпрати">
      </form>
		</div>
		<?php
		include 'inc/footer.php';
		?>
  </body>
</html>
