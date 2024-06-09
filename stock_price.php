<?php
    include("connection.php");
    session_start();
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        
        // PostgreSQL uses the GROUP BY clause differently, make sure all selected columns are either aggregated or part of the GROUP BY clause
        $sql_userid = "SELECT stock_id, max(close_price) as last_close_price FROM company_performance GROUP BY stock_id";
        $result = pg_query($conn, $sql_userid);
        
        if ($result) {
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    // Access and display individual data from $row
                    // echo "Stock ID: " . htmlspecialchars($row['stock_id']) . "<br>";
                    // echo "Last Close Price: " . htmlspecialchars($row['last_close_price']) . "<br>";
                }
            } else {
                header("Location: dash.php"); // Redirect to the dashboard if no rows found
                exit();
            }
        } else {
            // Handle database query error
            echo "Error: " . pg_last_error($conn);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
</head>

<body>

    <nav class="navbar" style="background-color:rgb(18, 62, 105);">
        <div class="container-fluid">
            <a class="navbar-brand">
                <h2 href="#" style="color: white; cursor: pointer;" onclick="window.location.href='dash.php'">Рынок</h2>
            </a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
                
            </form>
        </div>
    </nav>


    <div class="table-responsive justify-content-center float-center">
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Символ</th>
                <th scope="col">Название</th>
                <th scope="col">Дата</th>
                <th scope="col">Цена открытия</th>
                <th scope="col">Цена закрытия</th>
                <th scope="col">Нижняя рамка</th>
                <th scope="col">Верхняя рамка</th>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                <!-- Display the "Actions" column only if the user is an admin -->
                <th scope="col">Действия</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_userid = "SELECT stock_id, max(close_price) as last_close_price FROM company_performance GROUP BY stock_id";
            $result = pg_query($conn, $sql_userid);
            while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['stock_id']) . "</td>";
                $stock_id = $row['stock_id'];

                // Prepare and execute the query safely
                $sql_stc = "SELECT * FROM company WHERE stock_id = $1";
                $res_stc = pg_prepare($conn, "fetch_company", $sql_stc);
                $res_stc = pg_execute($conn, "fetch_company", array($stock_id));

                if ($res_stc && pg_num_rows($res_stc) > 0) {
                    $stc_row = pg_fetch_assoc($res_stc);
                    echo "<td>" . htmlspecialchars($stc_row['stock_name']) . "</td>";
                } else {
                    echo "<td>Не найдено</td>"; // Not found
                }
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['open_price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['close_price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lowest_price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['highest_price']) . "</td>";
                if ($_SESSION['role'] == 'admin') {
                    echo '<td><button class="btn btn-info btn-sm" onclick="editStock(' . 
                        "'" . htmlspecialchars($row['stock_id']) . "'," . 
                        "'" . htmlspecialchars($row['open_price']) . "'," . 
                        "'" . htmlspecialchars($row['close_price']) . "'," . 
                        "'" . htmlspecialchars($row['lowest_price']) . "'," . 
                        "'" . htmlspecialchars($row['highest_price']) . "'" . 
                        ')">Edit</button></td>';
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

   <!--js-->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
   integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
   crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
   integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
   crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
   integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
   crossorigin="anonymous"></script>
<script>
   $(document).ready(function () {
       $(".form-control").on("keyup", function () {
           var value = $(this).val().toLowerCase();
           $(".table tbody tr").filter(function () {
               $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
           });
       });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    // Function to prompt for values and perform the edit
    function editStock(stockId, openPrice, closePrice, lowestPrice, highestPrice) {
        const newOpenPrice = prompt('Enter new Open Price:', openPrice);
        const newClosePrice = prompt('Enter new Close Price:', closePrice);
        const newLowestPrice = prompt('Enter new Lowest Price:', lowestPrice);
        const newHighestPrice = prompt('Enter new Highest Price:', highestPrice);

        if (newOpenPrice !== null && newClosePrice !== null && newLowestPrice !== null && newHighestPrice !== null) {
            // Use AJAX to send the values to a PHP script for processing
            $.ajax({
                url: 'update_stock.php',
                type: 'POST',
                data: {
                    stockId: stockId,
                    newOpenPrice: newOpenPrice,
                    newClosePrice: newClosePrice,
                    newLowestPrice: newLowestPrice,
                    newHighestPrice: newHighestPrice
                },
                success: function (response) {
                    console.log('Update successful');
                    // Redirect back to the stock page
                    window.location.href = 'stock_price.php';
                },
                error: function () {
                    console.log('Update failed');
                }
            });
        } else {
            console.log('Editing canceled');
        }
    }
</script>
    
<footer class="container">
        <center><p>&copy; 2024 Москва</p>
        <p class="float-center"><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
        </center>
        
</footer>
</body>

</html>