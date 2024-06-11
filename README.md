# Portfolio Management System

## Установка на Open Server Panel

### Шаг 1: Клонирование репозитория

1. Клонируйте репозиторий на ваш локальный сервер:
    ```bash
    git clone https://github.com/mix3084/pm.ru.git
    ```
2. Переместите папку с проектом в директорию Open Server, например, `domains`.

### Шаг 2: Настройка базы данных PostgreSQL

1. Запустите Open Server Panel.
2. Откройте [Adminer](http://127.0.0.1/openserver/adminer/index.php).
3. Выберите движок PostgreSQL.
4. Введите логин `postgres` и пароль `postgres`.
5. Создайте новую базу данных с именем `Portfolio_Management`.

### Шаг 3: Импорт структуры базы данных

1. Внутри базы данных `Portfolio_Management` выполните SQL-запрос из файла `PORTFOLIO_MANAGEMENT_SYSTEM.sql`.

### Шаг 4: Настройка соединения с базой данных

1. Откройте файл `connection.php` и обновите параметры подключения:
    ```php
    <?php
    $host = "localhost";
    $port = "5432";
    $dbname = "Portfolio_Management";
    $user = "postgres";
    $password = "postgres";

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }
    ?>
    ```

### Шаг 5: Запуск проекта

1. Запустите Open Server Panel и убедитесь, что сервер работает.
2. Перейдите в браузере по адресу `http://pm.ru`.
