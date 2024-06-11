<?php
$title = 'Рынок';
include("connection.php");
session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['usern'];

	$role = $_SESSION['role'];
	$sql_userid = "SELECT stock_id, MAX(close_price) AS last_close_price FROM company_performance GROUP BY stock_id";
	$result = pg_query($conn, $sql_userid);
	
	if ($result) {
		if (pg_num_rows($result) > 0) {
			$stock_data = pg_fetch_all($result);
		} else {
			header("Location: dash.php"); // Redirect to the dashboard if no rows found
			exit();
		}
	} else {
		// Handle database query error
		echo "Error: " . pg_last_error($conn);
	}
}
?>
<?php include("header.php"); ?>
<h1><?=$title;?></h1>
<form class="d-flex">
	<input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
</form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Символ</th>
				<th>Название</th>
				<th>Дата</th>
				<th>Цена открытия</th>
				<th>Цена закрытия</th>
				<th>Нижняя рамка</th>
				<th>Верхняя рамка</th>
				<?php if ($_SESSION['role'] == 'admin') : ?>
				<th>Действия</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($stock_data)) {
				foreach ($stock_data as $row) {
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
						echo "<td>Не найдено</td>";
					}

					$sql_date = "SELECT date, open_price, close_price, lowest_price, highest_price FROM company_performance WHERE stock_id = $1 ORDER BY date DESC LIMIT 1";
					$res_date = pg_prepare($conn, "fetch_date_" . $stock_id, $sql_date);
					$res_date = pg_execute($conn, "fetch_date_" . $stock_id, array($stock_id));

					if ($res_date && pg_num_rows($res_date) > 0) {
						$date_row = pg_fetch_assoc($res_date);
						echo "<td>" . htmlspecialchars($date_row['date']) . "</td>";
						echo "<td>" . htmlspecialchars($date_row['open_price']) . "</td>";
						echo "<td>" . htmlspecialchars($date_row['close_price']) . "</td>";
						echo "<td>" . htmlspecialchars($date_row['lowest_price']) . "</td>";
						echo "<td>" . htmlspecialchars($date_row['highest_price']) . "</td>";
					} else {
						echo "<td>Нет данных</td>";
						echo "<td>Нет данных</td>";
						echo "<td>Нет данных</td>";
						echo "<td>Нет данных</td>";
						echo "<td>Нет данных</td>";
					}

					if ($_SESSION['role'] == 'admin') {
						echo '<td><button class="btn btn-info btn-sm" onclick="editStock(' . 
							"'" . htmlspecialchars($row['stock_id']) . "'," . 
							"'" . htmlspecialchars($date_row['open_price']) . "'," . 
							"'" . htmlspecialchars($date_row['close_price']) . "'," . 
							"'" . htmlspecialchars($date_row['lowest_price']) . "'," . 
							"'" . htmlspecialchars($date_row['highest_price']) . "'" . 
							')">Edit</button></td>';
					}
					echo "</tr>";
				}
			} else {
				echo "<tr>";
				echo "<td colspan='7'>Нет данных</td>";
				if ($_SESSION['role'] == 'admin') {
					echo "<td></td>";
				}
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>
<?php include("footer.php"); ?>