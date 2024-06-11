<?php include("connection.php");?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Разработка онлайн платформы для управления инвестиционными портфелями и персональным финансовым планированием</title>
	<link rel=stylesheet href='/style.css' type=text/css media=all>
</head>

<body>
	<div class="cont">
		<div class="form sign-in">
			<h2>Добро пожаловать</h2>
			<form name="form" id="loginForm">
				<label>
					<span>Эл. почта</span>
					<input type="email" name="email" id="email" />
				</label>
				<label>
					<span>Пароль</span>
					<input type="password" name="password" id="password" />
				</label>
				<p id="error-message" style="color: red;"></p>
				<p class="forgot-pass">Забыли пароль?</p>
				<br>
				<input type="submit" class="submit button1" name="signin" value="Войти">
			</form>
		</div>
		<div class="sub-cont">
			<div class="img">
				<div class="img__text m--up">
					<h3>Нет аккаунта? Регистрация!<h3>
				</div>
				<div class="img__text m--in">
					<h3>Если есть аккаунт, пройдите авторизацию.<h3>
				</div>
				<div class="img__btn">
					<span class="m--up">Регистрация</span>
					<span class="m--in">Войти</span>
				</div>
			</div>
			<div class="form sign-up">
				<form id="registrationForm" method="POST">
					<h2>Создать аккаунт</h2>
					<label>
						<span>Имя</span>
						<input type="text" name="name2" id="name2" required />
					</label>
					<label>
						<span>Дата рождения</span>
						<input type="date" id="dob" name="dob"
							onchange="validateDOB();" required>
					</label>
					<label>
						<span>Эл. почта</span>
						<input type="email" name="email2" id="email2" required />
					</label>
					<label>
						<span>ИНН</span>
						<input type="text" name="pan2" id="pan2" required />
					</label>
					<label>
						<span>Пароль</span>
						<input type="password" name="password2" id="password2" required />
					</label>
					<br>
					<div id="resultMessage"></div>
					<input type="submit" class="button1 submit" value="Регистрация">
				</form>
			</div>
		</div>
	</div>
	<footer class="container">
		<p align=center>&copy; 2024 Москва</p>
		<p class="float-center" align=center><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
	</footer>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="/script.js"></script>
</body>

</html>