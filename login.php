<?php
    include("connection.php"); // Ensure this uses pg_connect
    session_start();
    if (isset($_POST["signin"])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize the inputs
        $email = pg_escape_string($conn, $email);
        $password = pg_escape_string($conn, $password);

        // Prepare and execute the query
        $sql = "SELECT * FROM user_details WHERE email = $1 AND password = $2";
        $result = pg_prepare($conn, "login", $sql);
        $result = pg_execute($conn, "login", array($email, $password));

        // Check the result
        if (pg_num_rows($result) == 1) {
            $row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
            echo "id: " . $row["user_id"] . " - Name: " . $row["name"] . "<br>";
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row["user_id"];
            $_SESSION['usern'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            header("Location: dash.php"); // Redirect to dashboard
            exit();
        } else {
            echo("Incorrect Password");
            header("Location: index.php"); // Redirect back to index page
            exit();
        }
    }
?>
