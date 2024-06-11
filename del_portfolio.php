<?php
include("connection.php");
session_start();

if (isset($_GET['stock_id']) && isset($_GET['stocks_to_sell'])) {
	$stock_id = $_GET['stock_id'];
	$stocks_to_sell = $_GET['stocks_to_sell'];
	$user_id = $_SESSION['user_id'];

	// Sanitize inputs to prevent SQL Injection
	$stock_id = pg_escape_string($conn, $stock_id);
	$stocks_to_sell = pg_escape_string($conn, $stocks_to_sell);
	$user_id = pg_escape_string($conn, $user_id);

	// Retrieve the current number of stocks
	$sql_select = "SELECT * FROM portfolio WHERE stock_id = $1 AND user_id = $2";
	$result = pg_prepare($conn, "select_stocks", $sql_select);
	$result = pg_execute($conn, "select_stocks", array($stock_id, $user_id));

	if ($result && pg_num_rows($result) > 0) {
		$row = pg_fetch_assoc($result);
		$current_stocks = $row['quantity'];

		// Check if the user has enough stocks to sell
		if ($current_stocks >= $stocks_to_sell) {
			// Calculate the new number of stocks after selling
			$new_stocks = $current_stocks - $stocks_to_sell;

			if ($new_stocks > 0) {
				// Update the number of stocks in the portfolio
				$sql_update = "UPDATE portfolio SET quantity = $1 WHERE stock_id = $2 AND user_id = $3";
				$update_result = pg_prepare($conn, "update_stocks", $sql_update);
				if (pg_execute($conn, "update_stocks", array($new_stocks, $stock_id, $user_id))) {
					header("Location: portfolio.php");
					exit();
				} else {
					echo "Error updating record: " . pg_last_error($conn);
				}
			} else {
				// Delete the record if the quantity is zero
				$sql_delete = "DELETE FROM portfolio WHERE stock_id = $1 AND user_id = $2";
				$delete_result = pg_prepare($conn, "delete_stocks", $sql_delete);
				if (pg_execute($conn, "delete_stocks", array($stock_id, $user_id))) {
					header("Location: portfolio.php");
					exit();
				} else {
					echo "Error deleting record: " . pg_last_error($conn);
				}
			}
		} else {
			header("Location: portfolio.php");
			exit();
		}
	} else {
		echo "Error retrieving stock information: " . pg_last_error($conn);
	}

	pg_free_result($result);
} else {
	echo "Invalid parameters.";
}

// Close the database connection
pg_close($conn);
?>
