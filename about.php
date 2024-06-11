<?php
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];

	// Очистите электронную почту, чтобы предотвратить внедрение SQL-кода
	$email = pg_escape_string($conn, $email);

	// Подготовить заявление к исполнению
	$sql = "SELECT * FROM user_details WHERE email = $1";
	$result = pg_query_params($conn, $sql, array($email));

	if ($result && pg_num_rows($result) > 0) {
		// Пользователь найден, извлеките данные
		$row = pg_fetch_assoc($result); // Извлеките первую строку (при условии, что на каждое электронное письмо приходится один пользователь).
		$username = $row['name'];
		$pan = $row['pan'];
		$dob = $row['dob'];
		$pass = $row['password'];
	} else {
		// Пользователь не найден
		echo "Пользователь не найден.";
	}
} else {
	// Перенаправьте пользователя на страницу входа в систему, если он не вошел в систему
	header("Location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel=stylesheet href='/style.css' type=text/css media=all>
</head>

<body>
    <div class="navbar-top">
        <div class="title">
            <h1 onclick="window.location.href='dash.php'" style="cursor: pointer;">О пользователе</h1>
        </div>
        <ul>
            <li>
                <a href="logout.php">
                    <i class="fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="main">
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td>ID</td>
                            <td>:</td>
                            <?php
                                echo "<td>";
                                echo $_SESSION['user_id'];
                                echo "</td>";
                                ?>
                        </tr>
                        <tr>
                            <td>Имя</td>
                            <td>:</td>
                            <?php
                                echo "<td>";
                                echo $username;
                                echo "</td>";
                                ?>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <?php
                                echo "<td>";
                                echo $email;
                                echo "</td>";
                                ?>
                        </tr>
                        <tr>
                            <td>ИНН</td>
                            <td>:</td>
                            <?php
                                echo "<td>";
                                echo $pan;
                                echo "</td>";
                            ?>
                        </tr>
                        <tr>
                            <td>Дата рождения</td>
                            <td>:</td>
                            <?php
                                echo "<td>";
                                echo $dob;
                                echo "</td>";
                            ?>
                        </tr>
                        <tr>
                            <td>Пароль</td>
                            <td>:</td>
                            <?php
                            echo "<td id='passwordField'>";
                            echo $pass;
                            echo "</td>";
                            ?>
                            <td>
                                <button onclick="editPassword()">Поменять</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<footer class="container">
    <center>
        <p>&copy; 2024 Москва</p>
        <p class="float-center"><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
    </center>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="/script.js"></script>

</html>