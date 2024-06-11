<?php
$title = 'Редактировать профиль';
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
    $username = $_SESSION['usern'];
    
	$role = $_SESSION['role'];
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
	header("Location: index.php");
	exit();
}
?>
<?php include("header.php"); ?>
<h1><?=$title;?></h1>
<form>
    <div class="mb-3 row">
        <label for="userId" class="col-sm-2 col-form-label">ID</label>
        <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="userId"
                value="<?php echo $_SESSION['user_id']; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="username" class="col-sm-2 col-form-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="username" value="<?php echo $username; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" readonly class="form-control-plaintext" id="email" value="<?php echo $email; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="pan" class="col-sm-2 col-form-label">ИНН</label>
        <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="pan" value="<?php echo $pan; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="dob" class="col-sm-2 col-form-label">Дата рождения</label>
        <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="dob" value="<?php echo $dob; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Пароль</label>
        <div class="col-sm-10">
            <div class="input-group">
                <input type="password" readonly class="form-control-plaintext" id="password"
                    value="<?php echo $pass; ?>">
                <button class="btn btn-outline-secondary" type="button" onclick="editPassword()">Поменять
                    пароль</button>
            </div>
        </div>
    </div>
</form>
<div id="passwordField"></div>
<?php include("footer.php"); ?>