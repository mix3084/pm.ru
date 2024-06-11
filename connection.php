<?php
// Раскомментируйте, чтобы отображать сообщения о состоянии соединения
// echo("Attempting to connect...<br>");

// Определение параметров подключения
$host = "localhost";
$port = "5432"; // Default port for PostgreSQL
$dbname = "Portfolio_Management";
$user = "postgres"; // Убедитесь, что это правильное имя пользователя для вашего сервера PostgreSQL
$password = "postgres";

// Создать строку подключения
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

// Подключение к базе данных PostgreSQL
$conn = pg_connect($connection_string);

// Проверьте состояние подключения
if (!$conn) {
    echo "Не удалось установить соединение.";
}

// Раскомментируйте для выполнения простого примера запроса
// $query = "SELECT * FROM user_details";
// $result = pg_query($conn, $query);
// if ($result) {
//     while ($row = pg_fetch_assoc($result)) {
//         echo "User ID: " . $row['user_id'] . " - Name: " . $row['name'] . "<br>";
//     }
// } else {
//     echo "0 results";
// }

// Раскомментируйте, чтобы вставить пример данных
// $insert_query = "INSERT INTO user_details (user_id, dob, name, password, pan, email)
// VALUES
// ('AQC123456703', '2003-06-30', 'John Josw', 'password1', 'AQC1234567', 'john11@example.com'),
// ('TBC123456703', '2003-06-30', 'Johny sine', 'password1', 'TBC1234567', 'johns@example.com')";
// $insert_result = pg_query($conn, $insert_query);
// if ($insert_result) {
//     echo "Успешно созданы новые записи";
// } else {
//     echo "ОШИБКА: " . pg_last_error($conn);
// }

// Закройте соединение
// pg_close($conn);
?>
