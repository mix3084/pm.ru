<?php
$title = 'Портфолио';
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$uid = $_SESSION['user_id'];
	$username = $_SESSION['usern'];
	$role = $_SESSION['role'];

	if ($role == "admin") {
		header("Location: dash.php");
		exit();
	}

	// Sanitize the user_id to prevent SQL injection
	$uid = pg_escape_string($conn, $uid);

	// Prepare and execute the query safely
	$sql = "SELECT * FROM portfolio WHERE user_id = $1";
	$result = pg_prepare($conn, "fetch_portfolio", $sql);
	$result = pg_execute($conn, "fetch_portfolio", array($uid));

	$portfolio_data = [];
	if ($result) {
		// Check if there are results
		if (pg_num_rows($result) > 0) {
			// Fetch results and store them in an array
			$portfolio_data = pg_fetch_all($result);
		} else {
			$portfolio_data = [];
		}
	} else {
		// Query failed or no user found
		echo "User not found.";
	}
} else {
	// Redirect the user to the login page if not logged in
	header("Location: index.php");
	exit();
}
?>
<?php include("header.php"); ?>
<h1><?=$title;?></h1>
<h2 class="text-warning">Ваши сделки</h2>
<a class="btn btn-success" href="add_to_portfolio.php">Добавить акции</a>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Символ</th>
				<th>Имя</th>
				<th>Цена</th>
				<th>Количество</th>
				<th>Итого</th>
				<th>Продажа</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (!empty($portfolio_data)) {
			foreach ($portfolio_data as $row) {
				echo "<tr>";
				echo "<td>" . htmlspecialchars($row['stock_id']) . "</td>";
				$stock_id = $row['stock_id'];
		
				// Properly escape the variable to prevent SQL injection
				$escaped_stock_id = pg_escape_string($conn, $stock_id);
				
				// Prepare and execute the query for company data
				$sql_stc = "SELECT * FROM company WHERE stock_id = $1";
				$res_stc = pg_prepare($conn, "fetch_company_" . $stock_id, $sql_stc);
				$res_stc = pg_execute($conn, "fetch_company_" . $stock_id, array($escaped_stock_id));
		
				if ($res_stc && pg_num_rows($res_stc) > 0) {
					$stc_row = pg_fetch_assoc($res_stc);
					echo "<td>" . htmlspecialchars($stc_row['stock_name']) . "</td>";
				} else {
					echo "<td>Нет данных</td>";
				}
		
				$p = $row['buy_price'];
				$q = $row['quantity'];
				$t = $p * $q;
		
				echo "<td>" . htmlspecialchars($row['buy_price']) . "</td>";
				echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
				echo "<td>" . htmlspecialchars($t) . "</td>";
				echo "<td><button class='btn btn-danger btn-sm' onclick=\"deleteRecordPortfolio('" . htmlspecialchars($row['stock_id']) . "')\">Продать</button></td>";
				echo "</tr>";
			}
		} else {
			echo "<tr>";
			echo "<td> Нет данных</td>";
			echo "<td> Нет данных</td>";
			echo "<td> Нет данных</td>";
			echo "<td> Нет данных</td>";
			echo "<td> Нет данных</td>";
			echo "<td></td>";
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
</div>
<?php include("footer.php"); ?>