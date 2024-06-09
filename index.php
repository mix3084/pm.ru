<?php include("connection.php");?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       body,button,input{font-family:'Open Sans',Helvetica,Arial,sans-serif}.cont,.form{position:relative}.cont,.sub-cont,body{background:#fff}.cont,.img,.img__btn,.sub-cont{overflow:hidden}#button1,input,label{display:block}.forgot-pass,.img__text,.tip,h2,input,label{text-align:center}.img__btn,.submit,label span{text-transform:uppercase}*,:after,:before{-webkit-box-sizing:border-box;box-sizing:border-box;margin:0;padding:0}button,input{border:none;outline:0;background:0 0}.tip{font-size:20px;margin:40px auto 50px}.cont{border-radius:20px;width:900px;height:550px;margin:0 auto 100px;-webkit-box-shadow:-10px -10px 15px rgba(255,255,255,.3),10px 10px 15px rgba(70,70,70,.15),inset -10px -10px 15px rgba(255,255,255,.3),inset 10px 10px 15px rgba(70,70,70,.15);box-shadow:-10px -10px 15px rgba(255,255,255,.3),10px 10px 15px rgba(70,70,70,.15),inset -10px -10px 15px rgba(255,255,255,.3),inset 10px 10px 15px rgba(70,70,70,.15)}#button1,.img__btn{margin:0 auto;color:#fff;font-size:15px;cursor:pointer}.form{width:640px;height:100%;-webkit-transition:-webkit-transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out;-o-transition:transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out,-webkit-transform 1.2s ease-in-out;padding:50px 30px 0}.img:before,.sub-cont{width:900px;-webkit-transition:-webkit-transform 1.2s ease-in-out;top:0;height:100%}.sub-cont{position:absolute;left:640px;padding-left:260px;transition:transform 1.2s ease-in-out;-o-transition:transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out,-webkit-transform 1.2s ease-in-out}.img,.img:after,.img__btn span,.img__btn:after,.img__text{position:absolute;left:0}#button1,.img,label{width:260px}.cont.s--signup .sub-cont{-webkit-transform:translate3d(-640px,0,0);transform:translate3d(-640px,0,0)}#button1{height:36px;border-radius:30px}.img{z-index:2;top:0;height:100%;padding-top:360px}.img:before{content:'';position:absolute;right:0;opacity:.8;background-size:cover;transition:transform 1.2s ease-in-out;-o-transition:transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out,-webkit-transform 1.2s ease-in-out}.img:after{content:'';top:0;width:100%;height:100%;background:rgba(0,0,0,.6)}.cont.s--signup .img:before{-webkit-transform:translate3d(640px,0,0);transform:translate3d(640px,0,0)}.img__text{z-index:2;top:50px;width:100%;padding:0 20px;color:#fff;-webkit-transition:-webkit-transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out;-o-transition:transform 1.2s ease-in-out;transition:transform 1.2s ease-in-out,-webkit-transform 1.2s ease-in-out}.img__text h2{margin-bottom:10px;font-weight:400}.img__text p{font-size:14px;line-height:1.5}.cont.s--signup .img__text.m--up{-webkit-transform:translateX(520px);-ms-transform:translateX(520px);transform:translateX(520px)}.img__text.m--in{-webkit-transform:translateX(-520px);-ms-transform:translateX(-520px);transform:translateX(-520px)}.cont.s--signup .img__text.m--in{-webkit-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0)}.img__btn{z-index:2;position:relative;width:100px;height:36px;background:0 0}.forgot-pass,label span{font-size:12px;color:#cfcfcf}.img__btn:after{content:'';z-index:2;top:0;width:100%;height:100%;border:2px solid #fff;border-radius:30px}.img__btn span{top:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;width:100%;height:100%;-webkit-transition:-webkit-transform 1.2s;transition:transform 1.2s;-o-transition:transform 1.2s;transition:transform 1.2s,-webkit-transform 1.2s}.img__btn span.m--in{-webkit-transform:translateY(-72px);-ms-transform:translateY(-72px);transform:translateY(-72px)}.cont.s--signup .img__btn span.m--in{-webkit-transform:translateY(0);-ms-transform:translateY(0);transform:translateY(0)}.cont.s--signup .img__btn span.m--up{-webkit-transform:translateY(72px);-ms-transform:translateY(72px);transform:translateY(72px)}h2{width:100%;font-size:26px}label{margin:25px auto 0}input{width:100%;margin-top:5px;padding-bottom:5px;font-size:16px;border-bottom:1px solid rgba(0,0,0,.4)}.forgot-pass{margin-top:15px}.submit{margin-top:40px;margin-bottom:20px;background:#d4af7a}.fb-btn{border:2px solid #d3dae9;color:#8fa1c7}.fb-btn span{font-weight:700;color:#455a81}.sign-in{-webkit-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.cont.s--signup .sign-in{-webkit-transition-timing-function:ease-in-out;-o-transition-timing-function:ease-in-out;transition-timing-function:ease-in-out;-webkit-transition-duration:1.2s;-o-transition-duration:1.2s;transition-duration:1.2s;-webkit-transform:translate3d(640px,0,0);transform:translate3d(640px,0,0)}.sign-up{-webkit-transform:translate3d(-900px,0,0);transform:translate3d(-900px,0,0)}.cont.s--signup .sign-up{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}#error-message{color:red;margin-top:.5rem;text-align:center}
    </style>
</head>

<body>
    <div class="cont">
        <div class="form sign-in">
            <h2>Добро пожаловать</h2>
            <form name="form" id="loginForm">
                <label>
                    <span>Эл. почта</span>
                    <input type="email" name="email" id="email" />
                </label>
                <label>
                    <span>Пароль</span>
                    <input type="password" name="password" id="password" />
                </label>
                <p id="error-message" style="color: red;"></p>
				<p class="forgot-pass">Забыли пароль?</p>
                <br>
                <input type="submit" id="button1" class="submit" name="signin" value="Войти">
            </form>
        </div>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h3>Нет аккаунта? Регистрация!<h3>
                </div>
                <div class="img__text m--in">
                    <h3>Если есть аккаунт, пройдите авторизацию.<h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Регистрация</span>
                    <span class="m--in">Войти</span>
                </div>
            </div>
            <div class="form sign-up">
                <form name="form" action="signup.php" method="POST">
                    <h2>Создать аккаунт</h2>
                    <label>
                        <span>Имя</span>
                        <input type="Name" name="name2" id="name2" required />
                    </label>
                    <label>
                        <span>Дата рождения (YYYY-MM-DD)</span>
                        <input type="text" id="dob" name="dob" pattern="\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])"
                            onchange="validateDOB();" required>
                    </label>
                    <label>
                        <span>Эл. почта</span>
                        <input type="email" name="email2" id="email2" required />
                    </label>
                    <label>
                        <span>ИНН</span>
                        <input type="text" name="pan2" id="pan2" required />
                    </label>
                    <label>
                        <span>Пароль</span>
                        <input type="password" name="password2" id="password2" required />
                    </label>
                    <br>
                    <input type="submit" id="button1" class="submit" name="Регистрация" required>
                </form>
            </div>
        </div>
    </div>
    <script>
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
        document.querySelector('.img__btn').addEventListener('click', function () {
            document.querySelector('.cont').classList.toggle('s--signup');
        });

        // AJAX для формы логина
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
    </script>
    <footer class="container">
        <p align=center>&copy; 2024 Москва</p>
        <p class="float-center" align=center><a href="#">Правила</a> &middot; <a href="#">Соглашения</a></p>
    </footer>
</body>

</html>