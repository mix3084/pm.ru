

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
</head>
<style>
    h1{
        color:rgb(255, 204, 0);
    }
    a:hover{
        color:cyan;
    }
    select,input{
        float:right;
    }
    form{
        color:rgb(78, 211, 255);
    }
</style>
<body>
    <center><h1>Добавить транзакцию</h1></center>
    <main class="container my-5" style="width: 50%; height:fit-content; float: center; justify-content: center; text-align: left; margin: 25%; padding: 2.5rem;"><h2>
        <form method="POST" action=''>
            Символ:
            <select name="symbol">
                {% for company in companies %}
                <option value="{{ company[0] }}">{{ company[0] }}</option>
                {% endfor %}
            </select>
            <br><br>
             Время транзакции: <input type="date" name='transaction_date' />
            <br><br>
             Тип транзакции: 
            <select name="transaction_type">
                <option value="Buy">Buy</option>
                <option value="Sell">Sell</option>
            </select>
            <br><br>
            Количество: <input type='number' name='quantity' />
            <br><br>
             Рейтинг: <input type='number' name='rate' />
            <br><br>
          <center><input type="submit" value="Add" href="portfolio.php" style="float:left"><center>
        </form>
    </main>
         <center><h3><button action="portfolio.php">Назад</button></h3></center>
    
</body>
</html>