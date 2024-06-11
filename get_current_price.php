<?php
include("connection.php");
session_start();

if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];

	// Sanitize input to prevent SQL Injection
	$symbol = pg_escape_string($conn, $symbol);

	// Modify the query to get the current price based on the selected symbol
	$sql = "SELECT stock_price FROM company WHERE stock_id = $1";
	$result = pg_prepare($conn, "fetch_price", $sql);
	$result = pg_execute($conn, "fetch_price", array($symbol));

	if ($result && pg_num_rows($result) > 0) {
		$row = pg_fetch_assoc($result);
		echo $row['stock_price'];
	} else {
		echo "Error: " . pg_last_error($conn);
	}
} else {
	echo "Symbol not provided.";
}

// Close the database connection if needed
pg_close($conn);
?>
