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
            alert("You must be at least 18 years old.");
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
function editPassword() {
    var passwordField = document.getElementById('passwordField');
    var passwordValue = passwordField.innerHTML;

    // Replace label with input box and save changes button
    passwordField.innerHTML = '<form id="passwordForm">';
    passwordField.innerHTML += '<input type="password" name="newPassword" id="newPassword" value="' + passwordValue + '">';
    passwordField.innerHTML += '<button type="button" onclick="saveChanges()">Save Changes</button>';
    passwordField.innerHTML += '</form>';
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