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
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Добавить в список наблюдения</title>
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
	<center><h1>Добавить в список наблюдения</h1></center>
	<main class="container my-5" style="width: 50%; height: fit-content; float: center; justify-content: center; text-align: left; margin: 25%; padding: 2.5rem;">
		<h2>
			<form method="POST" action='add_tw.php'>
				Символ компании
				<select name="symbol">
					<?php
					$sql = "SELECT * FROM company";
					$result = pg_query($conn, $sql);
					if ($result) {
						while ($row = pg_fetch_assoc($result)) {
							$companyName = htmlspecialchars($row['stock_id']);
							echo "<option value=\"$companyName\">$companyName</option>";
						}
						// Free the result set
						pg_free_result($result);
					} else {
						echo "Error: " . pg_last_error($conn);
					}
					// Close the database connection
					pg_close($conn);
					?>
				</select>
				<center><input type="submit" id="button2" class="submit" name="sub_tw" required></center>
			</form>
		</h2>
	</main>
	<center><h3><a href="#" onclick="window.location.href='watchlist.php'">Назад</a></h3></center>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
		integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
		integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
