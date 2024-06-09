<?php
    include("connection.php"); // Ensure this file is updated to use PostgreSQL with pg_connect
    session_start();
    if (isset($_SESSION['email'])) {
        $uid = $_SESSION['user_id'];
        $username = $_SESSION['usern'];
        $role = $_SESSION['role'];

        if ($role == "admin") {
            header("Location: dash.php");
            exit();
        }

        // Sanitize the user_id to prevent SQL injection
        $uid = pg_escape_string($conn, $uid);

        // Prepare and execute the query safely
        $sql = "SELECT * FROM portfolio WHERE user_id = $1";
        $result = pg_prepare($conn, "fetch_portfolio", $sql);
        $result = pg_execute($conn, "fetch_portfolio", array($uid));

        if ($result) {
            // Check if there are results
            if (pg_num_rows($result) > 0) {
                // Fetch results and use them as needed
                // For example, you could fetch all rows like this:
                while ($row = pg_fetch_assoc($result)) {
                    // Process each row
                    echo "Stock ID: " . $row['stock_id'] . " - Quantity: " . $row['quantity'] . "<br>";
                }
            } else {
                echo "No portfolio data found.";
            }
        } else {
            // Query failed or no user found
            echo "User not found.";
        }

        // Use the user information to personalize the dashboard
    } else {
        // Redirect the user to the login page if not logged in
        header("Location: login.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
<style>
    button.btn a{
        color:azure;
    }
</style>

</head>


<body>
    <nav class="navbar navbar-expand-xl navbar-dark" style="background-color:rgb(18, 62, 105);">
        <div class="container-fluid">
            <a class="navbar-brand fw-normal text-center" href="#" onclick="window.location.href='dash.php'">Портфолио <?php echo $username; ?> </a>         
        </div>
        <form method="POST" action='logout.php'>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal" type="submit"
                        name="logout">Выйти</button>
                </form>
    </nav>

    <h1 style="color: rgb(50, 241, 75); text-align: center;">Добро пожаловать, <?php echo $username; ?>! </h1>
    <br><h2 style="color:rgb(252, 209, 19); font-size:x-large ; text-align: center;">Ваши сделки
    </h2>
    <button class="btn btn-success float-right" action="add_transaction.php"><a href="add_to_portfolio.php">Добавить акции</a></button>
    
    <br>
    <div class="table-responsive justify-content-center float-center">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Символ</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Итого</th>
                    <th scope="col">Продажа</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['STOCK_ID']) . "</td>";
                    $stock_id = $row['STOCK_ID'];
            
                    // Properly escape the variable to prevent SQL injection
                    $escaped_stock_id = pg_escape_string($conn, $stock_id);
                    
                    // Prepare and execute the query for company data
                    $sql_stc = "SELECT * FROM company WHERE stock_id = $1";
                    $res_stc = pg_prepare($conn, "fetch_company", $sql_stc);
                    $res_stc = pg_execute($conn, "fetch_company", array($escaped_stock_id));
            
                    if ($res_stc && pg_num_rows($res_stc) > 0) {
                        $stc_row = pg_fetch_assoc($res_stc);
                        echo "<td>" . htmlspecialchars($stc_row['STOCK_NAME']) . "</td>";
                    } else {
                        echo "<td>Нет данных</td>"; // No data in English
                    }
            
                    $p = $row['buy_price'];
                    $q = $row['quantity'];
                    $t = $p * $q;
            
                    echo "<td>" . htmlspecialchars($row['buy_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($t) . "</td>";
                    echo "<td><button onclick=\"deleteRecord('" . htmlspecialchars($row['STOCK_ID']) . "')\">Продать</button></td>";
                    echo "</tr>";
                }
            }
            
            else{
                echo "<tr>";
                echo "<td> Нет данных";
                echo "<td> Нет данных";
                echo "<td> Нет данных";
                echo "<td> Нет данных";
                echo "<td> Нет данных";
                echo "<tr>";
            }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteRecord(stockId) {
            var stocksToSell = prompt("Сколько акции хотите продать?");

            if (stocksToSell !== null && stocksToSell !== "") {
                var confirmDelete = confirm("Вы действительно хотите продать " + stocksToSell + " акции?");

                if (confirmDelete) {
                    window.location.href = "del_portfolio.php?stock_id=" + stockId + "&stocks_to_sell=" + stocksToSell;
                }
            } else {
                alert("Введите правильное количество.");
            }
        }
    </script>
    <center>
        <div id="myDivT" style="width:1000px; height:500px;"></div>
    </center>


   
    <footer class="container">
        <center><p>&copy; 2024 Москва</p>
        <p class="float-center"><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
        </center>
        
    </footer>
</body>

</html>