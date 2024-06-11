<?php
header('Content-Type: application/json');

include("connection.php"); // Ensure this file uses pg_connect to establish a PostgreSQL connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email2'];
	$password = $_POST['password2'];
	$name = $_POST['name2'];
	$pan = $_POST['pan2'];
	$dob = $_POST['dob'];

	// Sanitize inputs to prevent SQL Injection
	$email = pg_escape_string($conn, $email);
	$password = pg_escape_string($conn, $password);
	$name = pg_escape_string($conn, $name);
	$pan = pg_escape_string($conn, $pan);
	$dob = pg_escape_string($conn, $dob);

	// Check if the email already exists
	$check_email_query = "SELECT * FROM user_details WHERE email = $1";
	$result = pg_query_params($conn, $check_email_query, array($email));

	if (pg_num_rows($result) > 0) {
		echo json_encode(["message" => "Пользователь с таким email уже существует"]);
	} else {
		// Prepare a statement for safer execution
		$sql = "INSERT INTO user_details (name, email, password, pan, dob) VALUES ($1, $2, $3, $4, $5)";

		// Prepare the SQL statement
		$result = pg_prepare($conn, "insert_user", $sql);
		// Execute the SQL statement with the parameters
		$result = pg_execute($conn, "insert_user", array($name, $email, $password, $pan, $dob));

		if ($result) {
			echo json_encode(["message" => "Регистрация прошла успешно"]);
		} else {
			echo json_encode(["message" => "Ошибка при регистрации: " . pg_last_error($conn)]);
		}
	}
	pg_close($conn);
} else {
	echo json_encode(["message" => "Неверный метод запроса"]);
}
?>
