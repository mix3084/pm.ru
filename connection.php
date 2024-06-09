<?php
/**
 * Функция для подключения к базе данных PostgreSQL с использованием PDO
 *
 * @param string $host - адрес хоста базы данных
 * @param string $port - порт базы данных
 * @param string $dbname - имя базы данных
 * @param string $user - имя пользователя базы данных
 * @param string $password - пароль пользователя базы данных
 * @return PDO - объект PDO при успешном подключении
 * @throws PDOException - выбрасывает исключение в случае ошибки подключения
 */
function connectToDatabase($host, $port, $dbname, $user, $password) {
	try {
		// Формируем строку подключения
		$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
		
		// Устанавливаем параметры подключения
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Режим обработки ошибок
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Режим выборки данных
			PDO::ATTR_EMULATE_PREPARES => false, // Отключение эмуляции подготовленных выражений
		];

		// Создаем новый объект PDO
		$pdo = new PDO($dsn, $user, $password, $options);
		return $pdo;
	} catch (PDOException $e) {
		// Выбрасываем исключение в случае ошибки подключения
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
}

// Определение параметров подключения
$host = "localhost";
$port = "5432";
$dbname = "Portfolio_Management";
$user = "postgres";
$password = "root";

// Попытка подключения к базе данных
try {
	$conn = connectToDatabase($host, $port, $dbname, $user, $password);
	echo "Connected successfully";
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}



// Uncomment to execute a simple query example
// $query = "SELECT * FROM user_details";
// $result = pg_query($conn, $query);
// if ($result) {
//     while ($row = pg_fetch_assoc($result)) {
//         echo "User ID: " . $row['user_id'] . " - Name: " . $row['name'] . "<br>";
//     }
// } else {
//     echo "0 results";
// }

// Uncomment to insert data example
// $insert_query = "INSERT INTO user_details (user_id, dob, name, password, pan, email)
// VALUES
// ('AQC123456703', '2003-06-30', 'John Josw', 'password1', 'AQC1234567', 'john11@example.com'),
// ('TBC123456703', '2003-06-30', 'Johny sine', 'password1', 'TBC1234567', 'johns@example.com')";
// $insert_result = pg_query($conn, $insert_query);
// if ($insert_result) {
//     echo "New records created successfully";
// } else {
//     echo "Error: " . pg_last_error($conn);
// }

// Close the connection
// pg_close($conn);
?>
