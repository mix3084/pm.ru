<?php
include("connection.php");
session_start();

if (isset($_POST["sub_tt"])) {
	$sym = $_POST['symbol'];
	$quantit = $_POST['quantity'];
	$price = $_POST['price'];
	$uid = $_SESSION['user_id'];
	$uid2 = $_POST['uid'];
	$tdate = $_POST['transaction_date'];
	$fd = date('Y-m-d', strtotime($tdate));
	$type = $_POST['type'];

	// Sanitize inputs to prevent SQL Injection
	$sym = pg_escape_string($conn, $sym);
	$quantit = pg_escape_string($conn, $quantit);
	$price = pg_escape_string($conn, $price);
	$uid = pg_escape_string($conn, $uid);
	$uid2 = pg_escape_string($conn, $uid2);
	$fd = pg_escape_string($conn, $fd);
	$type = pg_escape_string($conn, $type);

	// Insert into TRANSACTION table
	if ($type == 'bought') {
		$sql_q = "INSERT INTO TRANSACTION (date_of_purchase, user_id_purchased, stock_id, price, quantity, user_id_bought)
				  VALUES ($1, $2, $3, $4, $5, $6)";
		$values = array($fd, $uid, $sym, $price, $quantit, $uid2);
	} else {
		$sql_q = "INSERT INTO TRANSACTION (date_of_purchase, user_id_purchased, stock_id, price, quantity, user_id_bought)
				  VALUES ($1, $2, $3, $4, $5, $6)";
		$values = array($fd, $uid2, $sym, $price, $quantit, $uid);
	}

	$transaction_result = pg_prepare($conn, "insert_transaction", $sql_q);
	$transaction_result = pg_execute($conn, "insert_transaction", $values);

	if ($transaction_result) {
		echo "Transaction added successfully!";
	} else {
		echo "Error inserting transaction: " . pg_last_error($conn);
	}

	// Insert or update portfolio
	if ($type == 'bought') {
		$sql_q = "INSERT INTO portfolio (user_id, quantity, buy_price, stock_id)
				  VALUES ($1, $2, $3, $4)
				  ON CONFLICT (user_id, stock_id) 
				  DO UPDATE SET quantity = portfolio.quantity + EXCLUDED.quantity, buy_price = EXCLUDED.buy_price";
		$values = array($uid, $quantit, $price, $sym);
	} else {
		$sql_q = "INSERT INTO portfolio (user_id, quantity, buy_price, stock_id)
				  VALUES ($1, $2, $3, $4)
				  ON CONFLICT (user_id, stock_id) 
				  DO UPDATE SET quantity = portfolio.quantity + EXCLUDED.quantity, buy_price = EXCLUDED.buy_price";
		$values = array($uid2, $quantit, $price, $sym);
	}

	$portfolio_result = pg_prepare($conn, "insert_portfolio", $sql_q);
	$portfolio_result = pg_execute($conn, "insert_portfolio", $values);

	if ($portfolio_result) {
		echo "Portfolio updated successfully!";
	} else {
		echo "Error updating portfolio: " . pg_last_error($conn);
	}

	// Redirect to the transaction page
	header("Location: transaction.php");
	exit();
}
?>
