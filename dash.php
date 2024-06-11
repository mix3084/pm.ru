<?php
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$role = $_SESSION['role'];
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
	header("Location: index.php");
	exit();
}
?>
<?php include("header.php"); ?>
<h1>Главная</h1>
<?php include("footer.php"); ?>