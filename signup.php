<?php
    include("connection.php"); // Ensure this file uses pg_connect to establish a PostgreSQL connection
    
        $email = $_POST['email2'];
        $password = $_POST['password2'];
        $name = $_POST['name2'];
        $pan = $_POST['pan2'];
        $dob = $_POST['dob']; 
        // Sanitize inputs to prevent SQL Injection (you should do more than this for production)
        $email = pg_escape_string($conn, $email);
        $password = pg_escape_string($conn, $password);
        $name = pg_escape_string($conn, $name);
        $pan = pg_escape_string($conn, $pan);
        $dob = pg_escape_string($conn, $dob);
        
        // Prepare a statement for safer execution
        $sql = "INSERT INTO user_details (name, email, password, pan, dob) VALUES ($1, $2, $3, $4, $5)";
        
        // Prepare the SQL statement
        $result = pg_prepare($conn, "insert_user", $sql);
        // Execute the SQL statement with the parameters
        $result = pg_execute($conn, "insert_user", array($name, $email, $password, $pan, $dob));
        echo "signuping";
        if ($result) {
            echo "User registered successfully!";
            header("Location: index.php"); // Redirect to the index page
            exit();
        } 
        else {
            echo "Error: " . pg_last_error($conn);
        }    
    
?>
