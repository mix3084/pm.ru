<?php
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];

	// Очистите электронную почту, чтобы предотвратить внедрение SQL-кода
	$email = pg_escape_string($conn, $email);

	// Подготовить заявление к исполнению
	$sql = "SELECT * FROM user_details WHERE email = $1";
	$result = pg_prepare($conn, "fetch_user", $sql);
	$result = pg_execute($conn, "fetch_user", array($email));

	if (pg_num_rows($result) > 0) {
		// Пользователь найден, извлеките данные
		$row = pg_fetch_assoc($result); // Извлеките первую строку (при условии, что на каждое электронное письмо приходится один пользователь).

		// Теперь вы можете получить доступ к имени пользователя и другим данным
		$username = $row['name'];
		$pan = $row['pan'];

		// Используйте $username и $pan по мере необходимости
	} else {
		// Пользователь не найден, перенаправьте на главную страницу
		header("Location: index.php");
		exit();
	}

	// Дополнительную логику, зависящую от пользователя, можно найти здесь

} else {
	// Перенаправьте пользователя на страницу входа в систему, если он не вошел в систему
	header("Location: login.php");
	exit();
}
?>

<!doctype html>
<html lang="ru">

<head>
    <!-- Обязательные мета-теги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel=stylesheet href='/style.css' type=text/css media=all>
    <title>Portfolio Management System</title>
</head>

<body>
    <nav class="navbar" style="background-color:rgb(18, 62, 105);">
        <div class="container-fluid">
            <a class="navbar-brand fw-normal" style="color: white" href="about.php"><?php echo isset($username) ? $username : ''; ?></a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <div class="mx-2 my-2">
                    <form method="POST" action='logout.php'>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal" type="submit" name="logout">Выйти</button>
                    </form>
                </div>
        </div>
    </nav>

    <div class="container justify-content-center text-center my-3">
        <div class="row g-6">
            <div class="col-6">
                <div class="p-4 border my-3" style="background-color:rgb(22, 90, 158); color:aliceblue;">
                    <a href="#" onclick="window.location.href='portfolio.php'">Портфолио</a>
                </div>
            </div>
            <div class="col-6">
                <div class="p-4 border my-3" style="background-color:rgb(22, 90, 158);"><a href="#"
                        onclick="window.location.href='stock_price.php'">Рынок</a></div>
            </div>
            <div class="col-6">
                <div class="p-4 border my-3" style="background-color:rgb(22, 90, 158);"><a href="#"
                        onclick="window.location.href='watchlist.php'">Лист ожидания</a></div>
            </div>
            <div class="col-6">
                <div class="p-4 border my-3" style="background-color:rgb(22, 90, 158);"><a href="#" onclick="window.location.href='transaction.php'">Транзакции</a></div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <!-- FOOTER -->
    <footer class="container">
        <center>
            <p>&copy; 2024 Москва</p>
            <p class="float-center"><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
        </center>
    </footer>
</body>

</html>