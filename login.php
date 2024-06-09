<?php
 include("connection.php"); // Ensure this uses pg_connect
 if (!$conn) {
 	die(json_encode(array("status" => "error", "message" => "Не удалось установить соединение:" . pg_last_error())));
 }

 session_start();

 if (isset($_POST["signin"])) {
 	$email = $_POST['email'];
 	$password = $_POST['password'];

 	// Sanitize the inputs
 	$email = pg_escape_string($conn, $email);
 	$password = pg_escape_string($conn, $password);

 	// Prepare and execute the query
 	$sql = "SELECT * FROM user_details WHERE email = $1 AND password = $2";
 	$result = pg_prepare($conn, "login", $sql);

 	if ($result === false) {
 		echo json_encode(array("status" => "error", "message" => "Не удалось подготовить заявление: " . pg_last_error($conn)));
 		exit();
 	}

 	$result = pg_execute($conn, "login", array($email, $password));

 	if ($result === false) {
 		echo json_encode(array("status" => "error", "message" => "Не удалось выполнить инструкцию: " . pg_last_error($conn)));
 		exit();
 	}

 	// Check the result
 	if (pg_num_rows($result) == 1) {
 		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
 		$_SESSION['email'] = $email;
 		$_SESSION['user_id'] = $row["user_id"];
 		$_SESSION['usern'] = $row['name'];
 		$_SESSION['role'] = $row['role'];

 		echo json_encode(array("status" => "success", "message" => "Вход в систему прошел успешно"));
 	} else {
 		echo json_encode(array("status" => "error", "message" => "Неверный адрес электронной почты или пароль"));
 	}
 } else {
 	echo json_encode(array("status" => "error", "message" => "Подпись не установлена"));
 }
