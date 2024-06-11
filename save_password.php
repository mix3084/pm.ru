<?php
include("connection.php"); // Make sure to include your database connection file

session_start();

if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Validate and sanitize the new password
		$newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';

		// Prepare the SQL statement
		$sql = "UPDATE user_details SET password = $1 WHERE email = $2";
		$result = pg_prepare($conn, "update_password", $sql);

		// Execute the SQL statement
		$result = pg_execute($conn, "update_password", array($newPassword, $email));
		
		if ($result) {
			echo "Password updated successfully";
		} else {
			echo "Error updating password: " . pg_last_error($conn);
		}
	} else {
		echo "Invalid request method";
	}
} else {
	// Redirect the user to the login page if not logged in
	header("Location: about.php");
	exit();
}
?>
