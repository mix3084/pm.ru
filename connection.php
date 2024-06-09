<?php
// Uncomment to show connection status messages
// echo("Attempting to connect...<br>");

// Define connection parameters
$host = "localhost";
$port = "5432"; // Default port for PostgreSQL
$dbname = "Portfolio_Management";
$user = "postgres"; // Ensure this is the correct username for your PostgreSQL server
$password = "postgres";

// Create connection string
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

// Connect to the PostgreSQL database
$conn = pg_connect($connection_string);

// Check the connection status
if (!$conn) {
    echo "Не удалось установить соединение.";
}

// Uncomment to execute a simple query example
// $query = "SELECT * FROM user_details";
// $result = pg_query($conn, $query);
// if ($result) {
//     while ($row = pg_fetch_assoc($result)) {
//         echo "User ID: " . $row['user_id'] . " - Name: " . $row['name'] . "<br>";
//     }
// } else {
//     echo "0 results";
// }

// Uncomment to insert data example
// $insert_query = "INSERT INTO user_details (user_id, dob, name, password, pan, email)
// VALUES
// ('AQC123456703', '2003-06-30', 'John Josw', 'password1', 'AQC1234567', 'john11@example.com'),
// ('TBC123456703', '2003-06-30', 'Johny sine', 'password1', 'TBC1234567', 'johns@example.com')";
// $insert_result = pg_query($conn, $insert_query);
// if ($insert_result) {
//     echo "New records created successfully";
// } else {
//     echo "Error: " . pg_last_error($conn);
// }

// Close the connection
// pg_close($conn);
?>
