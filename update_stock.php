<?php
// update_stock.php

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$stockId = $_POST['stockId'];
	$newOpenPrice = $_POST['newOpenPrice'];
	$newClosePrice = $_POST['newClosePrice'];
	$newLowestPrice = $_POST['newLowestPrice'];
	$newHighestPrice = $_POST['newHighestPrice'];

	// Sanitize inputs to prevent SQL Injection
	$stockId = pg_escape_string($conn, $stockId);
	$newOpenPrice = pg_escape_string($conn, $newOpenPrice);
	$newClosePrice = pg_escape_string($conn, $newClosePrice);
	$newLowestPrice = pg_escape_string($conn, $newLowestPrice);
	$newHighestPrice = pg_escape_string($conn, $newHighestPrice);

	// Prepare the SQL statement
	$sql = "UPDATE company_performance SET
			open_price = $1,
			close_price = $2,
			lowest_price = $3,
			highest_price = $4
			WHERE stock_id = $5";

	$result = pg_prepare($conn, "update_stock", $sql);
	$result = pg_execute($conn, "update_stock", array($newOpenPrice, $newClosePrice, $newLowestPrice, $newHighestPrice, $stockId));

	if ($result) {
		echo 'Update successful';
	} else {
		echo 'Error updating record: ' . pg_last_error($conn);
	}
} else {
	echo 'Invalid request method';
}
?>
