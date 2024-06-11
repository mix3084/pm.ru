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
	<title>Добавить акции</title>
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
	<center><h1>Добавить акции</h1></center>
	<main class="container my-5" style="width: 50%; height: fit-content; float: center; justify-content: center; text-align: left; margin: 25%; padding: 2.5rem;">
		<h2>
			<form method="POST" action='add_t.php'>
				Символ
				<select name="symbol" id="symbol" onchange="getSymbolCurrentPrice()">
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
					?>
				</select>
				<br><br>
				Цена: <span id="currentPrice"></span>
				<script>
					function getSymbolCurrentPrice() {
						var symbol = document.getElementById('symbol').value;

						// Make an AJAX request to get the current price
						var xhr = new XMLHttpRequest();
						xhr.open('GET', 'get_current_price.php?symbol=' + symbol, true);

						xhr.onload = function () {
							if (xhr.status == 200) {
								var currentPriceSpan = document.getElementById('currentPrice');
								currentPriceSpan.textContent = xhr.responseText;
								currentPriceSpan.style.color = 'black';
								currentPriceSpan.style.textAlign = 'right';
							} else {
								console.error('Request failed. Status: ' + xhr.status);
							}
						};

						xhr.send();
					}
				</script>
				<br><br>
				Количество
				<input type='number' name='quantity' required />
				<br><br>
				Итого <input type="text" name="price" id="price" class="price-input" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
				<br><br>
				<center><input type="submit" id="button2" class="submit" name="sub_t" required></center>
			</form>
		</h2>
	</main>
	<center><h3><a href="#" onclick="window.location.href='dash.php'">Назад</a></h3></center>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
		integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
		integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	<script src="/assets/js/script.js"></script>
</body>
</html>
