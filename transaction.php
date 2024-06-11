<?php
$title = 'Транзакции';
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

	$sql_userid = "SELECT * FROM transaction WHERE user_id_purchased = $1 OR user_id_bought = $1";
	$result = pg_prepare($conn, "fetch_transactions", $sql_userid);
	$result = pg_execute($conn, "fetch_transactions", array($user_id));

	if ($result) {
		$transactions = pg_fetch_all($result);
	} else {
		// Обработка ошибки запроса к базе данных
		echo "Error: " . pg_last_error($conn);
	}
} else {
	header("Location: index.php");
	exit();
}
?>
<?php include("header.php"); ?>
<h1><?=$title;?></h1>
<form class="d-flex">
	<input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
</form>
<a class="btn btn-success my-2" href="/make_transac.php">+ Добавить</a>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Рынок ID</th>
                <th>Дата добавления</th>
                <th>Добавлено</th>
                <th>Продано</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Итого</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (!empty($transactions)) {
                foreach ($transactions as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['transaction_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stock_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_of_purchase']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id_purchased']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id_bought']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    $q = $row['quantity'];
                    $p = $row['price'];
                    $t = $p * $q;
                    echo "<td>" . htmlspecialchars($t) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='8'>Нет транзакций</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include("footer.php"); ?>