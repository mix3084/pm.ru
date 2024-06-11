<?php
include("connection.php");
session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];
	if ($role == "admin") {
		header("Location: dash.php");
		exit();
	}

	// Очистите user_id, чтобы предотвратить SQL-инъекцию
	$user_id = pg_escape_string($conn, $user_id);

	$sql_userid = "SELECT * FROM watchlist WHERE user_id = $1";
	$result = pg_prepare($conn, "fetch_watchlist", $sql_userid);
	$result = pg_execute($conn, "fetch_watchlist", array($user_id));

	if ($result) {
		if (pg_num_rows($result) > 0) {
			// Извлекать и отображать данные
			$watchlist_data = pg_fetch_all($result);
		} else {
			header("Location: dash.php"); // Перенаправьте на страницу панели мониторинга, если строки не найдены
			exit();
		}
	} else {
		// Обработка ошибки запроса к базе данных
		echo "Error: " . pg_last_error($conn);
	}
} else {
	header("Location: login.php"); // Перенаправить на страницу входа в систему, если вы не вошли в систему
	exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel=stylesheet href='/style.css' type=text/css media=all>
</head>

<body>
    <nav class="navbar" style="background-color:rgb(18, 62, 105);">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="dash.php">
                Лист ожидания
            </a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search Symbol..." aria-label="Search">
            </form>
        </div>
    </nav>
    <div class="container my-5">
        <a class="btn btn-primary" href="#" onclick="window.location.href='add_to_watch.php'">+ Добавить</a>
        <div class="table-responsive justify-content-center float-center">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Символ</th>
                        <th scope="col">Название</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($watchlist_data)) {
                        foreach ($watchlist_data as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['stock_id']) . "</td>";
                            $stock_id = $row['stock_id'];
                            $sql_stc = "SELECT * FROM company WHERE stock_id = $1";
                            $res_stc = pg_prepare($conn, "fetch_company_" . $stock_id, $sql_stc);
                            $res_stc = pg_execute($conn, "fetch_company_" . $stock_id, array($stock_id));
                            if ($res_stc && pg_num_rows($res_stc) > 0) {
                                $stc_row = pg_fetch_assoc($res_stc);
                                echo "<td>" . htmlspecialchars($stc_row['stock_name']) . "</td>";
                            } else {
                                echo "<td>Stock Name Not Found</td>";
                            }
                            echo "<td>" . htmlspecialchars($row['stock_price']) . "</td>";
                            echo "<td><button class='btn btn-danger' onclick=\"deleteRecord('" . htmlspecialchars($row['stock_id']) . "')\">Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td>Не добавлено</td>";
                        echo "<td>Не добавлено</td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="container">
        <center>
            <p>&copy; 2024 Москва</p>
            <p class="float-center"><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
        </center>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="/script.js"></script>
</body>

</html>
