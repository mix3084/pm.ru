<?php
$title = 'Лист ожидания';
include("connection.php");
session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
    $username = $_SESSION['usern'];
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
	header("Location: index.php"); // Перенаправить на страницу входа в систему, если вы не вошли в систему
	exit();
}
?>
<?php include("header.php"); ?>
<h1><?=$title;?></h1>
<form class="d-flex">
	<input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
</form>
<a class="btn btn-success my-2" href="/add_to_watch.php">+ Добавить</a>
<div class="table-responsive">
    <table class="table table-hover table-striped">
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
                    echo "<td><button class='btn btn-danger btn-sm' onclick=\"deleteRecord('" . htmlspecialchars($row['stock_id']) . "')\">Удалить</button></td>";
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
<?php include("footer.php"); ?>
