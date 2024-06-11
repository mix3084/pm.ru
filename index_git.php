<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Registration | PHP</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div>
	<form id="registrationForm" method="post">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<h1>Регистрация</h1>
					<p>Заполните все поля (поля ИНН в формате ААААА4444А).</p>
					<hr class="mb-3">
					<label for="firstname"><b>Имя</b></label>
					<input class="form-control" id="firstname" type="text" name="firstname" required>

					<label for="lastname"><b>Фамилия</b></label>
					<input class="form-control" id="lastname" type="text" name="lastname" required>

					<label for="email"><b>Почта</b></label>
					<input class="form-control" id="email" type="email" name="email" required>

					<label for="phonenumber"><b>Телефон</b></label>
					<input class="form-control" id="phonenumber" type="text" name="phonenumber" required>

					<label for="password"><b>Пароль</b></label>
					<input class="form-control" id="password" type="password" name="password" required>
					<hr class="mb-3">
					<input class="btn btn-primary" type="submit" id="register" name="create" value="Регистрация">
				</div>
			</div>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
	$(document).ready(function() {
		$('#registrationForm').on('submit', function(e) {
			e.preventDefault();

			var formData = {
				firstname: $('#firstname').val(),
				lastname: $('#lastname').val(),
				email: $('#email').val(),
				phonenumber: $('#phonenumber').val(),
				password: $('#password').val(),
				create: true
			};

			$.ajax({
				type: 'POST',
				url: 'registration.php',
				data: formData,
				success: function(response) {
					if (response == 'success') {
						Swal.fire({
							title: 'Регистрация успешна!',
							text: 'Ваш аккаунт был успешно создан.',
							icon: 'success'
						}).then(function() {
							window.location.href = 'login.php';
						});
					} else {
						Swal.fire({
							title: 'Ошибка!',
							text: response,
							icon: 'error'
						});
					}
				}
			});
		});
	});
</script>
</body>
</html>
