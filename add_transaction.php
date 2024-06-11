<?php
include("connection.php");
session_start();
if (isset($_SESSION['email'])) {
	$uid = $_SESSION['user_id'];
} else {
	// Redirect the user to the login page if not logged in
	header("Location: dash.php");
	exit();
}

// Fetch companies from the database
$sql = "SELECT stock_id FROM company";
$result = pg_query($conn, $sql);
$companies = [];
if ($result) {
	while ($row = pg_fetch_assoc($result)) {
		$companies[] = htmlspecialchars($row['stock_id']);
	}
	pg_free_result($result);
} else {
	echo "Error: " . pg_last_error($conn);
}

// Close the database connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Добавить транзакцию</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
	h1 {
		color: rgb(255, 204, 0);
	}

	a:hover {
		color: cyan;
	}

	select,
	input {
		float: right;
	}

	form {
		color: rgb(78, 211, 255);
	}
</style>
<body>
	<center><h1>Добавить транзакцию</h1></center>
	<main class="container my-5" style="width: 50%; height: fit-content; float: center; justify-content: center; text-align: left; margin: 25%; padding: 2.5rem;">
		<h2>
			<form method="POST" action='process_transaction.php'>
				Символ:
				<select name="symbol">
					<?php foreach ($companies as $company): ?>
						<option value="<?php echo $company; ?>"><?php echo $company; ?></option>
					<?php endforeach; ?>
				</select>
				<br><br>
				Время транзакции: <input type="date" name='transaction_date' required />
				<br><br>
				Тип транзакции:
				<select name="transaction_type">
					<option value="Buy">Купить</option>
					<option value="Sell">Продать</option>
				</select>
				<br><br>
				Количество: <input type='number' name='quantity' required />
				<br><br>
				Рейтинг: <input type='number' name='rate' required />
				<br><br>
				<center><input type="submit" value="Добавить" style="float:left"></center>
			</form>
		</h2>
	</main>
	<center><h3><a href="#" onclick="window.location.href='portfolio.php'">Назад</a></h3></center>
</body>
</html>
