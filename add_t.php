<?php
include("connection.php");
session_start();

if (isset($_POST["sub_t"])) {
	$sym = $_POST['symbol'];
	$quantit = $_POST['quantity'];
	$price = $_POST['price'];
	$uid = $_SESSION['user_id'];

	// Sanitize inputs to prevent SQL Injection
	$sym = pg_escape_string($conn, $sym);
	$quantit = pg_escape_string($conn, $quantit);
	$price = pg_escape_string($conn, $price);
	$uid = pg_escape_string($conn, $uid);

	// Check if the stock_id already exists in the portfolio
	$check_sql = "SELECT stock_id FROM portfolio WHERE user_id = $1 AND stock_id = $2";
	$check_result = pg_prepare($conn, "check_stock", $check_sql);
	$check_result = pg_execute($conn, "check_stock", array($uid, $sym));

	if (pg_num_rows($check_result) > 0) {
		// Stock_id already exists, update the existing record
		$update_sql = "UPDATE portfolio SET quantity = quantity + $1 WHERE user_id = $2 AND stock_id = $3";
		$update_result = pg_prepare($conn, "update_stock", $update_sql);
		if (pg_execute($conn, "update_stock", array($quantit, $uid, $sym))) {
			echo "Updated successfully!";
		} else {
			echo "Error updating record: " . pg_last_error($conn);
		}
	} else {
		// Stock_id doesn't exist, insert a new record
		$insert_sql = "INSERT INTO portfolio (user_id, quantity, buy_price, stock_id) VALUES ($1, $2, $3, $4)";
		$insert_result = pg_prepare($conn, "insert_stock", $insert_sql);
		if (pg_execute($conn, "insert_stock", array($uid, $quantit, $price, $sym))) {
			echo "Added successfully!";
		} else {
			echo "Error inserting record: " . pg_last_error($conn);
		}
	}

	// Redirect to the portfolio page
	header("Location: portfolio.php");
	exit();
}
?> 
