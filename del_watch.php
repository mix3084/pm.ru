<?php
include("connection.php");
session_start();

if (isset($_GET['stock_id'])) {
	$stock_id = $_GET['stock_id'];
	$user_id = $_SESSION['user_id'];

	// Sanitize inputs to prevent SQL Injection
	$stock_id = pg_escape_string($conn, $stock_id);
	$user_id = pg_escape_string($conn, $user_id);

	// Perform the delete operation
	$sql_delete = "DELETE FROM watchlist WHERE stock_id = $1 AND user_id = $2";
	$delete_result = pg_prepare($conn, "delete_watchlist", $sql_delete);
	if (pg_execute($conn, "delete_watchlist", array($stock_id, $user_id))) {
		header("Location: watchlist.php");
		exit();
	} else {
		echo "Error deleting record: " . pg_last_error($conn);
	}
} else {
	echo "Invalid stock_id parameter.";
}

// Close the database connection
pg_close($conn);
?>
