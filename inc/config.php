<?php
// Определение корневого пути вашего проекта
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/pm.ru/');

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
    die("Не удалось установить соединение: " . pg_last_error());
}

// Установка параметров сессии
session_start();
?>
