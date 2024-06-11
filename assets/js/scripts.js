function validateDOB() {
    var dobInput = document.getElementById('dob');
    var dobValue = dobInput.value;

    if (dobValue !== "") {
        var today = new Date();
        var enteredDate = new Date(dobValue);
        var age = today.getFullYear() - enteredDate.getFullYear();

        // Check if the birthday has occurred this year
        if (today.getMonth() < enteredDate.getMonth() || (today.getMonth() === enteredDate
                .getMonth() && today.getDate() < enteredDate.getDate())) {
            age--;
        }

        if (age < 18) {
            alert("Вам должно быть не менее 18 лет.");
            dobInput.value = ""; // Clear the input field
            dobInput.focus(); // Set focus back to the input field
            return false;
        }
    }

    return true;
}
if (document.querySelector('.img__btn')) {
    document.querySelector('.img__btn').addEventListener('click', function () {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
}


// AJAX для формы логина
if ( document.getElementById('loginForm') ) {
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();
    
        var formData = new FormData(this);
        formData.append('signin', 'true'); // Вручную добавляем поле signin
    
        fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = 'dash.php';
                } else {
                    document.getElementById('error-message').textContent = data.message;
                }
            })
            .catch(error => console.error('Error:', error));
    });
}
if (document.getElementById('registrationForm')) {
    document.getElementById('registrationForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('signup.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('resultMessage').innerText = data.message;
                if (data.message === "Регистрация прошла успешно") {
                    document.getElementById('registrationForm').reset();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
}
function deleteRecord(stockId) {
    window.location.href = "del_watch.php?stock_id=" + stockId;
}
if ($(".form-control")) {
    $(".form-control").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
}
function deleteRecordPortfolio(stockId) {
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
function editPassword() {
    var passwordField = document.getElementById('passwordField');
    var passwordValue = passwordField.innerHTML;
    passwordField.innerHTML = `
    <form id="passwordForm" class="input-group">
        <input class="form-control" type="password" name="newPassword" id="newPassword" value="${passwordValue}">
        <button class="btn btn-success" type="button" onclick="saveChanges()">Изменить пароль</button>
    </form>
    `
}

function saveChanges() {
    var newPassword = $('#newPassword').val();

    // AJAX request to save the new password
    $.ajax({
        type: 'POST',
        url: 'save_password.php',
        data: { newPassword: newPassword },
        success: function(response) {
            // Update UI or provide feedback to the user
            var passwordField = document.getElementById('passwordField');
            passwordField.innerHTML = newPassword;
            alert(response); // You can replace this with a more user-friendly notification
        },
        error: function(error) {
            console.log(error);
            alert('Error updating password.');
        }
    });
}

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