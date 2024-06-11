<?php
include("connection.php");
session_start();

if (isset($_POST["sub_tw"])) {
	$sym = $_POST['symbol'];
	$uid = $_SESSION['user_id'];

	// Sanitize inputs to prevent SQL Injection
	$sym = pg_escape_string($conn, $sym);
	$uid = pg_escape_string($conn, $uid);

	// Check if the stock_id already exists in the watchlist
	$check_sql = "SELECT stock_id FROM watchlist WHERE user_id = $1 AND stock_id = $2";
	$check_result = pg_prepare($conn, "check_watchlist", $check_sql);
	$check_result = pg_execute($conn, "check_watchlist", array($uid, $sym));

	if (pg_num_rows($check_result) == 0) {
		// The stock_id doesn't exist in the watchlist, so insert a new record
		$sql_price = "SELECT stock_price FROM company WHERE stock_id = $1";
		$price_result = pg_prepare($conn, "fetch_stock_price", $sql_price);
		$price_result = pg_execute($conn, "fetch_stock_price", array($sym));

		if ($price_result && pg_num_rows($price_result) > 0) {
			$row = pg_fetch_assoc($price_result);
			$p_price = $row['stock_price'];

			$insert_sql = "INSERT INTO watchlist (user_id, stock_id, stock_price) VALUES ($1, $2, $3)";
			$insert_result = pg_prepare($conn, "insert_watchlist", $insert_sql);
			if (pg_execute($conn, "insert_watchlist", array($uid, $sym, $p_price))) {
				echo "Added successfully!";
			} else {
				echo "Error inserting record: " . pg_last_error($conn);
			}
		} else {
			echo "Error fetching stock price: " . pg_last_error($conn);
		}
	}

	// Redirect to the watchlist page
	header("Location: watchlist.php");
	exit();
}
?>
